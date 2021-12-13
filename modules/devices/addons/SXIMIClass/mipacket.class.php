<?php
/**
*	Класс для работы с сетевыми udp-пакетами по протоколу miIO.
*
*	+ генерация ключа и вектора инициализации из токена
*	+ расшифровка
*	+ шифрование
*	+ парсинг udp-пакета
*	+ сборка udp-пакета
*
*	https://github.com/OpenMiHome/mihome-binary-protocol
*
*	Copyright (C) 2017-2019 Agaphonov Dmitri aka skysilver <skysilver.da@gmail.com>
*/

class miPacket {

	private	$magic = '2131';
	private	$length = '';
	private	$unknown1 = '00000000';
	private	$devicetype = '';
	private	$serial = '';
	public	$ts = '';
	private	$checksum = '';
	public	$timediff = 0;

	public	$data = '';
	public	$info = array('devicetype' => '',
						  'serial' => '',
						  'token' => '');

	private $token = '';
	private $key = '';
	private $iv = '';

	/*
		Сохранение токена.
	*/

	public function setToken($token) {

		if ($this->verifyToken($token)) {
			$this->token = $token;
			$this->getKeyIv();
			return true;
		} else {
			return false;
		};

	}

	/*
		Вывод токена.
	*/

	public function getToken() {

		return $this->token;

	}

	/*
		Проверка длины токена.
	*/

	private function verifyToken($token) {

		if (strlen($token) == 32) return true;
		 else return false;

	}

	/*
		Вычисление ключа шифрования и вектора первичной инициализации на основе токена.
	*/

	private function getKeyIv() {

		$this->key = md5(hex2bin($this->token));
		$this->iv = md5(hex2bin($this->key.$this->token));

	}

	/*
		Шифрование данных.
	*/

	public function encryptData($data) {

		if ($this->verifyToken($this->token)) {
			return bin2hex(openssl_encrypt($data, 'AES-128-CBC', hex2bin($this->key), OPENSSL_RAW_DATA, hex2bin($this->iv)));
		} else return false;

	}

	/*
		Расшифровка данных.
	*/

	public function decryptData($data) {

		if ($this->verifyToken($this->token)) {
			return openssl_decrypt(hex2bin($data), 'AES-128-CBC', hex2bin($this->key), OPENSSL_RAW_DATA, hex2bin($this->iv));
		} else return false;

	}

	/*
		Формирование пакета.
	*/

	public function msgBuild($cmd) {

		$this->data = $this->encryptData($cmd);

		$this->length = sprintf('%04x', (int)strlen($this->data)/2 + 32);

		$this->ts = sprintf('%08x', time() + $this->timediff);	// с учетом разницы времени между устройством и сервером

		$packet = $this->magic.$this->length.$this->unknown1.$this->devicetype.$this->serial.$this->ts.$this->token.$this->data;

		$this->checksum = md5(hex2bin($packet));

		$packet = $this->magic.$this->length.$this->unknown1.$this->devicetype.$this->serial.$this->ts.$this->checksum.$this->data;

		return $packet;

	}

	/*
		Разбор пакета по полям.
	*/

	public function msgParse($msg) {

		$this->magic = substr($msg, 0, 4);
		$this->length = substr($msg, 4, 4);
		$this->unknown1 = substr($msg, 8, 8);
		$this->devicetype = substr($msg, 16, 4);
		$this->serial = substr($msg, 20, 4);
		$this->ts = substr($msg, 24, 8);
		$this->checksum = substr($msg, 32, 32);

		if ( ($this->length == '0020') && (strlen($msg)/2 == 32) ) {
			$this->setToken(substr($msg, 32, 32));
			// запомним разницу времени между устройством и сервером
			$this->timediff = hexdec($this->ts) - time();
		} else {
			$data_length = strlen($msg) - 64;
			if ($data_length > 0) {
				$this->data = substr($msg, 64, $data_length);
			}
		}

		$this->info['devicetype'] = $this->devicetype;
		$this->info['serial'] = $this->serial;
		$this->info['token'] = $this->token;

	}

	/*
		Вывод заголовка пакета.
	*/

	public function printHead() {

		echo 'magic: ' . $this->magic . PHP_EOL;
		echo 'length: ' . $this->length . ' --> ' . hexdec($this->length) . ' bytes' . PHP_EOL;
		echo 'unknown1: ' . $this->unknown1 . PHP_EOL;
		echo 'devicetype: ' . $this->devicetype . PHP_EOL;
		echo 'serial: ' . $this->serial . PHP_EOL;
		echo 'ts: ' . $this->ts . ' --> ' . hexdec($this->ts) . ' seconds' . ' --> ' . date('Y-m-d H:i:s', hexdec($this->ts)) . PHP_EOL;
		echo 'timediff: ' . $this->timediff . PHP_EOL;
		echo 'checksum: ' . $this->checksum . PHP_EOL;

	}

	/*
		Вывод полей пакета и данных.
	*/

	public function printPacket() {

		$this->printHead();
		echo 'data: ' . $this->data . PHP_EOL;

	}
}

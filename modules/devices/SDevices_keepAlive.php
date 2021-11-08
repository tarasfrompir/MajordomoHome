<?php
$ot = $this->object_title;

$this->setProperty('alive', 1);


$alive_timeout = (int)$this->getProperty('aliveTimeout') * 60 * 60;
if ($alive_timeout==0) {
    $alive_timeout = 12 * 60 * 60; // 12 часов
}

if ($alive_timeout>0) {
  setTimeout($ot . '_alive_timer', 'setGlobal("' . $ot . '.alive", 0);', $alive_timeout);
}
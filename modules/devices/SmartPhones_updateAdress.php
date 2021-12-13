<?php
$temp = $this->getProperty('coordinates');
$coord = explode(",", $temp);

$adress = geocodingFromCoord($coord[0], $coord[1]);
$this->setProperty('address', $adress);
if (isset($this->linked_user) and $this->linked_user != '') {
    sg($this->linked_user.'.coordinates', $temp);
    sg($this->linked_user.'.address', $adress);
}
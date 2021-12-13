<?php
$new_value =json_decode($params['NEW_VALUE'], true);
$old_value =json_decode($params['OLD_VALUE'], true);
$this->setProperty('updated', time());
$this->setProperty('alive', 1);
if ($new_value == $old_value) return;
$this->setProperty('coordinates', trim($new_value['latitude']) . ',' . trim($new_value['longitude']) );
$this->setProperty('speed', intval(trim($new_value['speed'])) );
$this->setProperty('battery', intval(trim($new_value['battlevel'])));
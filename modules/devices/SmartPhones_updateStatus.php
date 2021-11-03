<?php
$new_value =json_decode($params['NEW_VALUE'], true);
$old_value =json_decode($params['OLD_VALUE'], true);
if ($new_value == $old_value) return;
$this->setProperty('coordinates', trim($new_value['latitude']) . ',' . trim($new_value['longitude']) );
$this->setProperty('speed', trim($new_value['speed']) );
$this->setProperty('battery', trim($new_value['battlevel']));

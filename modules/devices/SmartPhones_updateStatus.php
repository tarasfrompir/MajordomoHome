<?php
$new_value =json_decode($params['NEW_VALUE']);
$old_value =json_decode($params['OLD_VALUE']);
if (strval($new_value['latitude']) == strval($old_value['latitude']) and strval($new_value['longitude']) == strval($old_value['longitude'])) return;
$out = json_decode($new_value, true);
$this->setProperty('coordinates', trim($out['latitude']) . ',' . trim($out['longitude']) );
$this->setProperty('speed', trim($out['speed']) );
$this->setProperty('battery', trim($out['battlevel']));


<?php

//DebMes($params);
//DebMes($this);
if (!$this->location_id) return;
if (!$this->getProperty('mainSensor')) return;

$outnew = json_decode($params["NEW_VALUE"], True);
$outold = json_decode($params["OLD_VALUE"], True);
$room = getRoomObjectByLocation($this->location_id, 1);
$mainsensor = $this->getProperty('mainSensor');
// set temperature
if (($outnew["result"][0]["value"] != $outold["result"][0]["value"]) and $mainsensor) setGlobal ($room . '.temperature', $outnew["result"][0]["value"]);

// set humidity
if (($outnew["result"][2]["value"] != $outold["result"][2]["value"]) and $mainsensor) setGlobal ($room . '.humidity', $outnew["result"][2]["value"]);

/*
"location_id"
20:27:22 0.97353700 [
{
"did": "temperature",
"siid": 3,
"piid": 7,
"code": 0,
"value": 22.2
},
{
"did": "water_level",
"siid": 2,
"piid": 7,
"code": 0,
"value": 34
},
{
"did": "humidity",
"siid": 3,
"piid": 9,
"code": 0,
"value": 58
},
{
"did": "speed_level",
"siid": 7,
"piid": 1,
"code": 0,
"value": 554
},
{
"did": "power",
"siid": 2,
"piid": 1,
"code": 0,
"value": true
},
{
"did": "mode",
"siid": 2,
"piid": 5,
"code": 0,
"value": 1
},
{
"did": "led_brightnes",
"siid": 5,
"piid": 2,
"code": 0,
"value": 1
},
{
"did": "clean_mode",
"siid": 7,
"piid": 5,
"code": 0,
"value": false
},
{
"did": "child_lock",
"siid": 6,
"piid": 1,
"code": 0,
"value": false
},
{
"did": "power_time",
"siid": 7,
"piid": 3,
"code": 0,
"value": 714515
},
{
"did": "target_humidity",
"siid": 2,
"piid": 6,
"code": 0,
"value": 50
},
{
"did": "dry",
"siid": 2,
"piid": 8,
"code": 0,
"value": true
},
{
"did": "use_time",
"siid": 2,
"piid": 9,
"code": 0,
"value": 2234102
},
{
"did": "button_pressed",
"siid": 2,
"piid": 10,
"code": 0,
"value": 0
},
{
"did": "buzzer",
"siid": 4,
"piid": 1,
"code": 0,
"value": false
},
{
"did": "actual_speed",
"siid": 7,
"piid": 1,
"code": -4004
}
*/
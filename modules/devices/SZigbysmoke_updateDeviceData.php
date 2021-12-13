<?php
//DebMes($params);

$outnew = json_decode($params["NEW_VALUE"], true);
$outold = json_decode($params["OLD_VALUE"], true);
if ($outnew['alarm'] == $outold['alarm']) return;
if ($outnew['alarm'] == '0' ) {
    $this->setProperty('activity',0);
} else {
    $this->setProperty('activity',1);
}
$this->setProperty('alive',1);
$this->setProperty('updated',time());
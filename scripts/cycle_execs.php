<?php
// run all exec command with api - cycle dont need
exit;
chdir(dirname(__FILE__) . '/../');

include_once("./config.php");
include_once("./lib/loader.php");

set_time_limit(0);

include_once("./load_settings.php");
$checked_time = 0;
SQLExec("DELETE FROM safe_execs");

while (1) {
    if (time() - $checked_time > 10) {
        $checked_time = time();
        echo date("H:i:s") . " Cycle " . basename(__FILE__) . ' is running ';
    }

    if ($safe_execs = SQLSelectOne("SELECT * FROM safe_execs ORDER BY PRIORITY DESC, ID")) {
        if (IsWindowsOS()) {
            $command = utf2win($safe_execs['COMMAND']);
        } else {
            $command = $safe_execs['COMMAND'];
        }
        SQLExec("DELETE FROM safe_execs WHERE ID = '" . $safe_execs['ID'] . "'");
        //DebMes("Executing : " . $command,'execs');
        execInBackground($command);
        if ($safe_execs['ON_COMPLETE']) {
            //DebMes("On complete code: ".$safe_execs['ON_COMPLETE'], 'execs');
            try {
                eval($safe_execs['ON_COMPLETE']);
            } catch (Exception $e) {
                DebMes('ON_COMPLETE command - '. $safe_execs['ON_COMPLETE'] . ' for command - '.$command.' have error. Error: exception ' . get_class($e) . ', ' . $e->getMessage() ,'execs');
            }
        }
        continue ;
    }

    if (isRebootRequired() || IsSet($_GET['onetime'])) {
        exit;
    }

    sleep(1);
}

DebMes("Unexpected close of cycle: " . basename(__FILE__));

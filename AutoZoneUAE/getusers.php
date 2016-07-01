<?php
/**
 * Creates Unsynced rows data as JSON
 */

    include_once 'db_functions.php';

    $db = new DB_Functions();
    $users = $db->getPostMetaData();

    $a = array();
    $b = array();

    if ($users != false){
        while ($row = mysql_fetch_array($users)) {      
            $b["post_id"] = $row["post_id"];
            $b["meta_key"] = $row["meta_key"];
            array_push($a,$b);
        }
        echo json_encode($a);
    }
?>

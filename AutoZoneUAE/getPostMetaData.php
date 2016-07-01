<?php
/**
 * This php retruns JSON contains post meta data
 */

    include_once 'db_functions.php';

    $db = new DB_Functions();
    $dbReadValues = $db->getPostMetaData();

    $a = array();
    $b = array();

    if ($dbReadValues != false){
        while ($row = mysql_fetch_array($dbReadValues)) {      
            $b["post_id"] = $row["post_id"];
            $b["meta_key"] = $row["meta_key"];
	    $b["meta_value"] = $row["meta_value"];
            array_push($a,$b);
        }
        echo json_encode($a);
    }
?>

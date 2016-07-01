
	
<?php
/**
 * This php retruns JSON contains post data

ID, post_title, post_name, post_type, guid, comment_count
 */

    include_once 'db_functions.php';

	$post_id = $_GET['post_id'];

echo 'Param:' , $post_id ;
	


    $db = new DB_Functions();
    $dbReadValues = $db->getPostData();

    $a = array();
    $b = array();

    if ($dbReadValues != false){
        while ($row = mysql_fetch_array($dbReadValues)) {      
            $b["ID"] = $row["ID"];
            $b["post_title"] = $row["post_title"];
	    $b["post_name"] = $row["post_name"];
	$b["post_type"] = $row["post_type"];
	$b["guid"] = $row["guid"];
	$b["comment_count"] = $row["comment_count"];
            array_push($a,$b);
        }
        echo json_encode($a);
    }
?>

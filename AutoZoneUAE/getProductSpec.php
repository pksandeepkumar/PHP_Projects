<?php
/**
 This php returns product spec
 * this php accept parameter product_id
 */

    include_once 'db_functions.php';

	$product_id = $_GET['product_id'];

	//echo 'Param:' , $product_id ;
	
    $db = new DB_Functions();
    
    //Get all product specs
    $dbReadValues = $db->getProductSpecs($product_id);

    $a = array();
    $b = array();
    
    $specFieldNameAndValueParent = array();

    if ($dbReadValues != false){
        while ($row = mysql_fetch_array($dbReadValues)) {    
			$specFieldNameAndValue = array();
			
			$filedName = $row["meta_key"];  
			$filedValue = $row["meta_value"];  
			
            $specFieldNameAndValue["name"] = $row["meta_key"];
            $specFieldNameAndValue["value"] = $row["meta_value"];
            if( $filedName == "colors") {
				$query = "SELECT * FROM `wp_postmeta` WHERE `post_id` = $product_id ";
				$query.= "AND (";
				for ($x = 0; $x <$filedValue; $x++) {
					$query .= " meta_key LIKE 'colors_". $x ."_color'";
					if($x + 1 != $filedValue ) {
						$query .= " OR ";
					}
				} 
				$query.= ")";
				
				$dbReadColors = $db->executeQuery($query);
				if ($dbReadColors != false){
					
					$colorArrayParent = array();
					while ($rowColors = mysql_fetch_array($dbReadColors)) { 
						$colorArray = array();
						$colorArray ["color"] = $rowColors["meta_value"]; 
						array_push($colorArrayParent,$colorArray);
					}   
					$specFieldNameAndValue["colors"] = $colorArrayParent;
				}
				//echo 'Query:' , $query  ;

			}
            array_push($specFieldNameAndValueParent,$specFieldNameAndValue);
        }
        $b["specs"] = $specFieldNameAndValueParent;
        array_push($a,$b);
        echo json_encode($a);
    }
?>

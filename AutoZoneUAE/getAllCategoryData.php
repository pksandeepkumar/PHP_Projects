<?php
/**
 * This php returns all category with ites item
 */

    include_once 'db_functions.php';

    $db = new DB_Functions();

	//Reading all category ids from wp_term_taxonomy
    $dbReadValues = $db->getAllCatTermIDS();

    $a = array();
    $b = array();

    if ($dbReadValues != false){
        while ($row = mysql_fetch_array($dbReadValues)) {   
	    $term_id = $row["term_id"];   
		//echo 'Term ID:' , $term_id ;
        $b["cat_id"] = $row["term_id"];
        //$b["description"] = $row["description"];
	    //$b["meta_value"] = $row["meta_value"];
		
		//Reading cat name from  wp_terms
		$dbTermData = $db->getCatName($term_id);
		//var_dump($dbTermData);
		if ($dbTermData != false){
			while ($rowTermData = mysql_fetch_array($dbTermData)) {
				$b["cat_name"] = $rowTermData["name"]; 
				//array_push($a,$b); SELECT * FROM `wp_term_relationships` WHERE `term_taxonomy_id` = 6
				$product_array = array();
				$product_array_parent = array();
				//Reading all products under this category from wp_term_relationships
				$dbTermProductID = $db->getAllProductsPostID($term_id);
				if ($dbTermProductID != false){
					 while ($rowTermProduct = mysql_fetch_array($dbTermProductID)) {
						 $product_id = $rowTermProduct["object_id"];   
						 $product_array["product_id"] = $rowTermProduct["object_id"];
						 
						 //Reading product Data from post
						 $dbProductData = $db->getProductData($product_id); 
						 if ($dbProductData != false){ 
							 while ($rowProductData = mysql_fetch_array($dbProductData)) {
								 $product_array["product_name"] = $rowProductData["post_title"];
								 break;
							 }
						 }
						 //Reading product image id from post meta data
						 $dbProductImageID = $db->getProductImageID($product_id); 
						 if ($dbProductImageID != false){ 
							 
							 while ($rowProductImageId = mysql_fetch_array($dbProductImageID)) {
								 $productImageIds = $rowProductImageId["meta_value"];
								 
								 $splitArray = explode(',', $productImageIds);
								 $product_image_array_parent = array();
								 foreach($splitArray as $image_id){
									 //echo 'image_id :' , $image_id ;
									 //Reading product image data from post
									 $dbProductImageData = $db->getProductData($image_id); 
									 $product_image_array = array();
									 
									 if ($dbProductImageData != false){ 
										 while ($rowProductImageData = mysql_fetch_array($dbProductImageData)) {
											 $product_image_array["image_url"] = $rowProductImageData["guid"];
											 break;
										 }
									 }
									 array_push($product_image_array_parent, $product_image_array);
									 
								 }
								 $product_array["images"] = $product_image_array_parent;
								 break;
							 }
						 }
						 
						 //Reading product details
						 
						 
						 
						 
						 //Push product into array
						 array_push($product_array_parent, $product_array);
					 }
					 $b["products"] = $product_array_parent;
					 //array_push($b, $product_array);
				}
				

				break;
			}
		}
		array_push($a,$b);


            
        }
        echo json_encode($a);
    }
?>

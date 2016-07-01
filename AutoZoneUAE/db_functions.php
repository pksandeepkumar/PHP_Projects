<?php
/**
 * DB operations functions
 */
class DB_Functions {
 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        include_once 'db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
 
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($User) {
        // Insert user into database
        $result = mysql_query("INSERT INTO user(Name) VALUES('$User')");
 
        if ($result) {
            return true;
        } else {     
die(mysql_error())      ; 
                // For other errors
                return false;
        }
    }
     /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM user");
        return $result;
    }
    /**
     * Get Yet to Sync row Count
     */
    public function getUnSyncRowCount() {
        $result = mysql_query("SELECT * FROM autozone_automobile.user");
        return $result;
    }

/**
     * Get Post Metadata
     */
    public function getPostMetaData() {
        $result = mysql_query("SELECT * FROM autozone_automobile.wp_postmeta WHERE `meta_key` LIKE '%product%'");
        return $result;
    }

	public function getPostData() {
        $result = mysql_query("SELECT ID, post_title, post_name, post_type, guid, comment_count FROM `wp_posts` WHERE post_type = 'Attachment' OR post_type = 'product'");
        return $result;
    	}

	public function getAllCatTermIDS() {
        $result = mysql_query("SELECT * FROM `wp_term_taxonomy` WHERE `taxonomy` LIKE 'product_cat' AND `parent` = 0");
        return $result;
    	}


	public function getCatName($term_id) {
        $result = mysql_query("SELECT * FROM `wp_terms` WHERE `term_id` =$term_id");
        return $result;
    	}
    	
    	public function getAllProductsPostID($term_id) {
        $result = mysql_query("SELECT * FROM `wp_term_relationships` WHERE `term_taxonomy_id` = $term_id");
        return $result;
    	}
    	
    	//This can be also user to get product image
    	public function getProductData($post_id) {
        $result = mysql_query("SELECT * FROM `wp_posts` WHERE `ID` = $post_id");
        return $result;
    	}
    	
    	//Returns product image ids as string like 21,22,23
    	public function getProductImageID($post_id) {
        $result = mysql_query("SELECT * FROM `wp_postmeta` WHERE `post_id` = $post_id AND (`meta_key` 
        LIKE '_product_image_gallery' OR `meta_key` LIKE '_thumbnail_id'  )");
        return $result;
    	}
    	
    	//Returns all product specs
    	public function getProductSpecs($product_id) {
        $result = mysql_query("SELECT * FROM `wp_postmeta` WHERE meta_key NOT LIKE '%\_%' AND post_id = $product_id");
        return $result;
    	}
    	
    	//Execute a query
    	public function executeQuery($query) {
        $result = mysql_query($query);
        return $result;
    	}
    	
    	
    	
    	




    /**
     * Update Sync status of rows
     */
    public function updateSyncSts($id, $sts){
        $result = mysql_query("UPDATE user SET syncsts = $sts WHERE Id = $id");
        return $result;
    }
}
 
?>

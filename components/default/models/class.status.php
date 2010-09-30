<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Status extends ActiveRecord {
	var $table = "status";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
//    	$this->has_association("stages", "stage_id");
//      $this->create_belongs_to_association('author', 'CmsUser', 'author_id');
//      $this->create_has_and_belongs_to_many_association('categories', 'BlogCategory', 'blog_post_categories', 'category_id', 'post_id', array('order' => 'name ASC'));
    }

    public static function find_status_by_category_and_name( $category, $name ) {
    	//todo: there has to be a better way to do this, hardcoding the table name is not cool
    	$sql = "SELECT * FROM silk_status AS s WHERE category=? AND name=? ORDER BY ID DESC LIMIT 1";
    	$params = array( "category"=>$category, "name"=>$name );
    	return \pool\Status::find_by_query( $sql, $params);
    }
    
	public function validate() {
		if( empty($this->params["name"]) ) $this->add_validation_error("Status must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
}
?>
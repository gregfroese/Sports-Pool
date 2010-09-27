<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Sport extends ActiveRecord {
	var $table = "sports";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->has_association("seasons", "sport_id" ); //haven't tried this
//      $this->create_belongs_to_association('author', 'CmsUser', 'author_id');
//      $this->create_has_and_belongs_to_many_association('categories', 'BlogCategory', 'blog_post_categories', 'category_id', 'post_id', array('order' => 'name ASC'));
    }

	public function validate() {
		if( empty($this->params["name"]) ) $this->add_validation_error("Sport must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
}
?>
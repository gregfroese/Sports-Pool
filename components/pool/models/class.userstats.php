<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Userstats extends ActiveRecord {
	var $table = "userstats";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->create_belongs_to_association( "user", "silk\auth\User", "user_id", array() );
    }
    
	public function validate() {
	}
}
?>
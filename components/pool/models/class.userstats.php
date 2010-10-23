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
    	$this->create_belongs_to_association( "status", "pool\Status", "status_id", array() );
    	$this->create_has_many_association( "responses", "\pool\Bonusresponses", "bonus_id" );
    }
    
	public function validate() {
	}
}
?>
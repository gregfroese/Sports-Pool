<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Bonusresponses extends ActiveRecord {
	var $table = "bonusresponses";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->create_belongs_to_association( "user", "silk\auth\User", "user_id", array() );
    	$this->create_belongs_to_association( "bonus", "\pool\Bonus", "bonus_id", array() );
    }
    
	public function validate() {
//		if( empty($this->params["name"]) ) $this->add_validation_error("Seasons must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
}
?>
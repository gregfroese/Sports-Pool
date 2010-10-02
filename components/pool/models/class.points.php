<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Points extends ActiveRecord {
	var $table = "points";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->create_belongs_to_association( "game", "pool\Game", "game_id");
    	$this->create_belongs_to_association( "user", "silk\Auth\User", "user_id");
    }
    
	public function validate() {
	}
}
?>
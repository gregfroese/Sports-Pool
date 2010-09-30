<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Seasonusers extends ActiveRecord {
	var $table = "seasonusers";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->create_belongs_to_association("user", "\silk\Auth\User", "user_id");
    	$this->create_has_many_association("seasons", "Season", "season_id");
    }

	public function validate() {
	}
}
?>
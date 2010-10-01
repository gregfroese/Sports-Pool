<?php
namespace silk\auth;
use \silk\orm\ActiveRecord;

class ACL extends ActiveRecord {
	public $table = "ACL";
	
	function __construct()
    {
        parent::__construct();
    }
    
	public function setup() {
	}
}
?>
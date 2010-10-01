<?php
namespace silk\auth;
use silk\orm\ActiveRecord;

class AclAro extends ActiveRecord {
	public $table = "ACL_ARO";
	
	function __construct()
    {
        parent::__construct();
    }
    
	public function setup() {
	}
}
?>
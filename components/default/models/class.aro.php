<?php
namespace silk\auth;
use \silk\orm\ActiveRecord;

class ARO extends ActiveRecord {
	public $table = "ARO";
	public $params = array('id' => -1, 'lft' => 1, 'rgt' => 1, 'parent_id' => -1, 'item_order' => 0);
	
	function __construct()
    {
        parent::__construct();
    }
    
	public function setup() {
		$this->assign_acts_as('nested_set');
	}
}
?>
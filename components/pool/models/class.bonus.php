<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Bonus extends ActiveRecord {
	var $table = "bonus";

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
//		if( empty($this->params["name"]) ) $this->add_validation_error("Seasons must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
	
	public function getResponse( $user = null ) {
		if( empty( $user )) {
			$user = \silk\auth\UserSession::get_current_user();
		}
		$bonusResponse = \pool\Bonusresponses::find_by_user_id_and_bonus_id( $user->id, $this->id );
		return $bonusResponse;
	}
	
	public function saveResponse( $response, $user = null ) {
		if( empty( $user )) {
			$user = \silk\auth\UserSession::get_current_user();
		}
		$bonusResponse = new \pool\Bonusresponses();
		$bonusResponse->user_id = $user->id;
		$bonusResponse->bonus_id = $this->id;
		$bonusResponse->response = $response;
		$bonusResponse->save();
	}
}
?>
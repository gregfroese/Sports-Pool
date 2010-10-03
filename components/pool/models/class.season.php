<?php

namespace pool;
use silk\action\Response;

use \silk\orm\ActiveRecord;

class Season extends ActiveRecord {
	var $table = "seasons";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->create_has_many_association("stages", "Stage", "season_id");
    	$this->create_belongs_to_association( "status", "pool\Status", "status_id" );
    	$this->create_has_many_association( "seasonusers", "\pool\Seasonusers", "season_id" );
    	$this->create_has_many_association( "segments", "\pool\Segment", "season_id" );
      	$this->create_has_and_belongs_to_many_association('users', '\silk\auth\User', 'seasonusers', 'user_id', 'season_id', array('order' => 'first_name, last_name ASC'));
    }

    public function isMember( $user ) {
    	$sql = "SELECT * FROM silk_seasonusers AS su WHERE season_id = ? AND user_id = ?";
    	$params = array( $this->id, $user->id );
    	$seasonuser = \pool\Seasonusers::find_by_query( $sql, $params );
//    	var_dump( $sql, $params, $seasonuser );
    	if( !empty( $seasonuser )) {
//    		var_dump( $seasonuser );
    		return $seasonuser;
    	}
    	return 0;
    }
    
    public function loadMember( $user ) {
    	$sql = "SELECT * FROM silk_seasonusers AS su WHERE season_id = ? AND user_id = ?";
    	$params = array( $this->id, $user->id );
    	$seasonuser = \pool\Seasonusers::find_by_query( $sql, $params );
    	if( !empty( $seasonuser )) {
    		return $seasonuser;
    	}
    	return false;
    }
    
	public function validate() {
		if( empty($this->params["name"]) ) $this->add_validation_error("Seasons must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
	
	public function addMember( $user ) {
		$seasonuser = new \pool\Seasonusers();
		
		$seasonuser->season_id = $this->id;
		$seasonuser->user_id = $user->id;
		$seasonuser->active = 1;
		$seasonuser->save();
	}
	
	public function deleteMember( $user ) {
		$seasonuser = $this->loadMember( $user );
		$seasonuser->delete();
	}
	
	/**
	 * Get an associative array of the number of points for each user in the pool
	 * @param array $params
	 */
	public function getPoints( $params = array() ) {
		$chartPoints = array();
		foreach( $this->users as $user ) {
			$points = 0;
			foreach( $this->segments as $segment ) {
				foreach( $segment->games as $game ) {
					$gamePoints = $game->getPoints( $user );
//					if( !empty( $gamePoints->points )) {
						$points = $points + $gamePoints->points;
//					}
				}
			}
			$chartPoints[$user->first_name] = $points;
		}
		asort( $chartPoints );
		return $chartPoints;
	}
}
?>
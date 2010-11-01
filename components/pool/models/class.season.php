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
    	$this->create_has_many_association( "comments", "\pool\Comments", "season_id" );
      	$this->create_has_and_belongs_to_many_association('users', '\silk\auth\User', 'seasonusers', 'user_id', 'season_id', array('order' => 'first_name, last_name ASC'));
    }

    public function getComments( $page = 1, $limit = 10 ) {
    	$sql = "SELECT * FROM silk_comments AS c WHERE season_id = ? ORDER BY id DESC";
    	$params = array( $this->id );
    	$count = \pool\Comments::find_count( array( "conditions"=>array( "season_id = ?", array( $this->id )), "limit"=>array( $offset, $limit )));
    	$comments = \pool\Comments::find_all_by_query( $sql, $params, $limit, $page * $limit );
    	return array( "comments"=>$comments, "count"=>$count, "offset"=>$page * $limit, "limit"=>$limit );
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
			$total = 0;
			foreach( $this->segments as $segment ) {
				$points = $segment->getPointsBySegment( $user );
				$total = $total + $points;
				$chartPoints[$user->first_name . " " . $user->last_name][$segment->name] = $points;
			}
			$chartPoints[$user->first_name . " " . $user->last_name]["total"] = $total;
			//use the sort field as a key for sorting - here we want it to mirror total
			$chartPoints[$user->first_name . " " . $user->last_name]["sort"] = $total;
			$chartPoints[$user->first_name . " " . $user->last_name]["user_id"] = $user->id;
		}
		$chartPoints = $this->sortChartPoints($chartPoints);
		return $chartPoints;
	}
	
	public function sortChartPoints( $chartPoints ) {
		uasort( $chartPoints, array( "pool\Season", "sortPoints" ));
		return $chartPoints;
	}
	public function sortChartPointsNoKey( $chartPoints ) {
		usort( $chartPoints, array( "pool\Season", "sortPoints" ));
		return $chartPoints;
	}
	
	private function sortPoints( $a, $b ) {
		if( $a["sort"] > $b["sort"] ) {
			return 1;
		} elseif( $a["sort"] < $b["sort"] ) {
			return -1;
		} else {
			return 0;
		}
	}
	
	/**
	 * Get all points per user per segment
	 */
	public function getPointsBySegment() {
		$points = array();
		foreach( $this->seasonusers as $user ) {
			$key = $user->first_name . " " . $user->last_name;
			$points[$key] = array();
			foreach( $this->segments as $segment ) {
				$points[$key][$segment->name] = $segment->getPointsBySegment( $user );
			}
		}
		return $points;
	}
	
	public function getPerformanceByUser( $user ) {
		$points = array();
		foreach( $this->segments as $segment ) {
			$points["high"][$segment->name] = $segment->seasonstats->high;
			if( empty( $points["high"][$segment->name] )) { //need a value in there so we don't break the charts
				$points["high"][$segment->name] = 0;
			}
			$points["low"][$segment->name] = $segment->seasonstats->low;
			if( empty( $points["low"][$segment->name] )) { //need a value in there so we don't break the charts
				$points["low"][$segment->name] = 0;
			}
			$points["user"][$segment->name] = $segment->getUserstats( $user );
		}
		return $points;
	}
	
	public function getHighAndLowScoresBySegment( $user ) {
		$points = array();
		//getting the user points from another function that has already been called for this page (user_stats.tpl)
		//so it should be cached and its free
		$userPoints = $this->getPerformanceByUser( $user );
		$points["user"] = $userPoints["user"];
		$sql = "SELECT * FROM silk_userstats AS us WHERE season_id = ? ORDER BY segment_id";
		$params = array( $this->id );
		$results = \pool\Userstats::find_all_by_query( $sql, $params );
		$segPoints = array(); //total up each user's points for each segment and set the high and lows according to cumulative value
		$prevSegID = 0;
		foreach( $results as $result ) {
			if( $prevSegID != $result->segment_id ) {
				if( !empty( $segment )) {
					//only do this after the whole segment has been identified and processed
					//get the highs and lows
					$tempPoints = $segPoints; //don't want to lose my indexing so using a temp
					$points["high"][$segment->name] = $tempPoints[count( $tempPoints ) - 1];
					$points["low"][$segment->name] = $tempPoints[1];
				}
			
				$prevSegID = $result->segment_id;
				$segment = \pool\Segment::find_by_id( $result->segment_id );
			}
			if( empty( $segPoints[$result->user->id] )) {
				$segPoints[$result->user->id] = $result->points;
			} else {
				$segPoints[$result->user->id] += $result->points;
			}
		}
		//do it one more time
		//get the highs and lows
		$tempPoints = $segPoints; //don't want to lose my indexing so using a temp
		$points["high"][$segment->name] = $tempPoints[count( $tempPoints ) - 1];
		$points["low"][$segment->name] = $tempPoints[1];
		return $points;
	}
}
?>
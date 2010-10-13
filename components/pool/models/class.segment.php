<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Segment extends ActiveRecord {
	var $table = "segments";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->create_has_many_association( "games", "pool\Game", "segment_id", array() );
    	$this->create_belongs_to_association( "status", "pool\Status", "status_id", array() );
    	$this->create_belongs_to_association( "season", "pool\Season", "season_id", array() );
    	$this->create_has_many_association( "bonus", "pool\Bonus", "segment_id", array() );
    }

	public function validate() {
		if( empty($this->params["name"]) ) $this->add_validation_error("Segments must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
	
	public function getAverages() {
		$avg = array();
		$avg["home"] = 0;
		$avg["away"] = 0;
		$count = 0;
		foreach( $this->games as $game ) {
			if( $game->status->name == "Closed" ) {
				$count++;
				$avg["home"] = $avg["home"] + $game->home_score;
				$avg["away"] = $avg["away"] + $game->away_score;
			}
		}
		$avg["home"] = round( $avg["home"] / $count, 2 );
		$avg["away"] = round( $avg["away"] / $count, 2 );
		return $avg;
	}
	
	public function getBonusPoints( $user ) {
		foreach( $this->bonus as $bonus ) {		
			$sql = "SELECT * FROM silk_bonusresponses AS br WHERE user_id = ? AND bonus_id = ?";
			$params = array( $user->id, $bonus->id );
			$bonusReponses = \pool\Bonusresponses::find_all_by_query( $sql, $params );
			$points = 0;
			foreach( $bonusReponses as $br ) {
				$points = $points + $br->value;
			}
			return $points;
		}
	}
	
	/**
	 * Delete all points from a segment
	 */
	public function deletePoints() {
		foreach( $this->games as $game ) {
			foreach( $game->points as $point ) {
				$point->delete();
			}
		}
	}
	
	/**
	 * Get all the points for a user for this segment
	 * @param user $user
	 */
	public function getPointsBySegment( $user, $includeBonus = true ) {
		$game_ids = array();
		foreach( $this->games as $game ) {
			$game_ids[] = $game->id;
		}
		$userPoints = 0;
		if( count( $game_ids )) {
			$sql = "SELECT * FROM silk_points AS sp WHERE user_id = ? AND game_id IN (" . implode( ",", $game_ids ) . ")";
			$params = array( $user->id );
			$points = \pool\Points::find_all_by_query( $sql, $params );
			foreach( $points as $point ) {
				$userPoints = $userPoints + $point->points;
			}
		}
		if( $includeBonus ) {
			$userPoints = $userPoints + $this->getBonusPointsBySegment( $user );
		}
		return $userPoints;
	}
/**
	 * Get all the bonus points for a user for this segment
	 * @param user $user
	 */
	public function getBonusPointsBySegment( $user ) {
		$bonus_ids = array();
		foreach( $this->bonus as $bonus ) {
			$bonus_ids[] = $bonus->id;
		}
		if( count( $bonus_ids )) {
			$sql = "SELECT * FROM silk_bonusresponses AS br WHERE user_id = ? AND bonus_id IN (" . implode( ",", $bonus_ids ) . ")";
			$params = array( $user->id );
			$responses = \pool\Bonusresponses::find_all_by_query( $sql, $params );
			$userPoints = 0;
			foreach( $responses as $response ) {
				if( $response->value > 0 ) {
					$userPoints = $userPoints + $response->value;
				} 
			}
		}
		return $userPoints;
	}
	
	public function lockAllPicks( $user ) {
		if( empty( $user )) {
			$user = \silk\auth\UserSession::get_current_user();
		}
		foreach( $this->games as $game ) {
			$game->lockAllPicks( $user );
		}
	}
}
?>

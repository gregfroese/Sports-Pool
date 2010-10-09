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
//    	$this->has_association("stages", "stage_id");
//      $this->create_belongs_to_association('author', 'CmsUser', 'author_id');
//      $this->create_has_and_belongs_to_many_association('categories', 'BlogCategory', 'blog_post_categories', 'category_id', 'post_id', array('order' => 'name ASC'));
    }

	public function validate() {
		if( empty($this->params["name"]) ) $this->add_validation_error("Segments must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
	
	public function getAverages() {
		$avg = array();
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
}
?>
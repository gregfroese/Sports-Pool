<?php

namespace pool;
use \silk\orm\ActiveRecord;

class Game extends ActiveRecord {
	var $table = "games";

	function __construct()
    {
        parent::__construct();
    }

    function setup()
    {
    	$this->create_belongs_to_association( "hometeam", "pool\Team", "home_id");
    	$this->create_belongs_to_association( "awayteam", "pool\Team", "away_id");
    	$this->create_belongs_to_association( "winner", "pool\Team", "winner_id");
    	$this->create_belongs_to_association( "loserteam", "pool\Team", "loser_id");
    	$this->create_has_one_association( "awayteam", "pool\Team", "away_id");
    	$this->create_has_one_association( "winner", "pool\Team", "winner_id");
    	$this->create_has_one_association( "loser", "pool\Team", "loser_id");
    	$this->create_belongs_to_association( "status", "pool\Status", "status_id", array() );
    	$this->create_has_many_association( "points", "pool\Points", "game_id" );
    	$this->create_has_many_association( "picks", "pool\Pick", "game_id", array() );
//    	$this->has_association("stages", "stage_id");
//      $this->create_belongs_to_association('author', 'CmsUser', 'author_id');
//      $this->create_has_and_belongs_to_many_association('categories', 'BlogCategory', 'blog_post_categories', 'category_id', 'post_id', array('order' => 'name ASC'));
    }
    
    public function get_team( $team_id ) {
    	return \pool\Team::find_by_query( "select * from silk_teams where id=$team_id" );
    }
    
    public function closeGame() {
    	//close the actual game
    	$status = \pool\Status::find_status_by_category_and_name( "game", "Closed" );
    	$this->status_id = $status->id;
    	$this->save(); 
    	//lock all the picks for this game
    	$this->lockAllPicks();
    }
    
    public function lockAllPicks( $user = null ) {
    	$status = \pool\Status::find_status_by_category_and_name( "pick", "Locked" );
    	foreach( $this->picks as $pick ) {
    		if( empty( $user )) {
				$pick->status_id = $status->id;
    			$pick->save();
    		} elseif( $user->id == $pick->user_id ) {
    			$pick->status_id = $status->id;
    			$pick->save();
    		}
    	}
    }
    public function getAllPicks() {
    	$sql = "SELECT * FROM silk_picks AS sp WHERE game_id = ?";
    	$params = array( $this->id );
    	return \pool\Pick::find_all_by_query( $sql, $params );
    }
    
    public function reopenGame() {
    	$status = \pool\Status::find_status_by_category_and_name( "game", "Active" );
    	$this->status_id = $status->id;
    	$this->save(); 
    }
    
	public function getPoints( $user = null ) {
    	if( empty( $user )) {
    		$user = \silk\Auth\UserSession::get_current_user();
    	}
    	$sql = "SELECT * FROM silk_points AS sp WHERE game_id = ? AND user_id = ?";
    	$params = array( $this->id, $user->id );
    	return \pool\Points::find_by_query( $sql, $params );
    }
    
    public function getPick( $user = null ) {
    	if( empty( $user )) {
    		$user = \silk\Auth\UserSession::get_current_user();
    	}
    	$sql = "SELECT * FROM silk_picks AS sp WHERE game_id = ? AND user_id = ?";
    	$params = array( $this->id, $user->id );
    	return \pool\Pick::find_by_query( $sql, $params );
    }
    
    public function makePick( $user, $team_id ) {
    	//check if there is already a pick
    	$pick = $this->getPick( $user );
    	if( empty( $pick )) {
    		$pick = new \pool\Pick();
	    	$pick->game_id = $this->id;
	    	$pick->user_id = $user->id;
    	}
    	$pick->team_id = $team_id; //-1 is a tie
    	$pick->status_id = 7; //Open
    	$pick->save();
    }
    
    public function lockPick( $user ) {
    	$pick = $this->getPick( $user );
    	$pick->status_id = 8; //locked
    	$pick->save();
    }
    
    public function getAllPoints() {
    	$sql = "SELECT * FROM silk_points WHERE game_id = ?";
    	$params = array( $this->id );
    	$points = \pool\Points::find_all_by_query( $sql, $params );
    	return $points;
    }
    
    public function deleteAllPoints() {
    	foreach( $this->getAllPoints() as $points ) {
    		$points->delete();
    	}
    }
    
	public function validate() {
//		if( empty($this->params["name"]) ) $this->add_validation_error("Seasons must have a name.");
//		if( intval($this->params["startYear"] < date("yyyy"))) $this->add_validation_error("Season cannot exist in the past.");
	}
}
?>
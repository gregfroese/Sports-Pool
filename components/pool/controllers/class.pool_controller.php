<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class PoolController extends \silk\action\Controller {

	public function index( $params = null ) {
		/*show list of seasons*/
	//	$seasons = \pool\Season::find_all_by_status_id( 1 ); //why doesn't this work?
		$seasons = \pool\Season::find_all_by_query( "SELECT * FROM silk_seasons WHERE status_id=? ORDER BY id DESC", array( 1 ));
		$this->set( "seasons", $seasons );
		$this->set( "currentUser", \silk\Auth\UserSession::get_current_user() );
	}
	
	public function joinSeason( $params = array() ) {
		$season_id = $params["id"];
		$season = \pool\Season::find_by_id( $season_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$season->addMember( $user );
		\silk\action\Response::redirect_to_action( array( "action"=>"index" ));
	}
	
	public function leaveSeason( $params = array() ) {
		$season_id = $params["id"];
		$season = \pool\Season::find_by_id( $season_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$season->deleteMember( $user );
		\silk\action\Response::redirect_to_action( array( "action"=>"index" ));
	}
	
	public function viewSeason( $params = array() ) {
		$season_id = $params["id"];
		$season = \pool\Season::find_by_id( $season_id );
		$this->set( "season", $season );
	}
	
	public function enterPicks( $params = array() ) {
		$segment_id = $params["id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$this->set( "segment", $segment );
		$this->set( "date", date( "Y-m-d H:i:s" ));
	}
	
	public function pickTeam( $params = array() ) {
		$game_id = $params["id"];
		$game = \pool\Game::find_by_id( $game_id );
		$team_id = $params["subid"];
		$user = \silk\Auth\UserSession::get_current_user();
		$game->makePick( $user, $team_id );
		$this->set( "game", $game );
		$this->set( "date", date( "Y-m-d H:i:s" ));
	}
	
	public function lockPick( $params = array() ) {
		$game_id = $params["id"];
		$game = \pool\Game::find_by_id( $game_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$game->lockPick( $user );
		$this->set( "game", $game );
	}
	
	public function pickTie( $params = array() ) {
		$game_id = $params["id"];
		$game = \pool\Game::find_by_id( $game_id );
		$team_id = -1;
		$user = \silk\Auth\UserSession::get_current_user();
		$game->makePick( $user, $team_id );
		$this->set( "game", $game );
		$this->set( "date", date( "Y-m-d H:i:s" ));
	}
	
	public function viewScores( $params = array() ) {
		$segment_id = $params["id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$this->set( "segment", $segment );
		$this->set( "user", $user );
		$this->set( "currentUser", $user );
		$this->set( "order_of_games", $this->order_of_games( $segment ));
	}
	
	public function viewPicks( $params = array() ) {
		$segment_id = $params["id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$this->set( "segment", $segment );
		$this->set( "currentUser", $user );
		$this->set( "order_of_games", $this->order_of_games( $segment ));
	}
	
	private function order_of_games( $segment ) {
		//create an array of the games for a display helper
		$order_of_games = array();
		$count = 0;
		foreach( $segment->games as $game ) {
			$count++;
			$order_of_games[$count] = $game->id;
		}
		return $order_of_games;
	}
}
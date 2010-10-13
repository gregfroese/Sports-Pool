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
		//create a chart
		$chartPoints = $season->getPoints();
		$origChartPoints = $chartPoints;
		
		//find the high and low values for each segment
		$ranges = array();
		
		//set the current user's values
		$user = \silk\auth\UserSession::get_current_user();
		$userName = $user->first_name . " " . $user->last_name;
		$ranges[$userName] = $chartPoints[$userName];
		
		foreach( $season->segments as $segment ) {
			$chartPoints = $origChartPoints;
			foreach( $chartPoints as $name=>$segmentTotals ) {
				$chartPoints[$name]["sort"] = $chartPoints[$name][$segment->name];
			}
			$chartPoints = $season->sortChartPointsNoKey( $chartPoints );
			
			//don't use a segment that doesn't have any points yet
			if( !empty( $chartPoints[count($chartPoints)-1]["sort"] )) {
				$ranges["High"][$segment->name] = $chartPoints[count($chartPoints)-1]["sort"];
				//don't use a zero value for the low
				$count = 0;
				$ranges["Low"][$segment->name] = $chartPoints[$count]["sort"];
				while( $chartPoints[$count]["sort"] <= 0 ) {
					$count++;
					$ranges["Low"][$segment->name] = $chartPoints[$count]["sort"];
					if( $count > 100 ) break;
				}
			}
//			var_dump( $chartPoints, $range, count($chartPoints)-1 ); die;
		}
		//remove items in the user's array that isn't in the high/low ranges
		foreach( $ranges[$userName] as $key=>$value ) {
			if( !array_key_exists( $key, $ranges["High"] )) {
				unset( $ranges[$userName][$key] );
			}
		}		
		$points = $season->getPointsBySegment();
		$this->set( "points", $points );
		$this->set( "chartPoints", $chartPoints ); 
		$this->set( "season", $season );
		$this->set( "total", array() );
		$this->set( "ranges", $ranges );
		$this->set( "userName", $userName );
	}
	
	public function enterPicks( $params = array() ) {
		$segment_id = $params["id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$this->set( "segment", $segment );
		$this->set( "date", date( "Y-m-d H:i:s" ));
		$this->set( "user", \silk\auth\UserSession::get_current_user() );
	}
	
	public function pickTeam( $params = array() ) {
		$this->show_layout = false;
		$game_id = $params["id"];
		$game = \pool\Game::find_by_id( $game_id );
		$team_id = $params["subid"];
		$user = \silk\Auth\UserSession::get_current_user();
		$game->makePick( $user, $team_id );
		$this->set( "game", $game );
		$this->set( "date", date( "Y-m-d H:i:s" ));
	}
	
	public function lockPick( $params = array() ) {
		$this->show_layout = false;
		$game_id = $params["id"];
		$game = \pool\Game::find_by_id( $game_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$game->lockPick( $user );
		$this->set( "game", $game );
	}
	
	public function lockAllPicks( $params = array() ) {
		$segment_id = $params["segment_id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$segment->lockAllPicks( $user );
		\silk\action\Response::redirect_to_action( array( "controller"=>"pool", "action"=>"enterPicks", "id"=>$segment->id ));
	}
	
	public function pickTie( $params = array() ) {
		$this->show_layout = false;
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
		$this->set( "average", $segment->getAverages() );
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
	
	/**
	 * Ajax function to save a bonus response
	 * @param unknown_type $params
	 */
	public function saveBonus( $params = array() ) {
		$this->show_layout = false;
		$bonus_id = $params["bonus_id"];
		$user = \silk\auth\User::find_by_id( $params["user_id"] );
		$bonus = \pool\Bonus::find_by_id( $bonus_id );
		$bonus->saveResponse( $params["response"], $user );
		$this->set( "bonus", $bonus );
		$this->set( "date", date( "Y-m-d H:i:s" ));
		$this->set( "user", \silk\Auth\UserSession::get_current_user() );
	}
}

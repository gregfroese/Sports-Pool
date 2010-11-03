<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-
use pool\Game;
use silk\action\Request;
class SeasonmanagerController extends \silk\action\Controller {

	function index($params) {
		$seasons = \pool\Season::find_all(array("order" => "name ASC"));
		$this->set("seasons", $seasons );
	}

	function edit( $params ) {
		$season = \pool\Season::find_by_id( $params["id"] );
		if( !empty( $params["name"] )) { //creating a new one or saving an edit
			$season = new \pool\Season();
			$season->update_parameters( $params );
			$season->save();
			$this->set( "message", "$season->name saved successfully" );
		}
		
		$this->set( "season", $season );
		
		$statuses = \pool\Status::find_all_by_query( "select * from silk_status where category = 'season' order by name asc" );
		$this->set( "statuses", $statuses );
		$sports = \pool\Sport::find_all_by_query( "select * from silk_sports order by name asc" );
		$this->set( "sports", $sports );
		$this->set( "params", $params );
	}
	
	public function manage( $params = array() ) {
		$season = \pool\Season::find_by_id( $params["id"] );
		$segments = \pool\Segment::find_all_by_query( "select * from silk_segments where season_id=$season->id" );
		$this->set( "season", $season );
		$this->set( "segments", $segments );
	}
	
	public function editSegment( $params = array() ) {
		$season = \pool\Season::find_by_id( $params["id"] );
		$segment = \pool\Segment::find_by_id( $params["subid"] );
		if ( !empty( $params["save"] )) { //saving an edit or creating a new one
			if( !isset( $segment->id )) $segment = new \pool\Segment();
			$segment->update_parameters( $params );
			$segment->id = $params["subid"]; //override the id passed in $params
			$segment->save();
			$redirect = "/seasonmanager/manage/$season->id";
			\silk\action\Response::redirect( $redirect );
		}
		
		$this->set( "season", $season );
		$this->set( "segment", $segment );
		$statuses = \pool\Status::find_all_by_query( "select * from silk_status where category = 'segment' order by name asc" );
		$this->set( "statuses", $statuses );
		$this->set( "params", $params );
	}
	
	public function manageSegment( $params = array() ) {
		$season = \pool\Season::find_by_id( $params["id"] );
		$this->set( "season", $season );
		$segment = \pool\Segment::find_by_id( $params["subid"] );
		$this->set( "segment", $segment );
		$this->set( "games", $segment->games );
	}
	
	public function editGame( $params = array() ) {
		$segment = \pool\Segment::find_by_id( $params["id"] );
		$season = \pool\Season::find_by_id( $segment->season_id );
		$game = \pool\Game::find_by_id( $params["subid"] );
		
		if( !empty( $params["save"] )) { //creating a new game or saving an edit
			if( !isset( $game->id )) $game = new \pool\Game();
			$game->update_parameters( $params );
			$game->id = $params["subid"]; //override the id passed in $params
			$game->save();
			$redirect = "/seasonmanager/manageSegment/$season->id/$segment->id";
			\silk\action\Response::redirect( $redirect );
		}
		
		$sql = "select * from silk_teams where sport_id=" . $season->sport_id . " order by name ASC";
		$teams = \pool\Team::find_all_by_query( $sql );
		$this->set( "teams", $teams );
		$this->set( "game", $game );
		$this->set( "season", $season );
		$this->set( "segment", $segment );
		$statuses = \pool\Status::find_all_by_query( "select * from silk_status where category = 'game' order by name asc" );
		$this->set( "statuses", $statuses );
		$this->set( "params", $params );
	}
	
	public function closeGame( $params = array() ) {
		$this->show_layout = false;
		$game_id = $params["id"];
		$game = Game::find_by_id( $game_id );
		$game->closeGame();
		$this->set( "game", $game );
	}
	
	public function reopenGame( $params = array() ) {
		$this->show_layout = false;
		$game_id = $params["id"];
		$game = Game::find_by_id( $game_id );
		$game->reopenGame();
		$this->set( "game", $game );
	}
	
	public function getStatus( $params = array() ) {
		$this->show_layout = false;
		$game_id = $params["id"];
		$game = Game::find_by_id( $game_id );
		$this->set( "game", $game );
	}
	
	public function calculatePoints( $params ) {
		$segment = \pool\Segment::find_by_id( $params["id"] );
		//remove all points from the segment - don't worry, they're all re-calculated
		//this is necessary in case a game is re-opened
		$segment->deletePoints();
		$closedGames = 0;
		
		ob_start();
		foreach( $segment->games as $game ) {
			//only calc points for closed games
			if( $game->status->name == "Closed" ) {
				$closedGames++;
				//have to lock all picks here in case the game was closed on the edit screen
				$game->lockAllPicks();
				//delete all the points already assigned for this game so we can recalc at any time
				$game->deleteAllPoints();
				//calculate the point difference - used for determining ties
				$pointDiff = abs( $game->away_score - $game->home_score );
				if( $pointDiff <= 3 ) {
					$tie = true;
				} else {
					$tie = false;
				}
				
				//find the winner v3 2010.11.02
				echo $game->awayteam->name . "($game->away_id): $game->away_score vs " . $game->hometeam->name . "($game->home_id): $game->home_score<br />";
				if( $game->home_score > $game->away_score ) { //home team wins
					$winner = $game->home_id;
				} elseif( $game->away_score > $game->home_score ) { //away team wins
					$winner = $game->away_id;
				}
				
				//give out points
				foreach( $segment->season->users as $user ) {
					$pick = $game->getPick( $user );
					if( !empty( $pick )) {
						echo "user: $user->first_name picked $pick->team_id<br />winner: $winner<br />";
						$gamePoints = 0;
						//if the pick was a winner, give some points
						if( $pick->team_id == $winner ) {
							$gamePoints = $game->modifier;
							//double the points if the user correctly picked a tie
							echo "$user->first_name got it right - $gamePoints points<br />";
						}
						
						//if the game was a tie and the user picked a tie, they get double the points
						if( $tie && $pick->team_id == -1 ) {
							$gamePoints = $game->modifier * 2;
						}
						$points = new pool\Points();
						$points->user_id = $user->id;
						$points->game_id = $game->id;
						$points->points = $gamePoints;
						$points->save();
					}
				}
			}
		}
		//delete all the user stats and season stats for this segment
		$segment->cleanStats();
		
		//store each user's points in the userstats table
		$allPoints = array(); //store them all so we can get the high/low out
		foreach( $segment->season->users as $user ) {
			$userStats = \pool\Userstats::find_by_user_id_and_segment_id( $user->id, $segment->id );
			$points = $segment->getPointsBySegment( $user );
			if( empty( $userStats )) {
				$userStats = new \pool\Userstats();
				$userStats->user_id = $user->id;
				$userStats->season_id = $segment->season->id;
				$userStats->segment_id = $segment->id;
				$userStats->points = $points;
			} else {
				$userStats->points = $points;
			}
			$userStats->save();
			//@TODO: add a flag on a user to include or exclude them from the stats
			//they might have just stopped participating so who cares, don't drag down the rest
			if( $points ) {
				$allPoints[] = $points;
			}
		}
		//store the high and low for this segment in seasonstats table
		sort( $allPoints );
		if( count( $allPoints )) { //don't need to do anything if there are no points
			$seasonStats = \pool\Seasonstats::find_by_season_id_and_segment_id( $segment->season->id, $segment->id );
			if( empty( $seasonStats )) {
				$seasonStats = new \pool\Seasonstats();
				$seasonStats->season_id = $segment->season->id;
				$seasonStats->segment_id = $segment->id;
			}
			$seasonStats->high = $allPoints[count( $allPoints ) - 1];
			$seasonStats->low = $allPoints[0];
			$seasonStats->save();
		}
		$contents = ob_get_contents();
		ob_end_clean();
		silk\action\Response::redirect_to_action( array( "controller"=>"seasonmanager", "action"=>"manageSegment", "id"=>$segment->season_id, "subid"=>$segment->id ));
	}

	/**
	 * Ajax function to return statistical data
	 * @param array $params
	 */
	public function createChart( $params = array() ) {
		$this->show_layout = false;
		$season_id = $params["season_id"];
		$season = \pool\Season::find_by_id( $season_id );
		$points = $season->getPointsBySegment();
		$this->set( "data", json_encode( $points ));
	}
	
	public function enterScores( $params = array() ) {
		$segment_id = $params["id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$this->set( "segment", $segment );
		$this->set( "currentUser", $user );
	}
	
	public function saveScores( $params = array() ) {
		$segment_id = $params["segment_id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		foreach( $segment->games as $game ) {
			if( isset( $params["away_score"][$game->id]) && isset( $params["home_score"][$game->id] )) {
				$game->away_score = $params["away_score"][$game->id];
				$game->home_score = $params["home_score"][$game->id];
				$game->save();
			}
		}
		silk\action\Response::redirect_to_action( array( "controller"=>"seasonmanager", "action"=>"manageSegment", "id"=>$segment->season_id, "subid"=>$segment->id ));
	}
	
	public function editBonus( $params = array() ) {
		$segment_id = $params["id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$user = \silk\Auth\UserSession::get_current_user();
		$statuses = \pool\Status::find_all_by_query( "SELECT * FROM silk_status WHERE category=? ORDER BY id ASC", array( "bonus" ));
		if( empty( $params["bonus_id"] )) {
			$bonus = new \pool\Bonus();
		} else {
			$bonus = \pool\Bonus::find_by_id( $params["bonus_id"] );
		}
		$this->set( "bonus", $bonus );
		$this->set( "statuses", $statuses );
		$this->set( "segment", $segment );
		$this->set( "currentUser", $user );
	}
	
	public function saveBonus( $params = array() ) {
		$segment_id = $params["segment_id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		if( empty( $params["bonus_id"] )) {
			$bonus = new \pool\Bonus();
			$bonus->update_parameters( $params );
		} else {
			$bonus = \pool\Bonus::find_by_id( $params["bonus_id"] );
			$bonus->update_parameters( $params );
			$bonus->id = $params["bonus_id"]; //id is overwritten here so we'll reset it
		}
		$bonus->save();
		\silk\action\Response::redirect_to_action( array( "controller"=>"seasonmanager", "action"=>"manageSegment", "id"=>$segment->season_id, "subid"=>$segment->id ));
	}
	
	public function markBonusWinners( $params = array() ) {
		$segment_id = $params["id"];
		$segment = \pool\Segment::find_by_id( $segment_id );
		$bonus = \pool\Bonus::find_by_id( $params["bonus_id"] );
//		var_dump( $bonus );
//		var_dump( $bonus->responses ); die;
		$this->set( "segment", $segment );
		$this->set( "bonus", $bonus );
	}
	
	/**
	 * Ajax function to mark a bonus response as being correct
	 * @param unknown_type $params
	 */
	public function winner( $params = array() ) {
		$this->show_layout = false;
		$response_id = $params["id"];
		$response = \pool\Bonusresponses::find_by_id( $response_id );
		$response->value = $response->bonus->modifier;
		$response->save();
		$this->set( "response", $response );		
	}
	
/**
	 * Ajax function to mark a bonus response as being incorrect
	 * @param unknown_type $params
	 */
	public function loser( $params = array() ) {
		$this->show_layout = false;
		$response_id = $params["id"];
		$response = \pool\Bonusresponses::find_by_id( $response_id );
		$response->value = 0;
		$response->save();
		$this->set( "response", $response );		
	}
}
?>

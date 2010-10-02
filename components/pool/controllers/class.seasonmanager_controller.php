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
			
		/* old code, no idea how much of it works
		 * 
//		$fields = array( "	end_year" => array( "visible" => "none" ),
//							"id" => array( "visible" => "yes") );
		$fields = array(
			"end_year" => array("label" => "Label override")
		);
		$form_params = array( 	"controller" => "season_manager",
								"method" => "editSeason_save",
								"action" => "editSeason_save",
								"submitValue" => "Save Changes",
								"fields" => $fields);

//		echo "<pre>"; var_dump($params); echo "</pre>";

		if( $params["input"] == $form_params["submitValue"] ) {
			//process the save
			//show result
			$this->set("form", orm('season')->data_table($form_params), null);
			return;
		}

		$season = orm('season');
		$one_season = $season->find_all(array("conditions" => array("id = ".$params["id"])));
//		echo "<pre>"; var_dump($one_season); echo "</pre>";

		$result = SilkForm::auto_form($form_params, $one_season);
		$this->set("form", $result);
		*/
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
		$game_id = $params["id"];
		$game = Game::find_by_id( $game_id );
		$game->closeGame();
		$this->set( "game", $game );
	}
	
	public function reopenGame( $params = array() ) {
		$game_id = $params["id"];
		$game = Game::find_by_id( $game_id );
		$game->reopenGame();
		$this->set( "game", $game );
	}
	
	public function getStatus( $params = array() ) {
		$game_id = $params["id"];
		$game = Game::find_by_id( $game_id );
		$this->set( "game", $game );
	}
	
	public function calculatePoints( $params ) {
		$segment = \pool\Segment::find_by_id( $params["id"] );
		
		
		$closedGames = 0;
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
				
				echo $game->awayteam->name . "($game->away_id): $game->away_score vs " . $game->hometeam->name . "($game->home_id): $game->home_score<br />";
				//find the winner
				if( $game->home_score > $game->away_score + 3 ) { //home team wins
					$winner = $game->home_id;
					echo "Home wins!<br />";
				} elseif( $game->away_score > $game->home_score + 3 ) { //away team wins
					$winner = $game->away_id;
					echo "Away wins!<br />";
				} elseif( $pointDiff >=0 && $pointDiff <=3 ) { //tie
					$winner = -1;
					echo "Tie!<br />";
				}
				
				//give out points
				foreach( $segment->season->users as $user ) {
					$pick = $game->getPick( $user );
					echo "user: $user->first_name picked $pick->team_id<br />winner: $winner<br />";
					$gamePoints = 0;
					if( $pick->team_id == $winner ) {
						$gamePoints = $game->modifier;
						//double the points if the user correctly picked a tie
						if( $winner == -1 ) {
							$gamePoints = $gamePoints * 2;
						}
						echo "$user->first_name got it right - $gamePoints points<br />";
					}
					$points = new pool\Points();
					$points->user_id = $user->id;
					$points->game_id = $game->id;
					$points->points = $gamePoints;
					$points->save();
				}
			}
		}
		silk\action\Response::redirect_to_action( array( "controller"=>"seasonmanager", "action"=>"manageSegment", "id"=>$segment->season_id, "subid"=>$segment->id ));
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
}
?>

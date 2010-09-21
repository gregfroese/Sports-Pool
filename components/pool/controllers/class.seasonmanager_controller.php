<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-
class SeasonmanagerController extends \silk\action\Controller {

	function index($params) {
		$seasons = \pool\Season::find_all(array("order" => "name ASC"));
		$this->set("seasons", $seasons );
		/*
		 * this goes in listseasons.tpl once stages are setup
		 <td>
	      {foreach from=$season->stages item=entry key=name}
	      {strip}
	      {$entry.name}<br />
	      {/strip}
	      {/foreach}
	  	</td>
		 */
	}

	function edit( $params ) {
		$season = \pool\Season::find_by_id( $params["id"] );
		if( $params["id"] == "0" ) { //creating a new one
			$season = new \pool\Season();
			$season->update_parameters( $params );
			$season->save();
			$this->set( "message", "Created $season->name successfully" );
		} elseif ( isset( $params["name"] )) { //saving an edit
			$season->update_parameters( $params, $season );
			$season->save();
			$this->set( "message", "Saved $season->name successfully" );
		}
		
		$this->set( "season", $season );
		
		$statuses = \pool\Status::find_all_by_query( "select * from silk_status where category = 'season' order by name asc" );
		$this->set( "statuses", $statuses );
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
		$segments = \pool\Segment::find_all_by_query( "select * from silk_segments where seasonid=$season->id" );
		$this->set( "season", $season );
		$this->set( "segments", $segments );
	}
	
	public function editSegment( $params = array() ) {
		$season = \pool\Season::find_by_id( $params["id"] );
		if( $params["subid"] == "0" ) { //new segment
			$segment = new \pool\Segment();
			$segment->fill_object( $params, $segment );
			$segment->id = 0; //override the id passed in $params
			$segment->seasonid = $season->id;
			$segment->dirty = true;
			$segment->save();
			$this->set( "message", "Created $segment->name successfully" );
		} elseif ( isset( $params["name"] )) { //saving an edit
			$segment = \pool\Segment::find_by_id( $params["subid"] );
			$segment->fill_object( $params, $segment );
			$segment->id = $params["subid"]; //override the id passed in $params
			$segment->dirty = true;
			$segment->save();
			$this->set( "message", "Saved $segment->name successfully" );
		}
		
		if( !isset( $segment )) {
			$segment = \pool\Segment::find_by_id( $params["subid"] );
		}
		$this->set( "season", $season );
		$this->set( "segment", $segment );
		$statuses = \pool\Status::find_all_by_query( "select * from silk_status where category = 'segment' order by name asc" );
		$this->set( "statuses", $statuses );
		$this->set( "params", $params );
	}
	
	public function manageSegment( $params = array() ) {
		$this->set( "season", \pool\Season::find_by_id( $params["id"] ));
		$segment = \pool\Segment::find_by_id( $params["subid"] );
		$this->set( "segment", $segment );
		$this->set( "games", $segment->games );
	}
	
	public function editGame( $params = array() ) {
		$segment = \pool\Segment::find_by_id( $params["id"] );
		$season = \pool\Season::find_by_id( $segment->seasonid );
		
		if( $params["subid"] == 0 ) { //new game
			$game = new \pool\Game();
			$game->fill_object( $params, $game );
			$game->id = 0; //override the id passed in $params
			$game->home_id = 0;
			$game->away_id = 0;
			$game->segment_id = $segment->id;
			$game->dirty = true;
			$game->save();
			$redirect = "/seasonmanager/editGame/$segment->id/$game->id";
			\silk\action\Response::redirect( $redirect );
		} elseif ( isset( $params["home_id"] )) { //saving an edit
			$game = \pool\Game::find_by_id( $params["subid"] );
			$game->fill_object( $params, $game );
			$game->segment_id = $segment->id;
			$game->id = $params["subid"]; //override the id passed in $params
			$game->dirty = true;
			$game->save();
			$redirect = "/seasonmanager/manageSegment/$season->id/$segment->id";
			\silk\action\Response::redirect( $redirect );
		}
		
		if( !isset( $game )) {
			$game = \pool\Game::find_by_id( $params["subid"] );
		}
		$sql = "select * from silk_teams where sport_id=" . $season->sport_id . " order by name ASC";
		$this->set( "teams", \pool\Team::find_all_by_query( $sql ));
		$this->set( "game", $game );
		$this->set( "season", $season );
		$this->set( "segment", $segment );
		$statuses = \pool\Status::find_all_by_query( "select * from silk_status where category = 'game' order by name asc" );
		$this->set( "statuses", $statuses );
		$this->set( "params", $params );
	}
}
?>

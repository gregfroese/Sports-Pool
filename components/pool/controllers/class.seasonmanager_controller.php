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
		$segments = \pool\Segment::find_all_by_query( "select * from silk_segments where seasonid=$season->id" );
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
		$this->set( "season", \pool\Season::find_by_id( $params["id"] ));
		$segment = \pool\Segment::find_by_id( $params["subid"] );
		$this->set( "segment", $segment );
		$this->set( "games", $segment->games );
	}
	
	public function editGame( $params = array() ) {
		$segment = \pool\Segment::find_by_id( $params["id"] );
		$season = \pool\Season::find_by_id( $segment->seasonid );
		$game = \pool\Game::find_by_id( $params["subid"] );
		var_dump( $params );
		
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
}
?>

<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-
class SeasonmanagerController extends \silk\action\Controller {

	function listSeasons($params) {
//		$seasons = orm('season')->find_all(array("order" => "name ASC"));
		$seasons = Season::find_all(array("order" => "name ASC"));
		var_dump( $seasons );
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

	function createSeason($params) {

		if( $params["input"]) {
			$season = new Season();
			$season->name = $params["seasonName"];
			$season->start_year = $params["startYear"];
			$season->end_year = $params["endYear"];
			$season->status_id = $params["status"];
			if (!$season->save()) {
				echo "Save failed<br />";
				$this->set("saveErrors", $season->validation_errors);
				return;
			}
			$savedSeason = $season->data_table($season);
			var_dump( $savedSeason ); die;
			$this->set("savedSeason", $savedSeason);
		}
	}

	function createSeasonStore($params) {

	}

	function showSeasonORM($params) {
		$seasons = orm('season')->find_all(array("order" => "name ASC"));
		echo "<pre>"; var_dump($seasons); echo "</pre>";
	}

	function editSeason($params) {

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
	}
}
?>
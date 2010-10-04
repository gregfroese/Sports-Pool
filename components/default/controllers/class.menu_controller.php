<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class MenuController extends \silk\action\Controller {
	public function index( $params = array() ) {
		$user = \silk\Auth\UserSession::get_current_user();
		$menu = "";
		$this->set( "user", $user );
		$seasons = array();
		foreach( \pool\Season::find_all( array( "order by"=>"name ASC")) as $season ) {
			if( $season->isMember( $user )) {
				$seasons[$season->id] = $season;
			}
		}
		$nonMemberSeasons = array();
		foreach( \pool\Season::find_all( array( "order by"=>"name ASC")) as $season ) {
			if( !$season->isMember( $user )) {
				$nonMemberSeasons[$season->id] = $season;
			}
		}
		$this->set( "seasons", $seasons );
		$this->set( "nonMemberSeasons", $nonMemberSeasons );
	}
}
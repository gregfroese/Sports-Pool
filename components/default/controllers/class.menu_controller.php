<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class MenuController extends \silk\action\Controller {
	public function index( $params = array() ) {
		$user = \silk\Auth\UserSession::get_current_user();
		$menu = "";
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
		$this->set( "user", $user );
		$this->set( "seasons", $seasons );
		$this->set( "nonMemberSeasons", $nonMemberSeasons );
	}

	public function admin( $params = array() ) {
		$user = \silk\Auth\UserSession::get_current_user();
		//check if an administrator (better ways to do this I'm sure)
                if( !empty( $user )) {
                        foreach( $user->groups as $group ) {
                                if( $group->name == "administrators" ) {
                                        $user->administrator = true;
                                }
                        }
                }
		//don't bother getting more info if we don't need it
		if( $user->administrator ) {
			$seasons = array();
			foreach( \pool\Season::find_all( array( "order by"=>"name ASC")) as $season ) {
				$seasons[$season->id] = $season;
			}
		}
                $this->set( "user", $user );
		$this->set( "seasons", $seasons );
	}
}

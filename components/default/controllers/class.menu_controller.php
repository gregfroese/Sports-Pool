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
	}
}
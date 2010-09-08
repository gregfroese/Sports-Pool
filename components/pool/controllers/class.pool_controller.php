<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class PoolController extends \silk\action\Controller {

function index( $params = null ) {
	$users = \silk\auth\User::find_all();
	$this->set('users', $users);
	foreach( $users as $user ) {
		$user->set_password( date( "Y-m-d H:i:s" ) );
		$user->email = date( "Y-m-d H:i:s" );
		$result = $user->save();
		var_dump( "save result $result" );
//		var_dump( $user );
		$us = new \silk\auth\UserSession( array( "username"=>$user->username, "password"=>"a" ));
		$result = $us->login();
		var_dump( "result", $result ); die;
	}
}

function dashboard($params) {
}

}
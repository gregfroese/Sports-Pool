<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class PoolController extends \silk\action\Controller {

function index( $params = null ) {
	/*
	$users = \silk\auth\User::find_all();
	$this->set('users', $users);
	foreach( $users as $user ) {
		$pass = "greg";
		$user->set_password( $pass );
		$user->email = date( "Y-m-d H:i:s" );
		$result = $user->save();
		var_dump( "save result $result" );
		$us = new \silk\auth\UserSession( array( "username"=>$user->username, "password"=>$pass ));
		$result = $us->login();
	}
	*/
}

function dashboard($params) {
}

}
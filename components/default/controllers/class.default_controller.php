<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class DefaultController extends \silk\action\Controller {

function index( $params = null ) {
	if( \silk\auth\UserSession::is_logged_in() ) {
		var_dump( "logged in" );
		$user = \silk\auth\UserSession::get_current_user();
	} else {
		var_dump( "NOT logged in" );
		$user = null;
	}
	var_dump( $user );
	$this->set( "user", $user );
	
	/*$users = \silk\auth\User::find_all();
	$this->set('users', $users);
	foreach( $users as $user ) {
		$pass = "aasdfasdfds";
		$user->set_password( $pass );
		$user->email = date( "Y-m-d H:i:s" );
		$result = $user->save();
		var_dump( "save result $result" );
//		var_dump( $user );
		$us = new \silk\auth\UserSession( array( "username"=>$user->username, "password"=>$pass ));
		$result = $us->login();
		var_dump( "result", $result );
	}*/
}

function test_ajax($params)  {
	    $this->show_layout = false;
	    $resp = new SilkAjax();
	    $resp->replace_html("#some_content", "New content says 'Hi!'");
	    $resp->replace("#some_content", "style", "color: red;");
	    $resp->insert("#some_content", " Append me, baby!");
	    $resp->insert("#some_content", "Prepend me, too. ", "prepend");
	    $resp->insert("#some_content", "<div id='after'>After</div>", "after");
	    $resp->insert("#some_content", "Before ", "before");
	    $resp->remove("#after");
	    return $resp->get_result();
	}
}


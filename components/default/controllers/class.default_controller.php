<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

//use silk\action\Request;
class DefaultController extends \silk\action\Controller {

function index( $params = null ) {
	if( isset( $_POST["username"] )) {
		$user = \silk\auth\User::find_by_username( $_POST["username"] );
		$session = new \silk\auth\UserSession( $params );
		if ( !$session->login() ) {
			$this->set( "error", "Wrong username or password" );
			$user = null;
		}
	}
	if( \silk\auth\UserSession::is_logged_in() ) {
		//just redirect to the main pool page
		\silk\action\Response::redirect_to_action( array( "controller"=>"pool", "action"=>"index" ));
		$user = \silk\auth\UserSession::get_current_user();
	} else {
		$user = null;
	}
	$this->set( "user", $user );
	
}

public function logout() {
	\silk\auth\UserSession::logout();
	\silk\action\Response::redirect_to_action(array('action' => 'index'));
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


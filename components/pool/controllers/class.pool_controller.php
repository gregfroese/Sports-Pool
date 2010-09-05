<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class PoolController extends \silk\action\Controller {

function index( $params = null ) {
	$users = \silk\auth\User::find_all();
	$this->set('users', $users);
}

function dashboard($params) {
}

}
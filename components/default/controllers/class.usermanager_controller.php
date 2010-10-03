<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class UsermanagerController extends \silk\action\Controller {
	public function index( $params = null ) {
		$users = \silk\auth\User::find_all();
		$this->set( "users", $users );
	}
	
	public function saveUser( $params = array() ) {
		$user_id = $params["user_id"];
		if( empty( $user_id )) {
			$user = new \silk\auth\User();
		} else {
			$user = \silk\auth\User::find_by_id( $user_id );
		}
		//don't know why id is coming through as empty
		if( empty( $params["id"] )) {
			$params["id"] = $user_id;
		}

		if( isset( $params["password"] ) && isset( $params["confirm_password"] )) {
			if( $params["password"] != $params["confirm_password"] ) {
				$this->set( "error", "Passwords do not match" );
			} elseif( $params["password"] == "" ) {
				//remove it from params so we don't change the value in the user object if it wasn't set
				unset( $params["password"] );
			}
		}
		
		$user->update_parameters( $params );
		$user->save();
		
		if( isset( $params["group_id"] ) && $params["group_id"] != 0 ) {
			//check if the user is already in the group - don't add them again
			$alreadyMember = false;
			foreach( $user->groups as $group ) {
				if( $group->id == $params["group_id"] ) {
					$alreadyMember = true;
					break;
				}
			}
			
			if( !$alreadyMember ) {
				$group = \silk\auth\Group::find_by_id( $params["group_id"] );
				$group->add_user( $user );
			}
		}
		silk\action\Response::redirect_to_action( array( "controller"=>"usermanager", "action"=>"index" ));
	}
	
	public function edit( $params = null ) {
		if( !empty( $params["id"] ) && $params["id"] !== "0" ) {
			$user = \silk\auth\User::find_by_id( $params["id"] );
		}
		$this->set( "user", $user );
		$groups = \silk\auth\Group::find_all( array( "order by"=>"name ASC" ));
		$groupArray = array();
		foreach( $groups as $group ) {
			if( $group->name != "anonymous" ) {
				$groupArray[$group->id] = $group->name;
			}
		}
		array_unshift( $groupArray, "Select Group" );
		$this->set( "allGroups", $groupArray );
	}
	
	public function deleteMember( $params = array() ) {
		$user = \silk\auth\User::find_by_id( $params["user_id"] );
		$group = \silk\auth\Group::find_by_id( $params["group_id"] );
		$group->remove_user( $user );
		silk\action\Response::redirect_to_action( array( "controller"=>"usermanager", "action"=>"index" ));
	}
}

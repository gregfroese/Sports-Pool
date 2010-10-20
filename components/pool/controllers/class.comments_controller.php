<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-

/**
* @author Greg Froese
*
*/

class CommentsController extends \silk\action\Controller {
	public function index( $params = array() ) {
		$this->set( "season", $params["season"] );
	}
	
	public function saveComment( $params = array() ) {
		$this->show_layout = false;
		$season_id = $params["season_id"];
		$season = \pool\Season::find_by_id( $season_id );
		$user = \silk\auth\UserSession::get_current_user();
		$com = $params["comment"];
		$comment = new \pool\Comments();
		$comment->user_id = $user->id;
		$comment->season_id = $season_id;
		$comment->comment = $com;
		$comment->save();
		$this->set( "season", $season );
	}
	
	/**
	 * Allow another controller to call this action to display the comments
	 * @param array $params
	 * @author Greg Froese
	 * @since Oct 19, 2010
	 */
	public function comments( $params = array() ) {
		$this->show_layout = false;
		$this->set( "season", $params["season"] );
	}
	
	public function getComments( $params = array() ) {
		$season_id = $params["id"];
		$season = \pool\Season::find_by_id( $season_id );
		$this->show_layout = false;
		$this->set( "season", $season );
	}
}
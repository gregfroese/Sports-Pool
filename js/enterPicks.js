 $(document).ready(function() {
 } );

function pickTeam( game_id, team_id ) {
	var link = "/pool/pickTeam/" + game_id + "/" + team_id;
	$(".game_" + game_id).load( link );
	return false;
}

function lockPick( game_id ) {
	var link = "/pool/lockPick/" + game_id;
	$(".game_" + game_id).load( link );
	return false;
}

function pickTie( game_id ) {
	var link = "/pool/pickTie/" + game_id;
	$(".game_" + game_id).load( link );
	return false;
}
function closeGame( game_id ) {
	var link = "/seasonmanager/closeGame/" + game_id;
	$(".gameAction_" + game_id).load( link );
	link = "/seasonmanager/getStatus/" + game_id;
	$(".gameStatus_" + game_id).load( link );
	return false;
}

function reopenGame( game_id ) {
	var link = "/seasonmanager/reopenGame/" + game_id;
	$(".gameAction_" + game_id).load( link );
	link = "/seasonmanager/getStatus/" + game_id;
	$(".gameStatus_" + game_id).load( link );
	return false;
}
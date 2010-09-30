 $(document).ready(function() {
 } );

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
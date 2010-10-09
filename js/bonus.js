function markWinner( response_id ) {
	var link = "/seasonmanager/winner/" + response_id;
	$(".user_" + response_id).load( link );
	return false;
}

function markLoser( response_id ) {
	var link = "/seasonmanager/loser/" + response_id;
	$(".user_" + response_id).load( link );
	return false;
}
 $(document).ready(function() {
	 init();
 } );

function init() {
	$(".closeGame").each(function() {
	    $(this).click( function() {
	    	var game_id = $(this).attr("href");
	    	link = "/seasonmanager/closeGame/" + game_id;
	    	$(".game_" + game_id).load( link );
	    	return false;
	    });
	 });
}
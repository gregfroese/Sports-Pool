$(document).ready(function() {
	//load the comments the first time
	season_id = $("input[name=season_id]").val();
	html = $(".commentContainer").val();
	link = "/comments/getComments/" + season_id;
	$(".commentContainer").load( link );
	
	$(".commentSubmit").unbind('click');
	$(".commentSubmit").click( function() {
		submitComment();
		return false;
	});
	$(window).keypress(function(e) {
	    if(e.keyCode == 13) {
	       submitComment();
	    }
	} );
} );

function submitComment() {
	season_id = $("input[name=season_id]").val();
	comment = $(".commentBox").val();
	if( comment != "" ) {
		$.post("/comments/saveComment", { season_id: season_id, comment: comment },
				   function(data){
				     $(".commentContainer").html(data);
				   });
		$(".commentBox").val("");
	}
	return false;
}

function toggleComments() {
	$(".commentContainer").toggleClass("hide");
	$(".commentAdd").toggleClass("hide");
	return false;
}

function getComments( season_id, page, limit ) {
	$.post("/comments/getComments", { season_id: season_id, page: page, limit: limit },
			function(data) {
				$(".commentContainer").html(data);
			});
	return false;
}
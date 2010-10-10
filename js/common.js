$(document).ready(function() {
	$(".datepicker").each( function() {
		$(this).AnyTime_picker(
			      { format: "%Z-%m-%d %k:%i:%S", firstDOW: 0 } );
	});
} );
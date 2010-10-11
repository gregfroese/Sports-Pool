$(document).ready(function() {
	//setup any date fields
	$(".datepicker").each( function() {
		$(this).AnyTime_picker(
			      { format: "%Z-%m-%d %k:%i:%S", firstDOW: 0 } );
	});
	
	//setup any tooltips
	$(".tip").each( function() {
		$(this).tipTip();
	});

	//setting up accordions
	$('.accordion').accordion();
} );
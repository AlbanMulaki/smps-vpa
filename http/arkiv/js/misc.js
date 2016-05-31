$(document).ready(function(){	
	var sudoSlider = $(".testimonial_wrapp").sudoSlider({
		autowidth:false,
		slideCount:3,
		continuous:true,
		numeric:false,
		vertical:true,
		auto: true,
		pause: 6000
	});
});

$(window).load(function() {
        $('#slider').nivoSlider();
    });
	
$(function(){
    $('#counter').countdown({
        image: 'images/digits.png',
    	startTime: '01:12:12:00'
	});
});

$(".close").live("click", function(event) {
    //code to close description, dosent work
    event.stopPropagation();
    $(".notification").fadeOut("normal", function() {
        $(this).remove();
    });
});
$(document).ready(function(){
var sudoSlider = $(".carouselpro_wrapp").sudoSlider({
continuous:true,auto:false,prevNext:true,autowidth:false,slideCount:4
});
var sudoSlider = $(".carouselsec_wrapp").sudoSlider({
continuous:true,auto:false,prevNext:true,autowidth:false,slideCount:5
});
});

$(document).ready(function(){
	$("#contactform").validate();
});
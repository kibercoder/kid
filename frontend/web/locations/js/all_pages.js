function is_touch_device() {
      return 'ontouchstart' in window        // works on most browsers 
      || navigator.maxTouchPoints;       // works on IE10/11 and Surface
};

var statusPlayback = true;

$(function(){
	//var fontSize = $('a i.center_part').css('font-size');
	//$('#touches').prepend(fontSize);

	$("video#bgvideo").bind('ended', function(){
		return stop_movie();
	  //$.mobile.changePage($('#idofpageyouwantogoto'), 'fade');
	});

	$('#stop_movie').click(function(){
		return stop_movie();
	});

	var v = document.getElementById("bgvideo");

	if (v != null) {

		$('#wrapper').click(function(){
			if (statusPlayback) {
				if (v.paused) {
				 	v.play();
				} else {
				 	v.pause();
				}
			}
		});

	}


});

function stop_movie(){
		statusPlayback = false;
		$('video.fade, #stop_movie').animate({opacity : 0}, 300, function(){
			$('video.fade, #stop_movie').remove();
		});
}
function is_touch_device() {
      return 'ontouchstart' in window        // works on most browsers 
      || navigator.maxTouchPoints;       // works on IE10/11 and Surface
};

$(function(){
	//var fontSize = $('a i.center_part').css('font-size');
	//$('#touches').prepend(fontSize);

	$("video#PB_Landing6__video").bind('ended', function(){
		return stop_movie();
	  //$.mobile.changePage($('#idofpageyouwantogoto'), 'fade');
	});

	$('#stop_movie').click(function(){
		return stop_movie();
	});

	//сдвигаем фоновое видео чтобы оно было по центру
	left_shift();
	//При изменении окна снова сдвигаем
	$( window ).resize(function() {
	  	return left_shift();
	});


	//Чтобы включить видео для сенсорных устройств 
	//нужно сделать возможность включения по клику
	/*var v = document.getElementById("PB_Landing6__video");

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

	}*/


});

function stop_movie(){
		statusPlayback = false;
		$('video.fade, #stop_movie').animate({opacity : 0}, 300, function(){
			$('video.fade, #stop_movie').remove();
		});
}

function left_shift(){
	var v = $("#PB_Landing6__video");

	if (v != null) {

		var doc_w = parseInt($( window ).width());
		//var v_width = parseInt(v.width());
		var v_width = 1920;

		$('#GlobalContent').css('width', v_width+'px');

		//alert(doc_w);

		if (doc_w < v_width) {
			var dif = v_width - doc_w;
			var left_shift = dif / 2;
			$(v).css('left', -left_shift+'px');
		}

	} else {
		$('#GlobalContent').css('left', 0).css('right', 0).css('margin', '0 auto');
	}
}
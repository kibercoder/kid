/** busTracer **/

(function(){

	var _defaults = {
		fps: 100,
		pathTime: 10000,
		point: [],
		showPoints: true,
		playing: false,

		onInit: function(el){},
		onChangeBreakpoint: function(data){},
	};

	$.fn.busTracer = function(options){

		if(this.length == 0) return this;

		if(this.length > 1){
			this.each(function(){$(this).busTracer(options)});
			return this;
		}

		var el = this;

		var _private = {
			confiq:  $.extend({}, _defaults, options),

			setPosition: function(){
				el.css(_private.data.currentPosition);
			},

			data: {
				playing: false,
				timer: null,
				currentBreakpoint: 0,
				nextBreakpoint: 1,
				currentPosition: null,
				path: {
					distance:[],
					distanceAll:0,
					time:[],
					delta:{
						x:[],
						y:[]
					}
				}
			},

			move: {
				play: function(){

					if ( !_private.data.playing ){
						_private.data.playing = true;
						_private.data.timer = setInterval(function(){

							_private.data.currentPosition.left += _private.data.path.delta.x[_private.data.currentBreakpoint];
							_private.data.currentPosition.top  += _private.data.path.delta.y[_private.data.currentBreakpoint];
							_private.setPosition();

							if (
								( _private.data.path.delta.x[_private.data.currentBreakpoint] >= 0 && _private.data.currentPosition.left >= _private.confiq.point[_private.data.nextBreakpoint][0] ) ||
								( _private.data.path.delta.y[_private.data.currentBreakpoint] >= 0 && _private.data.currentPosition.top >= _private.confiq.point[_private.data.nextBreakpoint][1] ) ||
								( _private.data.path.delta.x[_private.data.currentBreakpoint] < 0 && _private.data.currentPosition.left < _private.confiq.point[_private.data.nextBreakpoint][0] ) ||
								( _private.data.path.delta.y[_private.data.currentBreakpoint] < 0 && _private.data.currentPosition.top < _private.confiq.point[_private.data.nextBreakpoint][1] )
							){
								_private.data.currentPosition.left = _private.confiq.point[_private.data.nextBreakpoint][0];
								_private.data.currentPosition.top = _private.confiq.point[_private.data.nextBreakpoint][1];
								_private.data.currentBreakpoint = _private.data.nextBreakpoint;
								_private.data.nextBreakpoint = (_private.data.currentBreakpoint + 1) % _private.confiq.point.length;
								_private.confiq.onChangeBreakpoint({breakpoint: _private.data.currentBreakpoint, time: _private.data.path.time[_private.data.currentBreakpoint]});

							}


						}, ( 1000 / _private.confiq.fps) );
					}
				},
				pause: function(){
					clearInterval(_private.data.timer);
					_private.data.playing = false;
				},
				stop: function(){
					clearInterval(_private.data.timer);
					_private.data.playing = false;
					_private.data.currentBreakpoint = 0;
					_private.data.nextBreakpoint = 1;
					_private.data.currentPosition = {
						left: _private.confiq.point[0][0],
						top: _private.confiq.point[0][1]
					};
					_private.setPosition();
				}
			}

		};


		var init = function() {

			if (_private.confiq.showPoints){
				for( var p = 0; p < _private.confiq.point.length; p++){
					el.parent().prepend('<div class="trace-marker" style="top:' + _private.confiq.point[p][1] + 'px;left:' + _private.confiq.point[p][0] + 'px;">' + (p) +'</div>');
				}
			}

			/** установка позиции первой координаты **/
			_private.data.currentPosition = {
				left: _private.confiq.point[0][0],
				top: _private.confiq.point[0][1]
			};
			/** расчет расстояния между координатами [x, y, distance]**/
			for(var i = 0; i < _private.confiq.point.length; i++ ){
				var j = (i + 1) % _private.confiq.point.length ;

				var distance = Math.sqrt(Math.pow((_private.confiq.point[i][0] - _private.confiq.point[j][0]),2) + Math.pow((_private.confiq.point[i][1] - _private.confiq.point[j][1]),2));

				var y = _private.confiq.point[j][1] - _private.confiq.point[i][1];
				var x = _private.confiq.point[j][0] - _private.confiq.point[i][0] ;

				_private.data.path.distance.push([x, y, distance]);
				_private.data.path.distanceAll += distance;
			}
			/** расчет времени на прохождение каждого учестка **/
			for(var k = 0; k < _private.confiq.point.length; k++ ){
				_private.data.path.time.push( _private.confiq.pathTime * ( _private.data.path.distance[k][2] / _private.data.path.distanceAll ) );
			}
			/** расчет коэффициента перемещения объекта по координатам (delta x, delta y) **/
			for(var l = 0; l < _private.confiq.point.length; l++ ){
				var dx = (1000 * _private.data.path.distance[l][0]) / ( _private.confiq.fps * _private.data.path.time[l] );
				var dy = (1000 * _private.data.path.distance[l][1]) / ( _private.confiq.fps * _private.data.path.time[l] );
				_private.data.path.delta.x.push(dx);
				_private.data.path.delta.y.push(dy);
			}
			_private.setPosition();

			_private.confiq.onInit(el);

		};

		el.play = function(){
			_private.move.play();
		};

		el.pause = function(){
			_private.move.pause();
		};

		el.stop = function(){
			_private.move.stop();
		};

		init();

		return this;

	};


})();




/** spriteAnimate **/


(function(){

	var _defaults = {
		currentFrame: 1,			/** Начальный кадр (1 - первый кадр) **/
		framesCount: 24,			/** Количество кадров в спрайте **/
		framesStepLength: 100,		/** Ширина кадра в px **/
		direction: 'x',				/** Направление разбивки страйта, горизонтальная - x, вертикальная - y **/
		onBeforeAnimate: function(){},
		onAfterAnimate: function(){}
	};

	$.fn.spriteAnimate = function(options){

		if(this.length == 0) return this;

		if(this.length > 1){
			this.each(function(){$(this).spriteAnimate(options)});
			return this;
		}

		var el = this;

		var _private = {
			config:  $.extend({}, _defaults, options),

			data: {
				current: null,
				timer: null
			},

			setFrame: function(i){
				el.css('backgroundPosition', ( _private.config.direction.toLowerCase() == 'x' ? '-' + ( i * _private.config.framesStepLength ) : '0' ) + 'px ' + ( _private.config.direction.toLowerCase() == 'y' ? '-' + ( i * _private.config.framesStepLength ) : '0' ) );
			},

			stepFrame: function(i, time) {
				var t = time ? time : 1000;
				var count = Math.abs(i);
				var j = 0;
				_private.data.timer = setInterval(function(){
					var d = (_private.data.current + Math.sign(i)) % _private.config.framesCount;
					_private.data.current = d >= 0 ? d : _private.config.framesCount - 1;
					_private.setFrame(_private.data.current);
					j++;

					if ( j >= count ){
						clearTimeout(_private.data.timer);
					}

				}, (t/Math.abs(i)));
			},

			gotoFrame: function(i, time){
				var t = time ? time : 1000;

				var current = _private.data.current + 1;
				var count = ( Math.sign(i) > 0 ) ? ( (i > _private.data.current+1) ? (+ i - current) : (_private.config.framesCount - current + i) ) : (( Math.abs(i) <= current ) ? (current + i) : (_private.config.framesCount + current + i));
				var j = 0;
				var d = Math.sign(i);

				var timer = _private.data.timer = setInterval(function(){
					j++;
					var slice = _private.data.current + d;

					_private.data.current = slice % _private.config.framesCount >=0 ? slice % _private.config.framesCount : _private.config.framesCount - 1;
					_private.setFrame(_private.data.current);
					//console.log(j + ' ' + count);

					if ( j >= count ){
						clearInterval(timer);
						timer = null;
						//_private.config.onAfterAnimate(_private.data.current);
					}

				}, (t/count));

				setTimeout(function(){
					if ( !timer ) clearInterval(timer);
				}, t)
			}
		};


		var init = function() {
			//console.info(_private.config);
			_private.data.current = Math.abs(_private.config.currentFrame - 1);
			_private.setFrame(_private.data.current);
		};

		el.setFrame = function(i){
			_private.setFrame(i);
		};

		el.gotoFrame = function(i, time){
			_private.gotoFrame(i, time);
		};


		el.stepFrame = function(i, time){
			_private.stepFrame(i, time);
		};

		init();

		return this;

	};



})();


(function($) {
	$.fn.removeClassMask = function(mask) {
		return this.removeClass(function(index, cls) {
			var re = mask.replace(/\*/g, '\\S+');
			return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
		});
	};
})(jQuery);



var listTurns = [
			'-8520px', '-3120px', '-17760px', '-12240px', '0px', '-14280px'
];

var listPosition = [
			[0, '615px', '170px', listTurns[0], false],
			[1, '261px', '337px', listTurns[1], false],
			[2, '485px', '450px', listTurns[0], false],
			[3, '235px', '600px', listTurns[1], false],
			[4, '540px', '743px', listTurns[4], false],
			[5, '1120px', '450px', listTurns[5], '-17760px'],
			[6, '897px', '337px', listTurns[0], false],
			[7, '588px', '489px', listTurns[5], false],
			[8, '80px', '235px', listTurns[2], false],
			[9, '595px', '-10px', listTurns[1], '0px'],
			[10, '742px', '86px', listTurns[0], false],
	];

var listCars = [
			['car1', './img/bus_sprite-line.png', listPosition[0], 'trace-vehicle', '#map'],
			['car2', './img/bus_sprite-line2.png', listPosition[3], 'trace-vehicle2', '#map'],
	];


var defaultZindex = 1;
var defaultSpeed = 50000;
var maxZindex = 100;

function startCar(src, position, selectorMap, idCar, carClass){

	$("<div />").appendTo(selectorMap).attr("id", idCar).attr('inc', position[0])
				.addClass(carClass)
				.width('120').height('120').css('position', 'absolute').css('zIndex', defaultZindex)
				.css('left', position[1]).css('top', position[2]).css('display', 'none');

	$("<i />").appendTo('#'+idCar).css('backgroundImage', 'url('+src+')')
				.css('display', 'block')
				.css('backgroundRepeat', 'no-repeat').css('backgroundPosition', position[3]).width('120').height('120');

	return false;

}



$(function(){

	for (var i = 0; i < listCars.length; i++) {
		startCar(listCars[i][1], listCars[i][2], listCars[i][4], listCars[i][0], listCars[i][3]);
	}

	var spriteOptions = {
		currentFrame: 55,
		framesCount: 153,
		framesStepLength: 120,
		direction: 'x',
		onBeforeAnimate: function(){},
		onAfterAnimate: function(){}
	};
	var $busRotate = $('.trace-vehicle i').spriteAnimate(spriteOptions);


	var busOptions = {
		fps: 100,
		pathTime: defaultSpeed,
		point: [
			[615,170],	// 0
			[261,337],	// 1
			[485,450],	// 2
			[235,600],	// 3
			[540,743],	// 4
			[1120,450],	// 5
			[897,337],	// 6
			[588,489],	// 7
			[80,235],	// 8
			[595,0],	// 9
			[742,86]	// 10
		
		],
		showPoints: false,
		onInit: function(){
			$('.trace-vehicle').show(300);
			//$('.trace-vehicle').addClass('on_top');
			$('#store').css('zIndex', 3);
			$('#whitehouse').css('zIndex', 4);
			$('#policestation').css('zIndex', 5);
			$('.trace-vehicle').css('zIndex', 10);
			$('#filmstudio').css('zIndex', 17);
			$('#studio').css('zIndex', 35);

		},
		onChangeBreakpoint: function(data){

			//console.info(data);


			switch (data.breakpoint) {
				case 0: 
					$('#studio').css('zIndex', 35);
					$('#park').removeAttr('style');
					$('#kreml').removeAttr('style');
					$('#bank').removeAttr('style');
					$('#businescenter').removeAttr('style');
					$('#tv-tower').removeAttr('style');
				break; //51

				case 1: 
					$('.trace-vehicle').css('zIndex', 15);
					$('#redaction').css('zIndex', 32);
					$('#park').css('zIndex', 1);
					$busRotate.gotoFrame(-26, 100); 
				break;

				case 2: 
					$('#redaction').removeAttr('style');
					$busRotate.gotoFrame(51, 100); 
					$('.trace-vehicle').css('zIndex', defaultZindex);
				break;

				case 3: 
					$('.trace-vehicle').css('zIndex', 33);
					$('#radiostation').css('zIndex', 34);
					$busRotate.gotoFrame(-26, 100); 
				break;
				case 4:
					$('.trace-vehicle').css('zIndex', 36);
					$('#restaurant, #stylist').css('zIndex', 37);
					$('#studio').removeAttr('style');
					$('#academy').removeAttr('style');
				 	$busRotate.gotoFrame(-130, 100); 
				break;

				case 5: 
					$('.trace-vehicle').css('zIndex', 11);
					$('#academy').css('zIndex', 15);
					$busRotate.gotoFrame(-99, 100);
				break;
				case 6: 
					$('#studio').css('zIndex', 15);
					$('#park').css('zIndex', 1);
					$busRotate.gotoFrame(-51, 100); 
				break;

				case 7: 
					$('.trace-vehicle').css('zIndex', 15);
					$('#construction').css('zIndex', 16);
					$busRotate.gotoFrame(99, 100); 
				break;
				case 8: 
					$('#store').css('zIndex', 23);
					$('#whitehouse').css('zIndex', 24);
					$('#policestation').css('zIndex', 25);
					$busRotate.gotoFrame(128, 100); 
				break;
				case 9: 
					$('#kreml').css('zIndex', 50);
					$('#bank').css('zIndex', 51);
					$('#businescenter').css('zIndex', 52);
					$('#tv-tower').css('zIndex', 53);
					$busRotate.gotoFrame(26, 100); 
				break;
				case 10: 
					$('#store').css('zIndex', 3);
					$('#whitehouse').css('zIndex', 4);
					$('#policestation').css('zIndex', 5);
					$busRotate.gotoFrame(51, 100); 
				break;

				//case 11: $busRotate.gotoFrame(-51, data.time); break;

				default:

			}
		}
	};

	var $bus = $('.trace-vehicle').busTracer(busOptions);
	$bus.play();


	//Параметры для второй машины

	var spriteOptions2 = {
		currentFrame: 26,
		framesCount: 153,
		framesStepLength: 120,
		direction: 'x',
		onBeforeAnimate: function(){},
		onAfterAnimate: function(){}
	};
	var $busRotate2 = $('.trace-vehicle2 i').spriteAnimate(spriteOptions2);


	var busOptions2 = {
		fps: 100,
		pathTime: defaultSpeed,
		point: [

			[235,600],	// 3
			[540,743],	// 4
			[1120,450],	// 5
			[897,337],	// 6
			[588,489],	// 7
			[80,235],	// 8
			[595,0],	// 9
			[742,86],	// 10
			[615,170],	// 0
			[261,337],	// 1
			[485,450]	// 2

		],
		showPoints: false,
		onInit: function(){
			$('.trace-vehicle2').show(300);
			//$('.trace-vehicle2').addClass('on_top');
			$('.trace-vehicle2').css('zIndex', 33);
			$('#redaction').css('zIndex', 32);
			$('#radiostation').css('zIndex', 34);
		},
		onChangeBreakpoint: function(data){

			//console.info(data);


			switch (data.breakpoint) {
				case 0: 
					$('.trace-vehicle2').css('zIndex', 33);
					$('#redaction').css('zIndex', 32);
					$('#radiostation').css('zIndex', 34);
					$('#kreml').removeAttr('style');
					$('#bank').removeAttr('style');
					$('#businescenter').removeAttr('style');
					$('#tv-tower').removeAttr('style');
					$busRotate2.gotoFrame(-26, 100);  
				break;

				case 1: 
					$('.trace-vehicle2').css('zIndex', 36);
					$('#restaurant, #stylist').css('zIndex', 37);
					$('#studio').removeAttr('style');
					$('#academy').removeAttr('style');
					$busRotate2.gotoFrame(-128, 100);  
				break;
				case 2: 
					$('.trace-vehicle2').css('zIndex', 9);
					$('#kreml').css('zIndex', 7);
					$('#bank').css('zIndex', 8);
					$('#businescenter').css('zIndex', 9);
					$busRotate2.gotoFrame(-99, 100);  
				break;
				case 3: 
					$('#park').css('zIndex', 8);
					$busRotate2.gotoFrame(-51, 100);  
				break;
				case 4: 
					$('#construction').css('zIndex', 15);
					$busRotate2.gotoFrame(99, 100);   
				break;
				case 5: 
					$('#store').css('zIndex', 13);
					$('#whitehouse').css('zIndex', 14);
					$('#policestation').css('zIndex', 15);
					$busRotate2.gotoFrame(128, 100);  
				break;
				case 6: 
					$('#kreml').css('zIndex', 50);
					$('#bank').css('zIndex', 51);
					$('#businescenter').css('zIndex', 52);
					$('#tv-tower').css('zIndex', 53);
					$busRotate2.gotoFrame(26, 100);  
				break;
				case 7: 
					$('.trace-vehicle2').css('zIndex', 26);
					$busRotate2.gotoFrame(51, 100);
				break;

				case 8:
					$('#filmstudio').css('zIndex', 27);
					$('#radiostation').css('zIndex', 28);
					$('#park').removeAttr('style');
					$('#studio').removeAttr('style');
				break;

				case 9: 
					$('.trace-vehicle2').css('zIndex', 11);
					$('#park').css('zIndex', 10);
					$busRotate2.gotoFrame(-26, 100);  
				break;
				case 10: 
					$busRotate2.gotoFrame(51, 100);  
				break;

				//case 11: $busRotate2.gotoFrame(-51, data.time); break;

				default:

			}
		}
	};

	var $bus2 = $('.trace-vehicle2').busTracer(busOptions2);
	$bus2.play();



	/*$('.trace-vehicle').click(function () {
		if ( $(this).hasClass('pause') ){
			$(this).removeClass('pause');
			$bus.play();
		} else {
			$(this).addClass('pause');
			$bus.pause();
		}

	});*/


	/*$('body').on('click', '.trace-vehicle',function () {

		$bus.pause();

		jQuery.app.modal.open('modal-bus_trace', {
			width: 880,
			height: 600,
			modal: false,
			closeOnEscape: false
		});

	}).on('click', '.js_modal_bus-close', function(){
		$bus.play();
	});*/



});

Math.sign = Math.sign || function(x) {
  x = +x; // преобразуем в число
  if (x === 0 || isNaN(x)) {
    return x;
  }
  return x > 0 ? 1 : -1;
}
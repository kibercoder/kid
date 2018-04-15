$(function(){

    var close_form = "close";

    $(document).on("click", "body", function( event ) {

       if ($('#wraper_window').css('display')=='block'){

        var x_page = parseInt(event.pageX);
        
        var y_page = parseInt(event.pageY);
        
        var left_img = parseInt($('.src_galery').offset().left);
        
        var right_img = parseInt($(".src_galery").offset().left + $(".src_galery").width()+14);

        var top_img = parseInt($('.src_galery').offset().top);
        
        var bottom_img = parseInt($(".src_galery").offset().top + $(".src_galery").height()+14);
        
        /*
            alert('x_page ' 
                    + x_page 
                    + ' left_img ' 
                    + left_img 
                    + ' right_img '
                    + right_img
                    + ' bottom_img '
                    + bottom_img
                    + ' y_page ' 
                    + y_page 
                    + ' top_img ' 
                    + top_img 
                  );

*/


/*alert( 
'(' 
+ x_page 
+ ' < ' 
+ left_img 
+ ' || ' 
+ x_page
+ '>'
+ right_img
+ ')' 
+ ' || ' 
+ '('
+ y_page 
+ ' > ' 
+ bottom_img 
+ ' || ' 
+ y_page  
+ ' < ' 
+  top_img 
+ ')'
)*/



        if ( (x_page<left_img || x_page>right_img) && close_form == 'close'
            || (y_page>bottom_img || y_page<top_img) && close_form == 'close') {

               $('#wraper_window').fadeOut(420);
               $('.src_galery').fadeOut(420, function(){
                    $(this).remove();
               });
               $('.wraper_window2').fadeOut(420);
               
            }
            
            close_form = 'close';
            
       }
    });
        
 
    $('td.reg a').click(function(){
        id_tour = parseInt($(this).parent('td').parent('tr').attr('tour_id'));
        showTabsTour(id_tour);
        return false; 
    });
        
    $(document).on("click", ".tour", function(){
        id_tour = parseInt($(this).attr('id_tour'));
        showTabsTour(id_tour);
        return false; 
    });

    $(document).on("mousedown", ".src_galery", function( e ) {
        close_form = 'none';    
    });


    $(document).on("mouseup", ".src_galery", function( e ) {
        //close_form = 'close';
    });

});


function showTabsTour(id_tour){

    var doc = $(document);
    var height_body = parseInt(doc.height());
    var topIndent = parseInt(doc.scrollTop());

    if ($('.src_galery').length >= 1) {
        var topTour = $('.src_galery:last').position().top + 100;
        var leftTour = $('.src_galery:last').position().left + 100;
    } else {
        var topTour = 0;
        var leftTour = 0;
    }


    if (!isNaN(id_tour)) {

        if (!$('#wraper_window').length) {

                $('#wraper_window').remove();
                $('.wraper_window2').remove();
                $('.src_galery').remove();

                $('.list_avatars').prependTo('#src_galery');

                $('.src_galery .list_avatars').show();
                
                $('#wraper_window').css('height', height_body+'px');

                //$('#src_galery').css("left",(doc.width()-$('#src_galery').width())/2+doc.scrollLeft() + "px");
        }


            $.ajax({
              url: '/get-tour',
              type: 'POST',
              //contentType: false, // важно - убираем форматирование данных по умолчанию
              //processData: false, // важно - убираем преобразование строк по умолчанию
              data: 'id_tour='+id_tour,
              dataType: 'json',
              success: function(data){

                if(data){

                    if(data.id_t) {

                        console.log(data.list_places);

                        data.photo = (!data.photo) 
                                ? '../img/tournament/shield.png' 
                                    : '../img/tournament/img_tour/' + data.photo;

                        date_begin = getData(data.date_begin);

                        data.cost = parseInt(data.cost);
                        data.cost = (data.cost > 0) ? 'Стоимость: '+data.cost+' кидкоина' : 'Турнир бесплатный';

                        var htmlTour = '<div id_tour="'+data.id_t+'" class="src_galery" style="top: '+topTour+'px; left: '+leftTour+'px;">'

                                +'<div class="shield">'

                                    +'<div class="pic_shield">'
                                        +'<img src="'+data.photo+'" width="300" />'
                                    +'</div>'

                                    +'<div class="context">'
                                        +'<p class="date_begin">'+date_begin+'</p>'
                                        +'<p class="cost">'+data.cost+'</p>'
                                        +'<p>Максимальное колличество участников: '+data.max_member+'</p>'
                                    +'</div>'
                                +'</div>'

                                +'<div class="wrap_table_info">'
                                    +'<h3>Вы отменили регистрацию</h3>'

                                    +'<div class="repeal_signup">'
                                        +'<button></button>'
                                    +'</div>'

                                    +'<table cellspacing="0">'
                                        +'<colgroup>'
                                            +'<col span="1" width="34%" />'
                                        +'</colgroup>'
                                        +'<tbody>'
                                            +'<tr>'
                                                +'<td rowspan="2" class="cell_info">'

                                                    +'<p class="full_fund">Общий призовой фонд '+data.fund+' кидкоинов</p>'
                                                    +'<br />'
                                                    +'<p class="amount_prizes">Призовых мест: '
                                                        +data.amount_places
                                                    +'</p>'
                                                    +'<br />'


                                                    +'<div class="box4 custom-scroll-advanced_container">'
                                                    +'<div class="custom-scroll-advanced_inner">'

                                                    +'<ul class="list_places">'+data.list_places+'</ul>'

                                                    +'</div>'
                                                        +'<div class="custom-scroll-advanced_track-y">'
                                                            +'<span class="arrow top"></span>'
                                                            +'<span class="arrow bottom"></span>'
                                                        +'</div>'
                                                        +'<div class="custom-scroll-advanced_bar-y"></div>'
                                                    +'</div>'


                                                +'</td>'
                                                +'<td class="amount_players" style="border-left:  2px solid #a4865f;"></td>'
                                                +'<td class="amount_players" class="max_members">Игроки:</td>'
                                                +'<td class="amount_players"></td>'
                                            +'</tr>'
                                            +'<tr>'
                                                +'<td class="info_players">'

                                                    +'<p>Красные:</p>'

                                                    +'<div class="box custom-scroll-advanced_container">'
                                                        +'<div class="custom-scroll-advanced_inner">'

                                                        +'<ul>'+data.red_players+'</ul>'

                                                    +'</div>'
                                                    +'<div class="custom-scroll-advanced_track-y">'
                                                        +'<span class="arrow top"></span>'
                                                        +'<span class="arrow bottom"></span>'
                                                    +'</div>'
                                                    +'<div class="custom-scroll-advanced_bar-y"></div>'
                                                +'</div>'

                                                +'</td>'
                                                +'<td class="info_players">'
                                                    +'<p>Зелёные:</p>'
                                        
                                                    +'<div class="box2 custom-scroll-advanced_container">'
                                                    +'<div class="custom-scroll-advanced_inner">'

                                                    +'<ul>'+data.green_players+'</ul>'

                                                    +'</div>'
                                                        +'<div class="custom-scroll-advanced_track-y">'
                                                            +'<span class="arrow top"></span>'
                                                            +'<span class="arrow bottom"></span>'
                                                        +'</div>'
                                                        +'<div class="custom-scroll-advanced_bar-y"></div>'
                                                    +'</div>'

                                                +'</td>'
                                                +'<td class="info_players">'
                                                    +'<p>Синие:</p>'

                                                    +'<div class="box3 custom-scroll-advanced_container">'
                                                    +'<div class="custom-scroll-advanced_inner">'

                                                    +'<ul>'+data.blue_players+'</ul>'

                                                    +'</div>'
                                                        +'<div class="custom-scroll-advanced_track-y">'
                                                            +'<span class="arrow top"></span>'
                                                            +'<span class="arrow bottom"></span>'
                                                        +'</div>'
                                                        +'<div class="custom-scroll-advanced_bar-y"></div>'
                                                    +'</div>'

                                                +'</td>'
                                            +'</tr>'
                                        +'</tbody>'
                                    +'</table>'
                                +'</div>'
                                +'<img class="close" src="../img/tournament/close_button.png" />'
                            +'</div>';



                            $('.wraper_window2').append(htmlTour);

                                        

                            $('.wraper_window2').css('top', topIndent+'px');
                            $('#wraper_window').fadeIn(420);
                            $('.wraper_window2').fadeIn(420);
                            $('.src_galery').fadeIn(420, function(){
                                $(this).css('display', 'table');
                            });
                            
                            $('.src_galery img.close').click(function(){

                                if ($('.src_galery').length <= 1) {
                                    $('#wraper_window').fadeOut(420);
                                    $('.wraper_window2').fadeOut(420);
                                }

                                $(this).parent('.src_galery').fadeOut(420, function(){
                                    $(this).remove();
                                });

                            });


                            var myCS = $('.box').customScroll({
                                prefix: 'custom-scroll-advanced_',
                                offsetTop: 14,
                                offsetBottom: 14,
                                horizontal: false
                            });


                            var $track = myCS.$container.find('.custom-scroll-advanced_track-y');
                            function myScroll(delta) {
                                var $inner = myCS.$inner;
                                $inner.animate({'scrollTop': $inner.scrollTop() + delta + 'px'}, 100);
                            }
                            $track
                                .on('click', function(e) {
                                    var yPos = e.pageY - $(this).offset().top;
                                    var barTop = myCS.$bar.position().top;
                                    var h = myCS.$container.height() - 20;
                                    myScroll(yPos < barTop ? -h : h);
                                })
                                .on('click', '.arrow', function(e) {
                                    e.stopPropagation();
                                    var isTop = $(this).hasClass('top');
                                    myScroll(isTop ? -50 : 50);
                            });

                                var myCS = $('.box').customScroll({
                                prefix: 'custom-scroll-advanced_',
                                offsetTop: 14,
                                offsetBottom: 14,
                                horizontal: false
                            });


                            /*====box2=====*/

                            var myCS2 = $('.box2').customScroll({
                                prefix: 'custom-scroll-advanced_',
                                offsetTop: 14,
                                offsetBottom: 14,
                                horizontal: false
                            });

                            var $track2 = myCS2.$container.find('.custom-scroll-advanced_track-y');
                            function myScroll2(delta) {
                                var $inner2 = myCS2.$inner;
                                $inner2.animate({'scrollTop': $inner2.scrollTop() + delta + 'px'}, 100);
                            }
                            $track2
                                .on('click', function(e) {
                                    var yPos = e.pageY - $(this).offset().top;
                                    var barTop = myCS2.$bar.position().top;
                                    var h = myCS2.$container.height() - 20;
                                    myScroll2(yPos < barTop ? -h : h);
                                })
                                .on('click', '.arrow', function(e) {
                                    e.stopPropagation();
                                    var isTop = $(this).hasClass('top');
                                    myScroll2(isTop ? -50 : 50);
                            });


                            /*====box3=====*/

                            var myCS3 = $('.box3').customScroll({
                                prefix: 'custom-scroll-advanced_',
                                offsetTop: 14,
                                offsetBottom: 14,
                                horizontal: false
                            });

                            var $track3 = myCS3.$container.find('.custom-scroll-advanced_track-y');
                            function myScroll3(delta) {
                                var $inner3 = myCS3.$inner;
                                $inner3.animate({'scrollTop': $inner3.scrollTop() + delta + 'px'}, 100);
                            }
                            $track3
                                .on('click', function(e) {
                                    var yPos = e.pageY - $(this).offset().top;
                                    var barTop = myCS3.$bar.position().top;
                                    var h = myCS3.$container.height() - 20;
                                    myScroll3(yPos < barTop ? -h : h);
                                })
                                .on('click', '.arrow', function(e) {
                                    e.stopPropagation();
                                    var isTop = $(this).hasClass('top');
                                    myScroll3(isTop ? -50 : 50);
                            });


                            /*====box4=====*/

                            var myCS4 = $('.box4').customScroll({
                                prefix: 'custom-scroll-advanced_',
                                offsetTop: 14,
                                offsetBottom: 14,
                                horizontal: false
                            });

                            var $track4 = myCS4.$container.find('.custom-scroll-advanced_track-y');
                            function myScroll4(delta) {
                                var $inner3 = myCS4.$inner;
                                $inner3.animate({'scrollTop': $inner4.scrollTop() + delta + 'px'}, 100);
                            }
                            $track4
                                .on('click', function(e) {
                                    var yPos = e.pageY - $(this).offset().top;
                                    var barTop = myCS4.$bar.position().top;
                                    var h = myCS4.$container.height() - 20;
                                    myScroll4(yPos < barTop ? -h : h);
                                })
                                .on('click', '.arrow', function(e) {
                                    e.stopPropagation();
                                    var isTop = $(this).hasClass('top');
                                    myScroll4(isTop ? -50 : 50);
                            });


                    } else {

                        console.log('error');
                        return false;
                    }

                  //$that.replaceWith(json);
                }

              }

            });


        }


    }



function getData(my_date) {

    time = new Date(my_date);

    name_month=new Array ("января","февраля","марта", "апреля","мая", "июня","июля","августа","сентября", "октября","ноября","декабря");

    name_day=new Array ("воскресенье","понедельник", "вторник","среда","четверг", "пятница","суббота");

    time_sec=time.getSeconds();
    time_min=time.getMinutes();
    time_hours=time.getHours();
    time_wr=((time_hours<10)?"0":"")+time_hours;
    time_wr+=":";
    time_wr+=((time_min<10)?"0":"")+time_min;
    //time_wr+=":";
    //time_wr+=((time_sec<10)?"0":"")+time_sec;

    time_wr="Начало: "+name_day[time.getDay()]+", "+time.getDate()+" "+name_month[time.getMonth()]+" в "+time_wr;

    return time_wr;

}

//Начало: 10 декабря в 12:45
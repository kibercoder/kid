$(function(){

    var close_form = "close";

    $(document).on("click", "body", function( event ) {

       if ($('#wraper_window').css('display')=='block'){

        var x_page = parseInt(event.pageX);
        
        var y_page = parseInt(event.pageY);
        
        var left_img = parseInt($('#src_galery').offset().left);
        
        var right_img = parseInt($("#src_galery").offset().left + $("#src_galery").width()+14);

        var top_img = parseInt($('#src_galery').offset().top);
        
        var bottom_img = parseInt($("#src_galery").offset().top + $("#src_galery").height()+14);
        
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
               $('#src_galery').fadeOut(420);
               
            }
            
            close_form = 'close';
            
       }
    });
        
 
    $('td.reg a').click(function(){

        var doc = $(document);

        var height_body = parseInt(doc.height());

        var topIndent = parseInt(doc.scrollTop());

        if (!$('#wraper_window').length) {

            $('#wraper_window').remove();
            $('#wraper_window2').remove();
            $('#src_galery').remove();

            $('.list_avatars').prependTo('#src_galery');

            $('#src_galery .list_avatars').show();
            
            $('#wraper_window').css('height', height_body+'px');

            //$('#src_galery').css("left",(doc.width()-$('#src_galery').width())/2+doc.scrollLeft() + "px");

        }


        $('#wraper_window').css('height', height_body+'px');

        $('#wraper_window2').css('top', topIndent+'px');

        $('#wraper_window').fadeIn(420);
        $('#wraper_window2').fadeIn(420);
        $('#src_galery').fadeIn(420, function(){
            $(this).css('display', 'inline-block');
        });
        
        $('#src_galery img.close').click(function(){

            $('#wraper_window').fadeOut(420);
            $('#wraper_window2').fadeOut(420);
            $('#src_galery').fadeOut(420);

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


        return false; 
    });
        

    $(document).on("mousedown", "#src_galery", function( e ) {
        close_form = 'none';    
    });


    $(document).on("mouseup", "#src_galery", function( e ) {
        //close_form = 'close';
    });

});
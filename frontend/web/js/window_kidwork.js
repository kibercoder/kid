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
        
 
    $('#choice_avatar .label-group').click(function(){

        if (!$('#wraper_window').length) {

            $('#wraper_window').remove();
            $('#wraper_window2').remove();
            $('#src_galery').remove();

            var doc = $(document);

            var height_body = parseInt(doc.height());

            $('body').append('<div id="wraper_window"></div><div id="wraper_window2"><div id="src_galery"><i class="close">x</i></div></div>');

            $('.list_avatars').prependTo('#src_galery');

            $('#src_galery .list_avatars').show();
            
            $('#wraper_window').css('height', height_body+'px');

            //$('#src_galery').css("left",(doc.width()-$('#src_galery').width())/2+doc.scrollLeft() + "px");

        }


        $('#wraper_window').fadeIn(420);
        $('#wraper_window2').fadeIn(420);
        $('#src_galery').fadeIn(420);
        
        $('#src_galery i.close').click(function(){

            $('#wraper_window').fadeOut(420);
            $('#wraper_window2').fadeOut(420);
            $('#src_galery').fadeOut(420);

        });
        
        return false; 
    });
        

    $(document).on("mousedown", "#src_galery", function( e ) {
        close_form = 'none';    
    });


    $(document).on("mouseup", "#src_galery", function( e ) {
        //close_form = 'close';
    });

    $(document).on('click', '#src_galery .list_avatars td', function( e ) {
        var src = $(this).find('img').attr('src');
        var id_avatar = parseInt($(this).attr('id_ava'));

        $('.selected_avatar img').attr('src', src);
        $('#signupform-user_avatar').val(id_avatar);
        $('#profileform-user_avatar').val(id_avatar);
        $('#src_galery i.close').click();
    });

    PreloadImage('../../img/signup.jpg');


});


function PreloadImage (src) {
    var img = new Image ();
    img.onload = function () {
        $('.wrap_circle_user').show(100, function(){
            $(this).css('display', 'inline-block');
        });
    };
    img.src = src;
}
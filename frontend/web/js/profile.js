$(function() {

  //Пробигаемся по комментариям и меняем цвет тех которые были отмечены
  /*var cok_like = document.cookie;

  if (cok_like != ''){

    var id_cok_like = cok_like.split(';');

    for (var i=0; i < id_cok_like.length; i++) {

        if(id_cok_like[i].indexOf('_count_like') + 1) {
            
            id_str = id_cok_like[i].split('_count_like');
            
            commentId = id_str['0'];

            if(!isNaN(commentId)) {
                $('.like[comment-id='+commentId+']').removeClass('dislike');
            }

        }

   }
 
 }*/



  cicleStars('.level .level__star', 15, 80, 100);
  cicleStars('.level_small .level__star', 15, 24, 29);
  cicleStars('.level_comment .level__star', 15, 15, 18);

  //header status chenged to input
  $('.header__status').click( function () {
    $('.header__status').css('display','none')
    $('.header__status-input').css('display','block')
  })
  $(document).mouseup(function (e) {
    var div = $(".header__status-input");
    if (!div.is(e.target)
      && div.has(e.target).length === 0) {
      $('.header__status').css('display','block')
      $('.header__status-input').css('display','none')
    }
  });


  //arrow more achieve
  $('.more-achieve').click( function () {
    $('.wall__achieve_more').slideToggle()
    $('.more-achieve').toggleClass('up')
  })


  //smooth scrolling up
  $(".up-button").on("click", function (event) {
    event.preventDefault();
    var id = $(this).attr('href'),
      top = $(id).offset().top;
    $('body,html').animate({scrollTop: top}, 300);
  });


  //show more comments
  $('.comment-wrapper').on('click', '.comment__more', function () {

    comments = $(this).parent().find('li:not(ul.post__comments-wrap li[item=1])');

    //alert(comments.length);

    if(comments.length > 0) {

        nextComment = $(this).parent().find('ul.post__comments-wrap li:eq(1)');

        if (nextComment.css('display') == 'none') {
          comments.slideDown(170);
        } else {
          comments.slideUp(170);
        }
    }

  });

  $('.comment-wrapper').on('click', '.like', function () {

      commentId = parseInt($(this).attr('comment-id'));

      userId = parseInt($(this).attr('user-id'));

      count_like = parseInt($(this).text());

      if (!isNaN(commentId) && !isNaN(count_like) && !isNaN(userId)) {

        if (getCookie(commentId+'_count_like')) {

          rating = (count_like >= 1) ? count_like-1 : 0;

          if (!$(this).hasClass('dislike')) {
              $(this).addClass('dislike');
              $(this).text(rating);
          }

          deleteCookie(commentId+'_count_like', '', document.domain);
          action = 'less';

        } else {

          rating = (count_like >= 0) ? count_like+1 : 1;

          if ($(this).hasClass('dislike')) {
              $(this).removeClass('dislike');
              $(this).text(rating);
          }

          setCookie(commentId+'_count_like', 1, 1000, document.domain, '');
          action = 'more';
        }

         $.ajax({
          type: "POST",
          url: "/user/change_like",
          data: "commentid="+commentId+"&action="+action+"&userid="+userId,

          // Выводим то что вернул PHP
          success: function(data) {
            
              //alert(data);

          }});
      }

      

  });


  //repost
  $('.comment-wrapper').on('click', '.repost', function () {

    $('.modal_repost').css('display','flex')
    setTimeout(function () {
      $('.modal_repost').css('opacity','1')
    }, 100);
    $(document).on('mouseup', 'body', function (e) {
      var div = $(".modal__wrap");
      var btn = $(".repost");
      if (!div.is(e.target)
          && !btn.is(e.target)
          && btn.has(e.target).length === 0
        && div.has(e.target).length === 0) {
        $('.modal_repost').css('opacity','0')
        setTimeout(function () {
          $('.modal_repost').css('display','none')
        }, 300)
      }
    });
  })


  $(document).on('focus', '.wall__textarea', function(){
      $('.hide_buttons').show();
  });

  $(document).on('focus', '.new-wall__textarea', function(){
      $('.new-hide_buttons').show();
  });


  hideElementByClick(
      '.new-hide_buttons', 
      '.new-comment-form-container',
      '.new-wall__form .help-block'
  );

  hideElementByClick(
      '.hide_buttons', 
      '#comment-form',
      '.wall__form .help-block'
  );

  $('#message_form button.wall__affix').on('click',  function () {
    $('#message_form #message_file').click();
  });
  
});

function cicleStars(selector, num = 15, wrap = 15, radius = 18) {
  $(selector).each( function(index) {
    var f = 2 / num * index * Math.PI;
    var left = wrap + radius * Math.sin(f) + 'px';
    var top = wrap + radius * Math.cos(f) + 'px';
    $(this).css({'top':top,'left':left});
  });
}

function hideElementByClick(hideSelector, contourSelector, hideText = false) {

    $(document).on("click", "body", function( event ) {

       if ($(hideSelector).css('display')=='block'){

        x_page = parseInt(event.pageX);
        
        y_page = parseInt(event.pageY);
        
        left_img = parseInt($(contourSelector).offset().left);
        
        right_img = parseInt($(contourSelector).offset().left + $(contourSelector).width()+2);

        top_img = parseInt($(contourSelector).offset().top);
        
        bottom_img = parseInt($(contourSelector).offset().top + $(contourSelector).height()+2);
        
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



        if ( (x_page<left_img || x_page>right_img)
            || (y_page>bottom_img || y_page<top_img) ) {

               $(hideSelector).fadeOut(50);

               if ($(hideText).length) {
                  $(hideText).text('');
               }

            }
            
       }
  });

}


//Функции на проверку существования определённой cookie
function getCookie(name) {
  var pattern = "(?:; )?" + name + "=([^;]*);?";
  var regexp  = new RegExp(pattern);

  if (regexp.test(document.cookie))
  return decodeURIComponent(RegExp["$1"]);

  return false;
}

//Функция создания cookie со всеми параметрами
function setCookie(name, value, days, domain, path, secure) {

    if (!name || !value) return false;

    var date, str;
    if (days) {
        date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        str = "; expires="+date.toGMTString();

        if (path)    str += '; path=' + path;
        if (domain)  str += '; domain=' + domain;
        if (secure)  str += '; secure';

    } else {
        expires = "";
    }

    document.cookie = name+"="+encodeURIComponent(value)+str;
}

function deleteCookie( name, path, domain ) {
  if( getCookie( name ) ) {
    document.cookie = name + "=" +
      ((path) ? ";path="+path:"")+
      ((domain)?";domain="+domain:"") +
      ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
  }
}
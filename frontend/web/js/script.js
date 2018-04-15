$(document).ready(function() {


  $('.level .level__star').each( function(index) {
    var num = 15;
      var wrap = 80; // Размер "холста" для расположения картинок
      var radius = 100; // Радиус нашего круга
      var f = 2 / num * index * Math.PI;  // Рассчитываем угол каждой картинки в радианах
      var left = wrap + radius * Math.sin(f) + 'px';
      var top = wrap + radius * Math.cos(f) + 'px';
      $(this).css({'top':top,'left':left});
  })
  $('.level_small .level__star').each( function(index) {
    var num = 15;
    var wrap = 24;
    var radius = 29;
    var f = 2 / num * index * Math.PI;
    var left = wrap + radius * Math.sin(f) + 'px';
    var top = wrap + radius * Math.cos(f) + 'px';
    $(this).css({'top':top,'left':left});
  })
  $('.level_comment .level__star').each( function(index) {
    var num = 15;
    var wrap = 15;
    var radius = 18;
    var f = 2 / num * index * Math.PI;
    var left = wrap + radius * Math.sin(f) + 'px';
    var top = wrap + radius * Math.cos(f) + 'px';
    $(this).css({'top':top,'left':left});
  })
  $('.level_medium .level__star').each( function(index) {
    var num = 15;
    var wrap = 37;
    var radius = 43;
    var f = 2 / num * index * Math.PI;
    var left = wrap + radius * Math.sin(f) + 'px';
    var top = wrap + radius * Math.cos(f) + 'px';
    $(this).css({'top':top,'left':left});
  })


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
  $('.comment__more').click( function () {
    $('.comment__more-wrap').slideToggle()
  })


  //repost modal
  $('.repost').click( function () {
    $('.modal_repost').css('display','flex')
    setTimeout(function () {
      $('.modal_repost').css('opacity','1')
    }, 100);
  })


  //send message
  $('.user__send-message').click( function () {
    $('.modal_message').css('display','flex')
    setTimeout(function () {
      $('.modal_message').css('opacity','1')
    }, 100);
  })


  //send gift
  $('.user__gift-button').click( function () {
    $('.modal_gift').css('display','flex')
    setTimeout(function () {
      $('.modal_gift').css('opacity','1')
    }, 100);
  })
  $('.modal__close').click( function () {
    $('.modal__close').closest('.modal').css('opacity','0')
        setTimeout(function () {
          $('.modal__close').closest('.modal').css('display','none')
        }, 300)
  })


  //test modal
  $('.test__button_start').click(function () {
    $('.test__start').css('display','none')
    $('.test__item').css('display','flex')
  })
  $('.test__answer').click(function () {
    $('.test__item').css('display','none')
    $('.test__success').css('display','flex')
  })


  //modal close
  $(document).mouseup(function (e) {
    var div = $(".modal__wrap");
    var btn = $(".repost, .user__send-message, .user__gift-button");
    if (!div.is(e.target)
      && !btn.is(e.target)
      && btn.has(e.target).length === 0
      && div.has(e.target).length === 0) {
      $('.modal').css('opacity','0')
      setTimeout(function () {
        $('.modal').css('display','none')
      }, 300)
    }
  });


  //dialog message actions
  $('.message__item').click(function() {
    $(this).toggleClass('active')
    $('.dialog__action').addClass('active')
    if($('.message__item.active').length > 0) {
      var actionMessages = $('.message__item.active').length
      $('.action-messages').text(actionMessages)
    } else {
      $('.dialog__action').removeClass('active')
    }
  })


  //emoji
  $('.emoji-container').hover(function () {
    $('.emoji-wrapper').css('display','block')
    setTimeout(function () {
      $('.emoji-wrapper').css('opacity','1')
    }, 100)
  })
  $('.emoji-container').mouseleave(function () {
    $('.emoji-wrapper').css('opacity','0')
    setTimeout(function () {
      $('.emoji-wrapper').css('display','none')
    }, 100)
  })


  //friends tabs switch
  $('.friends__button_all').click(function() {
    $('.friends__button').removeClass('active')
    $(this).addClass('active')
    $('.friends__tab').removeClass('active')
    $('.friends__tab_all').addClass('active')
  })
  $('.friends__button_online').click(function() {
    $('.friends__button').removeClass('active')
    $(this).addClass('active')
    $('.friends__tab').removeClass('active')
    $('.friends__tab_online').addClass('active')
  })

  //friends apps switch
  $('.friends__app_incoming').click(function() {
    $('.friends__app').removeClass('active')
    $(this).addClass('active')
    $('.apps__tab').removeClass('active')
    $('.apps__tab_incoming').addClass('active')
  })
  $('.friends__app_outcoming').click(function() {
    $('.friends__app').removeClass('active')
    $(this).addClass('active')
    $('.apps__tab').removeClass('active')
    $('.apps__tab_outcoming').addClass('active')
  })


  //friends filter
  $('.friends__filter-btn').click(function() {
    $('.friends__filter').toggleClass('active')
    setTimeout(function () {
      $('.friends__filter').toggleClass('opacity')
    }, 100)
     $(document).mouseup(function (e) {
      var div = $(".friends__filter");
      var btn = $(".friends__filter-btn");
      if (!div.is(e.target)
          && !btn.is(e.target)
          && btn.has(e.target).length === 0
        && div.has(e.target).length === 0) {
        $('.friends__filter').removeClass('opacity')
        setTimeout(function () {
          $('.friends__filter').removeClass('active')
        }, 300)
      }
    });
  })


  //payment
  $(".payment__input_card").mask("9999 9999 9999 9999");
  $(".payment__input_date").mask("99 / 99");
  $(".payment__input_cvv").mask("999");

  
})
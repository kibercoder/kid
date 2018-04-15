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


  //repost
  $('.repost').click( function () {
    $('.modal_repost').css('display','flex')
    setTimeout(function () {
      $('.modal_repost').css('opacity','1')
    }, 100);
    $(document).mouseup(function (e) {
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

  
})
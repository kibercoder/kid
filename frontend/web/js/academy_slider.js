  var slider = tns({
    container: '.academy__slider',
    items: 1,
    mouseDrag: true,
    loop: false
  });

  $(".tns-nav button").each(function () {
    var id = $(this).attr('data-nav');
    $(this).text(++id);
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
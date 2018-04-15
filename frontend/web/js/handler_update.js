$(function(){
/*var labelID;

$('label').click(function() {
    labelID = $(this).attr('for');console.log($('#'+labelID));
    $('#'+labelID).trigger('click');
});*/

$('input#profileform-avatar').change(function(event) {

 
        var $that = $('#form-profile'),
        formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
        ///avatars/165x165/site/10.png

        var getRandom = '?get='+capcha(1111111, 9999999);

        //переменная id_avatar_src - прописана в view site/signup
        //$('.selected_avatar img').attr('src', '/avatars/165x165/site/'+id_avatar_src+getRandom);


        //переменная id_avatar_val - прописана в view site/signup
        //$('#profileform-user_avatar').val(id_avatar_val);

        $.ajax({
          url: '/user/handler',
          type: $that.attr('method'),
          contentType: false, // важно - убираем форматирование данных по умолчанию
          processData: false, // важно - убираем преобразование строк по умолчанию
          data: formData,
          dataType: 'json',
          success: function(data){

            //alert(data); return false;

            if(data){

                if (data.orientation) {
                  //alert(data.orientation);
                }
                
                if(data.success) {
                    //добавим случайный get чтобы картинка обновлялась
                    
                    $('.selected_avatar img').attr('src', data.namefile+getRandom);
                } else {
                    //alert(data.error);
                }

              //$that.replaceWith(json);
            }
          }
        });

    });

});

function capcha(one,two) {
    return Math.floor((Math.random() * (two-one+1))+one);
}
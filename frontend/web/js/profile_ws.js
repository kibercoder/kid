$(function() {

  $('#message_form input[type=file]').on('change', function(){
    var file = document.querySelector('#message_form input[type=file]').files[0];
    console.log(file);
    if(file.size > 1048576){
      $('#message_form').notify(
        "Размер файла не модет превышать 1 MB", 
        { position:"top right"}
      );
      return;
    }
    if(file)
      $(this).after('<div><span>'+file.name+' </span><a href="#" id="message_file_delete">Delete file</a></div>');
  });

  $('#message_form').on('click', '#message_file_delete', function(){
    $('#message_form input[type=file]').val('');
    $(this).parent().remove();
    return;
  });
  
  $('#send_message').on('click', function(){
    var txt, msg, file, fileData;
    txt = $("#message_form #message_txt");
    message = txt.val();
    var user_id = $(this).data('userid');
    if(!message) { 
      $('#message_form').notify(
        "Сообщение не может быть пустым", 
        { position:"bottom right" }
      );
      return; 
    }
    //file = $("#message_form #message_file").val();
    var file = document.querySelector('#message_form input[type=file]').files[0];
  
    if (file) {
      var reader  = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function () {
        console.log(file);
        fileData = reader.result;
        msg = JSON.stringify({ action: "message", user_id: user_id, message: message, file: file.name, fileData: fileData });
        sendCommand(msg);
        closeMessage();
      }      
    } else {
      msg = JSON.stringify({ action: "message", user_id: user_id, message: message});
      sendCommand(msg);
      closeMessage();
    }
  });

  function closeMessage(){
    $("#message_form #message_txt").val("");
    $("#message_form #message_file").val("");
    $('#message_file_delete').parent().remove();
    $('.modal_message').css('opacity','0')
    setTimeout(function () {
      $('.modal_message').css('display','none')
    }, 300); 
    $.notify('Сообщение было отправлено', "success"); 
  }

  $('.gift__button').on('click', function(){
    var gift_id = $(this).data('giftid');
    var user_id = $(this).data('userid');
    msg = JSON.stringify({ action: "gift", gift_id: gift_id, user_id: user_id});
    sendCommand(msg);
    closeGift();    
  })

  function closeGift(){
    $('.modal_gift').css('opacity','0')
    setTimeout(function () {
      $('.modal_gift').css('display','none')
    }, 300)

  }

  $('#add-friend').on('click', addFriend);
  $('#remove-friend').on('click', removeFriend); 

  function addFriend(){
    var user_id = $(this).data('userid');
    msg = JSON.stringify({ action: "add-friend", user_id: user_id});
    sendCommand(msg);
    $(this).attr('id', 'remove-friend').addClass('friend-submitted').text('Заявка отправлена').off("click").on('click', removeFriend);

    $.notify('Запрос на добавление в друзья отправлен', "success");
    return false;   
  }  

  function removeFriend(){
    var user_id = $(this).data('userid');
    msg = JSON.stringify({ action: "remove-friend", user_id: user_id});
    sendCommand(msg);
    if($(this).hasClass('friend-submitted')){
      $.notify('Заявка на добавление в друзья отменена', "info")
      $(this).attr('id', 'add-friend').removeClass('friend-submitted').text('Добавить в друзья').off("click").on('click', addFriend);
    }
    if($(this).hasClass('friend-remove')){
      $.notify('Удален из друзей', "warn");
      $(this).attr('id', 'add-friend').removeClass('friend-remove').text('Добавить в друзья').off("click").on('click', addFriend);
    }      
    return false;   
  }

  socket.onmessage = function(msg) { // JSON.parse
    var data = JSON.parse(msg.data);
    console.log(data);
    if(data.add_gift){
      $("#gift-1").attr('src', data.add_gift);
    }
    if(data.message){
      console.log(data.message);
    }
    if(data.notice){
      console.log(data.notice);
    }    
  };  

});

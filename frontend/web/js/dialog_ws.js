$(function() {
  $('#message_form button.dialog__affix').on('click',  function () {
    $('#message_form #message_file').click();
  });

  $('#message_form input[type=file]').on('change', function(){
    var file = document.querySelector('#message_form input[type=file]').files[0];
    console.log(file);
    if(file.size > 1048576){
      $('#message_form').notify(
        "Размер файла не может превышать 1 MB", 
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
      }      
    } else {
      msg = JSON.stringify({ action: "message", user_id: user_id, message: message});
      sendCommand(msg);
      clearMessage();
    }
  });

  function clearMessage(){
    $("#message_form #message_txt").val("");
    $("#message_form #message_file").val("");
    $('#message_file_delete').parent().remove();
    $.notify('Сообщение было отправлено', "success",{style: 'metro'}); 
  }  

  $.notify.addStyle("metro", {
    html: "",
    classes: {
        error: {
            "color": "#fafafa !important",
            "background-color": "#F71919",
            "border": "1px solid #FF0026"
        },
        success: {
            "background-color": "#8c6c8d",
            "border": "0px solid #4DB149",
            "color": "white"
        },
        info: {
            "color": "#fafafa !important",
            "background-color": "#1E90FF",
            "border": "1px solid #1E90FF"
        },
        warning: {
            "background-color": "#FAFA47",
            "border": "1px solid #EEEE45"
        },
        black: {
            "color": "#fafafa !important",
            "background-color": "#333",
            "border": "1px solid #000"
        },
        white: {
            "background-color": "#f1f1f1",
            "border": "1px solid #ddd"
        }
    }
  });
  $.notify('Сообщение было отправлено', "success",{style: 'metro'});

});

$(function() {

  var hash = window.location.hash.substr(1);
  switch(hash){
    case 'outcoming':
      $('.friends__app_outcoming, .apps__tab_outcoming').addClass('active');
    break;
    case 'incoming':
      $('.friends__app_incoming, .apps__tab_incoming').addClass('active');
    break;
    default:
      $('.friends__app_incoming, .apps__tab_incoming').addClass('active');
    break;   
  }

  $('.remove-submitted').on('click', removeSubmitted);

  function removeSubmitted(){
    var user_id = $(this).data('userid');
    msg = JSON.stringify({ action: "remove-submitted", user_id: user_id});
    sendCommand(msg);
    $('#countOutgoing').text(parseInt($('#countOutgoing').text())-1);
    $.notify('Заявка на добавление в друзья отменена', "info")
     $(this).parents('.friends__item').remove();
    
    return false;   
  }

  $('.friends__delete').on('click', removeFriend);

  function removeFriend(){
    var user_id = $(this).data('userid');
    msg = JSON.stringify({ action: "remove-friend", user_id: user_id});
    sendCommand(msg);
    $.notify('Удален из друзей', "warn");

    $('#countFriends').text(parseInt($('#countFriends').text())-1);
    
console.log($('.friends__tab_online .friends__item[data-userId='+user_id+']').length);    
    if($('.friends__tab_online .friends__item[data-userId='+user_id+']').length){
      $('.friends__tab_online .friends__item[data-userId='+user_id+']').remove();
      $('#countOnlineFriends').text(parseInt($('#countOnlineFriends').text())-1);
  console.log(parseInt($('#countOnlineFriends').text()));  
    }
    $('.friends__tab .friends__item[data-userId='+user_id+']').remove();
    return false;   
  }  

  $('.accept-friend').on('click', acceptFriend);

  function acceptFriend(){
    var user_id = $(this).data('userid');
    msg = JSON.stringify({ action: "accept-friend", user_id: user_id});
    sendCommand(msg);
    $('#countIncoming').text(parseInt($('#countIncoming').text())-1);
    $.notify('Заявка на добавление в друзья одобрена', "success");
    $(this).parents('.friends__item').remove();
    
    return false;   
  }  

  socket.onmessage = function(msg) { // JSON.parse
    var data = JSON.parse(msg.data);
    console.log(data);    
  };  

});

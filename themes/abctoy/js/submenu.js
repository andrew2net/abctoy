$('.mainmenulink').hover(function (){
  $('.submenu').css('display', 'none');
  var id = '#' + $(this).attr('submenu');
  $(id).css('display', 'inherit');
});

$('.mainmenuarea').mouseleave(function (){
  $('.submenu').css('display', 'none');
});

  $(document).ready(function() {
    $('#aSubmit').click(function() {
      $('#giftSelect').submit();
    });
  });

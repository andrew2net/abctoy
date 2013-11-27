$('.mainmenulink').hover(function (){
  $('.submenu').css('display', 'none');
  var id = '#' + $(this).attr('submenu');
  $(id).css('display', 'inherit');
});
$('.mainmenuarea').mouseleave(function (){
  $('.submenu').css('display', 'none');
});

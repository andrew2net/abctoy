$('.mainmenulink').hover(function() {
  $('.submenu').css('display', 'none');
  var id = '#' + $(this).attr('submenu');
  $(id).css('display', 'inherit');
});

$('.mainmenuarea').mouseleave(function() {
  $('.submenu').css('display', 'none');
});

$('#aSubmit').click(function() {
  $('#giftSelect').submit();
});

$('#GiftCategory').val($('#currentGroup').val());

$('#categoryOnly').change(function (){
  if (this.checked)
    $('#GiftCategory').val($('#currentGroup').val());
  else
    $('#GiftCategory').val('');
});
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

$('#categoryOnly').change(function() {
  if (this.checked)
    $('#GiftCategory').val($('#currentGroup').val());
  else
    $('#GiftCategory').val('');
});

$('.addToCart').click(function(event) {
  event.preventDefault();
  var id = $(this).attr('product');
  var quantity = $('#ProductForm_quantity').val();
  if (!quantity)
    quantity = 1;
  $.post('/addtocart', {
    'id': id,
    'quantity': quantity
  },
  function(data) {
    $('#shoppingCart').html(data);
  });
});

$('#buy-one-click').click(function() {
  $('form').submit();
});

$('.cart-quantity').change(function() {
  var sum = 0;
  $('.cart-quantity').each(function() {
    var price = $(this).attr('price');
    sum += parseInt(this.value) * price;
  });
  var id = $(this).attr('product');
  var quantity = parseInt(this.value);
  $.post('/changeCart', {
    'id': id,
    'quantity': quantity
  },
  function() {
    $('#cart-summ').html(sum + '.-');
    Cufon.replace('#cart-summ');
  }
  );
});

$('.submit').click(function() {
  $('form').submit();
});


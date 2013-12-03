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

Number.prototype.formatMoney = function(c, d, t) {
  var n = this,
          c = isNaN(c = Math.abs(c)) ? 0 : c,
          d = d == undefined ? "." : d,
          t = t == undefined ? " " : t,
          s = n < 0 ? "-" : "",
          i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
          j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "") + '.-';
};

function delivery() {
  var price = parseFloat($('input:checked + .cart-radio > span').attr('price'));
  var sum = parseFloat($('#cart-summ').attr('summ'));
  if (!isNaN(price)) {
    var price_f = price.formatMoney();
    $('#delivery-summ').html(price_f);
    $('#cart-total').html((price + sum).formatMoney());
  }
  else {
    $('#delivery-summ').html('');
    $('#cart-total').html(sum.formatMoney());
  }
  Cufon.replace('#delivery-summ, #cart-total');
}

$('#cart-city').change(function() {
  $.get('/delivery', {
    'city': this.value
  }, function(data) {
    $('#cart-delivery').html(data);
    delivery();
  });
});

delivery();
$('#cart-delivery').on('change', 'input[name="Order[delivery_id]"]', function() {
  delivery();
}
);

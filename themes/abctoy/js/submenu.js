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
    $("#add-product-dialog").dialog("open");
  });
});

$('#buy-one-click').click(function() {
  $('form').submit();
});

$(document).on('change', '.cart-quantity', function() {
  var id = $(this).attr('product');
  var quantity = parseInt(this.value);
  if (isNaN(quantity))
    quantity = 0;
  if (quantity < 0) {
    quantity = 0;
    this.value = quantity;
  } else if (quantity > 9) {
    quantity = 9;
  }
  calcSumm();
  $.post('/changeCart', {
    'id': id,
    'quantity': quantity
  });
}
);
$(document).on('click', '.cart-item-del', function() {
  var id = $(this).attr('product');
  $.post('/delitemcart', {
    'id': id,
  }, function(data) {
    $('#cart-items').html(data);
    calcSumm();
    Cufon.replace('#cart-items .cufon');
  }
  );
});

var cartQuantity;
$(document).on('keyup', '.cart-quantity', function(event) {
  if (parseInt(this.value) > 9)
    this.value = cartQuantity;
  calcSumm();
});

$(document).on('keydown', '.cart-quantity', function(event) {
  cartQuantity = this.value;
});

$('.submit').click(function() {
  $('form').submit();
});

$('#item-submit').on('click', '.item-link', function(event) {
  event.preventDefault();
  var action = this.pathname;
  $('#item-submit').attr('action', action);
  $('#item-submit').submit();
});

function calcSumm() {
  var cartSumm = 0;
  var discountSumm = 0;
  $('.cart-quantity').each(function() {
    var price = $(this).attr('price');
    var quantity = parseInt(this.value);
    cartSumm += quantity * price;
    discountSumm += $(this).attr('disc') * quantity;
  });
  if (isNaN(cartSumm))
    cartSumm = 0;
  $('#cart-summ').html(cartSumm.formatMoney());
  $('#cart-discount').html(discountSumm.formatMoney());
  var priceDelivery = parseFloat($('input:checked + .cart-radio > span').attr('price'));
  if (!isNaN(priceDelivery)) {
    var price_f = priceDelivery.formatMoney();
    $('#delivery-summ').html(price_f);
    $('#cart-total').html((priceDelivery + cartSumm).formatMoney());
  }
  else {
    $('#delivery-summ').html('');
    $('#cart-total').html(cartSumm.formatMoney());
  }
  Cufon.replace('#cart-summ, #cart-discount, #delivery-summ, #cart-total');
}

$('#cart-city').typing({
  start: function(event, $elem) {
  },
  stop: function(event, $elem) {
    var city = $elem.val();
    $.get('/delivery', {
      'city': city
    }, function(data) {
      $('#cart-delivery').html(data);
      calcSumm();
    });
  },
  delay: 2000
});

calcSumm();

$('#cart-delivery').on('change', 'input[name="Order[delivery_id]"]', function() {
  calcSumm();
}
);

$(document).ready(function() {
  $(document).on('keydown', ".input-number", function(event) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(event.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow: home, end, left, right
                            (event.keyCode >= 35 && event.keyCode <= 39)) {
              // let it happen, don't do anything
              return;
            }
            else {
              // Ensure that it is a number and stop the keypress
              if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
              }
            }
          });
});

$(function() {
  $("#add-product-dialog").dialog({
    autoOpen: false,
    modal: true,
    draggable: false,
    resizable: false,
    width: 400,
    dialogClass: "add-prodact-alert",
    show: {
      effect: "blind",
      duration: 500
    },
    hide: {
      effect: "explode",
      duration: 500
    }
  });
});

$('#close-add-dialog').click(function() {
  $("#add-product-dialog").dialog('close');
});

$('#cart-add-dialog').click(function() {
  $("#add-product-dialog").dialog('close');
});

$(function() {
  $('.jcarousel')
          .jcarousel({
    wrap: 'circular'
  }).jcarouselAutoscroll({
    interval: 5000,
    create: $('.jcarousel').hover(function() {
      $(this).jcarouselAutoscroll('stop');
    },
            function() {
              $(this).jcarouselAutoscroll('start');
            })
  });
});

$(function() {
  $('.weekcarousel')
          .jcarousel({
    wrap: 'circular'
  }).jcarouselAutoscroll({
    target: '+=1',
    interval: 7000,
    create: $('.weekcarousel').hover(function() {
      $(this).jcarouselAutoscroll('stop');
    },
            function() {
              $(this).jcarouselAutoscroll('start');
            })
  });
  $('.weekcarousel-prev').jcarouselControl({
    target: '-=4'
  });

  $('.weekcarousel-next').jcarouselControl({
    target: '+=4'
  });
});

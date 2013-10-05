(function() {
  jQuery(function() {
    var bodyHeight;
    bodyHeight = $('body').height();
    $('#categoryScroll').css('height', bodyHeight / 2);
    return $(window).resize(function() {
      bodyHeight = $('body').height();
      return $('#categoryScroll').css('height', bodyHeight / 2);
    });
  });

}).call(this);

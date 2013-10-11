(function() {
  jQuery(function() {
    var bodyHeight, bodyWidth;
    bodyHeight = $('body').height();
    bodyWidth = $('body').width();
    $('#categoryScroll').css('height', bodyHeight * 0.5);
    $('.modal-body').css('height', bodyHeight * 0.6);
    $('.modal-content').css('width', bodyWidth * 0.5);
    return $(window).resize(function() {
      bodyHeight = $('body').height();
      bodyWidth = $('body').width();
      $('#categoryScroll').css('height', bodyHeight * 0.5);
      $('.modal-body').css('height', bodyHeight * 0.6);
      return $('.modal-content').css('width', bodyWidth * 0.5);
    });
  });

}).call(this);

(function() {
  var resize;

  jQuery(function() {
    resize();
    return $(window).resize(function() {
      return resize();
    });
  });

  resize = function() {
    var bodyHeight, bodyWidth, postionCategoryScroll, postionEast, windowHeight;
    windowHeight = $(window).height();
    bodyHeight = $('body').height();
    bodyWidth = $('body').width();
    postionEast = $('#east').position();
    postionCategoryScroll = $('#categoryScroll').position();
    $('#categoryScroll').css('height', windowHeight - postionCategoryScroll.top - postionEast.top);
    $('.modal-body').css('height', bodyHeight * 0.6);
    return $('.modal-dialog, .modal-content').css('width', bodyWidth * 0.5);
  };

}).call(this);

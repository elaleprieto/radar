jQuery ->
	resize()
	
	$(window).resize ->
		resize()
		
resize = ->
	windowHeight = $(window).height()
	bodyHeight = $('body').height()
	bodyWidth = $('body').width()
	postionEast = $('#east').position()
	postionCategoryScroll = $('#categoryScroll').position()
	$('#categoryScroll').css('height', windowHeight - postionCategoryScroll.top - postionEast.top)
	$('.modal-body').css('height', bodyHeight * 0.6)
	$('.modal-dialog, .modal-content').css('width', bodyWidth * 0.5)
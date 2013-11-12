jQuery ->
	resize()
	
	$(window).resize ->
		resize()
		
resize = ->
	windowHeight = $(window).height()
	bodyHeight = $('body').height()
	bodyWidth = $('body').width()
	
	$('.modal-body').css('height', bodyHeight * 0.6)
	$('.modal-dialog, .modal-content').css('width', bodyWidth * 0.5)

	if $('#east').length > 0
		postionEast = $('#east').position()

	if $('#categoryScroll').length > 0
		postionCategoryScroll = $('#categoryScroll').position()
		$('#categoryScroll').css('height', windowHeight - postionCategoryScroll.top - postionEast.top)
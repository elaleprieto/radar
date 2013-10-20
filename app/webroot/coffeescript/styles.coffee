jQuery ->
	bodyHeight = $('body').height()
	bodyWidth = $('body').width()
	$('#categoryScroll').css('height', bodyHeight * 0.5)
	$('.modal-body').css('height', bodyHeight * 0.6)
	$('.modal-dialog, .modal-content').css('width', bodyWidth * 0.5)

	$(window).resize ->
		bodyHeight = $('body').height()
		bodyWidth = $('body').width()
		$('#categoryScroll').css('height', bodyHeight * 0.5)
		$('.modal-body').css('height', bodyHeight * 0.6)
		$('.modal-content').css('width', bodyWidth * 0.5)
		
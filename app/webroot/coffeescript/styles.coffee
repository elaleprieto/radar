jQuery ->
	windowHeight = $(window).height()
	bodyHeight = $('body').height()
	bodyWidth = $('body').width()
	
	
	postionEast = $('#east').position()
	postionCategoryScroll = $('#categoryScroll').position()
	$('#categoryScroll').css('height', windowHeight - postionCategoryScroll.top - postionEast.top)
	console.log postionCategoryScroll.top
	console.log windowHeight
	console.log postionEast.top
	console.log (windowHeight - postionCategoryScroll.top - postionEast.top)
	$('.modal-body').css('height', bodyHeight * 0.6)
	$('.modal-dialog, .modal-content').css('width', bodyWidth * 0.5)

	$(window).resize ->
		bodyHeight = $('body').height()
		bodyWidth = $('body').width()
		# $('#categoryScroll').css('height', bodyHeight * 0.5)
		
		$('.modal-body').css('height', bodyHeight * 0.6)
		$('.modal-content').css('width', bodyWidth * 0.5)
		
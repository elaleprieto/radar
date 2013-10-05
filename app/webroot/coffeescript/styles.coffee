jQuery ->
	bodyHeight = $('body').height()
	$('#categoryScroll').css('height', bodyHeight/2)

	$(window).resize ->
		bodyHeight = $('body').height()
		$('#categoryScroll').css('height', bodyHeight/2)
		
$('a.btn').on('click', function(e) {
 
	e.preventDefault();

	// Variables for iFrame code. Width and height from data attributes, else use default.
	var vidWidth = 560; // default
	var vidHeight = 315; // default
	if ( $(this).attr('data-width') ) { vidWidth = parseInt($(this).attr('data-width')); }
	if ( $(this).attr('data-height') ) { vidHeight =  parseInt($(this).attr('data-height')); }
	var iFrameCode = '<iframe width="' + vidWidth + '" height="'+ vidHeight +'" scrolling="yes" allowtransparency="true" allowfullscreen="true" src="'+  $(this).attr('href') +'" frameborder="0"></iframe>';

	// Replace Modal HTML with iFrame Embed
	$('#mediaModal .modal-body').html(iFrameCode);
	// Set new width of modal window, based on dynamic video content
	$('#mediaModal').on('show.bs.modal', function () {
		// Add video width to left and right padding, to get new width of modal window
		var modalBody = $(this).find('.modal-body');
		var modalDialog = $(this).find('.modal-dialog');
		var newModalWidth = vidWidth + parseInt(modalBody.css("padding-left")) + parseInt(modalBody.css("padding-right"));
		newModalWidth += parseInt(modalDialog.css("padding-left")) + parseInt(modalDialog.css("padding-right"));
		newModalWidth += 'px';
		// Set width of modal (Bootstrap 3.0)
	    $(this).find('.modal-dialog').css('width', newModalWidth);
	});

	// Open Modal
	$('#mediaModal').modal();

});

$('#mediaModal').on('hidden.bs.modal', function () {
	$('#mediaModal .modal-body').html('');
});
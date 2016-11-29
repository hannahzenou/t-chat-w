$(document).ready(function() {

	$('button.close').click(function(e) {
		e.preventDefault();

		// $(this).attr('data-dismiss')
		var dataDismiss = $(this).data('dismiss');

		// On prend le parent le plus proche dont la class est la meme que data-dismiss cad alert
		$(this).closest('.' + dataDismiss).remove(); // on remove l'élément donc la class esr .alert
	})

});
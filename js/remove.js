$(document).ready(function() {
	$('button#remove').click(function() {
		var id = $(this).data('post-id');
		
		var response = $.ajax({
			method: 	'POST',
			url: 			'/codify/removepost',
			data: 		{ 
									post_id: 	id
								},
			success: 	function(data, textStatus, xhr) {
				// window.location.reload();
				console.log('status: ' + xhr.status);
				console.log('text: ' + xhr.responseText);
			}
		});

	});
})
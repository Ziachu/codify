$(document).ready(function() {

})

function success(msg) {
	$('.modal header').removeClass('fail');
	$('.modal header').addClass('success');

	$('.modal #modal_title').text('success!');
	$('.modal #modal_content').text(msg);

	$('label[for="info_modal"]').click();
}

function fail(msg) {
	$('.modal header').removeClass('success');
	$('.modal header').addClass('fail');

	$('.modal #modal_title').text('fail!');
	$('.modal #modal_content').text(msg);

	$('label[for="info_modal"]').click();
}
export default {
	init() {
	// JavaScript to be fired on all pages

},
finalize() {
	// JavaScript to be fired on all pages, after page specific JS is fired

	if (typeof tabs !== "undefined") {
		$("#mytabs .hidden").removeClass('hidden');
		$("#mytabs").tabs();
	}

	$('.user_get_stats').click(function() {

		var t = $(this),
		userID = t.data('user'),
		courseID = t.data('course'),
		spinner = t.find('.spinner');

		spinner.addClass('is-active');

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: {
				'action': 'fetch_user_stats',
				'userid': userID,
				'courseid': courseID,
			},
			success: function(data){
				t.replaceWith(data);
				spinner.removeClass('is-active');
				/* eslint-disable no-console */
				// console.log(data);
				/* eslint-enable no-console */
			},
			error: function(data){
				alert(data);
				spinner.removeClass('is-active');
			},
		});
	});

	$('#reportsModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
		userID = button.data('user'),
		userName = button.data('user-name'),
		modal = $(this);

		modal.find('.modal-title').text('Raporty | ' + userName);
		modal.find('.modal-body').html('<span class="spinner is-active"></span>');

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: {
				'action': 'fetch_user_reports',
				'userid': userID,
			},
			success: function(data){
				modal.find('.modal-body').html(data);
				/* eslint-disable no-console */
				// console.log(data);
				/* eslint-enable no-console */
			},
			error: function(data){
				alert(data);
			},
		});
	});
},
};

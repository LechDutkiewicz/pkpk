jQuery(document).ready(function($) {

	tinymce.create('tinymce.plugins.report_plugin', {
		init : function(ed, url) {
				// Register command for when button is clicked
				ed.addCommand('report_insert_shortcode', function() {

					tb_show('Wstaw raport użytkownika', '#TB_inline?inlineId=report-thickbox');

					var select = $('#report_shortcode_select'),
					submit = $('#insert_report_shortcode');

					submit.off('click').on('click', function(){
						
						var lessonId = select.val();
						content = '[user_report id="' + lessonId + '"]';
						tinymce.execCommand('mceInsertContent', false, content);
						tb_remove();
					});


					// var selected = tinyMCE.activeEditor.selection.getContent(),
					// $reportReveal = $('#report_shortcode_reveal'),
					// submit = $reportReveal.find('[type="submit"]'),
					// content = null;

					// $reportReveal.foundation('open');

					// submit.off('click').on('click', function(){
					// 	$reportReveal.foundation('close');

					// 	var buttonRole = $(this).data('type'),
					// 	reportColor = $reportReveal.find('input[name="color"]:checked').val(),
					// 	target = $reportReveal.find('[name="' + buttonRole + '"]').val();

					// 	content =  '[cytat link_do=' + target;
					// 	content += reportColor !== undefined ? ' kolor=' + reportColor : '';
					// 	content += ']';

					// 	tinymce.execCommand('mceInsertContent', false, content);
					// });
					
				});

				ed.onInit.add(function(ed, evt) {
 					// make that the interactions window will open in a thickbox by adding the button the right attributes
 					$('#report-thickbox').addClass('thickbox');
 				});

			// Register buttons - trigger above command when clicked
			ed.addButton('report_button', {title : 'Wstaw raport', cmd : 'report_insert_shortcode', image : url + '/report.png'});
		}
	});

	// Register our TinyMCE plugin
	// first parameter is the button ID1
	// second parameter must match the first parameter of the tinymce.create() function above
	tinymce.PluginManager.add('report_button', tinymce.plugins.report_plugin);
});
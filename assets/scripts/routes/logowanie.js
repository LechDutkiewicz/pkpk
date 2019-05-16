/*eslint-disable */
export default {
  init() {
    // JavaScript to be fired on the login page
    // Perform AJAX login on form submit
  //   $('form#loginform1').on('submit', function(e) {
  //     //$('form#loginform1 .status').text(ajax_login_object.loadingmessage);
  //     $('#wp-submit1').val('Proszę czekać').prop('disabled', true);
  //     //console.log(ajax_login_object.redirecturl);
  //     $.ajax({
  //       type: 'POST',
  //       dataType: 'json',
  //       url: ajax_login_object.ajaxurl,
  //       data: {
  //         'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
  //         'username': $('form#loginform1 #user_login1').val(),
  //         'password': $('form#loginform1 #user_pass1').val(),
  //         'security': $('form#loginform1 #security').val()
  //       },
  //       success: function(data){
  //         $('form#loginform1 .status').show().text(data.message);
  //         $('#wp-submit1').val('Zaloguj').prop('disabled', false);
   //
  //         if (data.loggedin == true) {
  //           $('form#loginform1 .status').removeClass('alert-danger').addClass('alert-success');
  //           document.location.href = ajax_login_object.redirecturl;
  //         } else {
  //           $('form#loginform1 .status').addClass('alert-danger');
  //         }
  //       },
  //     });
  //     e.preventDefault();
  //  });
  },
};

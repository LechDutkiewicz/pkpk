import 'icheck/icheck';

export default {
  init() {
    // JavaScript to be fired on the login page
    $('input').iCheck({
       cursor: true,
    });

    $('#bpmj_edd_invoice_data_invoice_check').on('ifChecked', function() {
      $('.bpmj_edd_invoice_data_invoice').slideDown();
    });

    $('#bpmj_edd_invoice_data_invoice_check').on('ifUnchecked', function() {
      $('.bpmj_edd_invoice_data_invoice').slideUp();
    });
  },
};

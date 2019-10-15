import Vue from 'vue';
import 'icheck/icheck';
import autosize from 'autosize';

export default {
  init() {
    // JavaScript to be fired on the single lesson page
    const app = new Vue({
      el: '#app',
      data: {
        lessonsOpen: false,
        lessonsList: false,
        navOpen: false,
        headerSticky: false,
      },
      methods: {
        hamburger: function(){
          this.navOpen = !this.navOpen;
          this.lessonsOpen = false;
          if ( this.headerSticky ) {
            this.lessonsList = true;
          } else {
            this.lessonsList = !this.lessonsList;
          }

        },
        openLessons: function(){
          this.lessonsOpen = !this.lessonsOpen;
          this.navOpen = false;
          this.headerSticky = true;
          const y = $(window).scrollTop();  //your current y position on the page
          if ( y < 10 ) {
            $(window).scrollTop(y + 10);
          }
        },
      },
      computed: {
        bannerClass: function () {
          return {
            'nav-open': this.navOpen,
            'white-logo': !this.navOpen && !this.headerSticky,
          }
        },
      },
      mounted: function() {
        $('input#attachment').on('change', function() {
          const inputValue = $(this).val().replace(/C:\\fakepath\\/i, '');
          $('.comment-form-attachment label').text(inputValue);
        });

        const header = $(".main-header");
        header.sticky({ topSpacing: 0, zIndex: 99 });

        header.on('sticky-start', function() {
          app.headerSticky = true;
          app.lessonsList = true;
        });

        header.on('sticky-end', function() {
          app.headerSticky = false;
          app.lessonsList = false;
        });

        $('input').iCheck({
         cursor: true,
       });

        var timeoutId,
        raport = $('#raport'),
        action = 'autosave-raport',
        statusHolder = raport.find('.c-lesson__report--status');

        raport.keypress( function() {

          clearTimeout(timeoutId);
          timeoutId = setTimeout( function() {

            var form_data = new FormData(document.forms.namedItem("raport"));
            
            form_data.append('action', action);
            form_data.append('post_id', raport.data('post-id'));
            form_data.append('user_id', raport.data('user-id'));

            $.ajax({
              type:         'POST',
              url:          ajax_login_object.ajaxurl,
              data:         form_data,
              dataType:     'json',
              processData:  false,
              contentType:  false,
              cache:        false,
            }).success(function(){

              var d = new Date();
              statusHolder.html('Zapisano wersję roboczą o: ' + d.toLocaleTimeString() + '.<span style="color:red">Nie zapomnij wysłać raportu jak go ukończysz!</span>');

            }).error(function(){
              statusHolder.html('Nie udało się zrobić automatycznego zapisu wersji roboczej raportu.');
            });
          }, 750);
        });

        autosize(document.querySelectorAll('textarea'));
      },
    });
  },
};

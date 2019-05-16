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

        autosize(document.querySelectorAll('textarea'));
      },
    });
  },
};

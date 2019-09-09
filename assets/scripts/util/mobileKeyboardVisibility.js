import Breakpoint from './getResponsiveBreakpoint';

/**
 * Toggle class for desired Bootstrap screen sizes on input focus
 * @returns {boolean}
 * @author farside {@link https://stackoverflow.com/questions/8556933/screen-styling-when-virtual-keyboard-is-active}
 */

 const breakpoint = new Breakpoint;

 export default class mobileKeyboardVisibility {
  constructor() {
    this.mobileSizes = ["xs", "sm"];
    this.currentSize = breakpoint.getBreakpointName();
    this.isMobile = false;
  }

  detectIfMobile() {
    for (var i=this.mobileSizes.length - 1; i >=0; i--) {
      if (this.currentSize === this.mobileSizes[i]) {
        this.isMobile = true;
        break;
      }
    }
  }

  updateView() {
    if (this.isKeyboard) {
      $(document.body).addClass('when-keyboard-showing');
    } else {
      $(document.body).removeClass('when-keyboard-showing').addClass('keyboard-shown');
    }
  }

  bindInputEvents() {
    if (this.isMobile) {
      // add class on focus
      $("input, textarea").focus(function(){
        $(document.body).addClass('when-keyboard-showing');
      });
      // remove class on leave
      $("input, textarea").blur(function(){
        $(document.body).removeClass('when-keyboard-showing').addClass('keyboard-shown');
      });
    }
  }

  addListeners() {
    /* Android */
    var t = this;

    window.addEventListener("resize", function() {
      this.isKeyboard = (window.innerHeight < this.initial_screen_size);
      this.isLandscape = (screen.height < screen.width);

      t.updateView();
    }, false);

    /* iOS */
    $("input").bind("focus blur",function() {
      $(window).scrollTop(10);
      this.isKeyboard = $(window).scrollTop() > 0;
      $(window).scrollTop(0);

      t.updateView();
    });
  }

  init() {
    this.detectIfMobile();
    // this.addListeners();
    this.bindInputEvents();
  }
}
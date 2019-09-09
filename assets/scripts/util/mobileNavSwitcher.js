import Breakpoint from './getResponsiveBreakpoint';

/**
 * Toggle class for desired Bootstrap screen sizes on input focus
 * @returns {boolean}
 * @author farside {@link https://stackoverflow.com/questions/8556933/screen-styling-when-virtual-keyboard-is-active}
 */

 const breakpoint = new Breakpoint;

 export default class mobileNavSwitcher {
  constructor() {
    this.mobileSizes = ["xs", "sm", "md"];
  }

  detectIfMobile(currentSize) {
    for (var i=this.mobileSizes.length - 1; i >=0; i--) {
      if (currentSize === this.mobileSizes[i]) {
        return true;
      }
    }
  }

  bindNavSwitcher() {
    var t = this;

    window.addEventListener("resize", function() {

      var currentSize = breakpoint.getBreakpointName(),
      isMobile = t.detectIfMobile(currentSize);

      if (!isMobile) {

        var navContainer = $(".banner")
        if (navContainer.hasClass('nav-open')) {

          var lessonsContainer = $(".banner__lessons-list"),
          hamburger = $(".hamburger");
          navContainer.removeClass('nav-open');

          if (!$(".sticky-wrapper").hasClass("is-sticky")){
            navContainer.addClass('white-logo');
          }
          
          lessonsContainer.addClass('hidden');
          hamburger.removeClass('is-active');
        }
      }

    }, false);
  }

  init() {
    this.bindNavSwitcher();
  }
}
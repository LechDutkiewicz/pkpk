import mobileKeyboardVisibility from './../util/mobileKeyboardVisibility';
import mobileNavSwitcher from './../util/mobileNavSwitcher';

const mobBodySwitcher = new mobileKeyboardVisibility;
const mobNavSwitcher = new mobileNavSwitcher;

export default {
	init() {
    // JavaScript to be fired on all pages

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    mobBodySwitcher.init();
    mobNavSwitcher.init();
  },
};

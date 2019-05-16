/**
 * Detect and return the current active responsive breakpoint in Bootstrap
 * @returns {string}
 * @author farside {@link https://stackoverflow.com/users/4354249/farside}
 */

 export default class Breakpoint {
  constructor() {
    this.envs = ["xs", "sm", "md", "lg"];
    this.env = "";
    this.el = $("<div>");
  }

  appendContainers() {
    this.el.appendTo($("body"));
  }

  getBreakpointName() {
    this.appendContainers();
    
    for (var i=this.envs.length - 1; i >=0; i--) {
      this.env = this.envs[i];
      this.el.addClass("d-" + this.env + "-none");
      if (this.el.is(":hidden")) {
    /* eslint-disable no-console */
    console.log(this.env);
    /* eslint-enable no-console */
        break; // env detected
      }
    }
    this.el.attr("class", "");
    return this.env;
  }

  init() {
    this.appendContainers();
    /* eslint-disable no-console */
    // console.log('hula breakpoint');
    /* eslint-enable no-console */
  }
}
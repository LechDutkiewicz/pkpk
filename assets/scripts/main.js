/*eslint-disable */

/** import external dependencies */
import 'jquery';
import 'bootstrap';
import 'lity';

/** import local dependencies */
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import logowanie from './routes/logowanie';
import zamowienie from './routes/zamowienie';
import singleLesson from './routes/single-lesson';
import singleCourse from './routes/single-course';
import raporty from './routes/raporty';

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  /** All pages */
  common,
  /** Home page */
  home,
  /** About Us page, note the change from about-us to aboutUs. */
  aboutUs,
  /** Login page **/
  logowanie,
  /** Checkout **/
  zamowienie,
  /** Single lesson **/
  singleLesson,
  /** Single course **/
  singleCourse,
  /** Reports page **/
  raporty,
});

/** Load Events */
jQuery(document).ready(() => routes.loadEvents());

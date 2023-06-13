/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

require("bootstrap");
const mdb = require('./mdb/js/mdb.pro');
window.mdb = mdb // add lib as a global object
// require('./mdb/plugins/js/all.min')
const Calendar = require('./mdb/plugins/js/calendar.min');
window.Calendar = Calendar;
require('./js/custom_calendar');
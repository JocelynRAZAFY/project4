
require('../css/app.css');
global.$ = require('jquery');
require('../jquery-ui-1.12.1/jquery-ui.min.js');
require('bootstrap');
<!-- Slimscroll -->
require('../../lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');
<!-- FastClick -->
require('../../lte/bower_components/fastclick/lib/fastclick.js');
const routes = require('../../public/js/fos_js_routes.json');
global.Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js');
// import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);
<!-- AdminLTE App -->
require('../../lte/dist/js/adminlte.min.js');
require('../../lte/dist/js/demo.js');
require('../js/load.js');


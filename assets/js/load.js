/**
 * Created by jocelyn on 10/29/18.
 */
$(document).ready(function(){

    switch(yourRoute) {

        case 'index':
            <!-- jQuery UI 1.11.4 -->
            require('../../lte/bower_components/jquery-ui/jquery-ui.min.js');
            <!-- Morris.js charts -->
            Raphael = require('../../lte/bower_components/raphael/raphael.min.js');
            require('../../lte/bower_components/morris.js/morris.min.js');
            <!-- Sparkline -->
            require('../../lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js');
            <!-- jvectormap -->
            require('../../lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');
            require('../../lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
            <!-- jQuery Knob Chart -->
            require('../../lte/bower_components/jquery-knob/dist/jquery.knob.min.js');
            <!-- daterangepicker -->
            global.moment = require('moment');
            require('../../lte/bower_components/bootstrap-daterangepicker/daterangepicker.js');
            require('../../lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
            require('../../lte/dist/js/pages/dashboard.js');

        case 'crud_one_page':
            require('../../lte/bower_components/datatables.net/js/jquery.dataTables.min.js');
            require('../../lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');
            $('#example1').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : false,
                'info'        : true,
                'autoWidth'   : false
            });
            require('./crudAjaxOnePage');
        default:

    }


    console.log(yourRoute);
});
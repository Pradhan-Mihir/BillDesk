		</div>
		<!-- /.container-fluid -->

	<footer class="footer text-center">&copy; 2021 Elite Admin  by <a href="https://www.tryoninfosoft.com/" target="_blank" title="Tryon Infosoft" >tryoninfosoft.com</a></footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
	
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="eliteadmin-ecommerce/bootstrap/dist/js/tether.min.js"></script>
    <script src="eliteadmin-ecommerce/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
	<script src="eliteadmin-ecommerce/js/jquery.PrintArea.js" type="text/JavaScript"></script>
    <!--slimscroll JavaScript -->
    <script src="eliteadmin-ecommerce/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="eliteadmin-ecommerce/js/waves.js"></script>
    <!--Counter js -->
    <script src="plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="plugins/bower_components/raphael/raphael-min.js"></script>
    <!---<script src="plugins/bower_components/morrisjs/morris.js"></script>--->
	<!-- Date Picker Plugin JavaScript -->
    <script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script src="plugins/bower_components/moment/moment.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="plugins/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.js" integrity="sha512-jG3l4wynNj06R0w9JW1WZaCDPvhqa4yz8EAVjYzWqibarcn8JeFDyNtUytcr7Idx+laN7OQDaoDNmUAI4nB1qA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.js" integrity="sha512-jG3l4wynNj06R0w9JW1WZaCDPvhqa4yz8EAVjYzWqibarcn8JeFDyNtUytcr7Idx+laN7OQDaoDNmUAI4nB1qA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="eliteadmin-ecommerce/js/custom.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
	<script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script src="eliteadmin-ecommerce/js/dashboard1.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
	<script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
	<script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
	<script src="plugins/bower_components/switchery/dist/switchery.min.js"></script>
	<script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
	<script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
   
	<script>
    
    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({

        todayHighlight: true
    });

    // Daterange picker

    $('.input-daterange-datepicker').daterangepicker({
		locale :{format: 'DD/MM/YYYY'},
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: '06/01/2015',
        maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        dateLimit: {
            days: 6
        }
    });
    </script>
	
	<script>
    jQuery(document).ready(function() {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());

        });
        // For select 2

        $(".select2").select2();
        $('.selectpicker').selectpicker();
		
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }

        $("input[name='tch1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
        $("input[name='tch2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='tch3']").TouchSpin();

        $("input[name='tch3_22']").TouchSpin({
            initval: 40
        });

        $("input[name='tch5']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });

        // For multiselect

        $('#pre-selected-options').multiSelect();
        $('#optgroup').multiSelect({
            selectableOptgroup: true
        });
			
        $('#public-methods').multiSelect();
        $('#select-all').click(function() {
            $('#public-methods').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function() {
            $('#public-methods').multiSelect('deselect_all');
            return false;
        });
        $('#refresh').on('click', function() {
            $('#public-methods').multiSelect('refresh');
            return false;
        });
        $('#add-option').on('click', function() {
            $('#public-methods').multiSelect('addOption', {
                value: 42,
                text: 'test 42',
                index: 0
            });
            return false;
        });
		
		
    });
    </script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

	
	<script>
    $(document).ready(function() {
		
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });

            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
	</script>
    <script src="js/jasny-bootstrap.js"> </script>
    <!---donut chart--->
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>


</html>

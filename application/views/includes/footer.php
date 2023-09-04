</section>
</section>
<!--main content end-->

</section>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.js?<?=rand()?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url();?>assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo base_url();?>assets/js/easypiechart/jquery.easypiechart.js"></script>
<script src="<?php echo base_url();?>assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>

<script class="include" type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-multi-select/js/jquery.quicksearch.js"></script>

<!--script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script-->

<script src="<?php echo base_url();?>assets/js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="<?php echo base_url();?>assets/js/select-init.js"></script>

<!--common script init for all pages-->
<script src="<?php echo base_url();?>assets/js/scripts.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap-switch.js"></script>

<script src="<?php echo base_url();?>assets/js/toggle-init.js"></script>

<script src="<?php echo base_url();?>assets/js/advanced-form.js"></script>

<!-- Tables -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatables.min.js"></script>

<!-- Wizard Steps -->
<script src="<?php echo base_url();?>assets/js/jquery-steps/jquery.steps.js"></script>

<!--script for this page only-->
<script src="<?php echo base_url();?>assets/js/table-editable.js"></script>

<!-- Multi Select -->
<script src="<?=base_url()?>assets/multi-select/dist/js/BsMultiSelect.js"></script>

		<!-- END JAVASCRIPTS -->
		<script>
		   jQuery(document).ready(function() {
				EditableTable.init();
			});
			
		</script>

		<script type="text/javascript">
             $(function() {
               $('.date_sheet').datepicker({ dateFormat: 'dd-mm-yyyy' }).val();
             });
        </script>

		<script type="text/javascript">
        $(function(){
          $("#example").bsMultiSelect();
        });
    </script>

	<script type="text/javascript">
    	

		$(document).ready(function() {
		    var table = $('#tablesData').DataTable( {
		        	"paging":   false,
		    		"info":   false,
		    		"scrollY": 400,
        			"scrollX": true,
        			"bFilter": false
		    } );
		 
		    $('a.toggle-vis').on( 'click', function (e) {
		        e.preventDefault();
		 
		        // Get the column API object
		        var column = table.column( $(this).attr('data-column') );
		 
		        // Toggle the visibility
		        column.visible( ! column.visible() );
		    } );
		} );
		$("#example_filter").hide();
    </script>

	<script src="<?php echo base_url();?>assets/js/select2.js"></script>
    <script type="text/javascript">
	     $(document).ready(function() {
			$("select").removeClass( "form-control");
			$("select").select2();
		});
	</script>

	</body>
</html>
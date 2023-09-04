    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/select2.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-repeater-main/jquery.repeater.min.js"></script>

    <script type="text/javascript">
	     $(document).ready(function() {
			$("select").removeClass( "form-control");
            $('select').select2({dropdownCssClass: "selectheight"});
		});
	</script> 
    <script>
    $(document).ready(function () {
        $('.repeater').repeater({
            show: function () {
                $(this).slideDown();
                $('.select2-container').remove();
                $('select').select2({dropdownCssClass: "selectheight"});
                $('.select2-container').css('width','100%');

            },

            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        })
    });
    $(document).on('change','.service',function(){
            var base_url = "http://falaq.safro/";
            var elem=$(this);
            var service = elem.val();
            // alert(service);
            $.ajaxSetup({
                beforeSend: function(){
                $('#loading').show();
                },
            });
            $.post(base_url+"externalvendor/getTaskType", {service:service} , function(data){
            $('#loading').hide();
            // alert(data);
            elem.parents(".row").siblings(".row").children().children("select.task_type").html(data);
            });
        });
</script>
 </body>
</html>
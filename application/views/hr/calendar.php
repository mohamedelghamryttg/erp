<link href='<?=base_url()?>assets/calendar/packages/core/main.css' rel='stylesheet' />
<link href='<?=base_url()?>assets/calendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='<?=base_url()?>assets/calendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='<?=base_url()?>assets/calendar/packages/list/main.css' rel='stylesheet' />
<script src='<?=base_url()?>assets/calendar/packages/core/main.js'></script>
<script src='<?=base_url()?>assets/calendar/packages/interaction/main.js'></script>
<script src='<?=base_url()?>assets/calendar/packages/daygrid/main.js'></script>
<script src='<?=base_url()?>assets/calendar/packages/timegrid/main.js'></script>
<script src='<?=base_url()?>assets/calendar/packages/list/main.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      defaultDate: '<?=date("Y-m-d")?>',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      events: [
     	<?php
        foreach ($meeting as $row) { ?>
        {
          title: '<?=$row->title?>',
          start: '<?=$row->start?>',
          end: '<?=$row->end?>',
          color: '#257e4a'
        },
        <?php } ?>
      ]
    });

    calendar.render();
  });

</script>
<style>

 body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }
.fc-view-container{
	margin-top: 80px;		
}

.fc-event-container{
	color: white;
}
	

</style>
<div class="row">
    <div class="col-sm-12">
    	<div class="col-sm-12">
	        <section class="panel">
				<header class="panel-heading ">
					<a title="show depth" href="">Meeting Room Calendar</a> - 
                	<?php if($permission->add == 1){ ?>
                            <a href="<?=base_url()?>hr/meetingRoomList" class="btn btn-primary ">Add New Meeting</a>
                        <?php } ?>
				</header>
				<div class="panel-body " id="calendar">
					<div class=" col-md-12">
						
						
					</div>
					
				</div>
				
			</section>
	    </div>

	   
    </div>
</div>
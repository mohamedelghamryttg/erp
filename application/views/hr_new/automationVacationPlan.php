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
        foreach ($automation_vacation_plan->result() as $row) { 
       
        ?>
         {  
            title: '<?php echo $this->admin_model->getAdmin($row->created_by)?>', 
           start: '<?=$row->date_from?> 00:00:00',
           end: '<?=$row->date_to?> 23:00:00',
           color: '#f64e60'
          },
        <?php  } ?>
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
<!--begin::Content-->
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
              <!--begin::Container-->
              <div class="container">
            
            
              <!--begin::Card-->
                <div class="card">
                  <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                      <h3 class="card-label">Vacation Plan</h3>
                    </div>
                    <div class="card-toolbar">
                     
                     <!--begin::Button-->
                      <?php if($permission->add == 1){ ?>
                        <a href="<?=base_url()?>hr/viewAutomationVacationPlan" class="btn btn-primary font-weight-bolder"> 
                      <?php } ?>
                      <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                          </g>
                        </svg>
                        <!--end::Svg Icon-->
                      </span>Vacation Plan List</a>
                      <!--end::Button-->
                    </div>
                  </div>
                  <div class="card-body" id="calendar">

                  
                  </div>
                </div>
                <!--end::Card-->
              </div>
              <!--end::Container-->
            </div>
            <!--end::Entry-->
          </div>
          <!--end::Content-->
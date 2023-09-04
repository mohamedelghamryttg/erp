<style type="text/css">
    /*.fit-image{
        width: 300px;
        object-fit: cover;
        height: 300px; /* only if you want fixed height 
    }*/
.imageAndPio {
  position: relative;
  width: 50%;
}

.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
  border-radius: 3%;
}

.overlay {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
  color: rgba(0, 0, 0, 0.5);
  border-radius: 3%;
}

.imageAndPio:hover .image {
   opacity: 0.7;
}
.imageAndPio:hover .overlay {
    opacity: 1;
}
.text {
  background-color: #0000;
  /*color: white;*/
  font-size: 16px;
  padding: 16px 32px;
}
/* .img-fluid ,.image{
    max-width: 90%;
    /*position: absolute;
    /*height: auto;
}
.image{
   background-color: rgba(0, 0, 0, 0.5);
   /*position: relative;
   display: none;
   z-index: 10;
}
.img-fluid:hover .image{
    display: block;
    /*background-color: rgba(0, 0, 0, 0.5);
}*/
    .lable{
        display: block;
        /*font-family: Arial, Helvetica, sans-serif;*/
        /*font-family: Courier;*/
        font-family: cursive;
        text-transform: capitalize;
        padding-top: 1%;

    }
    .nameLable {
        font-size: 30px;
        color: #312239;
    }
    .jobDescLable{
         font-size: 25px;
    }
    .emailLable{
         font-size: 20px;
         color:#185898; 
         text-transform: none;
    }
    .phoneLable{
         font-size: 20px;
    }
    .content{
        /* font-size: 20px;
         color: #312239;
         font-family: cursive;
         align-content: center;
         text-align: center;*/
          align-items: center;
          justify-content: center;
          margin: auto; 
          width: 60%;

    }
    .contentLable{
        /*color: #185898;*/
        font-size: 25px;
    }
    .m{
        margin: auto;
    }
    .list{
        border-radius: 25px;
        font-size: 20px;
        background-color: #eeeeee;
    } 
    .image-upload>form>input {
        display: none;
      } 
      .list_item{
        padding: 5px;
      }
      .total{
        background-color: lightgreen;
      }
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-10 m">
        <section class="panel">
            <div class="panel-body ">
                <?php if($this->session->flashdata('true')){ ?>
                  <div class="alert alert-success" role="alert">
                          <span class="fa fa-check-circle"></span>
                          <span><strong><?=$this->session->flashdata('true')?></strong></span>
                        </div>
                <?php  } ?>
                <?php if($this->session->flashdata('error')){ ?>
                        <div class="alert alert-danger" role="alert">
                          <span class="fa fa-warning"></span>
                          <span><strong><?=$this->session->flashdata('error')?></strong></span>
                        </div>
               <?php  } ?> 
              <!-- start image and pio part -->
                <div class="col-2 float-left imageAndPio"> 
                 <?php if(empty($employee->employee_image)){ ?>
                  <img class="image" id="img" src="<?=base_url()?>assets/uploads/employeesImages/default.jpg"> 
                <?php }else{ ?>
                    <img class="image" id="img" src="<?=base_url()?>assets/uploads/employeesImages/<?=$employee->employee_image?>"> 
               <?php  } ?>
                       <div class="overlay image-upload" id="overlay">  
                        <label for="file">
                            <div class="text"><img class="image" onmouseout="var e = document.getElementById('image-upload_form'); e.submit();" id="img"src="http://localhost/html/assets/images/add_image.png"></div>
                        </label>
                      <form  action="<?php echo base_url()?>admin/addEmployeesImages" method="post" id="image-upload_form" enctype="multipart/form-data">
                            <input type="file" id="file"name="file" >
                            <!--<input type="submit" id="submit"name="submit">-->
                         </form>

                      </div>
                </div>
                 <div class="col-10 float-left p-3"> 
                     <label class="lable nameLable"><?=$employee->name?></label>
                     <label class="lable jobDescLable"><?php echo $this->hr_model->getTitle($employee->title);?></label>
                     <label class="lable emailLable"><?=$employee->email?></label>
                     <label class="lable phoneLable"><i class="fas fa-phone-alt"></i><?=$employee->phone?></label>
                 </div>
         </div>
      </section>
    </div>
</div>
              <!-- end image and pio part -->
<div class="row">
    <div class="col-lg-10 m">
        <section class="panel">
            <div class="panel-body ">  
              <!--start data -->
                  <!-- start list -->
                  <div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item list_item ">
                            <a class="list nav-link active"style="border-radius: 25px;" data-toggle="pill" href="#account_settings"aria-controls="pills-home" aria-selected="true">Account Settings</a>
                            </li>
                            <!--<li class="nav-item list_item">
                            <a class="list nav-link"style="border-radius: 25px;" data-toggle="pill" href="#personal_info"aria-controls="pills-profile" aria-selected="false">Personal Info</a>
                            </li>-->
                            <li class="nav-item list_item">
                            <a class="list nav-link"style="border-radius: 25px;" data-toggle="pill" href="#job_info"aria-controls="pills-contact" aria-selected="false">Job Info</a>
                            </li>
                            <li class="nav-item list_item">
                            <a class="list nav-link"style="border-radius: 25px;" data-toggle="pill" href="#vacation_balance"aria-controls="pills-contact" aria-selected="false">Vacation Balance</a>
                            </li> 
                           <!-- <li class="nav-item list_item">
                            <a class="list nav-link"style="border-radius: 25px;" data-toggle="pill" href="#performance"aria-controls="pills-contact" aria-selected="false">Performance</a>
                            </li>-->
                        </ul> 
                    </div>
                        <!-- end list -->
                        <!-- start data section -->
                <div class="tab-content mx-auto" id="pills-tabContent">
                        <div class="tab-pane fade active show in" id="account_settings"  aria-labelledby="pills-home-tab">
                                   

                 <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url()?>admin/doEditProfile" method="post" enctype="multipart/form-data">

                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="user_name">Username</label>

                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?=$users->user_name?>" readonly="" data-maxlength="300" name="user_name" id="user_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="email">Email</label>

                                <div class="col-lg-6">
                                    <input type="email"  placeholder="E-mail" readonly="" class=" form-control" value="<?=$users->email?>" name="email" id="email" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="inputPassword">Password</label>

                                <div class="col-lg-6">
                                    <input type="password" id="inputPassword" placeholder="Password" class=" form-control" value="<?=base64_decode($users->password)?>" 
                                    name="password"  required="">
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button> <a href="<?php echo base_url()?>admin" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>

                 </div>

                <div class="tab-pane fade" id="personal_info" aria-labelledby="pills-profile-tab">
                   <div class="form">
                                <form class="cmxform form-horizontal ">
                           
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Name</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $employee->name;?>" name="name" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Birth Date</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $employee->birth_date;?>" name="birth_date" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Gender</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $gender = ($employee->gender == 1) ? 'Male' : 'Female';?>" name="gender" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-lg-3 control-label">National ID</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $employee->national_id;?>" name="national_id" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            
                        </form>
                    </div>             
                 </div>

                <div class="tab-pane fade" id="job_info" aria-labelledby="pills-contact-tab">
                  <div class="form">
                    <form class="cmxform form-horizontal ">
                           <div class="form-group">
                                <label class="col-lg-3 control-label">Role</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $this->hr_model->getTitle($employee->title);?>" name="title" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Function</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $this->hr_model->getDepartment($employee->department);?>" name="department" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Direct Manager</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $this->hr_model->getEmployee($employee->manager);?>" name="manager" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Hiring Date</label>
                                <div class="col-lg-6">
                                    <input type="text" class=" form-control" value="<?php echo $employee->hiring_date;?>" name="hiring_date" data-maxlength="300" readonly >
                                </div>
                            </div>  
                            
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="vacation_balance" aria-labelledby="pills-contact-tab">
                  <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
            <thead>
              <tr>
                    <th class="total"> Total <?= $vacationBalance->year ?> Balance</th>
                    <th class="total"> Total <?= $vacationBalance->year-1 ?> Balance</th>
                    <!--<th>Double Days Balance</th>-->
                    <th> Consumed Annual Leave</th>
                    <th> Consumed Casual Leave</th>
                    <th class="total"> Total Consumed </th>
                    <!-- <th class="total"> Total Remaining Balance (Current Year + Previous Year + Double Days ) </th>-->
                     <th class="total"> Total Remaining Balance (Current Year + Previous Year ) </th>
                   <!-- <th>Sick Leave</th>-->
                    <!-- <th>Marriage</th>-->
                    <!--<th>Death Leave</th>-->
              </tr>
            </thead>
           <tbody>
              <tr> 
                    <td class="total"><?= $vacationBalance->current_year ?></td>
                   <!--<td class="total"> 21 </td>-->
                    <td class="total"><?= $vacationBalance->previous_year ?></td>
                   <!-- <td><?= $vacationBalance->double_days ?></td>-->
                    <td><?= $vacationBalance->annual_leave ?></td>
                    <td><?= $vacationBalance->casual_leave ?></td>
                    <td class="total"><?= $vacationBalance->casual_leave + $vacationBalance->annual_leave ?></td>
                    <td class="total"><?= ($vacationBalance->current_year + $vacationBalance->previous_year) ?> </td>
                   <!-- <td><?= $vacationBalance->sick_leave ?></td>-->
                   <!--   <td><?= $vacationBalance->marriage ?></td>-->
                   <!-- <td><?= $vacationBalance->death_leave ?></td>-->
              </tr>
            </tbody>
          </table>
                </div>

                <div class="tab-pane fade" id="performance" aria-labelledby="pills-contact-tab">
                   <h3>performance</h3>
                </div>
             </div>
                       <!-- end data section -->

            </div>
              <!--end data -->
        </div>
    </section>
  </div>
</div> 
<script type="text/javascript">
  function addEmployeesImages(){
    var file = $('#file').val();
    //alert(file);
    $.ajaxSetup({
        beforeSend: function(){
          $('#loading').show();
        },
    });
    $.post(base_url+"admin/addEmployeesImages", {file:file} , function(data){
    // alert(data);
    //$("#customerContact").html(data);
        $('#loading').hide();

    }); 
}
</script>
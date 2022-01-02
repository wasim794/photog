<?php require_once 'common.php';
$emp_code = $_REQUEST['id'];
if(!empty($_POST['report']) && $_POST['report']!='Datewise'){ $report = $_POST['report']; $start = date('Ymd');
    if($report=='Weekly'){ $end = date('Ymd', strtotime('-7 days')); }
    else if($report=='Monthly'){ $end = date('Ymd', strtotime('-30 days')); }
     else { $end = date('Ymd', strtotime('-365 days')); }
    $query = $conn->query("select date,id,name,phone,discount,total,service from booking  where emp_code='$emp_code' and status='Complete' and (bdate BETWEEN '$end' AND '$start')  order by id desc");
}
else if(!empty($_POST['report']) && $_POST['report']=='Datewise'){
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    $start = date('Ymd', strtotime($date1));
    $end = date('Ymd', strtotime($date2));
    $end = date('Ymd', strtotime("+1 day", strtotime($end))); 
  
    if(!empty($date1) && !empty($date2)){
     $query = $conn->query("select date,id,name,phone,discount,total,service from booking  where emp_code='$emp_code' and status='Complete' and (bdate BETWEEN '$start' AND '$end')  order by id desc");   
    }
    else if(!empty($date1) && empty($date2)){
     $query = $conn->query("select date,id,name,phone,discount,total,service from booking  where emp_code='$emp_code' and status='Complete' and date ='$date1'  order by id desc");   
    }
}
else{
$query = $conn->query("select date,id,name,phone,discount,total,service from booking  where emp_code='$emp_code' and status='Complete'  order by id desc");
}	
  include('includes/head.php'); include('includes/header.php');?>

<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>
    Technician Earning Info</li>
</ol>
<div class="agile-grids">				
   <div class="agile-tables">
	  <div class="w3l-table-info">					  
		 <div class="panel-default">
           <div class="panel-body">
		    <h3>Technician Info</h3>
			<?php  $sql=$conn->query("SELECT ufile,name,phone,email,address,pincode,city,state FROM technician where id='$emp_code'");
			       $data=$sql->fetch_array();
				    if(!empty($data['ufile'])){$pic = PHOTOURL.$data['ufile'];} else { $pic ='images/user.png'; }?>
			<table class=" table-responsive">
		 
			<tr><td><strong>Profile : </strong></td><td>
			 
			<div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  />
            </div> </td></tr>
			<tr><td><strong> Name : </strong></td><td> <?= $data['name'];?></td></tr>
			<tr><td><strong> Phone : </strong></td><td> <?= $data['phone'];?></td></tr>
			<tr><td><strong> Email : </strong></td><td> <?= $data['email'];?></td></tr>
			<tr><td><strong>Address : </strong></td><td> <?= $data['address'];?>,
			<?= $data['city'];?>,<?= $data['state'];?>-<?= $data['pincode'];?></td></tr>			
 			</table>
		 	
		   </div>
		   </div>
		   
		   	 <div class="panel-default">
           <div class="panel-body">
               <form method="post">
                   <div class="col-lg-3">   <label style=" margin-top: 16px;">Find The Earning Report </label></div>
                   <input type="hidden" name="id" value="<?= $emp_code;?>">
                  <div class="col-lg-3">  <select name="report" class="form-control">
                      <option value="Datewise" <?php if($report=='Datewise'){echo 'selected="selected"';}?>>Datewise</option>
                       <option value="Weekly" <?php if($report=='Weekly'){echo 'selected="selected"';}?>>Weekly</option>
                       <option value="Monthly" <?php if($report=='Monthly'){echo 'selected="selected"';}?>>Monthly</option>
                       <option value="Yearly" <?php if($report=='Yearly'){echo 'selected="selected"';}?>>Yearly</option>
                       <option value="" <?php if($report==''){echo 'selected="selected"';}?>>All</option>
                   </select>
                   </div>
                    <div class="col-lg-2">   <input type="text" name="date1" class="form-control" id="datepicker2" value="<?= $date1; ?>"></div>
                    <div class="col-lg-2">   <input type="text" name="date2" class="form-control" id="datepicker3"  value="<?= $date2; ?>"></div>
                 <div class="col-lg-2">   <input type="submit" name="search" class="btn btn-primary"></div>
                   
               </form>
		   </div>
		   </div>
					 <div class="panel-default">
           <div class="panel-body">

		    <h3><strong>  Earning Info </strong> </h3>
		   
		    <table id="table1" class=" table-responsive">
					<thead>
					  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>
 						  <th>Customer</th>	
 						  <th width="30%">Service</th>						 
 						  <th>Total</th>
 						  <th></th>
 						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
			  $i=0;
			   $earning=0; $total =0;
              while($data=$query->fetch_array()){
                  $i++;
				   $total = $data['total'] - $data['discount'];
				   $earning = $earning + $total ;			   
			 ?> 
				<tr>
				  <td><?php echo $i;?></td>	
				  <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>	
				  <td><?php echo $data['id'];?></td>				   	
				   <td><?php echo $data['name'].' <br>('.$data['phone'].')';?></td>
				    <td><?php echo $data['service'];?></td>	  
				  <td><i class="fa fa-inr"></i> <?= $total;?></td>	
				  <td><a href="lead-view.php?id=<?= $data['id'];?>" class="btn btn-success" target="_blank">View</a></td>
	    	  	  </tr>
					<?php } ?>	 						  
						</tbody>
				<tfoot>
				<tr><td colspan="4">&nbsp;</td><td><strong>Total Earing - </strong></td>
				<td colspan="2"><strong><i class="fa fa-inr"></i> <?= $earning;?></strong></td></tr>
				</tfoot>		
					  </table>       
			 			  </div></div>
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
<?php require_once 'common.php';
 include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Payment History</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Payment History</strong> </h3>
					 
		        <table id="table1" class="table table-responsive">
					<thead>
					  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>
						  <th>Technician</th>
						  <th>Customer</th>	
						  <th>Total</th>						 
 						  <th>Payment Mode</th>
						  <th>Payment Status</th>
						  <th></th>							
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
		$query = $conn->query("select emp_code,id,date,name,phone,discount,total,payment_type,payment_status from booking  where payment_type!='' order by id desc");
			  $i=0;
              while($data=$query->fetch_array()){
                  $i++;
                   $emp_code = $data['emp_code'];
				   $lead_id = $data['id'];
				  				 
 				  $sql2=$conn->query("SELECT name,ufile FROM technician where id='$emp_code'");
                  $show=$sql2->fetch_array();
				   
                  if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}
			      else { $pic ='images/user.png'; }					   
			 ?> 
				<tr>
				  <td><?php echo $i;?></td>	
				  <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>	
				  <td><?php echo $data['id'];?></td>
				  <td><?php if(!empty($show['name'])){?><div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  /> </div><br />
			         <?php echo $show['name']; }?>  </td>	
				   <td><?php echo $data['name'].' <br>('.$data['phone'].')';?></td>	  
				  <td><i class="fa fa-inr"></i> <?php if(empty($data['discount'])){echo $data['total'];}
				            else {echo $data['total']-$data['discount'];}?></td>
	 
			      <td><button type="button" class="btn btn-<?php if($data['payment_type']=='Cash'){ echo 'success';} else{echo 'warning';}?>"><?= $data['payment_type'];?></button></td>
				  <td><?php echo $data['payment_status'];?></td>
 				 <td><a href="lead-view.php?id=<?= $lead_id?>" class="btn btn-primary">View</a></td>
					  	  </tr>
					<?php } ?>	 						  
						</tbody>
					  </table>  
				  	  
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
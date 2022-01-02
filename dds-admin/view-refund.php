<?php require_once 'common.php';
 include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Refund</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Refund</strong> </h3>
					 
		        <table id="table1" class="table table-responsive">
					<thead>
					  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>
						  <th>Technician</th>
						  <th>Customer</th>							 
 						  <th>Payment Mode</th>
						  <th>Payment Status</th>
						  <th>Return Payment(CREDIT)</th>
						  <th></th>							
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
		$query = $conn->query("select emp_code,id,date,name,phone,discount,total,payment_type,payment_status,refund_amt from booking where status='Cancel' order by id desc");
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
	 
			      <td><button type="button" class="btn btn-<?php if($data['refund_amt']=='Cash'){ echo 'success';} else{echo 'warning';}?>"><?= $data['payment_type'];?></button></td>
				  <td><?php if($data['refund_amt']=='') echo 'No'; else echo 'Yes';?></td>
				   <td> <?php echo $data['refund_amt']+0;?></td>
 				 <td><a href="refund_view.php?id=<?= $lead_id?>" class="btn btn-primary">View</a></td>
					  	  </tr>
					<?php } ?>	 						  
						</tbody>
					  </table>  
				  	  
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
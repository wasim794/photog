<?php require_once 'common.php';
 include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Booking</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Booking</strong> </h3>
					 
		<table id="table1" class="table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>	
						  <th>Customer</th>	
							<th>Registered  No</th>	
							<th>Service</th>
							<th>Technician</th>	
 							<th>Status</th>
							<th>Credit</th>
							<th>Action</th>								
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
		$query = $conn->query("select * from booking where type='online' and status='request' or status='Request' order by id desc");
			       $i=0;
                   while($data=$query->fetch_array()){
				   $i++;
				    $id = $data['id'];	
 				    $email = $data['userid'];	
					$emp_code = $data['emp_code'];
					$service = explode(',',$data['service']);
					$category = explode(',',$data['category']);
					$size = sizeof($service);
							       
			       $sql1=$conn->query("SELECT name,phone FROM registration where id='$email'");
			       $data1=$sql1->fetch_array();
				   
				   $sql2=$conn->query("SELECT name,phone,ufile FROM technician where id='$emp_code'");
                  $show=$sql2->fetch_array();
                  if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}
			      else { $pic ='images/user.png'; }	
				   
			 ?> 
				<tr>
					  <td><?php echo $i;?></td>	
					    <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>
						 <td><?php echo $data['id'];?></td>					  
				      <td><?php echo $data1['name'];?></td>
					  <td><?php echo $data1['phone'];?></td>
				       <td><?php for($z=0;$z<$size;$z++){ if(!empty($service[$z])){ echo $service[$z];
					   if(!empty($category[$z])){  echo ' -('.pack_child($category[$z],$conn).')'; } echo ', ';
					} }?></td>
					   <td>
					   <?php if(!empty($show['name'])){?>
			<div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  />
            </div><br />
			 <?php echo $show['name']; }?>  
			 </td>
					 <td><?php echo $data['status'];?></td>
					  <td><?php echo $data['credit'];?></td>
					 <td><a href="booking-edit.php?id=<?= $id;?>" class="btn btn-primary">Edit</a></td>
					  	  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>  
				  	  
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
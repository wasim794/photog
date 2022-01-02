<?php require_once 'common.php';
 include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Part Delivery</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Part Delivery</strong> </h3>
					 
		<table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>
						  <th> Part Delivery Date & Time</th>
						  <th>Technician</th>	
						  <th>Booking Status</th>						 
 							<th width="20%"> </th>								
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
			  $query = $conn->query("select * from part order by id desc");
			  $i=0;
              while($row=$query->fetch_array()){
               $lead_id = $row['lead_id'];
			   $sql = $conn->query("select emp_code,date,id,status from booking where id= '$lead_id' order by id desc");
			   if($sql->num_rows>0){
			      $i++;
			      $data = $sql->fetch_array();
                  $emp_code = $data['emp_code'];				 
 				  $sql2=$conn->query("SELECT name,ufile FROM technician where id='$emp_code'");
                  $show=$sql2->fetch_array();
				   
                  if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}
			      else { $pic ='images/user.png'; }					   
			 ?> 
				<tr>
				  <td><?php echo $i;?></td>	
				  <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>	
				  <td><?php echo $data['id'];?></td>
				  <td><?= date('d/M/Y', strtotime($row['date'])).'  and '.$row['time'];?></td>				  
				  <td><?php if(!empty($show['name'])){?><div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  /> </div><br />
			         <?php echo $show['name']; }?>  </td>
			      <td><?php echo $data['status'];?></td>
 				 <td><a href="lead-view.php?id=<?= $lead_id?>" class="btn btn-success">View</a>
					 <a href="booking-edit.php?id=<?= $lead_id;?>" class="btn btn-primary">Edit</a> </td>
					  	  </tr>
					<?php } }?>	 						  
						</tbody>
					  </table>  
				  	  
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
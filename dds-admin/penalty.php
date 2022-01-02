<?php require_once 'common.php';
 include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Penalty</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Penalty</strong> </h3>
					 
		        <table id="table1" class="table table-responsive">
					<thead>
					  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>
						  <th>Penalty Date</th>
						  <th>Penalty Credit</th>
						  <th>Technician</th>
						  <th>Customer</th>	
						  <th>Booking Status</th>						 
 						  <th width="10%"> </th>								
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
		$query = $conn->query("select lead_id,tech_id,coin,date from credit where type='Penalty' order by id desc");
			  $i=0;
              while($row=$query->fetch_array()){
               $lead_id = $row['lead_id'];
			   $sql = $conn->query("select date,id,status,name,phone from booking where id= '$lead_id'");
			   if($sql->num_rows>0){
			      $i++;
			      $data = $sql->fetch_array();
                  $emp_code = $row['tech_id'];				 
 				  $sql2=$conn->query("SELECT name,ufile FROM technician where id='$emp_code'");
                  $show=$sql2->fetch_array();
				   
                  if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}
			      else { $pic ='images/user.png'; }					   
			 ?> 
				<tr>
				  <td><?php echo $i;?></td>	
				  <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>	
				  <td><?php echo $data['id'];?></td>
				  <td><?= date('d/M/Y', strtotime($row['date']));?></td>	
				  <td><?php echo str_replace('-','',$row['coin']);?></td>			  
				  <td><?php if(!empty($show['name'])){?><div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  /> </div><br />
			         <?php echo $show['name']; }?>  </td>
	 
				   <td><?php echo $data['name'].' ('.$data['phone'].')';?></td>
	 
			      <td><?php echo $data['status'];?></td>
 				 <td><a href="lead-view.php?id=<?= $lead_id?>" class="btn btn-success">View</a></td>
					  	  </tr>
					<?php } }?>	 						  
						</tbody>
					  </table>  
				  	  
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
<?php require_once 'common.php';
if ( isset($_POST['refund']) && !empty($_POST['lead_id']) ) {	
		$lead_id = trim($_POST['lead_id']);
		$tech_id = trim($_POST['tech_id']);
		$coin = trim($_POST['credit']);
		$reason = 'Refund For Lead id #'.$lead_id;
		$type = 'Refund';
	$query = "INSERT INTO credit(tech_id,coin,type,reason,lead_id) VALUES('$tech_id','$coin','$type','$reason','$lead_id')";
			$res = $conn->query($query);
		if($res){ $errTyp = "success"; $errMSG = "Successfully Refund Credit";}
		else { $errTyp = "danger"; $errMSG = "Something went wrong, try again later...";}			
		
}		
 include('includes/head.php'); include('includes/header.php');
 ?>
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Other Lead</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Other Lead</strong> </h3>
			 <?php if ( isset($errMSG) ) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="fa fa-info"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>		 
		<table id="table1">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>
						     <th>Customer</th>	
							<th>Contact  No</th>	
							<th>Service</th>
							<th>Technician</th>	
							<th>Status</th>	
							<th>Credit</th>
 							<th> </th>								
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
			  $query = $conn->query("select date, phone,name,service,status,id,emp_code,category,credit  from booking where  status='Cancel' order by id desc");
			       $i=0;
                   while($data=$query->fetch_array()){
				   $i++;
				    $id = $data['id'];	
 					$emp_code = $data['emp_code'];
  
                   $service = explode(',',$data['service']);
					$category = explode(',',$data['category']);
					$size = sizeof($service);
					
 				   $sql2=$conn->query("SELECT name,ufile FROM technician where id='$emp_code'");
                   $show=$sql2->fetch_array();
				   
                  if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}
			      else { $pic ='images/user.png'; }	
				   
			 ?> 
				<tr>
					  <td><?php echo $i;?></td>	
					    <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>	
						<td><?php echo $data['id'];?></td>				  
				      <td><?php echo $data['name'];?></td>
					  <td><?php echo $data['phone'];?></td>
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
			  <td><?php echo $credit = $data['credit'];?></td>
 					 <td><a href="lead-view.php?id=<?= $id;?>" class="btn btn-success">View</a>
					 <a href="booking-edit.php?id=<?= $id;?>" class="btn btn-primary">Edit</a>
					 <?php if(!empty($emp_code) && !empty($credit)){
					 $s = $conn->query("select id from credit where tech_id='$emp_code' and lead_id='$id'");
					 $num = $s->num_rows;
					 if($num==0){
					 ?>
					 <form action="" method="post">
					  <input type="hidden" name="lead_id"  value="<?= $id;?>"/>
					  <input type="hidden" name="credit"  value="<?= $credit;?>"/>
					  <input type="hidden" name="tech_id"  value="<?= $emp_code;?>"/>
					  <input type="submit" name="refund" value="Refund" class="btn btn-success"/>
					 </form>
					 <?php } }?>
					 </td>
					  	  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>  
				  	  
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
<?php require_once 'common.php';
 include('includes/head.php'); include('includes/header.php');?>
<script>
   function change_status(status){
	window.location = "area_status.php?review="+status;
}

</script>
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Reviews</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Posted Reviews</strong> </h3>
					
					<table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Date</th>
							<th>Customer</th>	
							<th>Contact No.</th>	
							<th width="20%">Review</th>
							<th>Rating</th>
							<th>Technician</th>							
							<th> Status</th>
							<th> Action</th>						
						  </tr>
						</thead>
						<tbody>
					 
			 <?php 
			  $query = $conn->query("select review.id, review.emp_code, review.email,review.view,review.date, rating.rate,review.status from review INNER JOIN rating ON review.id = rating.review_id order by review.id desc");
			       $i=0;
                   while($data=$query->fetch_array()){
				   $i++;
				$id = $data['id'];	
				   $emp_code = $data['emp_code'];	
				    $email = $data['email'];	
							       
			       $sql1=$conn->query("SELECT name,phone FROM registration where id='$email'");
			       $data1=$sql1->fetch_array();
				   
				   $sql2=$conn->query("SELECT name,phone FROM technician where id='$emp_code'");
			       $data2=$sql2->fetch_array();
			 ?> 
			 
			      <tr>
					  <td><?php echo $i;?></td>	
					   <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>					  
				      <td><?php echo $data1['name'];?></td>
					  <td><?php echo $data1['phone'];?></td>
				      <td><?php echo $data['view'];?></td>
					  <td> <?php echo $data['rate'];?> <i class="fa fa-star"></i></td>
					  <td><?php echo $data2['name'];?> (<?php echo $data2['phone'];?>)</td>
					 <td> <?php if($data['status']==1) {?>
     <a href="#" onClick="change_status(<?=$id?>)" class="btn btn-primary">Active</a>
                <?php }else{?> 
     <a href="#" onClick="change_status(<?=$id?>)" class="btn btn-danger">Inactive</a>
                <?php }?></td>
				<td><a href="edit-review.php?id=<?php echo $id;?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a> </td>
					  	  </tr>     
					<?php }?>	  
				  	  
					</tbody>
					  </table>	  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
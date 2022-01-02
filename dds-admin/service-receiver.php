<?php require_once 'common.php';
 include('includes/head.php'); include('includes/header.php');?>
<script>
   function change_status(status){
	window.location = "area_status.php?receiver="+status;
}

</script>
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Service Receiver</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong>Service Receivers</strong> </h3>
					 
			<table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						    <th>Pic</th>
							<th>Name</th>	
							<th>Phone</th>	
							<th>Email</th>
 							<th>Address</th>
							<th>Date</th>
							<th>Status</th>							
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
			  $query = $conn->query("select * from registration  order by id desc");
			       $i=0;
                   while($data=$query->fetch_array()){
				   $i++;
				$id = $data['id'];	
				if(empty($data['pic'])){$pic = '../images/user.png';}
	else { $pic = PHOTOURL.$data['pic'];}				  
			 ?> 
				<tr>
					  <td><?php echo $i;?></td>	
					  <td> <div class="profile">
					 <img src="<?php echo $pic;?>"  />
            </div></td>					  
				      <td><strong><?php echo $name= $data['name'];?></strong></td>
					  <td><?php echo $data['phone'];?></td>
				      <td><?php echo $data['email'];?></td>
 					   <td><?php echo $data['address'];?>, <?php echo $data['city'];?> ,
					    <?php echo $data['state'];?> - <?php echo $data['area'];?></td>
					  <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>
					  <td> <?php if($data['status']==1) {?>
     <a href="#" onClick="change_status(<?=$id?>)" class="btn btn-primary">Active</a>
                <?php }else{?> 
     <a href="#" onClick="change_status(<?=$id?>)" class="btn btn-danger">Inactive</a>
                <?php }?>	  	  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/sidebar.php');?>
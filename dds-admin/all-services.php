<?php require_once 'common.php';
$id = $_REQUEST['id'];
$name = $_REQUEST['name'];	


include('includes/head.php');
include('includes/header.php');?>

<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>All Services</li>
            </ol>
			
<div class="agile-grids">	
				<div class="agile-tables">
				<a href="service-provider.php" class="btn btn-success pull-right">Back</a>
					<div class="w3l-table-info">
					  <h2 style="text-transform:capitalize"><?= $name?>'s Services Details</h2>
		<table id="table1">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Category</th>	
							<th>Service</th>
							<th>Area</th>	
							<th>Days</th>			
							<th>Timing </th>	
							<th>Status</th>	
							<th>Date</th>			
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM services where emp_code='$id' order by sid desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $sub = $data['sub'];
			 $category = $data['category'];
			$i++;
			 ?>
				<tr>
					  <td><?php echo $i;?></td>						  
				      <td><?php echo Category($category,$conn);?></td>
					  <td><?php echo SubCategory($sub,$conn);?></td>
				      <td><?php echo $data['area'];?></td>
					  <td><?php echo $data['days'];?></td>
					  <td><?php echo $data['timing'];?> To <?php echo $data['timing1'];?></td>
					  <td><?php echo date('d M Y', strtotime($data['date']));?></td>
					  <td> <?php if($data['status']==1) {?>
     <p class="approved" >Active</p>
                <?php }else{?> 
     <p class="ico_pending">Inactive</p>
                <?php }?> </td>	
				
						  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>	
					</div>
 </div>
			</div>

<?php include('includes/footer.php');?>	
 <?php include('includes/sidebar.php');?>
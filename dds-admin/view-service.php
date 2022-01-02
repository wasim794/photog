<?php require_once 'common.php';
if (isset($_REQUEST['delete']) ){
$sql=$conn->query("select * FROM `service` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];	


  $sql1=$conn->query("select * FROM `images` WHERE service_id='".$_REQUEST['delete']."'");
	while($row1 = $sql1->fetch_array()){
	$filename1 = $row1['file_name'];  unlink(PHOTOURL.$filename1);
	}
$db1=$conn->query("DELETE FROM `images` WHERE service_id='".$_REQUEST['delete']."'");
		$db=$conn->query("DELETE FROM `service` WHERE id='".$_REQUEST['delete']."'");
		if($db){	
		 unlink(PHOTOURL.$filename);	
		header('location:view-service.php');	exit;
		}
	}		
include('includes/head.php');
include('includes/header.php');?>
<script>
   function change_status(status){
	window.location = "area_status.php?status="+status;
}
  function change_status1(status){
	window.location = "area_status.php?hide="+status;
}
function chkDelete(ids,pid){

	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-service.php?id="+pid+"&delete="+ids;
	}
	else 	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Services</li>
            </ol>
<div class="agile-grids">	
<a href="add-service.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Services</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Services Details</h2>
		<table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Category</th>	
							<th>Sub</th>
							<th>Title</th>	
							<th>Image</th>			
							<th>Recommended </th>	
							<th>Status</th>			
							<th width="15%">Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM service  order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			 if(!empty($data['ufile'])){$pic = $data['ufile'];}
			 else { $pic ='favicon.png'; }
			 ?>
				<tr>
					  <td><?php echo $i;?></td>						  
				      <td><?php echo Category($data['category'],$conn);?></td>
					  <td><?php echo SubCategory($data['sub'],$conn);?></td>
				      <td><?php echo $data['title'];?></td>
					  <td> <img src="uploads/<?php echo $pic;?>" width="100" ></td>
					  <td> <?php if($data['rstatus']==1) {?>
     <a href="#" style="text-decoration:none;" onClick="change_status1(<?=$data['id']?>)" class="approved" >Yes</a>
                <?php }else{?> 
     <a href="#" style="text-decoration:none;" onClick="change_status1(<?=$data['id']?>)" class="ico_pending">No</a>
                <?php }?> </td>	
				 <td> <?php if($data['status']==1) {?>
   <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['id']?>)" class="approved" >Active</a>
                <?php }else{?> 
 <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['id']?>)" class="ico_pending">Inactive</a>
                <?php }?> </td>	
							<td><a href="add-service.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>	
					</div>
 </div>
			</div>

<?php include('includes/footer.php');?>	
 <?php include('includes/sidebar.php');?>
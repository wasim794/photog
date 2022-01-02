<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) {	
	$sql=$conn->query("select ufile FROM `category` WHERE cid='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];	
		$db=$conn->query("DELETE FROM `category` WHERE cid='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:view-category.php');	exit;
		}
	}		
	
 include('includes/head.php');	 include('includes/header.php');?>
				<script>
function chkDelete(ids,pid){

	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-category.php?id="+pid+"&delete="+ids;
	}
	else	{
		return false;
	}
}
 
  function change_status(status){
	window.location = "area_status.php?cstatus="+status;
}
  function change_status1(status){
	window.location = "area_status.php?front="+status;
}
</script>
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Category</li>
            </ol>
<div class="agile-grids">	
		<div class="agile-tables">
<a href="add-category.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Category</a>	
				  			
		
					<div class="w3l-table-info">
					  <h2>Category Details</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Category</th>	
							<th>Image</th>
							
							<th>Front</th>				
							<th>Status</th>			
							<th width="20%">Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM category  order by cid asc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			 if(!empty($data['ufile'])){$pic = $data['ufile'];}
			 else { $pic ='favicon.png'; }
			 ?>
						  <tr>
						  <td><?php echo $i;?></td>						  
					       <td><?php echo $data['cate'];?></td>
						 <td> <img src="uploads/<?php echo $pic;?>" width="100" ></td>
						 
						 <td> <?php if($data['front']==1) {?>
                <a href="#" style="text-decoration:none;" onClick="change_status1(<?=$data['cid']?>)" class="approved" >Yes</a>
                <?php }else{?> 
                <a href="#" style="text-decoration:none;" onClick="change_status1(<?=$data['cid']?>)" class="ico_pending">No</a>
                <?php }?> </td>	
				
				
				<td> <?php if($data['status']==1) {?>
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['cid']?>)" class="approved" >Active</a>
                <?php }else{?> 
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['cid']?>)" class="ico_pending">Inactive</a>
                <?php }?> </td>
							<td><a href="add-category.php?cid=<?php echo $data["cid"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["cid"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>

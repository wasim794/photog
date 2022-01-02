<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) 
	{
	$sql=$conn->query("select * FROM `partner` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];
	
		$db=$conn->query("DELETE FROM `partner` WHERE id='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:view-partner.php');	exit;
		}
		
	}	 include('includes/head.php'); include('includes/header.php');?>
<script> 
  function change_status(sstatus){
	window.location = "area_status.php?pstatus="+sstatus;
}

function chkDelete(ids,pid){

	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-partner.php?id="+pid+"&delete="+ids;
	}
	else	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Partner</li> </ol>
<div class="agile-grids">	
<a href="add-partner.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Partner</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Partner Details</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Link</th>
							<th>Image</th>
							<th>Status</th>
							<th width="20%">Action</th>
							
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM partner  order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;			
			 ?>
						  <tr>
						  <td><?php echo $i;?></td>
						    <td><?php echo $data['title'];?></td>
						  <td><img src="uploads/<?php echo $data['ufile'];?>" width="150" ></td>
					       <td> <?php if($data['status']==1) {?>
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['id']?>)" class="approved" >Active</a>
                <?php }else{?> 
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['id']?>)" class="ico_pending">Inactive</a>
                <?php }?> </td>
							<td><a href="add-partner.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
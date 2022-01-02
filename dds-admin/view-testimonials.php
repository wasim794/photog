<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) {
	$sql=$conn->query("select * FROM `testimonials` WHERE nid='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];
	
		$db=$conn->query("DELETE FROM `testimonials` WHERE nid='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:view-testimonials.php');	exit;
		}
	}
	
 include('includes/head.php');	 include('includes/header.php');?>
				<script>
 
  function change_status(status)
{
	window.location = "area_status.php?tstatus="+status;
}

function chkDelete(ids,pid)
{

	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-testimonials.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Testimonials</li>
            </ol>
<div class="agile-grids">	
<a href="add-testimonials.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Testimonials</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2> What Clients Say?</h2>
					    <table id="table" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th width="20%">Name</th>
							<th width="20%">Pic</th>
							<th>Review</th>
							<th>Status</th>
							<th width="20%">Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM testimonials  order by nid desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++; ?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $data['title'];?></td>
						  <td><img src="uploads/<?php echo $data['ufile'];?>" width="100"></td>
						   <td><?php echo $data['detail'];?></td>
					       <td> <?php if($data['status']==1) {?>
  <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['nid']?>)" class="approved" >Active</a>
                <?php }else{?> 
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['nid']?>)" class="ico_pending">Inactive</a>
                <?php }?> </td>
							<td align="center"><a href="add-testimonials.php?nid=<?php echo $data["nid"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["nid"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a>
							
							</td>
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>

<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
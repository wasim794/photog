<?php require_once 'common.php';
$thead ='Slider';
if (isset($_REQUEST['delete']) )
	{
	$sql=$conn->query("select * FROM `slider` WHERE fid='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];
	
		$db=$conn->query("DELETE FROM `slider` WHERE fid='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:view-slider.php');	exit;
		}
	}		 include('includes/head.php');  include('includes/header.php');?>
	<script>
 
  function change_status(sstatus)
{
	window.location = "area_status.php?sstatus="+sstatus;
}

function chkDelete(ids,pid)
{

	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-slider.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View slider</li>
            </ol>
<div class="agile-grids">	
<a href="add-slider.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New slider</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Slider Details</h2>
					    <table id="table" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Heading</th>
						  <th>Sub Heading</th>
							<th>Banner</th>
							<th>Video</th>
							<th>Status</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM slider  order by fid desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;  ?>
						  <tr>
						  <td><?php echo $i;?></td>
						    <td><?php echo $data['category'];?></td>
							 <td><?php echo $data['title'];?></td>
						  <td><img src="uploads/<?php echo $data['ufile'];?>" width="200" height="100"></td>
						  <td style="    max-width: 132px;
    width: 100px;"> <?php echo $data['video']?></td>
					       <td> <?php if($data['status']==1) {?>
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['fid']?>)" class="approved" >Active</a>
                <?php }else{?> 
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['fid']?>)" class="ico_pending">Inactive</a>
                <?php }?> </td>
							<td><a href="add-slider.php?fid=<?php echo $data["fid"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["fid"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
			<style type="text/css">
				iframe {
    width: 100px;
    height: 100px;
}
			</style>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>

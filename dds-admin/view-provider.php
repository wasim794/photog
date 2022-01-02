<?php require_once 'common.php';
$thead ='Slider';
if (isset($_REQUEST['delete']) )
	{
	$sql=$conn->query("select * FROM `providers` WHERE fid='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];
	
		$db=$conn->query("DELETE FROM `providers` WHERE fid='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:view-provider.php');	exit;
		}
	}		 include('includes/head.php');  include('includes/header.php');?>
	<script>
 
  function change_status(prstatus)

{
	 alert(prstatus);
	window.location = "area_status.php?prstatus="+prstatus;
}

function chkDelete(ids,pid)
{

	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-provider.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View providers</li>
            </ol>
<div class="agile-grids">	
<a href="add-slider.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New providers</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>providers Details</h2>
					    <table id="table" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						 <!--  <th>Heading</th>
						  <th>Sub Heading</th> -->
							<th>Banner</th>
							<th>Status</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM providers  order by fid desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;  ?>
						  <tr>
						  <td><?php echo $i;?></td>
						    <!-- <td><?php echo $data['category'];?></td>
							 <td><?php echo $data['title'];?></td> -->
						  <td><img src="uploads/<?php echo $data['ufile'];?>" width="200" height="100"></td>
					       <td> <?php if($data['status']==1) {?>
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['fid']?>)" class="approved" >Active</a>
                <?php }else{?> 
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['fid']?>)" class="ico_pending">Inactive</a>
                <?php }?> </td>
							<td><a href="add-provider.php?fid=<?php echo $data["fid"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["fid"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>

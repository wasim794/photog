<?php require_once 'common.php';

if (isset($_REQUEST['delete']) )
	{
	$sql=$conn->query("select * FROM `logo` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	
		$db=$conn->query("DELETE FROM `logo` WHERE id='".$_REQUEST['delete']."'");
		if($db){
		 // unlink(PHOTOURL.$filename);
		header('location:view-addr.php');	exit;
		}
	}		 include('includes/head.php');  include('includes/header.php');?>
	<script>
 

function chkDelete(ids,pid)
{

	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-addr.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Address</li>
            </ol>
<div class="agile-grids">	
<a href="add-addr.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Address</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Address Details</h2>
					    <table id="table" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Email</th>
						  <th>Phone</th>
							<th>Address</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM logo  order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;  ?>
						  <tr>
						  <td><?php echo $i;?></td>
						    <td><?php echo $data['email'];?></td>
							 <td><?php echo $data['phone'];?></td>
						  <td><?php echo $data['address'];?></td>
					       
							<td><a href="add-addr.php?fid=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) {
		$db=$conn->query("DELETE FROM `package` WHERE id='".$_REQUEST['delete']."'");
		if($db){
		header('location:view-package.php');	exit;
		}
	}
	
 include('includes/head.php');	 include('includes/header.php');?>
<script> 
  function change_status(status){
	window.location = "area_status.php?pack="+status;
}

function chkDelete(ids,pid){
	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-package.php?id="+pid+"&delete="+ids;
	}
	else	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Package</li>
            </ol>
<div class="agile-grids">	
<a href="add-package.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Package</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2> Package</h2>
					    <table id="table1" class="table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th width="20%">Service</th>
							<th width="20%">Package</th>
							<th>Price</th>
							<th>credit</th>
							<th width="20%">Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM package  order by id asc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++; ?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo Child($data['child'],$conn);?></td>
						   <td><?php echo $data['pack'];?></td>
						    <td><?php echo $data['price'];?></td>
							<td><?php echo $data['credit']; if($data['type']=='Percentage'){echo '%';}?></td>
							<td align="center"><a href="add-package.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a>
							
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
<?php  include('common.php');
if (isset($_REQUEST['delete'])) {
		$db_1=$conn->query("DELETE FROM `city` WHERE id='".$_REQUEST['delete']."'");
		header('location:view-city.php');	exit;	}
 include('includes/head.php'); include('includes/header.php');?>	
<script>
function chkDelete(ids,pid){
	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-city.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View City</li>
            </ol>
<div class="agile-grids">	
<a href="add-city.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New City</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>All City</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>State</th>
						    <th>City</th>
						  <th width="20%">Action</th>
 						  </tr>
						</thead>
						<tbody>
 			 <?php 
			 $sql=$conn->query("SELECT * FROM city  order by state asc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;			
			 ?>
						  <tr>
						  <td><?php echo $i;?></td>
						    <td><?php echo $data['state'];?></td>
							<td><?php echo $data['cities'];?></td>
							<td><a href="add-city.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
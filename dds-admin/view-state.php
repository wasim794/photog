<?php  include('common.php');
if (isset($_REQUEST['delete'])) {
		$db_1=$conn->query("DELETE FROM `state` WHERE id='".$_REQUEST['delete']."'");
		header('location:view-state.php');	exit;	}
 include('includes/head.php'); include('includes/header.php');?>	
<script>
function chkDelete(ids,pid){
	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-state.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View State</li>
            </ol>
<div class="agile-grids">	
<a href="add-state.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New State</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>All State</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>State</th>
						  <th width="20%">Action</th>
 						  </tr>
						</thead>
						<tbody>
 			 <?php 
			 $sql=$conn->query("SELECT * FROM state  order by states asc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;			
			 ?>
						  <tr>
						  <td><?php echo $i;?></td>
						    <td><?php echo $data['states'];?></td>
							<td><a href="add-state.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
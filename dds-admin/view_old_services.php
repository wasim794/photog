<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) 	{
$sql=$conn->query("select ufile FROM `child` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];	
		$db =$conn->query("DELETE FROM `child` WHERE id='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:view-child.php');	exit;
		}
	}		

 include('includes/head.php');
 include('includes/header.php');?>
				<script>
function chkDelete(ids,pid){

	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-child.php?id="+pid+"&delete="+ids;
	}
	else	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Child Category</li>
            </ol>
<div class="agile-grids">	
<a href="add-child.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Child Category</a>	
				<div class="agile-tables">
				 		
		
					<div class="w3l-table-info">
					  <h2>Seo Old Detail </h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Category</th>	
							<th>Keyword</th>
							<th>Description</th>
							<th>title</th>
							
							<th width="20%">Action</th>
							
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM seo order by seo_id asc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			
			 ?>
						  <tr>
						  <td><?php echo $i;?></td>
					       <td><?php echo  SubCategory($data['cid'],$conn);?></td>
						   <td><?php echo $data['seo_title'];?></td> 
						   <td><?php echo $data['seo_des'];?></td> 
						   <td><?php echo $data['title'];?></td> 
							<td><a href="old_services.php?cid=<?php echo $data["seo_id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>			
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
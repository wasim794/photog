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
					  <h2>Child Category </h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Category</th>	
							<th>Sub Category</th>
							<th>Child Category</th>	
							<th>Image</th>
							<th width="20%">Action</th>
							
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM child order by id asc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			 if(!empty($data['ufile'])){$pic = $data['ufile'];}
			 else { $pic ='favicon.png'; }
			 ?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo  Category($data['cate'],$conn);?></td>
					       <td><?php echo  SubCategory($data['sub'],$conn);?></td>
						   <td><?php echo $data['title'];?></td> 
						   <td> <img src="uploads/<?php echo $pic;?>" width="100" ></td>
							<td><a href="add-child.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>			
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) 	{
		$db_1=$conn->query("DELETE FROM `subcategory` WHERE cid='".$_REQUEST['delete']."'");
		header('location:view-subcategory.php');	exit;
	}		

 include('includes/head.php');
 include('includes/header.php');?>
				<script>
function chkDelete(ids,pid){

	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-subcategory.php?id="+pid+"&delete="+ids;
	}
	else	{
		return false;
	}
}
  function change_status(status){
	window.location = "area_status.php?ccstatus="+status;
}
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Sub Category</li>
            </ol>
<div class="agile-grids">	
<a href="add-subcategory.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New SubCategory</a>	
				<div class="agile-tables">
				 		
		
					<div class="w3l-table-info">
					  <h2>Sub Category Details</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Category</th>	
							<th>Sub Category</th>
							<th>Type</th>		
							<th>Status</th>							
							<th width="20%">Action</th>
							
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT subcategory.sub, subcategory.status, subcategory.cid,subcategory.type ,category.cate FROM subcategory INNER JOIN category ON category.cid = subcategory.cate order by category.cate asc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $data['cate'];?></td>
					       <td><?php echo $data['sub'];?></td>
						     <td><?php echo $data['type'];?></td>
						    <td> <?php if($data['status']==1) {?>
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['cid']?>)" class="approved" >Active</a>
                <?php }else{?> 
                <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['cid']?>)" class="ico_pending">Inactive</a>
                <?php }?> </td>
							<td><a href="add-subcategory.php?cid=<?php echo $data["cid"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["cid"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>			
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
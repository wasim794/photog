<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) 
	{
		$db_1=$conn->query("DELETE FROM `terms` WHERE id='".$_REQUEST['delete']."'");
		header('location:view-terms.php');	exit;
	}		 ?>
<?php include('includes/head.php');?>
				<?php include('includes/header.php');?>
					<script>
function chkDelete(ids,pid)
{

	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-terms.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View terms</li>
            </ol>
<div class="agile-grids">	
			<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Terms Details</h2>
					    <table id="table1" class="table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th width="20%">Category</th>
							<th width="20%">Title</th>
							<th width="30%">Content</th>
							<th>Action</th>
							
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM terms order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $data['category'];?></td>
						  <td><?php echo $data['title'];?></td>
					      <td><?php echo substr($data['detail'],0,300);?>...</td>
							<td><a href="add-terms.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a>	</td>
							
						  </tr>
					<?php }?>	  
						  
						  
						  
						</tbody>
					  </table>
					</div>
				

				</div>
			</div>

<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
							
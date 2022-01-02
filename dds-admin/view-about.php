<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) {
	$sql=$conn->query("select * FROM `about` WHERE nid='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];
	
		$db=$conn->query("DELETE FROM `about` WHERE nid='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:view-about.php');	exit;
		}
	}
 include('includes/head.php');		 include('includes/header.php');?>
 
				<script>
function chkDelete(ids,pid)
{

	if(confirm("Are you sure you want to delete Record(s)"))
	{
		window.location.href="view-about.php?id="+pid+"&delete="+ids;
	}
	else
	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View About</li>
            </ol>
<div class="agile-grids">			
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>About Details</h2>
					    <table id="table" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th width="20%">Title</th>
								 <th width="20%">Pic</th>
							<th width="40%">Content</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM about order by nid desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $data['title'];?></td>
						   <td><img src="<?php echo PHOTOURL.$data['ufile'];?>" width="150"></td>
					      <td><?php echo substr($data['detail'],0,300);?>...</td>
							<td><a href="add-about.php?nid=<?php echo $data["nid"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["nid"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a>	</td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
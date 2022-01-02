<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) {
	$sql=$conn->query("select * FROM `blog` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['photo'];
	
	$db=$conn->query("DELETE FROM `blog` WHERE id='".$_REQUEST['delete']."'");
	if($db){ unlink(PHOTOURL.$filename); header('location:view-blog.php');	exit;}
	}
 include('includes/head.php');		 include('includes/header.php');?>
 <script>
function chkDelete(ids,pid){
	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-blog.php?id="+pid+"&delete="+ids;
	}
	else	{
		return false;
	}}
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Blog</li>
            </ol>
<div class="agile-grids">			
				<div class="agile-tables">
					<div class="w3l-table-info">
					 <?php if ( isset($_REQUEST['success']) ) { ?>
				<div class="form-group">
            	<div class="alert alert-success">
				<span class="fa fa-info"></span> Successfully Add blog details.
                </div>
            	</div>
                <?php } ?>
				 <?php if ( isset($_REQUEST['usuccess']) ) { ?>
				<div class="form-group">
            	<div class="alert alert-success">
				<span class="fa fa-info"></span> Successfully Update blog details.
                </div>
            	</div>
                <?php } ?>
					  <h2>Blog Details</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th width="20%">Title</th>
								 <th width="15%">Pic</th>
							<th width="30%">Content</th>
							<th width="15%">Date</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM blog order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $data['title'];?></td>
						   <td><img src="<?php echo PHOTOURL.$data['photo'];?>" width="150"></td>
					      <td><?php echo substr($data['detail'],0,200);?>...</td>
						   <td><?php echo date('d-M-Y', strtotime($data['date']));?></td>
							<td><a href="add-blog.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a>	</td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
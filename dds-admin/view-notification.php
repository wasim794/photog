<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) 	{
		$db_1=$conn->query("DELETE FROM `notification` WHERE id='".$_REQUEST['delete']."'");
		header('location:view-notification.php');	exit;
	}		

 include('includes/head.php');
 include('includes/header.php');?>
<script>
 function chkDelete(ids,pid){
 	if(confirm("Are you sure you want to delete Record(s)")){
		window.location.href="view-notification.php?delete="+ids;
	}
	else	{
		return false;
	}
} 
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Notification</li>
            </ol>
<div class="agile-grids">	
<a href="notification.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Send Notification</a>	
				<div class="agile-tables">
				 		
		
					<div class="w3l-table-info">
					  <h2>Notification Details</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Title</th>	
 							<th>Message</th>		
							<th>Service Type</th>
							<th>Date</th>							
							<th width="20%">Action</th>
							
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM notification order by id desc");
			 $data=$sql->fetch_array();
			 // echo sizeof($data);
			  $sql1="SELECT * FROM notification order by id desc";
            $result=mysqli_query($conn,$sql1);
			  $i=0;  
	         while($row=mysqli_fetch_array($result)){
			 $i++;  ?>
			 <tr>
				 <td><?php echo $i;?></td>
				 <td><?php echo $row['title'];?></td>
                  <td> <?php echo $row['message'];?> </td>
                 <td> <?php echo $row['service_type'];?> </td>
				 <td> <?php echo $row['date'];?> </td>
							 <td> <a href="javascript:void(0);" onClick="chkDelete(<?php echo $row["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	
						</tbody>
					  </table>
					</div>			
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/menu.php');?>
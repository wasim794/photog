<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) {	 
		$db=$conn->query("DELETE FROM `contact` WHERE id='".$_REQUEST['delete']."'");
		if($db){
		 unlink(PHOTOURL.$filename);
		header('location:contact-enquiry.php');	exit;
		}
	}
	
 include('includes/head.php');	 include('includes/header.php');?>
				<script> 
function chkDelete(ids,pid){
	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="contact-enquiry.php?id="+pid+"&delete="+ids;
	}
	else	{		return false;	}
}
</script>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Contact Enquiry</li>
            </ol>
<div class="agile-grids">	

				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Contact Enquiry</h2>
					    <table id="table">
						<thead>
						  <tr>
						  <th>#</th>
						  <th width="13%">Date</th>
							<th width="10%">Name</th>
							<th width="20%">Email</th>
							<th>Phone</th>
							<th>Subject</th>
							<th width="20%">Message</th>
							<th width="10%">Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM contact  order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++; ?>
						  <tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo date('d M,Y', strtotime($data['date']));?></td>
 						   <td><?php echo $data['name'];?></td>
						   <td><?php echo $data['email'];?></td>
						   <td><?php echo $data['phone'];?></td>
						   <td><?php echo $data['subject'];?></td>
						   <td><?php echo $data['message'];?></td>
					        
							<td align="center"><a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a>
							
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
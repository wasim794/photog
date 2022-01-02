<?php require_once 'common.php';
if (isset($_REQUEST['delete']) ){
$sql=$conn->query("select * FROM `approval` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['bpic'];
	$filename1 = $row['fpic'];	
    $filename2 = $row['cheque'];
		$db=$conn->query("DELETE FROM `approval` WHERE technician_id='".$_REQUEST['delete']."'");
		if($db){	
		 unlink(PHOTOURL.$filename); unlink(PHOTOURL.$filename1); unlink(PHOTOURL.$filename2);	
		header('location:technician-approval.php');	exit;
		}
	}		
include('includes/head.php');
include('includes/header.php');?>
<script>   
function chkDelete(ids,pid){
	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="technician-approval.php?id="+pid+"&delete="+ids;
	}
	else 	{
		return false;
	}
}
</script>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Technician Approval</li>
            </ol>
<div class="agile-grids">	
 				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Technician Approval</h2>
		<table id="table1" class="table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Profile</th>
							<th>Name</th>	
							<th>Contact No</th>
							<th>Id Proof</th>	
 							<th>Account No </th>
							<th>IFSC </th>
							<th> Date </th>	
							<th>Status</th>			
							<th width="15%">Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT technician.name, technician.phone, technician.ufile, technician.id, approval.type, approval.account, approval.ifsc, approval.adate, approval.status FROM technician inner join approval on technician.id=approval.technician_id  order by approval.id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			 if(!empty($data['ufile'])){$pic = PHOTOURL.$data['ufile'];}
			 else { $pic ='images/user.png'; }
			 ?>
				<tr> <td><?php echo $i;?></td>		
				<td><img src="<?php echo $pic;?>" style="width:100px; height:100px; border-radius:50%" ></td>
					 
					  <td><?php echo $data['name'];?></td>
					  <td><?php echo $data['phone'];?></td>	
					  <td><?php echo $data['type'];?></td>	
 				      <td><?php echo $data['account'];?></td>
					  <td><?php echo $data['ifsc'];?></td>
					  <td><?php echo date('d-m-Y', strtotime($data['adate']));?></td>
 				 <td><a href="#" style="text-decoration:none;"  class="<?= $data['status'];?>" ><?= $data['status'];?></a>
                 </td>	
							<td><a href="edit-approval.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>	
					</div>
 </div>
			</div>

<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
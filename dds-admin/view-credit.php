<?php require_once 'common.php';
if (isset($_REQUEST['delete'])) 	{
		$db_1=$conn->query("DELETE FROM `credit` WHERE id='".$_REQUEST['delete']."'");
		header('location:view-credit.php');	exit;
	}		

 include('includes/head.php');
 include('includes/header.php');?>
<script>
 function chkDelete(ids,pid){
 	if(confirm("Are you sure you want to delete Record(s)")){
		window.location.href="view-credit.php?id="+pid+"&delete="+ids;
	}
	else	{
		return false;
	}
} 
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Credit</li>
            </ol>
<div class="agile-grids">	
<a href="add-credit.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Credit</a>	
				<div class="agile-tables">
				 		
		
					<div class="w3l-table-info">
					  <h2>Credit Details</h2>
					    <table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Technician</th>	
 							<th>Type</th>		
							<th>Amount</th>
							<th>Particular</th>
							<th>Date</th>							
							<th width="20%">Action</th>
							
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT credit.id, credit.coin,credit.type, credit.reason ,credit.date, technician.name, technician.phone FROM credit INNER JOIN technician ON credit.tech_id = technician.id order by credit.id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;  ?>
			 <tr>
				 <td><?php echo $i;?></td>
				 <td><?php echo $data['name'];?> (<?php echo $data['phone'];?>)</td>
                  <td> <?php echo $data['type'];?> </td>
				 <td><?php echo str_replace('-','',$data['coin']);?></td>
                 <td> <?php echo $data['reason'];?> </td>
				 <td> <?php echo date('d M,Y', strtotime($data['date']));?> </td>
							<td><a href="add-credit.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
					<?php }?>	  
						</tbody>
					  </table>
					</div>			
				</div>
			</div>
<?php include('includes/footer.php');?>	
<?php include('includes/menu.php');?>
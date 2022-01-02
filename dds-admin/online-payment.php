<?php require_once 'common.php';
   if(isset($_REQUEST['id'])){		
		$db=$conn->query("UPDATE `booking` Set transfer='Yes' WHERE id='".$_REQUEST['id']."'");
		if($db){ header('location:online-payment.php');	exit; }
	}

 include('includes/head.php'); include('includes/header.php');?>
 <script>
  function chkTransfer(ids){  
  	if(confirm("Are you sure you want to transfer amount into Technician Account"))	{
		window.location.href="online-payment.php?id="+ids;	}
	else{	return false; }
	}
	
 </script>
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i> Online Payment</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong> Online Payment</strong> </h3>
					 
		        <table id="table1" class="table table-responsive">
					<thead>
					  <tr>
						  <th>#</th>
						  <th>Booking Date</th>
						  <th>Complaint No.</th>
						  <th>Technician</th>
						  <th>Customer</th>	
						  <th>Total</th>						 
 						  <th>Payment Status</th>
						  <th>TXN ID</th>
						  <th>Transfer Status</th>	
						  <th></th>							
						  </tr>
						</thead>
						<tbody>
																				  
				 <?php 
		$query = $conn->query("select emp_code,id,date,phone,name,discount,total,payment_status,payment_type,transfer from booking  where payment_type='Online' order by id desc");
			  $i=0;
              while($data=$query->fetch_array()){
                  $i++;
                   $emp_code = $data['emp_code'];
				   $lead_id = $data['id'];
				  				 
 				  $sql2=$conn->query("SELECT name,ufile FROM technician where id='$emp_code'");
                  $show=$sql2->fetch_array();
				   
                  if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}
			      else { $pic ='images/user.png'; }					   
			 ?> 
				<tr>
				  <td><?php echo $i;?></td>	
				  <td><?php echo date('d/M/Y',strtotime($data['date']));?></td>	
				  <td><?php echo $data['id'];?></td>
				  <td><?php if(!empty($show['name'])){?><div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  /> </div><br />
			         <?php echo $show['name']; }?>  </td>	
				   <td><?php echo $data['name'].' <br>('.$data['phone'].')';?></td>	  
				  <td><i class="fa fa-inr"></i> <?php if(empty($data['discount'])){echo $data['total'];}
				            else {echo $data['total']-$data['discount'];}?></td>
	  
				  <td><?php echo $data['payment_status'];?></td>
				 <td><?php echo $data['txn'];?></td>
				  <td>
				     <?php if($data['transfer']=='Yes'){ echo '<button type="button" class="btn btn-success">Yes</button>';}
					      else { ?>
	<a href="javascript:void(0);" onClick="chkTransfer(<?= $lead_id?>)" class="btn btn-danger"> Transfer  </a>
						  
						  <?php }?>
				  </td>
 				 <td><a href="lead-view.php?id=<?= $lead_id?>" class="btn btn-primary">View</a></td>
					  	  </tr>
					<?php } ?>	 						  
						</tbody>
					  </table>  
				  	  
						  
						
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
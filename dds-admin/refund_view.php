<?php require_once 'common.php'; 

$id = $_REQUEST['id'];
//$emp_code = '';
if(isset($_POST['btn-signup']))
{
    $amount=$_POST['amount'];
    $emp_code=$_POST['emp_code'];
    $q=$conn->query("UPDATE `booking` SET `refund_amt` = '$amount' WHERE `booking`.`id` = '$id'");
    	$query = "INSERT INTO credit(tech_id,coin,type,reason,lead_id) VALUES('$emp_code','$amount','Credit','Refund','$id')";
			$res = $conn->query($query);
    header('location:view-refund.php');
}
$query = $conn->query("select * from booking where id='$id'");
$data=$query->fetch_array();

    $remark = $data['remark'];
	$phone = $data['phone'];
	$status = $data['status'];
	$extra = $data['extra'];
	$eamount = $data['eamount'];
	$emp_code = $data['emp_code'];
	$userid = $data['userid'];	
	$total = $data['total'];
	$rtime = $data['rtime'];	
	$rdate = $data['rdate'];
	$type = $data['type'];
$discount = $data['discount'];
					$service = explode(',',$data['service']);
					$category = explode(',',$data['category']);
					$qty = explode(',',$data['qty']);
					$price = explode(',',$data['price']);
					$subtotal = explode(',',$data['subtotal']);
					$size = sizeof($service);
					
$sql1=$conn->query("SELECT name,phone FROM registration where id='$userid'");
$data1=$sql1->fetch_array();

$sql2=$conn->query("SELECT ufile,name,phone,city,state FROM technician where id='$emp_code'");
$show=$sql2->fetch_array();
 
 if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}else { $pic ='images/user.png'; }	
	
  include('includes/head.php');  include('includes/header.php');?>
 
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Refund  </li>
            </ol>
 	<div class="validation-system"> 		
 		<div class="validation-form">
  	 <div class="panel-default">
           <div class="panel-body">
		    <h3>Refund Info </h3>
			<table class=" table-responsive">
			<tr><td><strong>Registerd Phone : </strong></td><td> <?= $data1['phone'];?></td></tr>
			<tr><td><strong>Registerd Name : </strong></td><td> <?= $data1['name'];?></td></tr>
			<tr><td colspan="2">&nbsp; </td></tr>
			<tr><td><strong>Booking Name : </strong></td><td> <?= $data['name'];?></td></tr>
			<tr><td><strong>Booking Phone : </strong></td><td> <?= $data['phone'];?></td></tr>
			<tr><td><strong>Booking Email : </strong></td><td> <?= $data['email'];?></td></tr>
			<tr><td><strong>Address : </strong></td><td> <?= $data['address'];?>,
			<?= $data['city'];?>,<?= $data['pincode'];?></td></tr>
			<tr><td><strong>Location : </strong></td><td> <?= $data['location'];?></td></tr>
			<tr><td><strong>Booking Date: </strong></td><td> <?= date('d/M/Y', strtotime($data['date']));?></td></tr>
			<tr><td><strong>Time Slot : </strong></td><td> <?= $data['time'];?></td></tr>
			<?php if(!empty($rdate)){?>
			<tr><td><strong>Reschedule Date: </strong></td><td> <?= date('d/M/Y', strtotime($data['rdate']));?></td></tr>
			<tr><td><strong>Time Slot : </strong></td><td> <?= $data['rtime'];?></td></tr>
			<?php }?>
			<tr><td><strong>Status : </strong></td><td> <?= $data['status'];?></td></tr>
			<tr><td><strong>Job Status : </strong></td><td> <?= $data['status1'];?></td></tr>
			<tr><td><strong>Remark : </strong></td><td> <?= $data['remark'];?></td></tr>
			<tr><td><strong>Professional : </strong></td><td>
			<?php if(!empty($show['name'])){?>
			<div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  />
            </div>
			 <?= $show['name'];?> &nbsp;<br />
			 <i class="fa fa-phone"></i> <?= $show['phone'];?>  &nbsp;<br />
			 <i class="fa fa-map-marker"></i> <?= $show['city'];?>,<?= $show['state'];?>
			 <?php }?>
			 </td></tr>
			 <tr><td><strong>Credit : </strong></td><td> <?= $data['credit'];?></td></tr>
			 
			 <?php $psql = $conn->query("select date,time from part where lead_id= '$id'");
			       if($psql->num_rows>0){
				   $prow = $psql->fetch_array();
				   ?>
			 <tr><td><strong>Part Delivery Date & Time : </strong></td>
			 <td> <?= date('d/M/Y', strtotime($prow['date'])).'  and '.$prow['time'];?></td></tr>
			 <?php }?>
			 
			  <?php if(!empty($data['payment_type'])){  ?>
			 <tr><td><strong>Payment Mode : </strong></td><td>
			 <button type="button" class="btn btn-<?php if($data['payment_type']=='Cash'){ echo 'success';} else{echo 'warning';}?>"><?= $data['payment_type'];?></button></td></tr>
			 <tr><td><strong>Payment Status : </strong></td><td><?= $data['payment_status'];?></td></tr>
			 <?php }?>
			<tr><td><strong>Refund Amount : </strong></td><td> <?= $data['refund_amt'];?></td></tr>
				<tr><td><strong>Complaint No. </strong></td><td> <?= $data['id'];?></td></tr>
			
 			</table>
			
			<table class=" table-responsive">
			<thead>
			<tr><th>S.no</th><th>Service</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
</thead>
			<tbody>
				<?php $i=1;for($z=0;$z<$size;$z++){ if(!empty($service[$z])){?>
			<tr>
			<td><?= $i++;?></td>
			<td><?= $service[$z];?> <?php if(!empty($category[$z])  && trim($service[$z])=='Repair'){
			 echo '('.pack_child($category[$z],$conn).')'; }?></td>
			<td> <?= $qty[$z];?></td>
			<td> <i class="fa fa-inr"></i> <?= $price[$z];?></td>
			<td> <i class="fa fa-inr"></i> <?= $subtotal[$z];?></td>
			</tr>
			<?php }} if(!empty($eamount)){ $total = $total + $eamount;?>
			<tr>
			<td><?= $z;?></td>
			<td><?= $extra;?> (Extra Service)</td>
			<td> 1</td>
			<td> <i class="fa fa-inr"></i> <?= $eamount;?></td>
			<td> <i class="fa fa-inr"></i> <?= $eamount;?></td>
			</tr>			
						
						<?php }?>
						<tr><td colspan="4" style="text-align:right"><strong>Total</strong></td><td>
						 <?php if($total>0){ echo number_format($total,2); }?> </td></tr>
						 <?php if($discount>0){?>
						 <tr><td colspan="4" style="text-align:right"><strong>Discount</strong></td><td>
						 <?php  echo number_format($discount,2);?> </td></tr>
						 <tr><td colspan="4" style="text-align:right"><strong>Grand Total</strong></td><td>
						 <?php echo number_format(($total-$discount),2); ?> </td></tr>
						 <?php }?>
			</tbody>			
			</table>
			<div class="validation-form">
   <?php if ( isset($errMSG) ) { ?>
   <div class="form-group">
      <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
         <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
      </div>
   </div>
   <?php } ?>			
   <form action="" autocomplete="off" method="post">
      <div class="vali-form">
      </div>
      <div class="vali-form">
         <div class="col-md-6 form-group1">
            <label class="control-label">Refund Amount</label>
            <input type="text" name="amount" value=""/>	
            <input type="hidden" name="emp_code" value="<?php echo $emp_code;?>">
            <span class="text-danger"><?php echo $coinError; ?></span>
         </div>
         <div class="clearfix"> </div>
         <div class="col-md-6 form-group1">
             <button type="submit" class="btn btn-primary"  name="btn-signup"><i class="fa fa-save"></i> Save</button>
         </div>
         <div class="clearfix"> </div>
      </div>
      <div class="vali-form">
         
   </form>
   </div>
</div>
		   </div>
		   </div>
		       
 
 </div>
</div>

<?php include('includes/footer.php');?>
<?php include('includes/menu.php');?>
<?php require_once 'common.php'; 

$id = $_REQUEST['id'];
$query = $conn->query("select * from booking where id='$id'");
$data=$query->fetch_array();

    $remark = $data['remark'];
	$phone = $data['phone'];
	$status = $data['status'];
    $emp_code = $data['emp_code'];
	$userid = $data['userid'];
	$extra = $data['extra'];
	$eamount = $data['eamount'];	
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
	
	$error = false;
  if (isset($_POST['save'])) {
     $id = trim($_POST['id']);
	$status = trim($_POST['status']);
	$ostatus = trim($_POST['ostatus']);
	$emp_code = trim($_POST['emp_code']);
	$emp = trim($_POST['emp']);	 
	$remark = trim($_POST['remark']);
	$rdate = trim($_POST['rdate']);
	$rtime = trim($_POST['rtime']);
	$type = trim($_POST['type']);
	$discount = trim($_POST['discount']);
		
	$sql2=$conn->query("SELECT name FROM technician where id='$emp_code'");
    $show=$sql2->fetch_array();
 	$tname= $show['name'];
	 if(isset($_POST["service"])){
	$result =$_POST["service"];
	$s1 = sizeof($result); 
	$service='';
	 for($k=0;$k<$s1;$k++){  $rr = strtok($result[$k],'-(');
 	  $service = $service.','.$rr;}  } else{ $service =''; }
	 if(isset($_POST["category"])){ $category = ','.implode(",", $_POST["category"]);  } else{ $category =''; }
	 if(isset($_POST["qty"])){ $qty = ','.implode(",", $_POST["qty"]);  } else{ $qty =''; }
	 if(isset($_POST["price"])){ $price = ','.implode(",", $_POST["price"]);  } else{ $price =''; }
	  
	  $s = explode(',',$service);
	  $size = sizeof($s);
	  
	  	if(!empty($price)){
			$q = explode(',',$qty);
			$p = explode(',',$price);			
			$size1 = sizeof($q);
			 $subtotal=''; $total=0;
			   for($i=1;$i<$size1;$i++){
			     $ss = $q[$i]*$p[$i];
			     $subtotal = $subtotal.','.$ss;
			     $total = $total + $ss;				
			    }
			}
			else {$subtotal=''; $total='';}
	  
		 
	if(!$error) {
		$query="UPDATE booking SET
			status='$status',
			emp_code='$emp_code',
			category='$category',
			service='$service',
			price='$price',
			qty='$qty',
			subtotal='$subtotal',
			total='$total',
			discount='$discount',
			rdate='$rdate',
			rtime='$rtime',
			remark ='$remark'
			WHERE id='$id' limit 1 ";	
					
			 $res = $conn->query($query);
			
			if ($res) {		
			   if(!empty($emp_code)){
			    $res2 = $conn->query("UPDATE lead SET status='1' WHERE tech_id='$emp_code' and lead_id ='$id' limit 1");
                $res1  = $conn->query("UPDATE lead SET status='3' WHERE tech_id!='$emp_code' and lead_id ='$id'");
               
                $sql   = $conn->query("SELECT tech_id from lead WHERE tech_id!='$emp_code' and lead_id ='$id'");
                while($row= $sql->fetch_array()){
                $tt = $row['tech_id'];
                 $post = array('title'=>'Lead Notification','message'=>'Lead Accepted By Other','login_id'=>$tt);
                    $ch = curl_init('https://delhidailyservice.com/api/sendSinglePush.php');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_ENCODING,"");
                    header('Content-Type: text/html');
                    $data = curl_exec($ch);
                }
			   }
			   if($status=='Cancel'){
			       $res1  = $conn->query("DELETE from lead  WHERE  lead_id ='$id'");
			   }
			    
			if($ostatus !=$status){
			if(empty($emp)){ $message='Welcome To DDS..  Your Booking No. '.$id.' is '.$status.' and '.$tname.' will be handle your service requirement. Our helpline number is 9821221877 Thanks!';}
			else {
			$message='Welcome To DDS..  Your Booking No. '.$id.' is '.$status.' Our helpline number is 9821221877. Give us a feedback https://www.delhidailyservice.com/service-provider.php?review="2"&emp_code='.$emp_code.'&service='.$service.'&pack_child='.$category.'';
			}

$url = 'https://sms.textmysms.com/app/smsapi/index.php?key=25EEF2E867C120&campaign=0&routeid=13&type=text&contacts='.$phone.'&senderid=DDSRVC&msg='.urlencode($message);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'));
 $resp = curl_exec($curl);
curl_close($curl);
			
			}	
			 header('location:booking-edit.php?id='.$id); 
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}		
		}
	}
 include('includes/head.php');  include('includes/header.php');?>
 <style>
 #mode{
 display:none
 }
 .form-control {
 min-width:140px;
     
 }
 </style>
 <script type="text/javascript">
$(document).ready(function() {    
	$("#status").change(function() {		 
		 var status = $("#status").val();
		if(status=='Reschedule'){
		$("#mode").css("display", "block"); }	 
		else {$("#mode").css("display", "none"); }
     });
});
</script> 
<script>
function add_field(){
  var total_text=document.getElementsByClassName("input_text");
  total_text=total_text.length+1;
  document.getElementById("field_div").innerHTML=document.getElementById("field_div").innerHTML+
  "<div id='input_text"+total_text+"_wrapper' class='row row-space-20'><input type='text' class='input_text' id='input_text"+total_text+"' placeholder='Enter Text'><input type='button' value='Remove' onclick=remove_field('input_text"+total_text+"');></div>";
}
function remove_field(id){ 
  document.getElementById(id+"_wrapper").innerHTML="";
}
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Booking </li>
            </ol>
 	<div class="validation-system"> 		
 		<div class="validation-form">
  	 <div class="panel-default">
           <div class="panel-body">
		    <h3>Booking Info</h3>
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
			</table>
			
			<table class=" table-responsive">
			<thead>
			<tr><th>S.no</th><th>Service</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
</thead>
			<tbody>
				<?php $i=1;for($z=0;$z<$size;$z++){ if(!empty($service[$z])){?>
			<tr>
			<td><?= $i++;?></td>
			<td><?= $service[$z];?> <?php if(!empty($category[$z])){
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
						 <tr><td colspan="4" style="text-align:right"><strong>Discount</strong></td><td>
						 <?php if($discount>0){ echo number_format($discount,2); }?> </td></tr>
						 <tr><td colspan="4" style="text-align:right"><strong>Grand Total</strong></td><td>
						 <?php if($total>0){ echo number_format(($total-$discount),2); }?> </td></tr>
						 
			</tbody>			
			</table>
			
		   </div>
		   </div>
		<div class="panel-default">
           <div class="panel-body">
		    <h3>Edit Booking</h3>
 	       <?php if (isset($errMSG)) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">	
			<div class="row row-space-20">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="table-responsive">
         <table id="autocomplete_table" class="table table-bordered table-hover autocomplete_table">
             <thead class="thead-light">
                <tr>
                   <th scope="col">#</th>
                   <th scope="col">Service</th>
                    <th scope="col">Qty</th>
                   <th scope="col">Unit Price</th>
				   <th scope="col">  </th>
				   </tr>
            </thead>
            <tbody>
  
							<?php   
							for($j=0;$j<$size;$j++){ if(!empty($service[$j])){
							 if(!empty($category[$j])){
			$cat= ' -('.pack_child($category[$j],$conn).')'; } else {$cat ='-';}
							?>
							
							
  <tr id="row_<?= $j;?>">
   <td id="delete_<?= $j;?>" scope="row" class="delete_row"><img src="src/images/minus.svg" style="cursor:pointer">
   </td>
  
   <td>  <input type="text" data-type="service" name="service[]" id="service_<?= $j;?>" value="<?= $service[$j].$cat;?>" class="form-control autocomplete_txt" autocomplete="off"> </td>
        
	 <td> <input type="text" data-type="qty" name="qty[]" id="qty_<?= $j;?>" value="<?= $qty[$j];?>" class=" form-control" autocomplete="off" ></td>
	 
	  <td> <input type="text" data-type="price" name="price[]" id="price_<?= $j;?>" value="<?= $price[$j];?>" class="form-control"  autocomplete="off"></td>
	 
	  <td> <input type="hidden" data-type="category" name="category[]" id="category_<?= $j;?>" value="<?= $category[$j];?>" class="form-control"  autocomplete="off"></td>

                            </tr>	
							<?php }} ?>
						

                        </tbody>
                    </table>
					
                </div>  
                <div class="btn-container">  <a class="btn btn-success" id="addNew"> Add New </a>   </div>  
            </div>
		
</div>	
	<div class="vali-form">
 <div class="col-md-6 form-group1">
 <label class="control-label"> Discount </label>
<input type="text" name="discount" value="<?= $discount;?>" />
</div>

 <div class="clearfix"> </div>
 </div>
	
	
	
<div class="vali-form">
 <div class="col-md-6 form-group2">
 <label class="control-label"> Status </label>
<select name="status" id="status">
<option value="Request" <?php if($status=='Request'){ echo 'selected="selected"';}?>>Request</option>
<option value="Response" <?php if($status=='Response'){ echo 'selected="selected"';}?>>Response</option>
<option value="Reschedule" <?php if($status=='Reschedule'){ echo 'selected="selected"';}?>>Reschedule</option>
<option value="Processing" <?php if($status=='Processing'){ echo 'selected="selected"';}?>>Processing</option>
<option value="Pending" <?php if($status=='Pending'){ echo 'selected="selected"';}?>>Pending</option>
<option value="Complete" <?php if($status=='Complete'){ echo 'selected="selected"';}?>>Complete</option>
<option value="Cancel" <?php if($status=='Cancel'){ echo 'selected="selected"';}?>>Cancel</option>
</select>
</div>
<div class="col-md-6 form-group2">
 <label class="control-label"> Professional </label>
<select name="emp_code">
<option value="">Assign Technician</option>
<?php $query1 = $conn->query("select * from technician");
while($row=$query1->fetch_array()){
    $service = explode(',',$data['service']);
	$service1 = explode(',',$row['service']);
	$services = array_map('trim', $service1);
	

?>
<option value="<?php echo $row['id']?>" <?php if($row['id']==$emp_code){ echo 'selected="selected"';}?>><?php echo $row['name']?>, <?php echo $row['city']?></option>
<?php   }?>
</select>
</div>
 <div class="clearfix"> </div>
 </div>
<div class="vali-form" id="mode">
 <div class="col-md-6 form-group1">
 <label class="control-label">Reschedule Date </label>
<input type="text" name="rdate" value="<?= $rdate;?>" id="datepicker1"/>
</div>
<div class="col-md-6 form-group2">
 <label class="control-label">Reschedule Time </label>
<select name="rtime">
 <option value="10:00 To 11:00 AM" <?php if($rtime=='10:00 To 11:00 AM'){ echo 'selected="selected"';}?>>
 10:00 To 11:00 AM</option>     
 <option value="11:00 To 12:00 AM" <?php if($rtime=='11:00 To 12:00 AM'){ echo 'selected="selected"';}?>>11:00 To 12:00 AM </option>    
 <option value="12:00 To 1:00 PM" <?php if($rtime=='12:00 To 1:00 PM'){ echo 'selected="selected"';}?>>12:00 To 1:00 PM</option>  
 <option value="1:00 To 2:00 PM" <?php if($rtime=='1:00 To 2:00 PM'){ echo 'selected="selected"';}?>>1:00 To 2:00 PM</option>
 <option value="2:00 To 3:00 PM" <?php if($rtime=='2:00 To 3:00 PM'){ echo 'selected="selected"';}?>>2:00 To 3:00 PM </option>  
 <option value="3:00 To 4:00 PM" <?php if($rtime=='3:00 To 4:00 PM'){ echo 'selected="selected"';}?>>3:00 To 4:00 PM</option>   
 <option value="4:00 To 5:00 PM" <?php if($rtime=='4:00 To 5:00 PM'){ echo 'selected="selected"';}?>>4:00 To 5:00 PM </option>    
 <option value="5:00 To 6:00 PM" <?php if($rtime=='5:00 To 6:00 PM'){ echo 'selected="selected"';}?>>5:00 To 6:00 PM </option>   
 <option value="6:00 To 7:00 PM" <?php if($rtime=='6:00 To 7:00 PM'){ echo 'selected="selected"';}?>>6:00 To 7:00 PM</option>    
 <option value="7:00 To 8:00 PM" <?php if($rtime=='1:00 To 8:00 PM'){ echo 'selected="selected"';}?>>7:00 To 8:00 PM</option>
</select>
</div>
 <div class="clearfix"> </div>
 </div>
																						
 

  <div class="vali-form">
 <div class="col-md-12 form-group2">
 <label class="control-label"> Remark </label>
 <textarea class="form-control" cols="40" id="pitch_message" name="remark" rows="10"><?php echo $remark;?></textarea>
</div>

 <div class="clearfix"> </div>

 </div>	
 	
<div class="col-md-12 form-group button-2">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="ostatus" value="<?php echo $status;?>">
<input type="hidden" name="emp" value="<?php echo $emp_code;?>">
<input type="hidden" name="phone" value="<?php echo $phone;?>">
<input type="hidden" name="type" value="<?php echo $type;?>">
<button type="submit" class="btn btn-primary" name="save">Save</button>
</div>
<div class="clearfix"> </div>
</form>

 </div>
</div>       
 
 </div>
</div>
 <script src="src/js/app.js"></script>
<?php include('includes/footer.php');?>
<?php include('includes/menu.php');?>
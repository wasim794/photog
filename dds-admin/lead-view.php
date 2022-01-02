<?php require_once 'common.php'; 

$id = $_REQUEST['id'];
$query = $conn->query("select * from booking where id='$id' order by id Asc limit 1");
$data=$query->fetch_array();
    $remark = $data['remark'];
	$phone = $data['phone'];
	$name = $data['name'];
	$address = $data['address'];
	$city = $data['city'];
	$status = $data['status'];
	$extra = $data['extra'];
	$eamount = $data['eamount'];
	$emp_code = $data['emp_code'];
	$userid = $data['userid'];
	$service = $data['service'];	
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


$sql2=$conn->query("SELECT id,ufile,name,phone,city,state,phone FROM technician where phone='$phone' order by phone desc limit 1");
$show=$sql2->fetch_array();
//echo "SELECT id,ufile,name,phone,city,state,phone FROM technician where phone='$phone' order by phone desc limit 1";
$send_id = $show['id'];
 $complain=$conn->query("SELECT lead_id,tech_id,c_date,c_time,status FROM re_complain where lead_id='".$_GET['id']."' order by id desc limit 1");
$Cdata=$complain->fetch_array();


 if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];}else { $pic ='images/user.png'; }	
 
 

			   if(isset($_POST['submit']) and isset($_POST['id']))
			    {
$c_date=$_POST['date'];
$c_time=$_POST['time'];
$url = $_POST['id'];
$emp_code_check=$send_id;
//367;


			        $post = array('title'=>'Recomplaint Lead Notification','message'=>'You Get A Recomplaint Lead','login_id'=>$emp_code_check);
			        print_r($post);
			        // exit();
                    $ch = curl_init('https://delhidailyservice.com/api/sendSinglePush.php');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_ENCODING,"");
                    header('Content-Type: text/html');
                    $data = curl_exec($ch);
					print_r($data);
					//exit();
                    $query = "INSERT INTO re_complain(lead_id,tech_id,c_date,c_time,status)VALUES('$id','$emp_code','$c_date','$c_time','0')";
			        $res = $conn->query($query);
			         echo $queryb = "INSERT INTO `booking`(name, emp_code, address, city,  rtime, rdate, service, status) VALUES ('$name', '$emp_code', '$address', '$city', '$c_time', '$c_date', '$service', 'Recomplaint')";
			        $resb = $conn->query($queryb);
			      exit();
			      header("Location: lead-view.php?id=".$url."");
			    }
			    
	
  include('includes/head.php');  include('includes/header.php');?>
 
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Lead  </li>
            </ol>
 	<div class="validation-system"> 		
 		<div class="validation-form">
  	 <div class="panel-default">
           <div class="panel-body">
               
		    <h3>Lead Info </h3>
		    
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
			<tr><th>S.no</th><th>Service</th> <th>Brnadname</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
</thead>
			<tbody>
				<?php $i=1;for($z=0;$z<$size;$z++){ if(!empty($service[$z])){?>
			<tr>
			<td><?= $i++;?></td>
			<td><?= $service[$z];?> <?php if(!empty($category[$z])  && trim($service[$z])=='Repair'){
			 echo '('.pack_child($category[$z],$conn).')'; }?></td>
			 <td> <?= $data['brandname'];?></td>
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

			
				

			<script>
                $(document).ready(function(){
                    $("#Recomplaintdiv").hide();
                  $("#Recomplaint").click(function(){
                     $("#Recomplaintdiv").toggle();
                  });

                });
                </script>

                <?php if($Cdata==0){?>
               
			     <div id="Recomplaintdiv">
			    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
    			    <div class="row row-space-20">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="ilable1"><strong>Date</strong></label>
        						<input type="text" name="date" value="<?= $date; ?>" class=" form-control" id="date">
        						<span class="text-danger"><?php echo $dateError; ?></span>
        					</div>
    				    </div>
    				    <div class="col-md-6">
        					<div class="form-group">
        						<label for="title" class="ilable1"><strong>Time</strong></label>
        						<select name="time" class=" form-control" id="time">
    							    <option value="">--Select--</option>
        						</select>
        						<span class="text-danger" id="text" style="display:none;">No time slot is available for booking</span>
                             </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                        <input type="submit" id="c_save" class="btn btn-info" name="submit" value="save" >
    			    </div>
			    </form>
			 <?php }else{ } ?>
			
			

			    
			</div>
		   </div>
		   </div>
		       
<?php $complain=$conn->query("SELECT lead_id,tech_id,c_date,c_time,status FROM re_complain where lead_id='".$_GET['id']."' order by id desc");
while($Cdata=$complain->fetch_array()){ ?>

<?php if($Cdata==0){  } else{ ?>
<!-- second tab start here -->
<div class="panel-default">
           <div class="panel-body">
 <h3><strong>Recomplain </strong></h3>
		    
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
			<tr><td><strong>Complain Date: </strong></td><td> <?= date('d/M/Y', strtotime($Cdata['c_date']));?></td></tr>
			<tr><td><strong>Complain time : </strong></td><td> <?= $Cdata['c_time'];?></td></tr>
			
			<tr><td><strong>Status : </strong></td><td> <?php if($Cdata['status']=="0"){?>
 <?php echo 'Process';} else{ ?>
 	<? echo 'Complete';?>
			<?php } ?></td></tr>
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
			 <?php } ?>
			 </td></tr>
			
			</table>


			 

			     
       </div>


       <!-- end here -->
      

 
 </div>



 <?php } } ?>
 
  <!-- start here button -->
<div class="panel-default">
           <div class="panel-body">
           	 <div class="row">
			        <button class="btn btn-danger pull-right" id="Recomplaint">Recomplaint</button>
			     </div>
           </div>
       </div>

 <!-- end  here -->
</div>
<script>
	$(document).ready(function() {
		$(function() {
			$("#date").datepicker({
				minDate: new Date(),
				dateFormat: "yy/mm/dd"
			});
		});
		$("#date").change(function() {
			$('#time').empty();
// 			alert($("#date").val());
			var d = new Date($("#date").val());
			var dt = new Date();
// 			alert(d);
			var time = dt.getHours();
// 			alert(time);
			var r = 19 - time;
			// var r = 6;
			var arr = ["09:00 To 10:00 AM", "10:00 To 11:00 AM", "11:00 To 12:00 PM",
				"12:00 To 1:00 PM", "1:00 To 2:00 PM", "2:00 To 3:00 PM", "3:00 To 4:00 PM",
				"4:00 To 5:00 PM", "5:00 To 6:00 PM", "6:00 To 7:00 PM", "7:00 To 8:00 PM"
			];
			var t;
			if (d > dt) {
				$("#time").append("<option value=''>--Select--</option>");
				for (var i = 0; i < 11; ++i) {
					$("#time").append("<option value=" + arr[i] + ">" + arr[i] + "</option>");
				}
				$("#text").hide();
			} else {
				if (r > 0) {
					if (r >= 11) {
						t = 0;
					} else {
						t = 11 - r;
					}
					$("#time").append("<option value=''>--Select--</option>");
					for (var i = t; i < 11; ++i) {
						$("#time").append("<option value=" + arr[i] + ">" + arr[i] + "</option>");
					}
					$("#text").hide();
				} else {
					$("#text").show();
				}
			}
		});
	});
</script>
 <script src="src/js/app.js"></script>
<?php include('includes/footer.php');?>
<?php include('includes/menu.php');?>
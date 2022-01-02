<?php require_once 'common.php'; 
date_default_timezone_set('Asia/Calcutta');
function credit($id,$price,$conn){
  $sql = $conn->query("select credit,type  from package where id='$id'");
  $row  = $sql->fetch_array();
  if($row['type']=='Percentage'){  $credit = $price*$row['credit']/1000;}
  else {$credit = $row['credit'];}
  return $credit;
 }
 
 function sub($id,$conn){
    $sql2 = $conn->query("select child from package where id='$id'");
    $view = $sql2->fetch_array();
	$child = $view['child'];
	
	$sql = $conn->query("select sub from child where id='$child'");
    $row = $sql->fetch_array();
	$sub = SubCategory($row['sub'],$conn);
    return $sub;
 }
	function location($place,$l){
 $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$place."&sensor=false&key=AIzaSyBcQ6g445mNn36hHmfWHA2ZUvLLyOoJ64k";

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $details_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $geoloc = json_decode(curl_exec($ch), true);

   $step1 = $geoloc['results'];
   $step2 = $step1['geometry'];
   $coords = $step2['location'];
   $lat= $geoloc['results'][0]['geometry']['location']['lat'];
   $lon= $geoloc['results'][0]['geometry']['location']['lng'];
   if($l=='lat'){return $lat; }
   else{return $lon; }
 }
$name='';
$phone ='';
$email ='';
$city='';
$address='';
$pincode='';
$location='';
$date='';
$time='';
$qty='';
$brandname='';
$service='';
$category='';
$size=0;
$price='';
$id='';

$nameError='';
$phoneError='';
$locError ='';
$cityError ='';
$dateError='';
$timeError='';
$addError='';
$serviceError ='';

if(isset($_REQUEST['id'])){$id = $_REQUEST['id'];}

	$error = false;
if (isset($_POST['save']) && empty($_POST['id']) ) {

    $name = trim($_POST['name']);
	$phone = trim($_POST['phone']);
	$email = trim($_POST['email']);
	$city = trim($_POST['city']);
	$address = trim($_POST['address']);
	$pincode = trim($_POST['pincode']);
	$location = trim($_POST['location']);
	$date = trim($_POST['date']);
	$time = trim($_POST['time']);
	$status = 'Request';
	
	 if(isset($_POST["service"])){
	  $result =$_POST["service"];
	   $s1 = sizeof($result); 
	   for($k=0;$k<$s1;$k++){
	   $rr = strtok($result[$k],'-(');
 	  $service = $service.','.$rr;}  } else{ $service =''; }
	 if(isset($_POST["category"])){ $category = ','.implode(", ", $_POST["category"]);  } else{ $category =''; }
	 if(isset($_POST["qty"])){ $qty = ','.implode(", ", $_POST["qty"]);  } else{ $qty =''; }
	 if(isset($_POST["price"])){ $price = ','.implode(", ", $_POST["price"]);  } else{ $price =''; }
	  if(isset($_POST["brandname"])){ $brandname = ','.implode(", ", $_POST["brandname"]);  } else{ $brandname =''; }
	 

      $lead_service = explode(',',$service);
	  $size = sizeof($lead_service);
 	   
	    
		if(empty($city)){ $error = true; $cityError = "Please Select city.";} 
		if(empty($name)){ $error = true; $nameError = "Please Enter name.";} 
		 
		if(empty($phone)){ $error = true; $phoneError = "Please enter phone no.";	}
		
		if(empty($address)){$error = true; $addError = "Please enter address.";	}
		
		if(empty($location)) {$error = true; $locError = "Please enter location.";	}
		
		if(empty($service)){ $error = true;	$serviceError = "Please select service.";}
		if(empty($date)){ $error = true;	$dateError = "Please select date.";}
			if(empty($time)){ $error = true;	$timeError = "Please select time.";}
			
		if(!$error) {
			$result = $conn->query("SELECT id FROM registration WHERE  phone='$phone'");
            $count = $result->num_rows;
	  
			if($count==0){ $query = "INSERT INTO registration(name, phone, email, city, address, status) VALUES('$name', '$phone', '$email','$city', '$address', '1')";
			 $res = $conn->query($query);
			 $userid = $conn->insert_id;}
			 else{ $row= $result->fetch_array();      $userid = $row['id'];}
				   
			if(!empty($price)){
			   $q = explode(',',$qty);
			   $p = explode(',',$price);
			   $cat = explode(',',$category);
			   
			   $size1 = sizeof($q);
			   
			   $credit =0;$subtotal=''; $total=0;
			   for($i=1;$i<$size1;$i++){
			    $sub = $q[$i]*$p[$i];
			    $subtotal = $subtotal.','.$sub;
			    $total = $total + $sub;				
				$credit = $credit + $q[$i]*credit($cat[$i],$p[$i],$conn);
			   }
			}
			else {$subtotal=''; $total='';}
				   
 			$query = "INSERT INTO booking(userid, name, email, phone, address, city, pincode, location, date, time, category, service, price, qty, brandname, subtotal, total, status, type, credit) VALUES('$userid', '$name', '$email', '$phone', '$address', '$city', '$pincode', '$location', '$date', '$time', '$category', '$service', '$price', '$qty', '$brandname', '$subtotal', '$total', '$status', 'offline','$credit')";
			$res = $conn->query($query);
			$lead_id = $conn->insert_id;
			
           $place =  str_replace(' ','%20',$address).'%20'. str_replace(' ','%20',$city);
           $lat= location($place,'lat'); 
           $lon= location($place,'lon');
		   $ser1 = explode(',',$category);  
           $num = sizeof($ser1);
		   
		    $query1 = $conn->query("select technician.id, technician.name, technician.phone, technician.state, technician.city, technician.address, technician.service , technician.distance from technician inner join approval on technician.id=approval.technician_id where technician.status='1' and approval.status='Approved'  order by technician.id asc");
 while($data = $query1->fetch_array()){ 
    echo $tech_id = $data['id'];
    $state = $data['state'];
	$city = $data['city'];
	$address = $data['address'];
	$service1 = explode(',',$data['service']);
	$services = array_map('trim', $service1);
	$tech_distance = $data['distance'];
 	 
    $tplace=   str_replace(' ','%20',$address).'%20'. str_replace(' ','%20',$city). str_replace(' ','%20',$state);
   exit();
   $s = '';
	for($i=0;$i<=$num;$i++){  
	    if(!empty($ser1[$i])){ $s=trim($ser1[$i]);
		   $sub = sub($s,$conn);  
		     if(in_array($sub,$services)){ 
	            $tlat= location($tplace,'lat'); 
	            $tlon= location($tplace,'lon');
	            $url ='https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$lat.','.$lon.'&destinations='.$tlat.','.$tlon.'&key=AIzaSyBcQ6g445mNn36hHmfWHA2ZUvLLyOoJ64k';
 
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $geoloc = json_decode(curl_exec($ch), true);
                $distance = str_replace('mi','',$geoloc['rows'][0]['elements'][0]['distance']['text']);
                 $distance = trim($distance);
                 if($distance<=$tech_distance){  
                   
                    $post = array('title'=>'Lead Notification','message'=>'You Get A New Lead','login_id'=>$tech_id);
                    $ch = curl_init('https://delhidailyservice.com/api/sendSinglePush.php');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_ENCODING,"");
                    header('Content-Type: text/html');
                    $data = curl_exec($ch);
                    
                    $query = "INSERT INTO lead(lead_id,tech_id,status)VALUES('$lead_id','$tech_id','0')";
			        $res = mysql_query($query);
                 }
	            break;
	        }
	    }
	}
 }	
			if ($res) { header('location:view-lead.php');	 }
			else {	$errTyp = "danger";	$errMSG = "Something went wrong, try again later...";
				echo mysqli_error($conn);		die;	
			}		
		}
	}
	 
 include('includes/head.php');  include('includes/header.php');?>
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
 <script type="text/javascript">
$(document).ready(function() {    
	$("#datepicker1").change(function() {
	$(this).after('<div id="loader"></div>');
		$.get('loadtime.php?date=' + $(this).val(), function(data) {
			$("#time").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
});
</script> 
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Lead </li>
            </ol>
 	<div class="validation-system"> 		
 		<div class="validation-form">
  	            <?php if (isset($errMSG)) {?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>				
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">

<div class="row row-space-20">
		<div class="col-md-4">
<div class="form-group">
<label for="title" class="ilable1"><strong> Name </strong></label>
<input type="text" name="name" value="<?= $name;?>" class=" form-control">
<span class="text-danger"><?php echo $nameError; ?></span>
</div>
</div>
	
	<div class="col-md-4">
<div class="form-group">
<label for="title" class="ilable1"><strong> Contact No </strong></label>
<input type="text" name="phone" value="<?= $phone;?>" class=" form-control" onkeyup="checkInput(this);">
<span class="text-danger"><?php echo $phoneError; ?></span>
</div>
</div>	

<div class="col-md-4">
<div class="form-group">
<label for="title" class="ilable1"><strong> Email </strong></label>
<input type="text" name="email" value="<?= $email;?>" class=" form-control">
</div>
</div>
</div>
 
<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Address</strong></label>
<input type="text" name="address" value="<?= $address;?>" class=" form-control">
<span class="text-danger"><?php echo $addError; ?></span>
</div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Landmark </strong></label>
<input type="text" name="pincode" value="<?= $pincode;?>" class=" form-control">
 </div>
</div>	
</div>

<div class="row row-space-20">
<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>City</strong></label>
<input type="text" name="city" value="<?= $city;?>" class=" form-control">
<span class="text-danger"><?php echo $cityError; ?></span>
 </div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label for="Description" class="ilable1"><strong>Location</strong> </label><p style="margin-top:7px">
<input type="radio" name="location" value="Home" <?php if($location=='Home'){echo 'checked="checked"';}?> <?php if($location==''){echo 'checked="checked"';}?>> Home &nbsp; &nbsp; &nbsp; &nbsp; 
<input type="radio" name="location" value="Office" <?php if($location=='Office'){echo 'checked="checked"';}?>> Office &nbsp; &nbsp; &nbsp; &nbsp; 
<input type="radio" name="location" value="Other" <?php if($location=='Other'){echo 'checked="checked"';}?>> Other &nbsp;</p>
<span class="text-danger"><?php echo $locError; ?></span>	   
	   </div>
</div>
</div>
 

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

						<?php
						// $time = date('h:i A');
						// $time = date('h:i A', strtotime('+1 hour')); // syntax OK
						// echo '<script>console.log("' . $time . '");</script>';
						// $zone = date('A', strtotime($time));
						// echo '<script>console.log("' . $zone . '");</script>';
						// $hour = date('h', strtotime($time));
						// echo '<script>console.log("' . $hour . '");</script>';
						?>
						<select name="time" class=" form-control" id="time">
							<option value="">--Select--</option>
							<?php
							// if ($zone == 'PM') {
							// 	if ($hour >= 20) {
							// 		$timeError = 'No time slot is available for booking';
							// 	} else {
							// 		if ($hour == '12') {
							// 			$hour = 0;
							// 		}
							// 		for ($i = $hour + 1; $i <= 7; $i++) {
							// 			$k = $i + 1;
							// 			// echo '<option value="'.$i.':00 To '.$k.':00 PM">'.$i.':00 To '.$k.':00 PM</option>';
							// 		}
							// 	}
							// } else {
							// 	$dd = 	'<option value="12:00 To 1:00 PM">12:00 To 1:00 PM</option>  
							// <option value="1:00 To 2:00 PM">1:00 To 2:00 PM</option>
							// <option value="2:00 To 3:00 PM">2:00 To 3:00 PM </option>  
							// <option value="3:00 To 4:00 PM">3:00 To 4:00 PM</option>   
							// <option value="4:00 To 5:00 PM">4:00 To 5:00 PM </option>    
							// <option value="5:00 To 6:00 PM">5:00 To 6:00 PM </option>   
							// <option value="6:00 To 7:00 PM">6:00 To 7:00 PM</option>    
							// <option value="7:00 To 8:00 PM">7:00 To 8:00 PM</option> ';

							// if($hour=='10'){
							//     echo '<option value="11:00 To 12:00 AM">11:00 To 12:00 PM </option>'.$dd;
							//    }
							// else if($hour==9){echo '<option value="10:00 To 11:00 AM">10:00 To 11:00 AM</option>     
							// 		<option value="11:00 To 12:00 AM">11:00 To 12:00 AM </option>'.$dd; }
							//  else if($hour<9){echo '<option value="09:00 To 10:00 AM">09:00 To 10:00 AM</option><option value="10:00 To 11:00 AM">10:00 To 11:00 AM</option>     
							// 		<option value="11:00 To 12:00 AM">11:00 To 12:00 AM </option>'.$dd; }   

							// }
							?>
						</select>
						<!--<span class="text-danger"><?php echo $timeError; ?></span>-->
						<span class="text-danger" id="text" style="display:none;">No time slot is available for booking</span>
 </div>
</div>	
</div>
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
                     <th scope="col">Brandname</th>
				   <th scope="col">  </th>
				   </tr>
            </thead>
            <tbody>
  
							<?php   if($size>0){
							for($j=1;$j<$size;$j++){ 
							 $q = explode(',',$qty);
			                 $p = explode(',',$price);
			                  $b = explode(',',$brandname);
							 $s = explode(',',$service);
							 $c = explode(',',$category);
							?>
  <tr id="row_<?= $j;?>">
   <td id="delete_<?= $j;?>" scope="row" class="delete_row"><img src="src/images/minus.svg" style="cursor:pointer">
   </td>
  
   <td>  <input type="text" data-type="service" name="service[]" id="service_<?= $j;?>" value="<?= $s[$j];?>" class="form-control autocomplete_txt" autocomplete="off"> </td>
        
	 <td> <input type="text" data-type="qty" name="qty[]" id="qty_<?= $j;?>" value="<?= $q[$j];?>" class=" form-control" autocomplete="off" ></td>
	 
	  <td> <input type="text" data-type="price" name="price[]" id="price_<?= $j;?>" value="<?= $p[$j];?>" class="form-control"  autocomplete="off"></td>
	  <td><input type="text" data-type="brandname" name="brandname[]" id="brandname_<?= $j;?>" class="form-control" value="<?= $b[$j];?>" autocomplete="off"></td>
	 
	  <td> <input type="hidden" data-type="category" name="category[]" id="category_<?= $j;?>" value="<?= $c[$j];?>" class="form-control"  autocomplete="off"></td>

                            </tr>	
							<?php }} else {?>
							<tr id="row_1">
    <td id="delete_1" scope="row" class="delete_row"><img src="src/images/minus.svg"></td>
    <td> <input type="text" data-type="service" name="service[]" id="service_1" class="form-control autocomplete_txt" autocomplete="off"> </td>
		 
	 <td> <input type="text" data-type="qty" name="qty[]" id="qty_1" class="form-control" autocomplete="off"></td>
      
  <td><input type="text" data-type="price" name="price[]" id="price_1" class="form-control"></td>
  <td><input type="text" data-type="brandname" name="brandname[]" id="brandname_1" class="form-control"></td>
<td><input type="hidden" data-type="category" name="category[]" id="category_1" class="form-control"></td>

  
   
                            </tr>
							<?php }?>
                        </tbody>
                    </table>
					<div style="margin-bottom: 12px;color: red; font-size: 15px;" id="stock"> <?=$serviceError;?></div>
                </div>  
                <div class="btn-container">  <a class="btn btn-success" id="addNew"> Add New </a>   </div>  
            </div>
		
</div>


<div class="row row-space-20">
<div class="col-lg-12">
<input type="hidden" name="id" value="<?= $id;?>">
<input type="submit" class="btn btn-info" name="save" value=" Save">
</div>
</div>
</form>   
 
 </div>
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
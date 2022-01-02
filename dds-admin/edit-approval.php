 <style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}
#myImg1 {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg1:hover {opacity: 0.7;}
#myImg2 {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg2:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
 <?php require_once 'common.php'; 
 
$nameError='';
$typeError='';
$stateError ='';
$cityError ='';
$genderError='';
$pinError='';
$accError='';

if(isset($_REQUEST['id'])){
$id = $_REQUEST['id'];

$query1 = $conn->query("select * from technician where id='$id'");
$data1=$query1->fetch_array();
 	$address = $data1['address'];	
	$ccity = $data1['city'];
	$cstate = $data1['state'];	
	$cpincode = $data1['pincode'];


$query = $conn->query("select * from approval where technician_id='$id'");
$data=$query->fetch_array();
    
	$type = $data['type'];
	$bpic = $data['bpic'];
	$fpic = $data['fpic'];
	$id_no = $data['id_no'];
	
    $name = $data['name'];	
	$licence = $data['licence'];
	$gender = $data['gender'];
	$dob = $data['dob'];
	$fname = $data['fname'];
	$house = $data['house'];
	$street = $data['street'];	
	$city = $data['city'];
	$state = $data['state'];	
	$pincode = $data['pincode'];
	
	$bname = $data['bname'];
	$account = $data['account'];
	$ifsc = $data['ifsc'];
	$cheque = $data['cheque'];
	
	$status = $data['status'];
	
}
     $targetDir = "uploads/";
	 $allowTypes = array('jpg','png','jpeg','gif');
 	 $error = false;
 
	if (isset($_POST['save']) && !empty($_POST['id'])) {
     $id = trim($_POST['id']);
	 @extract($_REQUEST);
     		
	 	  
		if (empty($state)) {$error = true;	$stateError = "Please Select state.";} 		 
		if (empty($city)) {	$error = true;$cityError = "Please Select city.";	} 		
		if (empty($name)) {	$error = true;	$nameError = "Please Enter name.";} 		
		if (empty($type)) {	$error = true;	$typeError = "Please select id proof type.";	}
		if (empty($account)) {$error = true;$accError = "Please enter account no.";	}
 		if (empty($pincode)) {$error = true;$pinError = "Please enter pincode.";}
		 
			
	if(!$error) {
		if(!empty($_FILES['bpic']['name'])){
           $bpic = uniqid('Img_').$_FILES['bpic']['name'];
           $temp_path1 = $_FILES['bpic']['tmp_name'];
	
			$sql=$conn->query("select bpic FROM `approval` WHERE technician_id='$id'");
	        $row = $sql->fetch_array();
	        $filename = $row['bpic'];
	        unlink(PHOTOURL.$filename);			
			
			move_uploaded_file($temp_path1,PHOTOURL.$bpic);
			$query2="UPDATE approval SET bpic='$bpic' WHERE technician_id='$id' limit 1 ";
			$res2 = $conn->query($query2);
		}
		if(!empty($_FILES['fpic']['name'])){
		    $fpic = uniqid('Img_').$_FILES['fpic']['name'];
            $temp_path2 = $_FILES['fpic']['tmp_name'];
	 
			$sql=$conn->query("select fpic FROM `approval` WHERE technician_id='$id'");
	        $row = $sql->fetch_array();
	        $filename1 = $row['fpic'];
	        unlink(PHOTOURL.$filename1);			
			
			move_uploaded_file($temp_path2,PHOTOURL.$fpic);
			$query2="UPDATE approval SET fpic='$fpic' WHERE technician_id='$id' limit 1 ";
			$res2 = $conn->query($query2);
		}
		if(!empty($_FILES['cheque']['name'])){
		    $cheque = uniqid('Img_').$_FILES['cheque']['name'];
            $temp_path3 = $_FILES['cheque']['tmp_name']; 	 
			$sql=$conn->query("select cheque FROM `approval` WHERE technician_id='$id'");
	        $row = $sql->fetch_array();
	        $filename2 = $row['cheque'];
	        unlink(PHOTOURL.$filename2);			
			
			move_uploaded_file($temp_path3,PHOTOURL.$cheque);
			$query2="UPDATE approval SET cheque='$cheque' WHERE technician_id='$id' limit 1 ";
			$res2 = $conn->query($query2);
		}
			$query1="UPDATE technician SET			 
			state ='$cstate',
			city = '$ccity',
			address='$address',
			pincode='$cpincode' 
			WHERE id='$id' limit 1 ";						
			 $res1 = $conn->query($query1);
			
			$query="UPDATE approval SET			 
			type ='$type',
			id_no = '$id_no',
			name='$name',
			licence ='$licence',
			gender = '$gender',
			dob='$dob',
			fname ='$fname',
			house = '$house',
			street='$street',
			pincode ='$pincode',
			city = '$city',
			state='$state',
			bname='$bname',
			account ='$account',
			ifsc = '$ifsc',
			status='$status' 
			WHERE technician_id='$id' limit 1 ";						
			$res = $conn->query($query); 
 			 
			   if($res) {echo "<script>window.location.href='technician-approval.php';</script>"; }
			   else {$errTyp = "danger";$errMSG = "Something went wrong, try again later...";}		
		}
	}
 include('includes/head.php');  include('includes/header.php');?>
 
<script type="text/javascript">
$(document).ready(function() {    
	$("#state").change(function() {
	$(this).after('<div id="loader"></div>');
		$.get('loadcity.php?state=' + $(this).val(), function(data) {
			$("#city").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
});
</script> 
<script type="text/javascript">
$(document).ready(function() {    
	$("#cstate").change(function() {
	$(this).after('<div id="loader"></div>');
		$.get('loadcity.php?state=' + $(this).val(), function(data) {
			$("#ccity").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
});
</script> 
<style>
h3{padding:10px; font-size:18px;color: #4CAF50;    text-transform: uppercase;}
</style> 
 
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Edit Technician Approval  </li> </ol>
 	<div class="validation-system"> 		
 		<div class="validation-form">
  	            <?php if (isset($errMSG)) {?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>				
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
<h3><strong>Identification</strong></h3>
<div class="row row-space-20">

		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Type</strong></label>
<select class="form-control"  name="type">
  <option  value="">-- Select Any One --</option>
  <option value="Pancard" <?php if($type=='Pancard'){ echo 'selected="selected"';}?>>Pancard</option>
  <option value="Aadhar Card" <?php if($type=='Aadhar Card'){ echo 'selected="selected"';}?>>Aadhar Card</option>
 <option value="Driving Licence" <?php if($type=='Driving Licence'){ echo 'selected="selected"';}?>> Driving Licence</option>
  <option value="Voter Card" <?php if($type=='Voter Card'){ echo 'selected="selected"';}?>>Voter Card</option>
</select>
<span class="text-danger"><?php echo $typeError; ?></span>
</div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Id No. </strong></label>
<input type="text" name="id_no" value="<?= $id_no;?>" class=" form-control">
 </div>
</div>	
</div>

<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="company" class="ilable1"><strong>Front Image</strong></label>
<input type="file" name="fpic">
 <?php if(!empty($fpic)){?><br><img src="uploads/<?= $fpic;?>" style="width:150px; height:100px;" id="myImg">&emsp;<a href="uploads/<?= $fpic;?>" download="proposed_file_name"><i class="fa fa-download" aria-hidden="true " style="color:green"></i></a>&nbsp;<a title="Image Rotate" href="imagerotate.php?filename=<?= $fpic;?>" target="_blank"><i class="fa fa-refresh" aria-hidden="true " style="color:blue"></i></a><?php }?>
</div>
</div>
	<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
	<div class="col-md-6">
<div class="form-group">
<label for="company" class="ilable1"><strong>Back Image</strong></label>
<input type="file" name="bpic">
 <?php if(!empty($bpic)){?><br> <img src="uploads/<?= $bpic;?>" style="width:150px; height:100px;" id="myImg1">&emsp;<a href="uploads/<?= $bpic;?>" download="proposed_file_name"><i class="fa fa-download" aria-hidden="true " style="color:green"></i></a>&nbsp;<a title="Image Rotate" href="imagerotate.php?filename=<?= $bpic;?>" target="_blank"><i class="fa fa-refresh" aria-hidden="true " style="color:blue"></i></a>  <?php }?>
</div>
</div>
	<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg1");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
</div>
<hr />
<h3><strong>Personal Info</strong></h3>
<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>   Name </strong></label>
<input type="text" name="name" value="<?= $name;?>" class=" form-control">
<span class="text-danger"><?php echo $nameError; ?></span>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Licence No.</strong></label>
<input type="text" name="licence" value="<?= $licence;?>" class=" form-control">
 </div>
</div>
		
</div>


<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>   Gender </strong></label>
<select class="form-control"  name="gender">
  <option  value="">-- Select Any One --</option>
  <option value="Male" <?php if($gender=='Male'){ echo 'selected="selected"';}?>>Male</option>
  <option value="Female" <?php if($gender=='Female'){ echo 'selected="selected"';}?>>Female</option>
</select><span class="text-danger"><?php echo $genderError; ?></span>
</div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Date Of Birth</strong></label>
<input type="text" name="dob" value="<?= $dob;?>" id="datepicker1" class=" form-control">
 </div>
</div>	
</div>


<div class="row row-space-20">
 	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Father's Name</strong></label>
<input type="text" name="fname" value="<?= $fname;?>"   class=" form-control">
 </div>
</div>	
<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>House No</strong></label>
<input type="text" name="house" value="<?= $house;?>"   class=" form-control">
 </div>
</div>
</div>
<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Street</strong></label>
<input type="text" name="street" value="<?= $street;?>" class=" form-control">
 </div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Pincode </strong></label>
<input type="text" name="pincode" value="<?= $pincode;?>" class=" form-control">
 </div>
</div>	
</div>

<div class="row row-space-20">
<div class="col-md-6">
<div class="form-group">
<label for="Industry" class="ilable1"><strong>State </strong></label>
<select name="state" class="form-control"  id="state">
	<option value="">Select Any One</option>	
<?php  $sql1 = "select * from state order by states asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){
				  $states= $row['states'];
 				  ?>
			 	 <option value="<?php echo $states;?>" <?php if($state==$states){ echo 'selected="selected"';}?>>
				 <?php echo $states;?> </option>
			  <?php  }?> 
</select>
 </div>
</div>

<div class="col-md-6">
<div class="form-group">
<label for="Industry" class="ilable1"> <strong>City</strong></label>
<select name="city" class="form-control" id="city">
<?php if(empty($city)){ ?>
			 	 <option value="">Select Any One </option>
				 <?php } else {?>
				 <option value="<?php echo $city;?>"><?php echo $city;?> </option>
			  <?php  }?>
</select>
 </div>
</div>

</div>
<hr />
<h3><strong>Current Address</strong></h3>
<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Address</strong></label>
<input type="text" name="address" value="<?= $address;?>" class=" form-control">
 </div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Pincode </strong></label>
<input type="text" name="cpincode" value="<?= $cpincode;?>" class=" form-control">
 </div>
</div>	
</div>
<div class="row row-space-20">
 <div class="col-md-6">
<div class="form-group">
<label for="Industry" class="ilable1"><strong>State </strong></label>
<select name="cstate" class="form-control"  id="cstate">
	<option value="">Select Any One</option>	
<?php  $sql1 = "select * from state order by states asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){
				  $states= $row['states'];
 				  ?>
			 	 <option value="<?php echo $states;?>" <?php if($cstate==$states){ echo 'selected="selected"';}?>>
				 <?php echo $states;?> </option>
			  <?php  }?> 
</select>
<span class="text-danger"><?php echo $stateError; ?></span>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="Industry" class="ilable1"> <strong>City</strong></label>
<select name="ccity" class="form-control" id="ccity">
<?php if(empty($ccity)){ ?>
			 	 <option value="">Select Any One </option>
				 <?php } else {?>
				 <option value="<?php echo $ccity;?>"><?php echo $ccity;?> </option>
			  <?php  }?>
</select>
<span class="text-danger"><?php echo $cityError; ?></span>
</div>
</div>
</div>

<hr />
 <h3><strong>Bank Details</strong></h3>
 
 
 <div class="row row-space-20">
 	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Account Holder Name</strong></label>
<input type="text" name="bname" value="<?= $bname;?>"   class=" form-control">
 </div>
</div>	
<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Account No</strong></label>
<input type="text" name="account" value="<?= $account;?>"   class=" form-control">
<span class="text-danger"><?php echo $accError; ?></span>
 </div>
</div>
</div>
 
 <div class="row row-space-20">
 	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Ifsc</strong></label>
<input type="text" name="ifsc" value="<?= $ifsc;?>"   class=" form-control">
 </div>
</div>	
<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Cancel Cheque</strong></label>
<input type="file" name="cheque">
 <?php if(!empty($cheque)){?><br><img src="uploads/<?= $cheque;?>" style="width:150px; height:100px;" id="myImg2">&emsp;<a href="uploads/<?= $cheque;?>" download="proposed_file_name"><i class="fa fa-download" aria-hidden="true " style="color:green"></i></a>&nbsp;<a title="Image Rotate" href="imagerotate.php?filename=<?= $cheque;?>" target="_blank"><i class="fa fa-refresh" aria-hidden="true " style="color:blue"></i></a><?php }?> </div>
</div>
	<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg2");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
</div>
 <hr />
 <div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>   Status </strong></label>
<select class="form-control"  name="status">
   <option value="Pending" <?php if($status=='Pending'){ echo 'selected="selected"';}?>>Pending</option>
    <option value="Disapproved" <?php if($status=='Disapproved'){ echo 'selected="selected"';}?>>Disapproved</option>
  <option value="Approved" <?php if($status=='Approved'){ echo 'selected="selected"';}?>>Approved</option>
  </select>
 </div>
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

<?php include('includes/footer.php');?>
<?php include('includes/menu.php');?>
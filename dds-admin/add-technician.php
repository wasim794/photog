<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

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
  max-width: 500px;
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
if (isset($_REQUEST['delete'])){
$id =$_REQUEST['id'];
$sql=$conn->query("select * FROM `images2` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['file_name'];	 
		$db=$conn->query("DELETE FROM `images2` WHERE id='".$_REQUEST['delete']."'");
		if($db){ unlink(PHOTOURL.$filename);}
	}
	
$name='';
$last='';
$phone ='';
$phone1 ='';
$email ='';
$pancard='';
$state='';
$city='';
$address='';
$pincode='';
$ufile='';
$status='';
$service='';
$about='';
$id='';
$distance='';

$nameError='';
$phoneError='';
$stateError ='';
$cityError ='';
$panError='';
$pinError='';
$addError='';
$serviceError ='';

if(isset($_REQUEST['id'])){
$id = $_REQUEST['id'];
$query = $conn->query("select * from technician where id='$id'");
$data=$query->fetch_array();

    $name = $data['name'];
	$last = $data['last'];
	$phone = $data['phone'];
	$phone1 = $data['phone1'];
	$email = $data['email'];
	$pancard = $data['pancard'];
	$country='India';
	$state = $data['state'];	
	$city = $data['city'];
	$address = $data['address'];
	$pincode = $data['pincode'];
	$about = $data['about'];
	$status = $data['status'];
	$ufile = $data['ufile'];
	$service = $data['service'];
	$distance = $data['distance'];
}
 $targetDir = "uploads/";
	 $allowTypes = array('jpg','png','jpeg','gif');
	
	$error = false;
if (isset($_POST['save']) && empty($_POST['id']) ) {

    $name = trim($_POST['name']);
	$last = trim($_POST['last']);
	$phone = trim($_POST['phone']);
	$phone1 = trim($_POST['phone1']);
	$email = trim($_POST['email']);
	$pancard = trim($_POST['pancard']);
	$country='India';
	$state = trim($_POST['state']);
	$city = trim($_POST['city']);
	$address = trim($_POST['address']);
	$pincode = trim($_POST['pincode']);
	$about = trim($_POST['about']);
	$distance = trim($_POST['distance']);
	 if(isset($_POST["service"])){ $service = implode(", ", $_POST["service"]);  }
	  else{ $service =''; }
	
	$status = 1;
	$date = date('d-m-Y');
	
	    $_name1 =$_FILES['ufile']['name'];
        $ufile=$_name1;
        $temp_path1=$_FILES['ufile']['tmp_name'];
       
// start

if($_FILES['ufile']['type']=='image/jpeg'){
		$source=imagecreatefromjpeg($temp_path1);
		$file_name=time().'.jpg';
		imagejpeg($source,'uploads/'.$file_name,30);
	}elseif($_FILES['ufile']['type']=='image/png'){
		$source=imagecreatefrompng($temp_path1);
		$file_name=time().'.png';
		imagepng($source,'uploads/'.$file_name,30);
	}elseif($_FILES['ufile']['type']=='image/gif'){
		$source=imagecreatefromgif($temp_path1);
		$file_name=time().'.gif';
		imagegif($source,'uploads/'.$file_name,30);
	}else{
		echo "Please select only jpg, png and gif image";
	}

 //end 


        $file_type1=$_FILES['ufile']['type'];
		
	    if(empty($_name1)){$ufile='';}
	
	  $result = $conn->query("SELECT id FROM technician WHERE  phone='$phone'");
      $count = $result->num_rows;
	  
		if (empty($state)) {
			$error = true;
			$cstateError = "Please Select state.";
		} 
		 
		if (empty($city)) {
			$error = true;
			$cityError = "Please Select city.";
		} 
		if (empty($name)) {
			$error = true;
			$nameError = "Please Enter name.";
		} 
		if (empty($last)) {
			$error = true;
			$lastError = "Please enter last name.";
		}
		if (empty($phone)) {
			$error = true;
			$phoneError = "Please enter phone no.";
		}
		else if($count>0){
		$error = true;
			$phoneError = "Please enter another phone no.";
		}
		if (empty($pancard)) {
			$error = true;
			$panError = "Please enter pan no.";
		}
		if (empty($address)) {
			$error = true;
			$addError = "Please enter address.";
		}
		if (empty($pincode)) {
			$error = true;
			$pinError = "Please enter pincode.";
		}
		if (empty($service)) {
			$error = true;
			$serviceError = "Please select service.";
		}
			
			if(!$error) {
			move_uploaded_file($file_name,PHOTOURL.$ufile);
			$query = "INSERT INTO technician(name, last, phone, phone1, email, pancard, country, state, city, address, pincode, ufile, about, status, service,distance, date) VALUES('$name', '$last', '$phone', '$phone1', '$email', '$pancard', '$country', '$state', '$city', '$address', '$pincode',  '$file_name', '$about', '$status', '$service', '$distance','$date')";
			 $res = $conn->query($query);
			 $t_id = $conn->insert_id;
			
	 if(!empty(array_filter($_FILES['files']['name']))){          
		  foreach($_FILES['files']['name'] as $key=>$val){
             $fileName = basename($_FILES['files']['name'][$key]);
             $targetFilePath = $targetDir . $fileName;
             $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
             
			 if(in_array($fileType, $allowTypes)){
                 if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
              $insert = $conn->query("INSERT INTO images2(file_name, t_id) VALUES('$fileName','$t_id')");
                } 
            } 
        }
      }			
			
			if ($res) {			
		       header('location:view-technician.php');	
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
				echo mysqli_error($conn);
				die;	
			}		
		}
		
	}
	if (isset($_POST['save']) && !empty($_POST['id'])) {

    $name = trim($_POST['name']);
	$last = trim($_POST['last']);
	$phone = trim($_POST['phone']);
	$phone1 = trim($_POST['phone1']);
	$email = trim($_POST['email']);
	$pancard = trim($_POST['pancard']);
	$country='India';
	$state = trim($_POST['state']);
	$city = trim($_POST['city']);
	$address = trim($_POST['address']);
	$pincode = trim($_POST['pincode']);
	$about = trim($_POST['about']);
	$distance = trim($_POST['distance']);
	
	$id = trim($_POST['id']);
	 if(isset($_POST["service"])){ $service = implode(", ", $_POST["service"]);  }
	  else{ $service =''; }
	
	
	    $_name1 =$_FILES['ufile']['name'];
        $ufile=$_name1;
        $temp_path1=$_FILES['ufile']['tmp_name'];
        $file_type1=$_FILES['ufile']['type'];
	 		
	  $result = $conn->query("SELECT id FROM technician WHERE  phone='$phone' and id!='$id'");
      $count = $result->num_rows;
	  
		if (empty($state)) {
			$error = true;
			$cstateError = "Please Select state.";
		} 
		 
		if (empty($city)) {
			$error = true;
			$cityError = "Please Select city.";
		} 
		if (empty($name)) {
			$error = true;
			$nameError = "Please Enter name.";
		} 
		if (empty($last)) {
			$error = true;
			$lastError = "Please enter last name.";
		}
		if (empty($phone)) {
			$error = true;
			$phoneError = "Please enter phone no.";
		}
		else if($count>0){
		$error = true;
			$phoneError = "Please enter another phone no.";
		}
		if (empty($pancard)) {
			$error = true;
			$panError = "Please enter pan no.";
		}
		if (empty($address)) {
			$error = true;
			$addError = "Please enter address.";
		}
		if (empty($pincode)) {
			$error = true;
			$pinError = "Please enter pincode.";
		}
		if (empty($service)) {
			$error = true;
			$serviceError = "Please select service.";
		}
			
			
	if(!$error) {
		if(!empty($_name1)){
			$sql=$conn->query("select ufile FROM `technician` WHERE id='$id'");
	        $row = $sql->fetch_array();
	        $filename = $row['ufile'];
	        unlink(PHOTOURL.$filename);			
			
			move_uploaded_file($temp_path1,PHOTOURL.$ufile);
			$query2="UPDATE technician SET ufile='$ufile' WHERE id='$id' limit 1 ";
			$res2 = $conn->query($query2);
		}
			$query="UPDATE technician SET
			name='$name',
			last='$last',
			phone='$phone',
			phone1='$phone1',
			email='$email',
			pancard='$pancard',
		 	about='$about',
			state ='$state',
			city = '$city',
			address='$address',
			pincode='$pincode',
			service = '$service',
			distance = '$distance'
			WHERE id='$id' limit 1 ";						
			 $res = $conn->query($query);
			 
			  if(!empty(array_filter($_FILES['files']['name']))){          
		  foreach($_FILES['files']['name'] as $key=>$val){
             $fileName = basename($_FILES['files']['name'][$key]);
             $targetFilePath = $targetDir . $fileName;
             $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
             
			 if(in_array($fileType, $allowTypes)){
                 if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                     $insert = $conn->query("INSERT INTO images2(file_name, t_id) VALUES('$fileName','$id')");
                } 
            } 
        }
      } 
			
			if ($res) {			
		       header('location:view-technician.php');	
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}		
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
<style>
ul.options li {
    background: #def url(images/cross_bright.png) no-repeat 98% center;
    margin: 1px 5px 5px;
    padding: 0.1em 0.4em;
    cursor: pointer;
        font-weight: 600;
    border: solid 1px #cde;
    float: left;
    width: 31%;
    font-size: 15px;
	    list-style: none;
}
</style> 

<script>
function selectService(select)
{
  var option = select.options[select.selectedIndex];
  var ul = select.parentNode.getElementsByTagName('ul')[0];
     
  var choices = ul.getElementsByTagName('input');
  for (var i = 0; i < choices.length; i++)
    if (choices[i].value == option.value)
      return;
     
  var li = document.createElement('li');
  var input = document.createElement('input');
  var text = document.createTextNode(option.firstChild.data);
     
  input.type = 'hidden';
  input.name = 'service[]';
  input.value = option.value;

  li.appendChild(input);
  li.appendChild(text);
  li.setAttribute('onclick', 'this.parentNode.removeChild(this);');     
    
  ul.appendChild(li);
}
 </script>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="css/choosen.js"></script>
 
 <script>
function chkDelete(id,pid){
	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="add-technician.php?id="+id+"&delete="+pid;
	}
	else {return false;}
}
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Technician/ Service Provider </li>
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
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> First Name </strong></label>
<input type="text" name="name" value="<?= $name;?>" class=" form-control">
<span class="text-danger"><?php echo $nameError; ?></span>
</div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong>Last Name </strong></label>
<input type="text" name="last" value="<?= $last;?>" class=" form-control">
 </div>
</div>	
</div>

<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> PAN No. </strong></label>
<input type="text" name="pancard" value="<?= $pancard;?>" class=" form-control">
<span class="text-danger"><?php echo $panError; ?></span>
</div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Contact No </strong></label>
<input type="text" name="phone" value="<?= $phone;?>" class=" form-control">
<span class="text-danger"><?php echo $phoneError; ?></span>
</div>
</div>	
</div>
<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Email </strong></label>
<input type="text" name="email" value="<?= $email;?>" class=" form-control">
</div>
</div>
	
	<div class="col-md-6">
<div class="form-group">
<label for="company" class="ilable1"><strong>Profile Pic</strong></label>
<input type="file" name="ufile">
	   <?php if(!empty($ufile)){?><br>
			 <!--<img src="uploads/<?= $ufile;?>" style="width:100px; height:100px; border-radius:50%" id="myImg"><a href="uploads/<?= $ufile;?>" download="proposed_file_name"><i class="fa fa-download" aria-hidden="true " style="color:green"></i></a>-->
			 <img src="uploads/<?php echo $ufile."?_=".time(); ?>" style="width:100px; height:100px; border-radius:50%" id="myImg">&nbsp;<a href="uploads/<?= $ufile; ?>" download="proposed_file_name"><i class="fa fa-download" aria-hidden="true " style="color:green"></i></a>&nbsp;<a title="Image Rotate" href="imagerotate.php?filename=<?php echo $ufile; ?>" target="_blank"><i class="fa fa-refresh" aria-hidden="true " style="color:blue"></i></a>
			 <?php }?>
</div>
</div>	
<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close" style="color:#fff;">&times;</span>
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
<span class="text-danger"><?php echo $stateError; ?></span>
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
<span class="text-danger"><?php echo $cityError; ?></span>
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
<label for="title" class="ilable1"><strong>Pincode </strong></label>
<input type="text" name="pincode" value="<?= $pincode;?>" class=" form-control">
 </div>
</div>	
</div>

<div class="row row-space-20">
<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Alternate Contact No </strong></label>
<input type="text" name="phone1" value="<?= $phone1;?>" class=" form-control">
 </div>
</div>
</div>
<div class="row row-space-20">
<div class="col-lg-12">
<div class="form-group">
<label for="Description" class="ilable1"><strong>About Service Provider</strong> </label>
<textarea name="about"  class="form-control ckeditor" rows="5"  cols="40" id="pitch_message"><?= $about;?></textarea>
</div>
</div>
</div>

<div class="row row-space-20">
 	<div class="col-md-12">
<div class="form-group">
<label for="company" class="ilable1"><strong>Work Profile Multi Image upload</strong></label>
<input type="file" name="files[]" multiple >
	   <?php 
  $sql1=$conn->query("select * FROM images2 WHERE t_id='$id'");
	while($row1 = $sql1->fetch_array()){
	$filename1 = $row1['file_name'];  
	?><div class="col-md-3">
			 <a href="javascript:void(0);" onClick="chkDelete(<?php echo $id;?>,<?php echo $row1["id"];?>)" ><img src="images/cross_bright.png" /></a>
			 <img src="uploads/<?= $filename1 ;?>"  style="width:100%"></div>
			 <?php }?>
</div>
</div>	
</div>
<div class="row row-space-20">
		<div class="col-md-12">
<div class="form-group">
<label for="title" class="ilable1"><strong> Service </strong></label>
<ul class="options">
    <?php
	if(!empty($service)){
	 $service = explode(',',$service); $count1 = sizeof($service);
	
	for($j=0;$j<$count1;$j++){ 	?>
	<?php if($service[$j] != ''){ ?>
	<li onClick="this.parentNode.removeChild(this);">
    <input type="hidden" name="service[]" value="<?php echo trim($service[$j]);?>">
    <?php } ?>
	<?php echo trim($service[$j]);?></li>
	 <?php }}?>  
   </ul>
   
	<select class="form-control" onChange="selectService(this);">
<option style="font-weight:600">-- Select Multiple Service --</option>
<?php  $sql1 = "select sub from subcategory order by sub asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){
					  ?>
	<option value="<?php echo $row['sub'];?>" <?php if($service==$row['sub']){ echo 'selected="selected"';}?>>
				 <?php echo $row['sub'];?> </option>
			  <?php  }?> 

	</select>
	
<span class="text-danger"><?php echo $serviceError; ?></span>
</div>
</div>
</div>
<div class="row row-space-20">
<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Distance (1 KM = 1000 M)</strong></label>
<select name="distance" class="form-control">
			 	 <option value="">Select Any One </option>
				 <?php for ($k=10;$k<=100;){$k= $k+5;?>
				 <option value="<?php echo $k;?>" <?php if($k==$distance){echo 'selected="selected"';}?>><?php echo $k;?> KM </option>
			  <?php  }?>
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
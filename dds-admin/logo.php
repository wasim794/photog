<?php require_once 'common.php'; 
 $id='1';
 
  $sql1 = "select * from logo where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$ufile=$row['ufile'];
				$phone=$row['phone'];
				$email=$row['email'];
				$address=$row['address'];
						
$error = false;
	if (isset($_POST['btn-signup'])) {
	
	    $phone = trim($_POST['phone']);
		$email = trim($_POST['email']);
		$address = trim($_POST['address']);
		
		$_name=$_FILES['image']['name'];
        $ufile=$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 

			
		if( !$error ) {
		 if($_name!="")
           {		   
		   $sql=$conn->query("select * FROM `logo` WHERE id='$id'");
	       $row = $sql->fetch_array();
	       $filename = $row['ufile'];
		   unlink(PHOTOURL.$filename);
		   
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query="UPDATE logo SET ufile='$ufile' WHERE id='$id' limit 1 ";
			$res = $conn->query($query);
			}
			
			$query1="UPDATE logo SET
			phone='$phone',
			email='$email',
			address='$address'
			WHERE id='$id' limit 1 ";		
			$res1 = $conn->query($query1);
			
				
			if ($res1) {
				$errTyp = "success";
				$errMSG = "Successfully Updated...";
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
?>

<?php include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Company Profile</li> </ol>
 	<div class="validation-system">
 		<div class="validation-form">
 	      <?php if ( isset($errMSG) ) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="fa fa-info"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">	
         	
			
             <div class="vali-form">
            <div class="col-md-12 form-group2">
              <label class="control-label">Logo Upload </label>
             <input type="file" name="image">
			 <?php if(!empty($ufile)){?><br>
			 <img src="<?= PHOTOURL.$ufile;?>" style="width:15%">
			 <?php }?>
            </div>
            <div class="clearfix"> </div>
            </div>  
			
			<div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Primary Contact No.</label>
              <input type="text" placeholder="Primary Contact No." name="phone" value="<?php echo $phone; ?>">
            </div>
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Email Id</label>
              <input type="text" placeholder="Email Id" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="clearfix"> </div>
            </div>
           
               <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Address</label>
            <textarea   name="address" rows="5"><?php echo $address;?></textarea>
            </div>
           
            <div class="clearfix"> </div>
            </div>  
			
			<div class="vali-form">
            <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary"  name="btn-signup">Update</button>
            </div>
           <div class="clearfix"> </div>
            </div>
        </form>
    
 </div>
</div>
<?php include('includes/footer.php');?>
<?php include('includes/sidebar.php');?>
					
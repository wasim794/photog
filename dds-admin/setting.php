<?php require_once 'common.php'; 
	$id=$_SESSION['user'];
	$passError ='';
	$rpassError = '';
	$userPass = '';
	$userRpass = '';
	$error = false;
	if (isset($_POST['btn-signup']) ) {
		$userPass = trim($_POST['userPass']);
		$userRpass = trim($_POST['userRpass']);
		
		if (empty($userPass)) {
			$error = true;
			$passError = "Please enter your password";
		}
else if(strlen($userPass) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}
		if (empty($userRpass)) {
			$error = true;
			$rpassError = "Please enter your confirm password";
		}
else if($userRpass != $userPass ) {
			$error = true;
			$rpassError = "Password and confirm password did not match";
		}
	$password = hash('sha256', $userPass);
		if( !$error ) {
			$query="UPDATE users SET
			userPass='$password',
			pass='$userPass'
			WHERE userId='$id' limit 1 ";
			$res = $conn->query($query);
				
			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully change password ";
				
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
	
include('includes/head.php');
include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i> Admin Account</li>
            </ol>
 	<div class="validation-system">
 		<div class="validation-form">
         <?php if ( isset($errMSG) ) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>		 
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">	
              <div class="vali-form vali-form1">
            <div class="col-md-6 form-group1">
              <label class="control-label">Create a password </label>
            <input type="password" placeholder="Create a password" name="userPass" value="<?php echo $userPass; ?>">
            <span class="text-danger"><?php echo $passError; ?></span>
			</div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Repeated password</label>
           <input type="password" placeholder="Repeated password" name="userRpass" value="<?php echo $userRpass; ?>">
             <span class="text-danger"><?php echo $rpassError; ?></span>
			</div>
            <div class="clearfix"> </div>
            </div>
             
            <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary"  name="btn-signup">Submit</button>
              <button type="reset" class="btn btn-default">Reset</button>
            </div>
          <div class="clearfix"> </div>
        </form>
 </div>
</div>

<?php include('includes/footer.php');?>
<?php include('includes/sidebar.php');?>
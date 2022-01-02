<?php  include('common.php');
$id= '';
$states ='';	
$nameError ='';
  if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
   $id= $_REQUEST['id'];	
   $sql1 = "select * from state where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$states=$row['states'];
  } 
	
 	$error = false;
	if (isset($_POST['add']) && empty($_POST['id'])) {	
		$states = trim($_POST['states']);
 		if (empty($states)) {
			$error = true;
			$nameError = "Please enter state.";
		}		

 		if(!$error) {
          $query="INSERT INTO state SET states ='$states'  ";
          $phObj=$conn->query($query);	
	
 	if($phObj)	{		    
     echo '<script type="text/javascript">location.href="view-state.php"</script>';	
	}
	else{
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
				
			}	
	}
	}	
	
 	if (isset($_POST['add']) && !empty($_POST['id'])) {	
		$states = trim($_POST['states']);
		 
		if (empty($states)) {
			$error = true;
			$nameError = "Please enter state.";
		}		
		
 		if(!$error) {
        $query="UPDATE state SET states= '$states' WHERE id='$id' limit 1 ";
         $phObj=$conn->query($query);	
 	
	if($phObj)	{		
    echo '<script type="text/javascript">location.href="view-state.php"</script>';
 	}
	else{
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
 			}	
 	}
	}
		
 include('includes/head.php');  include('includes/header.php'); ?>	
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add State </li>
            </ol>
 	<div class="validation-system">
 		<div class="validation-form">
        <?php if ( isset($errMSG) ) {	?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>		
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">	
         	
          <div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">State Name</label>
              <input type="text" placeholder="State Name" name="states" value="<?php echo $states; ?>">
			   <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
           
            <div class="clearfix"> </div>
            </div>
                   
           <input type="hidden" name="id" value="<?php echo $id;?>">
            <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary"  name="add">Submit</button>
              <button type="reset" class="btn btn-default">Reset</button>
            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

</div>
 	<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
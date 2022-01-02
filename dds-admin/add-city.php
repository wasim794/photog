<?php  include('common.php');
$id= '';	
$cities='';
$state='';
$nameError ='';
$stateError = '';
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){

$id= $_REQUEST['id'];	
 $sql1 = "select * from city where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$cities=$row['cities'];
				$state=$row['state'];
 } 
	
	 /*------- submit action start--------*/
	$error = false;
	if (isset($_POST['add']) && empty($_POST['id'])) {	
		$cities = trim($_POST['cities']);
		$state = trim($_POST['state']);
		 
		if (empty($cities)) {
			$error = true;
			$nameError = "Please enter city.";
		}
		if (empty($state)) {
			$error = true;
			$stateError = "Please select state.";
		}		

 		if(!$error) {
            $query="INSERT INTO city SET state='$state', cities ='$cities'  ";
            $phObj=$conn->query($query);		
	
	if($phObj)	{		    
     echo '<script type="text/javascript">location.href="view-city.php "</script>';	
	}
	else{
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
 			}	
	}
	}	
	
		 /*------- update action start--------*/
	if (isset($_POST['add']) && !empty($_POST['id'])) {	
		$cities = trim($_POST['cities']);
		$state = trim($_POST['state']);
		 
		if (empty($cities)) {
			$error = true;
			$nameError = "Please enter city.";
		}
		if (empty($state)) {
			$error = true;
			$stateError = "Please select state.";
		}		
		
		if(!$error) {
         $query="UPDATE city SET state='$state', cities= '$cities' WHERE id='$id' limit 1 ";
          $phObj=$conn->query($query);		
	
	  if($phObj)	{		
   echo '<script type="text/javascript">location.href="view-city.php"</script>';	
	}
	else{
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}	
	}
	}
		
include('includes/head.php'); include('includes/header.php');?>	
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Add City</li>   </ol>

 	<div class="validation-system">
 		<div class="validation-form">
        <?php if ( isset($errMSG) ) {	?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>		
		<form class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"             method="post" enctype="multipart/form-data">
		<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">State Name</label>
              <select name="state" >
		   <option value="">Select Any One</option>
		   <?php $csql= $conn->query("select * from state");
		      while($crow=$csql->fetch_array()){?>			
<option value="<?php echo $crow['states'];?>" <?php if($state==$crow['states']){ echo 'selected="selected"';}?>><?php echo $crow['states'];?></option>
<?php }?>
			</select>
		   <span class="text-danger"><?php echo $stateError; ?></span>
            </div>
           
            <div class="clearfix"> </div>
            </div>
	   
	   <div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">City Name</label>
<input type="text" name="cities" value="<?php echo $cities; ?>" placeholder="City" />	
		   <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
           
            <div class="clearfix"> </div>
            </div>

	  
		  <input type="hidden" name="id" value="<?php echo $id; ?>">
	           <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary"  name="add">Submit</button>
              <button type="reset" class="btn btn-default">Reset</button>
            </div>
          <div class="clearfix"> </div>
			</form>
    
 </div>

</div>
 	<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
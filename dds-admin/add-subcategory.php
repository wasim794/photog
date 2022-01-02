<?php require_once 'common.php'; 
$cid='';
$cate = '';
$cateError ='';
$sub = '';
$subError ='';
$type = '';
if(isset($_REQUEST['cid'])){
 $cid=$_REQUEST['cid'];
 
  $sql1 = "select * from subcategory where cid='$cid'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$cate=$row['cate'];
				$sub=$row['sub'];
					$type=$row['type'];
			}	
						
$error = false;
	if (isset($_POST['btn-signup']) && empty($_POST['cid']) ) {
		
		$cate = trim($_POST['cate']);
		$sub = trim($_POST['sub']);
		$type = trim($_POST['type']);

		if (empty($cate)) {
			$error = true;
			$cateError = "Please select Category .";
		} 
		
		if (empty($sub)) {
			$error = true;
			$subError = "Please enter Sub Category.";
		} 
		
		if(!$error) {			
			$query = "INSERT INTO subcategory(cate,sub,type) VALUES('$cate','$sub','$type')";
			$res = $conn->query($query);
				
			if ($res) {
					header("location:view-subcategory.php");
				
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
	
	if (isset($_POST['btn-signup']) && !empty($_POST['cid']) ) {

		$cate = trim($_POST['cate']);
        $sub = trim($_POST['sub']);
		$type = trim($_POST['type']);
	
		if( !$error ) {
			$query="UPDATE subcategory SET 	cate='$cate',sub='$sub', type='$type'	WHERE cid='$cid' limit 1 ";
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-subcategory.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
 include('includes/head.php');  include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Sub Category</li> </ol>
 	<div class="validation-system">
 		<div class="validation-form">
 	     <?php if (isset($errMSG)){ ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php }?>	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">	
         	<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">Category</label>
              <select name="cate">
				  <option value="">Select Any One</option> 				
		  <?php   $sql1 = "select * from category order by cid asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){?>			  
		<option value="<?php echo $row['cid'];?>" <?php if($cate==$row['cid']){ echo 'selected="selected"';}?> ><?php echo $row['cate'];?> </option>
			  <?php }?>
			  </select>
			   <span class="text-danger"><?php echo $cateError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label"> Sub Category</label>
              <input type="text" placeholder="Sub Category" name="sub" value="<?php echo $sub; ?>">
			   <span class="text-danger"><?php echo $subError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			<div class="vali-form">
              <div class="col-md-6 form-group2">
 <label class="control-label"> Type </label>
<select name="type">
<option value="Booking" <?php if($type=='Booking'){ echo 'selected="selected"';}?>>Booking</option>
<option value="Enquiry" <?php if($type=='Enquiry'){ echo 'selected="selected"';}?>>Enquiry</option>
</select>
</div>
             <div class="clearfix"> </div>
            </div>
           <input type="hidden" name="cid" value="<?php echo $cid;?>">
          
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
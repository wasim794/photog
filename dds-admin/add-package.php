<?php require_once 'common.php'; 
$child='';
$pack = '';
$detail = '';
$price = '';
$packError = '';
$amountError = '';
$childError = '';
 $cError = '';
$id ='';
if(isset($_REQUEST['id'])){
 $id=$_REQUEST['id'];
 $catError = '';
  $sql1 = "select * from package where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$child=$row['child'];
				$pack=$row['pack'];
				$price=$row['price'];
				$detail=$row['detail'];
				$type =$row['type'];
				$credit =$row['credit'];
			}			
$error = false;
	if (isset($_POST['btn-signup']) && empty($_POST['id']) ) {
		$child = trim($_POST['child']);
		$pack = trim($_POST['pack']);
		$price = trim($_POST['price']);
	    $detail = trim($_POST['detail']);
		$credit = trim($_POST['credit']);
		$type = trim($_POST['type']);
					
		if (empty($child)) {
			$error = true;
			$childError = "Please select service .";
		} 
		if (empty($pack)) {
			$error = true;
			$packError = "Please enter package title .";
		}
		if (empty($price)) {
			$error = true;
			$priceError = "Please enter package price .";
		} 
		if (empty($credit)) {
			$error = true;
			$cError = "Please enter credit.";
		} 
		
		if( !$error ) {
			$query = "INSERT INTO package(child,pack,price,detail,type,credit) 
			VALUES('$child','$pack','$price','$detail','$type','$credit')";
			$res = $conn->query($query);
			if ($res) {
				header("location:view-package.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
				echo mysqli_error($conn); die;
			}	
		}		
	}
	
	if (isset($_POST['btn-signup']) && !empty($_POST['id']) ) {

		$child = trim($_POST['child']);
		$pack = trim($_POST['pack']);
		$price = trim($_POST['price']);
	    $detail = trim($_POST['detail']);
		$credit = trim($_POST['credit']);
		$type = trim($_POST['type']);

					
		if (empty($child)) {
			$error = true;
			$childError = "Please select service .";
		} 
		if (empty($pack)) {
			$error = true;
			$packError = "Please enter package title .";
		}
		if (empty($price)) {
			$error = true;
			$priceError = "Please enter package price .";
		} 
		if (empty($credit)) {
			$error = true;
			$cError = "Please enter credit.";
		} 
			
		if( !$error ) {
		
			$query="UPDATE package SET
			child='$child',
			pack='$pack',
			price='$price',
			detail='$detail',
			type='$type',
			credit='$credit'
			WHERE id='$id' limit 1 ";
			
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-package.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
 include('includes/head.php');  include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Package </li>
            </ol>
 	<div class="validation-system">
 		<div class="validation-form">
        <?php if ( isset($errMSG) ) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } 	?>		
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">
			
         	<div class="vali-form">
			<div class="col-md-6 form-group1">
              <label class="control-label">Service</label>
     <select name="child" id="combobox" class="form-control">
			  <option value="">Select Any One</option>
			  <?php $sql = $conn->query("select * from child order by id asc");
			      while($row=$sql->fetch_array()){
				  ?>
			  <option value="<?= $row['id'];?>"  <?php if($child=="$row[id]"){ echo 'selected="selected"';}?>><?php echo $row['title'];?></option>
			<?php }?>
			  </select>
			   <span class="text-danger"><?php echo $childError; ?></span>
            </div>
			
            <div class="col-md-6 form-group1">
              <label class="control-label">Package Name</label>
              <input type="text" placeholder="Package Name" name="pack" value="<?php echo $pack; ?>">
			   <span class="text-danger"><?php echo $packError; ?></span>
            </div>
			
			
            <div class="clearfix"> </div>
            </div>
	
			<div class="vali-form">
			<div class="col-md-6 form-group1">
              <label class="control-label">Price</label>
              <input type="text" placeholder="Price" name="price" value="<?php echo $price; ?>" onKeyUp="checkInput(this)">
            </div>
			
           <div class="clearfix"> </div> 
            </div>
			<div class="vali-form">
			<div class="col-lg-12">
<div class="form-group">
<label for="Description" class="ilable1"><strong>Detail</strong> </label>
<textarea name="detail"  class="form-control ckeditor" rows="5"  cols="40" id="pitch_message1"><?= $detail;?></textarea>

</div>
</div>
			<div class="clearfix"> </div> 
            </div>
			
			
			<div class="vali-form">
			<div class="col-md-6 form-group1">
              <label class="control-label">Credit Type</label>
               <select name="type"  class="form-control">
 			  <option value="Fixed"  <?php if($type=="Fixed"){ echo 'selected="selected"';}?>>Fixed</option>
	<option value="Percentage"  <?php if($type=="Percentage"){ echo 'selected="selected"';}?>>Percentage</option>
			  </select>
			   <span class="text-danger"><?php echo $childError; ?></span>
            </div>
			
            <div class="col-md-6 form-group1">
              <label class="control-label">Credit</label>
              <input type="text" placeholder="Credit" name="credit" value="<?php echo $credit; ?>">
			   <span class="text-danger"><?php echo $cError; ?></span>
            </div>
			
			
            <div class="clearfix"> </div>
            </div>
           <input type="hidden" name="id" value="<?php echo $id;?>">
          
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
<?php require_once 'common.php'; 
$category='';
$title ='';
$off='';
$id='';

$categoryError='';
$titleError ='';
$offError ='';

if(isset($_REQUEST['id'])){
$id = $_REQUEST['id'];
$query = $conn->query("select * from Sdiscount where id='$id'");
$data=$query->fetch_array();

    $category = $data['category'];
	$title = $data['title'];
	$off = $data['off'];	
  }  
	$error = false;
if (isset($_POST['save']) && empty($_POST['id']) ) {

    $category = trim($_POST['category']);
	$title = trim($_POST['title']);
	$off = trim($_POST['off']);
	 	
		if (empty($category)) {
			$error = true;
			$categoryError = "Please Select Category.";
		} 
		 
			if (empty($title)) {
			$error = true;
			$titleError = "Please Enter title.";
		} 
		if (empty($off)) {
			$error = true;
			$offError = "Please enter discount percentage.";
		}
			
			if(!$error) {
              $query = "INSERT INTO Sdiscount(category, title, off) VALUES('$category', '$title' , '$off')";
			 $res = $conn->query($query);
 	  			if ($res) {			
		       header('location:view-sec-discount.php');	
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
				echo mysqli_error($conn);
				die;	
			}		
		}
	}
	
if (isset($_POST['save']) && !empty($_POST['id'])) {
    $category = trim($_POST['category']);
 	$title = trim($_POST['title']);
	$off = trim($_POST['off']);
 		 
     if (empty($category)) {
			$error = true;
			$categoryError = "Please Select Category.";
		} 
		 
		 	if (empty($title)) {
			$error = true;
			$titleError = "Please Enter title.";
		} 
		if (empty($off)) {
			$error = true;
			$offError = "Please enter discount percentage.";
		}
			
	if(!$error) {
		 		$query="UPDATE discount SET
			category='$category',
 			title='$title',
		 	off='$off' 
			WHERE id='$id' limit 1 ";	
					
			 $res = $conn->query($query);
			 
 			if ($res) {			
		       header('location:view-sec-discount.php');	
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}		
		}
	}
 include('includes/head.php');  include('includes/header.php');?>
 
 
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Second Discount </li>
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
<label for="Industry" class="ilable1"><strong>Category </strong></label>
<select name="category" class="form-control"  id="cate">
	<option value="">Select Any One</option>	
<?php  $sql1 = "select * from child order by id asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){
				  $child= $row['title'];
				   $cid= $row['id'];
				  ?>
			 	 <option value="<?php echo $cid;?>" <?php if($category==$cid){ echo 'selected="selected"';}?>>
				 <?php echo $child;?> </option>
			  <?php  }?> 
</select>
<span class="text-danger"><?php echo $categoryError; ?></span>
</div>
</div>

</div>

<div class="row row-space-20">
		<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Title </strong></label>
<input type="text" name="title" value="<?= $title;?>" class=" form-control">
<span class="text-danger"><?php echo $titleError; ?></span>
</div>
</div>
	</div>
	<div class="row row-space-20">
	<div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Discount In Percentage </strong></label>
<input type="text" name="off" value="<?= $off;?>" class=" form-control" onkeyup="checkInput(this);">
<span class="text-danger"><?php echo $offError; ?></span>
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
<?php include('includes/sidebar.php');?>
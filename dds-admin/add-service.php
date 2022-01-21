<?php require_once 'common.php'; 
if (isset($_REQUEST['delete'])){
$id =$_REQUEST['id'];
$sql=$conn->query("select * FROM `images` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['file_name'];	 
		$db=$conn->query("DELETE FROM `images` WHERE id='".$_REQUEST['delete']."'");
		if($db){ unlink(PHOTOURL.$filename);}
	}
	
	if (isset($_REQUEST['delete1'])){
$id =$_REQUEST['id'];
$sql=$conn->query("select * FROM `images1` WHERE id='".$_REQUEST['delete1']."'");
	$row = $sql->fetch_array();
	$filename = $row['file_name'];
	$title_tag = $row['title_tag'];
	$heading_tag = $row['heading_tag'];
		 
		$db=$conn->query("DELETE FROM `images1` WHERE id='".$_REQUEST['delete1']."'");
		if($db){ unlink(PHOTOURL.$filename);}
	}

$category='';
$sub ='';
$title ='';
$title_tag ='';
$heading_tag ='';
$description='';
$video='';
$works='';
$why='';
$status='';
$id='';

$categoryError='';
$subError='';
$titleError ='';
$descriptionError ='';

if(isset($_REQUEST['id'])){

$id = $_REQUEST['id'];
$query = $conn->query("select * from service where id='$id'");
$data=$query->fetch_array();

    $category = $data['category'];
	$sub = $data['sub'];
	$title = $data['title'];
	$description = $data['description'];	
	$works = $data['works'];
	$why = $data['why'];
	$status = $data['status'];
	$ufile = $data['ufile'];
	$ufile1 = $data['ufile1'];
	$video = $data['video'];

	$subcategory = SubCategory($sub,$conn);
}   $targetDir = "uploads/";
	 $allowTypes = array('jpg','png','jpeg','gif');
	
	$error = false;
if (isset($_POST['save']) && empty($_POST['id']) ) {

    $category = trim($_POST['category']);
	$sub = trim($_POST['sub']);
	$title = trim($_POST['title']);
	$description = trim($_POST['description']);
	$works = trim($_POST['works']);
	$why = trim($_POST['why']);
	$subcategory = SubCategory($sub,$conn);
	$status = 1;
	$rstatus =0;
	$video = trim($_POST['video']);
	
	    $_name1 =$_FILES['ufile']['name'];
        $ufile=$_name1;
        $temp_path1=$_FILES['ufile']['tmp_name'];
        $file_type1=$_FILES['ufile']['type'];
		
		$_name2 =$_FILES['ufile1']['name'];
        $ufile1=$_name2;
        $temp_path2=$_FILES['ufile1']['tmp_name'];
        $file_type2=$_FILES['ufile1']['type'];
		
	if(empty($_name1)){$ufile='';}
	if(empty($_name2)){$ufile1='';}
	
		if (empty($category)) {
			$error = true;
			$categoryError = "Please Select Category.";
		} 
		 
		if (empty($sub)) {
			$error = true;
			$subError = "Please Select Sub Category.";
		} 
		if (empty($title)) {
			$error = true;
			$titleError = "Please Enter title.";
		} 
		if (empty($description)) {
			$error = true;
			$descriptionError = "Please enter description.";
		}
			
			if(!$error) {
			move_uploaded_file($temp_path1,PHOTOURL.$ufile);
			move_uploaded_file($temp_path2,PHOTOURL.$ufile1);
			$query = "INSERT INTO service(category,sub, title, ufile, ufile1, description, works, why, status, rstatus, video) VALUES('$category', '$sub', '$title' , '$ufile', '$ufile1','$description', '$works', '$why', '$status', '$rstatus','$video')";
			 $res = $conn->query($query);
			$service_id = $conn->insert_id;
			
	 if(!empty(array_filter($_FILES['files']['name']))){
          
		  foreach($_FILES['files']['name'] as $key=>$val){
             $fileName = basename($_FILES['files']['name'][$key]);
             $targetFilePath = $targetDir . $fileName;
             $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
             
			 if(in_array($fileType, $allowTypes)){
                 if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
              $insert = $conn->query("INSERT INTO images(file_name, service_id) VALUES('$fileName','$service_id')");
                } 
            } 
        }
      }
	  if(!empty(array_filter($_FILES['files1']['name']))){
          
		  foreach($_FILES['files1']['name'] as $key=>$val){
             $fileName = basename($_FILES['files1']['name'][$key]);
             $targetFilePath = $targetDir . $fileName;
             $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
             
			 if(in_array($fileType, $allowTypes)){
                 if(move_uploaded_file($_FILES["files1"]["tmp_name"][$key], $targetFilePath)){
             $insert = $conn->query("INSERT INTO images1(file_name, service_id, title_tag, heading_tag) VALUES('$fileName', '$service_id', '$title_tag', '$heading_tag')");
                } 
            } 
        }
      } 
			
 			if ($res) {			
		       header('location:view-service.php');	
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
	$sub = trim($_POST['sub']);
	$title = trim($_POST['title']);
	$description = trim($_POST['description']);
	$works = trim($_POST['works']);
	$why = trim($_POST['why']);
	$video = trim($_POST['video']);
 	$id = trim($_POST['id']);
 	$title_tag=$_POST['title_tag'];
 	$heading_tag = $_POST['heading_tag'];
	$subcategory = SubCategory($sub,$conn);
	   
	    $_name1 =$_FILES['ufile']['name'];
        $ufile=$_name1;
        $temp_path1=$_FILES['ufile']['tmp_name'];
        $file_type1=$_FILES['ufile']['type'];
		
		$_name2 =$_FILES['ufile1']['name'];
        $ufile1=$_name2;
        $temp_path2=$_FILES['ufile1']['tmp_name'];
        $file_type2=$_FILES['ufile1']['type'];

        
		 
     if (empty($category)) {
			$error = true;
			$categoryError = "Please Select Category.";
		} 
		 
		if (empty($sub)) {
			$error = true;
			$subError = "Please Select Sub Category.";
		} 
		if (empty($title)) {
			$error = true;
			$titleError = "Please Enter title.";
		} 
		if (empty($description)) {
			$error = true;
			$descriptionError = "Please enter description.";
		}
			
	if(!$error) {
		if(!empty($_name1)){
			$sql=$conn->query("select * FROM `service` WHERE id='$id'");
	        $row = $sql->fetch_array();
	        $filename = $row['ufile'];
	       unlink(PHOTOURL.$filename);			
			
			move_uploaded_file($temp_path1,PHOTOURL.$ufile);
			$query2="UPDATE service SET ufile='$ufile' WHERE id='$id' limit 1 ";
			$res2 = $conn->query($query2);
		}
		
		
		if(!empty($_name2)){
			$sql=$conn->query("select * FROM `service` WHERE id='$id'");
	        $row = $sql->fetch_array();
	        $filename1 = $row['ufile1'];
	       unlink(PHOTOURL.$filename1);			
			
			move_uploaded_file($temp_path2,PHOTOURL.$ufile1);
			$query2="UPDATE service SET ufile1='$ufile1' WHERE id='$id' limit 1 ";
			$res2 = $conn->query($query2);
		}
			$query="UPDATE service SET
			category='$category',
			sub='$sub',
			title='$title',
		 	description='$description',
			works ='$works',
			video='$video',
			why = '$why'
			WHERE id='$id' limit 1 ";	
					
			 $res = $conn->query($query);
			 
			 		
	 if(!empty(array_filter($_FILES['files']['name']))){          
		  foreach($_FILES['files']['name'] as $key=>$val){
             $fileName = basename($_FILES['files']['name'][$key]);
             $targetFilePath = $targetDir . $fileName;
             $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
             
			 if(in_array($fileType, $allowTypes)){
                 if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                     $insert = $conn->query("INSERT INTO images(file_name, service_id) VALUES('$fileName','$id')");
                } 
            } 
        }
      } 
		 if(!empty(array_filter($_FILES['files1']['name']))){          
		  foreach($_FILES['files1']['name'] as $key=>$val){
             $fileName = basename($_FILES['files1']['name'][$key]);
             $targetFilePath = $targetDir . $fileName;
             $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
             
			 if(in_array($fileType, $allowTypes)){
                 if(move_uploaded_file($_FILES["files1"]["tmp_name"][$key], $targetFilePath)){
             $insert = $conn->query("INSERT INTO images1(file_name, service_id, title_tag, heading_tag) VALUES('$fileName', '$id', '$title_tag', '$heading_tag')");
                } 
            } 
        }
      } 	 
			
			if ($res) {			
		       header('location:view-service.php');	
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}		
		}
	}
 include('includes/head.php');  include('includes/header.php');?>
 
<script type="text/javascript">
$(document).ready(function() {    
	$("#cate").change(function() {
	$(this).after('<div id="loader"></div>');
		$.get('loadsubcat.php?cate=' + $(this).val(), function(data) {
			$("#sub").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
});
</script> 
<script>
function chkDelete(id,pid){
	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="add-service.php?id="+id+"&delete="+pid;
	}
	else {return false;}
}
function chkDelete1(id,pid){
	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="add-service.php?id="+id+"&delete1="+pid;
	}
	else {return false;}
}
</script>
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Service </li>
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
<?php  $sql1 = "select * from category order by cate asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){
				  $cate= $row['cate'];
				   $cid= $row['cid'];
				  ?>
			 	 <option value="<?php echo $cid;?>" <?php if($category==$cid){ echo 'selected="selected"';}?>>
				 <?php echo $cate;?> </option>
			  <?php  }?> 
</select>
<span class="text-danger"><?php echo $categoryError; ?></span>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="Industry" class="ilable1"> <strong>Sub Category</strong></label>
<select name="sub" class="form-control" id="sub">
<?php if(empty($sub)){ ?>
			 	 <option value="">Select Any One </option>
				 <?php } else {?>
				 <option value="<?php echo $sub;?>"><?php echo $subcategory ;?> </option>
			  <?php  }?>
</select>
<span class="text-danger"><?php echo $subError; ?></span>
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
	
	<div class="col-md-6">
<div class="form-group col-md-6">
<label for="company" class="ilable1"><strong>Front Image (Size: 350x300)</strong></label>
<input type="file" name="ufile">
	   <?php if(!empty($ufile)){?><br>
			 <img src="uploads/<?= $ufile;?>" width="200">
			 <?php }?>
</div>

<div class="form-group col-md-6">
<label for="company" class="ilable1"><strong>Banner Image (Size: 1350x350)</strong></label>
<input type="file" name="ufile1">
	   <?php if(!empty($ufile1)){?><br>
			 <img src="uploads/<?= $ufile1;?>" width="200">
			 <?php }?>
</div>
</div>	
</div>
<div class="row row-space-20">
 	<div class="col-md-12">
<!-- <div class="form-group">
<label for="company" class="ilable1"><strong>Price List Multi Image upload</strong></label>
<input type="file" name="files[]" multiple >
	   <?php 
  $sql1=$conn->query("select * FROM images WHERE service_id='$id'");
	while($row1 = $sql1->fetch_array()){
	$filename1 = $row1['file_name'];  
	?><div class="col-md-3">
			 <a href="javascript:void(0);" onClick="chkDelete(<?php echo $id;?>,<?php echo $row1["id"];?>)" ><img src="images/cross_bright.png" /></a>
			 <img src="uploads/<?= $filename1 ;?>"  style="width:100%"></div>
			 <?php }?>
</div> -->
</div>	
</div>
<div class="row row-space-20">
<div class="col-lg-12">
<div class="form-group">
<label for="Description" class="ilable1"><strong>Short Description</strong> </label>
<textarea name="description"  class="form-control ckeditor" rows="5"  cols="40" id="pitch_message"><?= $description;?></textarea>
<span class="text-danger"><?php echo $descriptionError; ?></span>
</div>
</div>
</div>

<div class="row row-space-20">
<div class="col-lg-12">
<div class="form-group">
<label for="Description" class="ilable1"><strong>Long Description</strong> </label>
<textarea name="works"  class="form-control ckeditor" rows="5"  cols="40" id="pitch_message1"><?= $works;?></textarea>

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
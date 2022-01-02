<?php  include('common.php');

$title='';
$detail = '';
$titleError = '';
$detailError = '';
$id ='';
	 /*------- generate username start--------*/
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
$id= $_REQUEST['id'];	
$button ='Update';
 $sql1 = "select * from blog where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$title=$row['title'];
				$detail=$row['detail'];
				$photo=$row['photo'];
} 
else {  $button ='Add'; }

	
	 /*------- submit action start--------*/
	$error = false;
	if (isset($_POST['add']) && empty($_POST['id'])) {	
		@extract($_REQUEST);
        
		$_name=$_FILES['photo']['name'];
        $photo= uniqid('Img_').$_name;
        $temp_path=$_FILES['photo']['tmp_name'];
        $file_type=$_FILES['photo']['type'];
		 
		if (empty($title)) {
			$error = true;
			$titleError = "Please enter blog title.";
		}
		
		
		if (empty($detail)) {
			$error = true;
			$detailError = "Please enter description.";
		}
		
		if(!$error) {
			 move_uploaded_file($temp_path,PHOTOURL.$photo);
$query="INSERT INTO blog SET
title= '$title',
detail='$detail',
photo='$photo' ";

$phObj=$conn->query($query);	
	
	if($phObj)	{	
    echo '<script type="text/javascript">location.href="view-blog.php?success"</script>';
   	}
	else{
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
				
			}	
	}
	}	
	
		 /*------- update action start--------*/
	if (isset($_POST['add']) && !empty($_POST['id'])) {	
		@extract($_REQUEST);
	    
		$_name=$_FILES['photo']['name'];
        $photo= uniqid('Img_').$_name;
        $temp_path=$_FILES['photo']['tmp_name'];
       
	    $file_type=$_FILES['photo']['type'];
		if (empty($title)) {
			$error = true;
			$titleError = "Please enter blog title.";
		}
		
		
	if(!$error) {	
		if(!empty($_name)){
		move_uploaded_file($temp_path,PHOTOURL.$photo);	
		$query="UPDATE  blog SET
         title= '$title',
         detail='$detail' ,
         photo='$photo' 
         WHERE id='$id' limit 1 ";
		}
		else {
        $query="UPDATE  blog SET
        title= '$title',
        detail='$detail' 
        WHERE id='$id' limit 1 ";
        }
        $phObj=$conn->query($query);	
	
	if($phObj){
   echo '<script type="text/javascript">location.href="view-blog.php?usuccess"</script>';
   
	}
	else{
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
				
			}	
				
	}
	}
	
	
	

  include('includes/head.php');  include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Blog</li></ol>
			
 	<div class="validation-system">
 		<div class="validation-form">
 <?php if (isset($errMSG)) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">
         	<div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Title</label>
              <input type="text" placeholder="Title" name="title" value="<?php echo $title; ?>">
			   <span class="text-danger"><?php echo $titleError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			
           <div class="vali-form">
            <div class="col-md-12 form-group2">
              <label class="control-label">Pic Upload</label>
             <input type="file" name="photo">
			 <?php if(!empty($photo)){?><br>
			 <img src="uploads/<?= $photo;?>" width="200">
			 <?php }?>
            </div>
            <div class="clearfix"> </div>
            </div>
			
               <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Content</label>
    <textarea class="ckeditor" cols="40" id="pitch_message" name="detail" rows="10"><?php echo $detail;?></textarea>
			   <span class="text-danger"><?php echo $detailError; ?></span>
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
 </div>
</div>

<?php include('includes/footer.php');?>
<?php include('includes/sidebar.php');?>			

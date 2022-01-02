<?php require_once 'common.php'; 
$category='';
$title='';
$status ='';
 $fid='';
 $video='';
if(isset($_REQUEST['fid'])){
 $fid=$_REQUEST['fid'];
 
  $sql1 = "select * from slider where fid='$fid'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$status=$row['status'];
				$category=$row['category'];
				$title=$row['title'];
				$ufile=$row['ufile'];
				$video=$row['video'];
				}
						
$error = false;
	if ( isset($_POST['btn-signup']) && empty($_POST['fid']) ) {
		
		$status = trim($_POST['status']);
		$category = trim($_POST['category']);
		$title = trim($_POST['title']);
			$video = trim($_POST['video']);
		
		$_name=$_FILES['image']['name'];
        $ufile=$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
			
		if( !$error ) {
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query = "INSERT INTO slider(category,title,status,ufile,video) 
			VALUES('$category','$title','$status','$ufile','$video')";
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-slider.php");
				
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
	
	if ( isset($_POST['btn-signup']) && !empty($_POST['fid']) ) {
		
		$status = trim($_POST['status']);
		$category = trim($_POST['category']);
		$title = trim($_POST['title']);
		$video = trim($_POST['video']);
		
		$_name=$_FILES['image']['name'];
        $ufile=$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
		if( !$error ) {
		 if($_name!="")
           {		   
		    $sql=$conn->query("select * FROM `slider` WHERE fid='$fid'");
        	$row = $sql->fetch_array();
        	$filename = $row['ufile'];
  		    unlink(PHOTOURL.$filename);
		   
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query="UPDATE slider SET
			category='$category',
			title='$title',
			status='$status',
			ufile='$ufile',
			video='$video',
			WHERE fid='$fid' limit 1 ";
			}
			else 	{
			$query="UPDATE slider SET
			category='$category',
			title='$title',
			status='$status',
			video='$video',
			WHERE fid='$fid' limit 1 ";
			}
			$res = $conn->query($query);	
			if ($res) {
				header("location:view-slider.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}

include('includes/head.php');				 include('includes/header.php');?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add slider </li>
            </ol>
 	<div class="validation-system">
 		<div class="validation-form">
        <?php 	if ( isset($errMSG) ) {  ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>		 
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">	
         	
          <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Heading</label>
              <input type="text" placeholder="Heading" name="category" value="<?php echo $category; ?>">
            </div>
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Sub Heading</label>
              <input type="text" placeholder="Sub Heading" name="title" value="<?php echo $title; ?>">
            </div>
            <div class="clearfix"> </div>
            </div>
			
             <div class="vali-form">
            <div class="col-md-12 form-group2">
              <label class="control-label">Pic Upload (Size : 1350x600px)</label>
             <input type="file" name="image">
			 <?php if(!empty($ufile)){?><br>
			 <img src="uploads/<?= $ufile;?>" width="200">
			 <?php }?>
            </div>           
            <div class="clearfix"> </div>
            </div>  

            <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Videos</label>
              <input type="text" placeholder="Add video" name="video" value="<?php echo $video; ?>">
            </div>
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">Status</label>
             <select name="status">
	<option value="1" <?php if($status=='1') { ?> selected="selected" <?php } ?> >Active</option>
					<option value="0" <?php if($status=='0') { ?> selected="selected" <?php } ?> >Inactive</option>
					</select>
			 </div>
           <div class="clearfix"> </div> 
            </div>
			
           <input type="hidden" name="fid" value="<?php echo $fid;?>">
          
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
	
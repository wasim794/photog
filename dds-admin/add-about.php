<?php require_once 'common.php'; 
$title='';
$detail = '';
$titleError = '';
$detailError = '';
$catError = '';
$nid ='';
if(isset($_REQUEST['nid'])){
 $nid=$_REQUEST['nid'];
 $catError = '';
  $sql1 = "select * from about where nid='$nid'";
				$query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$title=$row['title'];
				$detail=$row['detail'];
				$ufile=$row['ufile'];
			}			
$error = false;
	if (isset($_POST['btn-signup']) && empty($_POST['nid'])){
		$title = trim($_POST['title']);
		$detail = trim($_POST['detail']);
	    
		$_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
			
		if (empty($title)) {
			$error = true;
			$titleError = "Please enter title .";
		} 
		
		if (empty($detail)) {
			$error = true;
			$detailError = "Please enter detail .";
		} 
		
		if( !$error ) {
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
		 	echo $query = "INSERT INTO about (title,detail,ufile) 
			VALUES('$title','$detail','$ufile')";
			$res = $conn->query($query);
//print_r($res);die();
			if ($res) {
			header("location:view-about.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
	
	if (isset($_POST['btn-signup']) && !empty($_POST['nid']) ) {

		$title = trim($_POST['title']);
		$detail = trim($_POST['detail']);
		
		$_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
					
		if( !$error ) {
		 if($_name!="") {
		    $sql=$conn->query("select * FROM `about` WHERE nid='$nid'");
	        $row = $sql->fetch_array();
	        $filename = $row['ufile'];
		    unlink(PHOTOURL.$filename);
		 
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query="UPDATE about SET
			title='$title',
			detail='$detail',
			ufile='$ufile'
			WHERE nid='$nid' limit 1 ";
			}
			else {
			$query="UPDATE about SET
			title='$title',
			detail='$detail'
			WHERE nid='$nid' limit 1 ";
			}
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-about.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
 include('includes/head.php');  include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add About</li>
            </ol>
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
             <input type="file" name="image">
			 <?php if(!empty($ufile)){?><br>
			 <img src="uploads/<?= $ufile;?>" width="200">
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
			
           <input type="hidden" name="nid" value="<?php echo $nid;?>">
          
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
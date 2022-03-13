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
  $sql1 = "select * from applyonline where nid='$nid'";
				$query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$title=$row['title'];
				$detail=$row['details'];
				$link=$row['link'];
			}			
$error = false;
	if (isset($_POST['btn-signup']) && empty($_POST['nid'])){
		$title = trim($_POST['title']);
		$detail = trim($_POST['detail']);
		$link = trim($_POST['link']);
	   
			
		if (empty($title)) {
			$error = true;
			$titleError = "Please enter title .";
		} 
		
		if (empty($detail)) {
			$error = true;
			$detailError = "Please enter detail .";
		} 
		
		if( !$error ) {
		 	echo $query = "INSERT INTO applyonline (title,details,link) 
			VALUES('$title','$detail','$link')";
			$res = $conn->query($query);
//print_r($res);die();
			if ($res) {
			header("location:view-apply.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
	
	if (isset($_POST['btn-signup']) && !empty($_POST['nid']) ) {

		$title = trim($_POST['title']);
		$detail = trim($_POST['detail']);
		$link = trim($_POST['link']);
					
		if( !$error ) {
		 if($title!="") {
		    $sql=$conn->query("select * FROM `applyonline` WHERE nid='$nid'");
	        $row = $sql->fetch_array();
			$query="UPDATE applyonline SET
			title='$title',
			details='$detail',
			link='$link'
			WHERE nid='$nid' limit 1 ";
			}
			$res = $conn->query($query);
			if ($res) {
				header("location:view-apply.php");
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
            <div class="col-md-12 form-group1">
              <label class="control-label">Content</label>
    <textarea class="ckeditor" cols="40" id="pitch_message" name="detail" rows="10"><?php echo $detail;?></textarea>
			   <span class="text-danger"><?php echo $detailError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
            <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Link</label>
              <input type="text" placeholder="link" name="link" value="<?php echo $link; ?>">
			   <span class="text-danger"><?php echo $titleError; ?></span>
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
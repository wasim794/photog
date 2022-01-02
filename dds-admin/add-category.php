<?php require_once 'common.php'; 
$cid='';
$cate = '';
$cateError ='';
if(isset($_REQUEST['cid'])){
 $cid=$_REQUEST['cid']; 
  $sql1 = "select * from category where cid='$cid'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$cate=$row['cate'];
				$ufile=$row['ufile'];
			}	
						
$error = false;
	if (isset($_POST['btn-signup']) && empty($_POST['cid']) ) {
		$cate = trim($_POST['cate']);
		
		$_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	  $type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
	
	if(empty($_name)){$ufile='';}
		if (empty($cate)) {
			$error = true;
			$cateError = "Please enter Category .";
		}
		
		if( !$error ) {
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query = "INSERT INTO category(cate,ufile) VALUES('$cate','$ufile')";
			$res = $conn->query($query);				
			if ($res) {
					header("location:view-category.php");
				
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}
		}		
	}
	
	if (isset($_POST['btn-signup']) && !empty($_POST['cid']) ) {
		$cate = trim($_POST['cate']);
		
        $_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	    $type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
	
		if(!$error) {
		 if($_name!="")           {
		    $sql=$conn->query("select * FROM `category` WHERE cid='$cid'");
	        $row = $sql->fetch_array();
	        $filename = $row['ufile'];
	       unlink(PHOTOURL.$filename);
		 
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query="UPDATE category SET cate='$cate', ufile='$ufile' WHERE cid='$cid' limit 1 ";			
			}
			else {
			$query="UPDATE category SET cate='$cate' WHERE cid='$cid' limit 1 ";
			}
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-category.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
 include('includes/head.php');  include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Category</li>
            </ol>
 	<div class="validation-system">
 		<div class="validation-form">
       <?php if (isset($errMSG) ) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php  } ?>		
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">	
         	<div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label"> Category</label>
              <input type="text" placeholder="Category" name="cate" value="<?php echo $cate; ?>">
			   <span class="text-danger"><?php echo $cateError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			
            <div class="vali-form">
            <div class="col-md-12 form-group2">
              <label class="control-label"> Image Upload</label>
             <input type="file" name="image">
			 <?php if(!empty($ufile)){?><br>
			 <img src="uploads/<?= $ufile;?>" width="200">
			 <?php }?>
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
<?php require_once 'common.php'; 
 $id='1';
  $sql1 = "select * from home where id='$id'";
  $query1 = $conn->query($sql1);
  $row = $query1->fetch_array();
  $ufile=$row['ufile'];
  $title=$row['title'];
  $detail=$row['detail'];
				
$error = false;	
	if (isset($_POST['btn-signup']) && !empty($_POST['id']) ) {
		$title = trim($_POST['title']);
 		$detail = trim($_POST['detail']);
		
		$_name=$_FILES['image']['name'];
        $ufile=$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 

			
	if( !$error ) {
		 if($_name!="")
           {		   
		   $sql=$conn->query("select * FROM `home` WHERE id='$id'");
	       $row = $sql->fetch_array();
	       $filename = $row['ufile'];
		   unlink(PHOTOURL.$filename);
		   
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query="UPDATE home SET ufile='$ufile' WHERE id='$id' limit 1 ";
			$res = $conn->query($query);
			}
			
			$query1="UPDATE home SET title='$title',detail='$detail' WHERE id='$id' limit 1 ";	
			$res1 = $conn->query($query1);
			if ($res1) {
				$errTyp = "success";
				$errMSG = "Successfully Updated...";
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Home Content</li>
</ol>
 	<div class="validation-system">
 		<div class="validation-form">
 <?php	if ( isset($errMSG) ) {?>
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
            </div>
            <div class="clearfix"> </div>
            </div>
			
             <div class="vali-form">
            <div class="col-md-12 form-group2">
              <label class="control-label">Pic Upload </label>
             <input type="file" name="image">
			 <?php if(!empty($ufile)){?><br>
			 <img src="<?= PHOTOURL.$ufile;?>" width="200">
			 <?php }?>
            </div>
            <div class="clearfix"> </div>
            </div> 
			 
			<div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Content</label>
     <textarea class="ckeditor" cols="40" id="pitch_message" name="detail" rows="10"><?php echo $detail;?></textarea>
            </div>
            <div class="clearfix"> </div>
            </div>	
				
						
           <input type="hidden" name="id" value="<?php echo $id;?>">
          
            <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary"  name="btn-signup">Update</button>
            </div>
          <div class="clearfix"> </div>
        </form>
 </div>
</div>

<?php include('includes/footer.php');?>
<?php include('includes/sidebar.php');?>							
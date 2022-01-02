<?php require_once 'common.php'; 
$title='';
$status ='';
$id='';
$titleError = '';
if(isset($_REQUEST['id'])){
 $id=$_REQUEST['id'];
 
  $sql1 = "select * from partner where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$status=$row['status'];
				$title=$row['title'];
				$ufile=$row['ufile'];
				}
						
$error = false;

	if ( isset($_POST['btn-signup']) && empty($_POST['id']) ) {
		
		$status = trim($_POST['status']);
		$title = trim($_POST['title']);
		
		$_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
			
		if( !$error ) {
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query = "INSERT INTO partner(title,status,ufile) VALUES('$title','$status','$ufile')";
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-partner.php");
				
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
	
	if ( isset($_POST['btn-signup']) && !empty($_POST['id']) ) {

		$status = trim($_POST['status']);
		$title = trim($_POST['title']);
		
		$_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	
	$type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
				
		if( !$error ) {
		 if($_name!="")
           {
		    $sql=$conn->query("select * FROM `partner` WHERE id='$id'");
	        $row = $sql->fetch_array();
	        $filename = $row['ufile'];
		    unlink(PHOTOURL.$filename);
		 
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query="UPDATE partner SET
			title='$title',
			status='$status',
			ufile='$ufile'
			WHERE id='$id' limit 1 ";
			
			}
			else
			{
			$query="UPDATE partner SET
			title='$title',
			status='$status'
			WHERE id='$id' limit 1 ";
			}
			$res = $conn->query($query);	
			if ($res) {
				header("location:view-partner.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
 include('includes/head.php');	include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Partner </li>
            </ol>
 	<div class="validation-system">
 		<div class="validation-form">
        <?php if ( isset($errMSG) ) {	?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>		
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">	
         	
          <div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">Link</label>
              <input type="text" placeholder="Link" name="title" value="<?php echo $title; ?>">
			   <span class="text-danger"><?php echo $titleError; ?></span>
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
			
			<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">Status</label>
             <select name="status">
	<option value="1" <?php if($status=='1') { ?> selected="selected" <?php } ?> >Active</option>
					<option value="0" <?php if($status=='0') { ?> selected="selected" <?php } ?> >Inactive</option>
					</select>
				<span></span>	
					
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
    
 	<!---->
 </div>

</div>
 	<?php include('includes/footer.php');?>	
<?php include('includes/sidebar.php');?>
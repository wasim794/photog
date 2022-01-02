<?php require_once 'common.php'; 
$id='';
$cate = '';
$cateError ='';
$sub = '';
$sub1 = '';
$subError ='';
$title = '';
$titleError ='';
if(isset($_REQUEST['id'])){
 $id=$_REQUEST['id'];
 
  $sql1 = "select * from child where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$cate=$row['cate'];
				$sub=$row['sub'];
				$title=$row['title'];
				$ufile=$row['ufile'];
				$sub1=  SubCategory($row['sub'],$conn);
				}		
$error = false;
	if (isset($_POST['btn-signup']) && empty($_POST['id']) ) {
		
		$cate = trim($_POST['cate']);
		$sub = trim($_POST['sub']);
        $title = trim($_POST['title']);
		
		$_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	    $type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
	  
		if (empty($cate)) {
			$error = true;
			$cateError = "Please select Category .";
		} 
		
		if (empty($sub)) {
			$error = true;
			$subError = "Please enter Sub Category.";
		} 
		
		if (empty($title)) {
			$error = true;
			$titleError = "Please enter child Category.";
		} 
		
		if(!$error) {	
		move_uploaded_file($temp_path,PHOTOURL.$ufile);		
			$query = "INSERT INTO child(cate,sub,title,ufile) 
			VALUES('$cate','$sub','$title','$ufile')";
			$res = $conn->query($query);
				
			if ($res) {
					header("location:view-child.php");
				
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
	
	if (isset($_POST['btn-signup']) && !empty($_POST['id']) ) {

		$cate = trim($_POST['cate']);
		$sub = trim($_POST['sub']);
        $title = trim($_POST['title']);
		
		$_name=$_FILES['image']['name'];
        $ufile=uniqid('Img_').$_name;
        $temp_path=$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
	    $type=array("image/jpg","image/jpeg","image/PNG","image/png","image/gif","image/bmp"); 
		
		if (empty($cate)) {
			$error = true;
			$cateError = "Please select Category .";
		} 
		
		if (empty($sub)) {
			$error = true;
			$subError = "Please enter Sub Category.";
		} 
		
		if (empty($title)) {
			$error = true;
			$titleError = "Please enter child Category.";
		} 
	
		if( !$error ) {
		
		if($_name!="")           {
		    $sql=$conn->query("select ufile FROM `child` WHERE id='$id'");
	        $row = $sql->fetch_array();
	        $filename = $row['ufile'];
	       unlink(PHOTOURL.$filename);
		 
			move_uploaded_file($temp_path,PHOTOURL.$ufile);
			$query1 ="UPDATE child SET  ufile='$ufile' WHERE id='$id' limit 1 ";	
			$res1 = $conn->query($query1);		
			}
		
			$query="UPDATE child SET 	cate='$cate',sub='$sub', title='$title'	WHERE id='$id' limit 1 ";
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-child.php");
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
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Child Category</li> </ol>
 	<div class="validation-system">
 		<div class="validation-form">
 	     <?php if (isset($errMSG)){ ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="fa fa-info"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php }?>	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post" enctype="multipart/form-data">	
         	<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">Category</label>
              <select name="cate" id="cate">
				  <option value="">Select Any One</option> 				
		  <?php   $sql1 = "select * from category order by cid asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){?>			  
		<option value="<?php echo $row['cid'];?>" <?php if($cate==$row['cid']){ echo 'selected="selected"';}?> ><?php echo $row['cate'];?> </option>
			  <?php }?>
			  </select>
			   <span class="text-danger"><?php echo $cateError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-6">
<div class="form-group">
<label for="Industry" class="ilable1"> <strong>Sub Category</strong></label>
<select name="sub" class="form-control" id="sub">
<?php if(empty($sub)){ ?>
			 	 <option value="">Select Any One </option>
				 <?php } else {?>
				 <option value="<?php echo $sub;?>"><?php echo $sub1 ;?> </option>
			  <?php  }?>
</select>
<span class="text-danger"><?php echo $subError; ?></span>
</div>
</div>
            <div class="clearfix"> </div>
            </div>
              
			  <div class="vali-form">
			  
			  <div class="col-md-6">
<div class="form-group">
<label for="title" class="ilable1"><strong> Child Category </strong></label>
<input type="text" name="title" value="<?= $title;?>" class=" form-control">
<span class="text-danger"><?php echo $titleError; ?></span>
</div>
</div> 

<div class="clearfix"> </div>
<div class="col-md-6 form-group2">
              <label class="control-label"> Image Upload</label>
             <input type="file" name="image">
			 <?php if(!empty($ufile)){?><br>
			 <img src="uploads/<?= $ufile;?>" width="200">
			 <?php }?>
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
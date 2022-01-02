<?php require_once 'common.php'; 
$title='';
$category = '';
$detail = '';
$titleError = '';
$detailError = '';
$catError = '';
$id ='';
if(isset($_REQUEST['id'])){
 $id=$_REQUEST['id'];

  $sql1 = "select * from terms where id='$id'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$title=$row['title'];
				$detail=$row['detail'];
				$category=$row['category'];
				
			}			
$error = false;

	if ( isset($_POST['btn-signup']) && empty($_POST['id']) ) {
		
		$title = trim($_POST['title']);
			$category = trim($_POST['category']);
		$detail = trim($_POST['detail']);

			
		if (empty($title)) {
			$error = true;
			$titleError = "Please enter title .";
		} 
		if (empty($category)) {
			$error = true;
			$catError = "Please select category .";
		} 
		if (empty($detail)) {
			$error = true;
			$detailError = "Please enter detail .";
		} 
		
		if( !$error ) {
 
 			$query = "INSERT INTO terms(category,title,detail) 
			VALUES('$category','$title','$detail')";
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-terms.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}
	}
	
	if ( isset($_POST['btn-signup']) && !empty($_POST['id']) ) {
		
		$title = trim($_POST['title']);
		$detail = trim($_POST['detail']);
		$category = trim($_POST['category']);
		
		if( !$error ) {
		
			$query="UPDATE terms SET
			title='$title',
			category='$category',
			detail='$detail'
			WHERE id='$id' limit 1 ";
			
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view-terms.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
				
		}
		
		
	}
 include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Terms</li></ol>
 	<div class="validation-system">
 		<div class="validation-form">

        <?php if ( isset($errMSG) ) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>			
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="post" >
		<div class="vali-form">
            <div class="col-md-12 form-group2">
              <label class="control-label">Category</label>
              <select name="category">
			  <?php if(!empty($category)){?>
		 <option value="<?php echo $category;?>"><?php echo $category;?></option>
			  <?php } else {?>
				 <option value="">Select Any One</option>
				
			  <?php }?>
			   <option value="Terms And Conditions">Terms And Conditions</option>
			 	 <option value="Privacy Policy">Privacy Policy</option>
				  <option value="FAQ">FAQ</option>
			  </select>
			   <span class="text-danger"><?php echo $catError; ?></span>
            </div>
           
            <div class="clearfix"> </div>
            </div>	
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
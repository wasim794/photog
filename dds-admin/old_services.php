<?php require_once 'common.php'; 
$cid='';
$keyword = '';
$description = '';
$cateError = '';
$cate = '';
$title = '';
if(isset($_REQUEST['cid'])){
 $cid=$_REQUEST['cid'];
 
  $sql1 = "select * from seo where seo_id='$cid'";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$keyword=$row['seo_title'];
				$description=$row['seo_des'];
				$cate=$row['cid'];
				$title = $row['title'];
					
			}	
						
$error = false;
	if (isset($_POST['btn-signup']) && empty($_POST['cid']) ) {
		
		$type = $conn -> real_escape_string($_POST['keyword']);
		$cate = $conn -> real_escape_string($_POST['cate']);
		$sub = $conn -> real_escape_string($_POST['description']);
		$title = $conn -> real_escape_string($_POST['title']);


		if (empty($cate)) {
			$error = true;
			$cateError = "Please select Category .";
		} 
		
		if (empty($sub)) {
			$error = true;
			$subError = "Please enter Sub Category.";
		} 
		
		if(!$error) {			
			$query = "INSERT INTO seo(cid,seo_title,seo_des,title) VALUES('$cate','$sub','$type','$title')";
			$res = $conn->query($query);
				
			if ($res) {
					header("location:view_old_services.php");
				
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
	
	if (isset($_POST['btn-signup']) && !empty($_POST['cid']) ) {

		$type = $conn -> real_escape_string($_POST['keyword']);
		$cate = $conn -> real_escape_string($_POST['cate']);
		$sub = $conn -> real_escape_string($_POST['description']);
		$title = $conn -> real_escape_string($_POST['title']);
		
		if( !$error ) {
			echo $query="UPDATE seo SET seo_title='$type',seo_des='$sub', cid='$cate', title='$title' WHERE seo_id='$cid' limit 1";
			$res = $conn->query($query);
				
			if ($res) {
				header("location:view_old_services.php");
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
		}		
	}
 include('includes/head.php');  include('includes/header.php');?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Seo Keyword</li> </ol>
 	<div class="validation-system">
 		<div class="validation-form">
 	     <?php if (isset($errMSG)){ ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php }?>	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">	
         	<div class="vali-form">
            
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">Category</label>
              <select name="cate">
				  <option value="">Select Any One</option> 				
		  <?php   $sql1 = "SELECT subcategory.sub, subcategory.status, subcategory.cid,subcategory.type ,category.cate FROM subcategory INNER JOIN category ON category.cid = subcategory.cate order by category.cate asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){?>			  
		<option value="<?php echo $row['cid'];?>" <?php if($cate==$row['cid']){ echo 'selected="selected"';}?> ><?php echo $row['sub'];?> </option>
			  <?php }?>
			  </select>
			   <span class="text-danger"><?php echo $cateError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>

            <div class="vali-form">
             <div class="col-md-6 form-group1">
              <label class="control-label"> Title</label>
              <textarea placeholder="Add Keyword" name="title"><?php echo $title; ?></textarea>
			   <span class="text-danger"><?php echo $error; ?></span>
            </div>
             <div class="clearfix"> </div>
        </div>

<div class="vali-form">
             <div class="col-md-6 form-group1">
              <label class="control-label"> Keyword</label>
              <textarea placeholder="Add Keyword" name="keyword"><?php echo $keyword; ?></textarea>
			   <span class="text-danger"><?php echo $error; ?></span>
            </div>
             <div class="clearfix"> </div>
        </div>
        <div class="vali-form">
             <div class="col-md-6 form-group1">
              <label class="control-label"> Description</label>
              <textarea placeholder="Add Description" name="description"><?php echo $description; ?></textarea>
			   <span class="text-danger"><?php echo $error; ?></span>
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
<?php require_once 'common.php'; 

$id = $_REQUEST['id'];
  $query = $conn->query("select review.id, review.emp_code, review.email,review.view,review.date, rating.rate,review.status from review INNER JOIN rating ON review.id = rating.review_id where review.id='$id' order by review.id desc");
 $data=$query->fetch_array();
 $emp_code = $data['emp_code'];	
  $email = $data['email'];	
  $rating = $data['rate'];	
  $review = $data['view'];
  $status = $data['status'];	
							       
 $sql1=$conn->query("SELECT * FROM registration where id='$email'");
 $data1=$sql1->fetch_array();
				   
 $sql2=$conn->query("SELECT * FROM technician where id='$emp_code'");
  $show=$sql2->fetch_array();
				   
 if(!empty($show['ufile'])){$pic = PHOTOURL.$show['ufile'];} else { $pic ='images/user.png'; }	
 
	$error = false;
	if (isset($_POST['save'])) {
    $id = trim($_POST['id']);
	$rating = trim($_POST['rating']);
 	$review = trim($_POST['review']);	
	$status = trim($_POST['status']);
		
	if(!$error) {
		$query="UPDATE review SET view='$review', status ='$status'  WHERE id='$id' limit 1 ";	
 		$res = $conn->query($query);
		
		$query1="UPDATE rating SET rate='$rating' WHERE review_id='$id' limit 1 ";	
 		$res1 = $conn->query($query1);
			
			if ($res) {			
		       header('location:review.php');	
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}		
		}
	}
 include('includes/head.php');  include('includes/header.php');?>
  
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Review </li>
            </ol>
 	<div class="validation-system"> 		
 		<div class="validation-form">
  	 <div class="panel-default">
           <div class="panel-body">
		    <h3>Review Info</h3>
			<table>
			<tr><td><strong>Review Date : </strong></td><td> <?= date('d/M/Y',strtotime($data['date']));?></td></tr>
			<tr><td><strong>Customer : </strong></td><td> <?= $data1['name'];?></td></tr>
			<tr><td><strong>Contact No : </strong></td><td> <?= $data1['phone'];?></td></tr>
			<tr><td colspan="2">&nbsp; </td></tr>
			<tr><td><strong>Review : </strong></td><td> <?= $data['view'];?></td></tr>
			<tr><td><strong>Rating : </strong></td><td> <?php echo $data['rate'];?> <i class="fa fa-star"></i></td></tr>
			<tr><td colspan="2">&nbsp; </td></tr>
			<tr><td><strong>Technician : </strong></td><td>
			<div class="profile" style="margin-right:5%">
					 <img src="<?php echo $pic;?>"  />
            </div>
			 <?= $show['name'];?> &nbsp;<br />
			 <i class="fa fa-phone"></i> <?= $show['phone'];?>  &nbsp;<br />
			 <i class="fa fa-map-marker"></i> <?= $show['city'];?>,<?= $show['state'];?>
			 </td></tr>
			</table>
			
			
			
		   </div>
		   </div>
		<div class="panel-default">
           <div class="panel-body">
		    <h3>Edit Review</h3>
 	       <?php if (isset($errMSG)) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>	
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">	
				
	
<div class="vali-form">
 <div class="col-md-6 form-group2">
 <label class="control-label"> Rating </label>
<select name="rating">
<option value="5" <?php if($rating=='5'){ echo 'selected="selected"';}?>>Excellent (5 Stars)</option>
<option value="4" <?php if($rating=='4'){ echo 'selected="selected"';}?>>Good (4 Stars)</option>
<option value="3" <?php if($rating=='3'){ echo 'selected="selected"';}?>>Average (3 Stars)</option>
<option value="2" <?php if($rating=='2'){ echo 'selected="selected"';}?>>Bad (2 Stars)</option>
<option value="1" <?php if($rating=='1'){ echo 'selected="selected"';}?>>Very Bad (1 Star)</option>
</select>
</div>

 <div class="clearfix"> </div>
 </div>
 
 <div class="vali-form">
 <div class="col-md-12 form-group2">
 <label class="control-label"> Review </label>
 <textarea class="ckeditor" cols="40" id="pitch_message" name="review" rows="10"><?php echo $review;?></textarea>
</div>

 <div class="clearfix"> </div>

 </div>	
 
 
 <div class="vali-form">
 <div class="col-md-6 form-group2">
 <label class="control-label"> Status </label>
<select name="status">
<option value="1" <?php if($status=='1'){ echo 'selected="selected"';}?>>Active</option>
<option value="0" <?php if($status=='0'){ echo 'selected="selected"';}?>>Inactive</option>
</select>
</div>

 <div class="clearfix"> </div>
 </div>
 	
<div class="col-md-12 form-group button-2">
<input type="hidden" name="id" value="<?php echo $id;?>">
<button type="submit" class="btn btn-primary" name="save">Save</button>
</div>
<div class="clearfix"> </div>
</form>

 </div>
</div>       
 
 </div>
</div>

<?php include('includes/footer.php');?>
<?php include('includes/menu.php');?>
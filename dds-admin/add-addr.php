<?php require_once 'common.php'; 


  $sql1 = "SELECT * FROM `logo` ORDER BY `logo`.`id` ASC";
				  $query1 = $conn->query($sql1);
				$row = $query1->fetch_array();
				$fid=$row['id'];
        $address_1=$row['address_1'];
        $address_2=$row['address_2'];
        $address_3=$row['address_3'];
       $address_4=$row['address_4'];


		
						
$error = false;


	

	if ( isset($_POST['btn-signup']) && !empty($_POST['fid'])) {
		
    $fid = $conn -> real_escape_string($_POST['fid']);
    $address_1 = $conn -> real_escape_string($_POST['address_1']);
    $address_2 = $conn -> real_escape_string($_POST['address_2']);
    $address_3 = $conn -> real_escape_string($_POST['address_3']);
    $address_4 = $conn -> real_escape_string($_POST['address_4']);
	    echo $query="UPDATE logo SET
			address_1='$address_1',address_2='$address_2',address_3='$address_3',address_4='$address_4'
			WHERE id='$fid' limit 1 ";
      $res = $conn->query($query);
      // exit;
			if ($res) {
			header("location:add-addr.php");
			}
		}
	
include('includes/head.php');
include('includes/header.php');?>
<script>
    CKEDITOR.replace('editor', {
      fullPage: true,
      extraPlugins: 'docprops',
      // Disable content filtering because if you use full page mode, you probably
      // want to  freely enter any HTML content in source mode without any limitations.
      allowedContent: true,
      height: 320
    });
  </script>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Add Address </li>
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
              <label class="control-label">About left</label>
            
              
			     <textarea name="address_1" id="editor"  class="form-control ckeditor" rows="5"  cols="40"><?= $address_1;?></textarea>
            </div>
            <div class="clearfix"> </div>
            </div>
			
            <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Information</label>
            
              
			     <textarea name="address_2" id="editor"  class="form-control ckeditor" rows="5"  cols="40"><?= $address_2;?></textarea>
            </div>
            <div class="clearfix"> </div>
            </div>
			
            <!-- <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Services</label>
            
              
			     <textarea name="address_3" id="editor"  class="form-control ckeditor" rows="5"  cols="40"><?= $address_3;?></textarea>
            </div>
            <div class="clearfix"> </div>
            </div>
			
            <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Have a Questions?</label>
            
              
			     <textarea name="address_4" id="editor"  class="form-control ckeditor" rows="5"  cols="40"><?= $address_4;?></textarea>
            </div>
            <div class="clearfix"> </div>
            </div> -->
			
			
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
	
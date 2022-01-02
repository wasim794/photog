<?php require_once 'common.php'; 
$tech_id='';
$reason = '';
$coin = '';
$type= '';
$userError = '';
$coinError = '';
$rError = '';
$id =''; 
 if(isset($_REQUEST['id']) && !empty($_REQUEST['id']) ) {
 $id = $_REQUEST['id'];
  $sql1 = "select * from credit where id='$id'";
  $query1 = $conn->query($sql1);
  $row = $query1->fetch_array();
  $tech_id=$row['tech_id'];
  $type=$row['type'];	
  $reason=$row['reason'];	
  $coin= str_replace('-','',$row['coin']);;  	
 }					
   
  $error = false;
	if(isset($_POST['btn-signup']) && empty($_POST['id']) ) {

		$tech_id = trim($_POST['tech_id']);
		$coin = trim($_POST['coin']);
		$reason = trim($_POST['reason']);
		$type = trim($_POST['type']);
        
		if($type=='Penalty'){$coins = '-'.$coin;}else {$coins = $coin;}
		if(empty($tech_id)){$error = true;	$userError = "Please select technician id .";	} 
		if(empty($coin)){$error = true;$coinError = "Please enter  Credit Amount.";	}
		if(empty($reason)){$error = true;$rError = "Please enter Particular.";	}
 				
		if( !$error ) {			
			$query = "INSERT INTO credit(tech_id,coin,type,reason) VALUES('$tech_id','$coins','$type','$reason')";
			$res = $conn->query($query);
			
			if($res){ header("location:view-credit.php");}
			else { $errTyp = "danger"; $errMSG = "Something went wrong, try again later...";}	
		}
	}
	
	if ( isset($_POST['btn-signup']) && !empty($_POST['id']) ) {	
		$tech_id = trim($_POST['tech_id']);
		$coin = trim($_POST['coin']);
		$reason = trim($_POST['reason']);
		$type = trim($_POST['type']);
        
		if($type=='Penalty'){$coins = '-'.$coin;}else {$coins = $coin;}
		if(empty($tech_id)){$error = true;	$userError = "Please select technician id .";	} 
		if(empty($coin)){$error = true;$coinError = "Please enter  Credit Amount.";	}
		if(empty($reason)){$error = true;$rError = "Please enter Particular.";	}
	 
	 	if(!$error ) {
		  $query="UPDATE credit SET tech_id='$tech_id',coin='$coins', type='$type', reason='$reason' WHERE id='$id' limit 1 ";
		  $res = $conn->query($query);
				
		  if ($res) { header("location:view-credit.php");}
		  else { $errTyp = "danger"; $errMSG = "Something went wrong, try again later..."; }	
		}
	}
 include('includes/head.php');
include('includes/header.php');?>
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Credit/Debit Wallet</li>
            </ol>
		
 	<div class="validation-system">
	<div class="w3l-table-info">
	 <div class="col-lg-9">
					  <h2>Credit/Debit Wallet</h2>
					  </div>
					   <div class="col-lg-3"> <button onclick="history.go(-1);" class="btn btn-warning pull-right"> Back <i class="fa fa-reply"></i></button></div>
					    <div class="clearfix"> </div>
					   </div> 	
 <div class="clearfix"> </div>
					   
 	<div class="validation-form">
        <?php if ( isset($errMSG) ) { ?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php } ?>			
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">
			
         	
			<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">Technician Id/Name</label>
             <select name="tech_id" id="combobox" class="form-control">
			  <option value="">Select Any One</option>
			  <?php $sql = $conn->query("select name, id,phone from technician order by id asc");
			      while($row=$sql->fetch_array()){
				  ?>
			  <option value="<?= $row['id'];?>"  <?php if($tech_id==$row['id']){ echo 'selected="selected"';}?>><?php echo $row['name'].' ('.$row['phone'].')';?></option>
			<?php }?>
			  </select>		 
			   <span class="text-danger"><?php echo $userError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-6 form-group2">
              <label class="control-label">Transaction</label>
              <select name="type">
 		<option value="Credit" <?php if($type=='Credit'){ echo 'selected="selected"';}?>>Credit</option>
		<option value="Penalty" <?php if($type=='Penalty'){ echo 'selected="selected"';}?>>Penalty</option>
		</select>			 
             </div>
            <div class="clearfix"> </div>
            </div>
			
            <div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label"> Amount</label>
              <input type="text" name="coin" value="<?php echo $coin; ?>" onKeyUp="checkInput(this)"/>			 
			   <span class="text-danger"><?php echo $coinError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			
			<div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">Reason/Particular</label>
              <input type="text" name="reason" value="<?php echo $reason; ?>" />			 
			   <span class="text-danger"><?php echo $rError; ?></span>
            </div>
            <div class="clearfix"> </div>
            </div>
			
           <input type="hidden" name="id" value="<?php echo $id;?>">
          
            <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary"  name="btn-signup"><i class="fa fa-save"></i> Save</button>
              <button type="reset" class="btn btn-default">Reset</button>
            </div>
          <div class="clearfix"> </div>
        </form>
 </div>

</div>
<?php include('includes/footer.php');?>
<?php include('includes/menu.php');?>

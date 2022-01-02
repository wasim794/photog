<html>
    
    <body>
        <?php
        require_once 'common.php';
        require_once 'dbconnect.php';
       // header('Content-Type: application/json');
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');
       
        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';
        
        $serviceError ='';
        $firebase = new Firebase();
        $push = new Push();
        date_default_timezone_set('Asia/Kolkata');
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        $date=date('Y-m-d H:i:s');
        // notification title
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $service = isset($_GET['service']) ? $_GET['service'] : '';
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        if (isset($_GET['btn-signup'])) {
        //echo $title . $message . $service; die;
        // push type - single user / topic
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
        
        // whether to include to image or not
        $include_image = isset($_GET['include_image']) ? TRUE : FALSE;
        
        
		    $query1 = $conn->query("select technician.id, technician.service  from technician inner join approval on technician.id=approval.technician_id where technician.status='1' and approval.status='Approved'  order by technician.id asc");
 while($data = $query1->fetch_array()){
    $tech_id = $data['id'];
	$service1 = explode(',',$data['service']);
	$services = array_map('trim', $service1);
 	 
   
    
		     if(in_array($service,$services)){ 
	            
                   
                    $post = array('title'=>$title,'message'=>$message,'login_id'=>$tech_id);
                    $ch = curl_init('https://delhidailyservice.com/api/sendSinglePush.php');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_ENCODING,"");
                   // header('Content-Type: text/html');
                    $data = curl_exec($ch);
                    
                    
                 
	            
	        }
	    
    //	header('location:notification.php');
 }	
 $query = "INSERT INTO notification(title,message, date,service_type,read_count)
    VALUES('$title','$message', '$date','$service','no')";
    $resultt=mysqli_query($conn,$query);
        }
        include('includes/head.php');
        include('includes/header.php');
        ?>
        
       
        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a><i class="fa fa-angle-right"></i>Notification</li>
            </ol>
            
        <div class="container">
            
<div class="col-lg-9">
					  <h2>Send Notification</h2>
					  </div>
					  <div class="clearfix"> </div>
					  
					  
            <form class="pure-form pure-form-stacked" method="get">
                

<div class="col-md-6">
<div class="form-group">
<label for="Industry" class="ilable1"><strong>Service </strong></label>
<select name="service" class="form-control"  id="service">
	<option value="">-- Select Service --</option>	
<?php  $sql1 = "select sub from subcategory order by sub asc";
				  $query1 = $conn->query($sql1);
				  while($row = $query1->fetch_array()){
 				  ?>
			 	 <option value="<?php echo $row['sub'];?>" <?php if($row['sub']==$service){ echo 'selected="selected"';}?>>
				 <?php echo $row['sub'];?> </option>
			  <?php  }?> 
</select>
<!--<span class="text-danger"><?php echo $stateError; ?></span>-->
</div>
</div>
<div class="clearfix"> </div>
                <fieldset>
                    <div class="col-md-6 form-group1">
              <label class="control-label"> Title</label>
                    <input type="text" id="title1" name="title" class="pure-input-1-2" placeholder="Enter title">
</div>
            <div class="clearfix"> </div>
            <div class="col-md-6 form-group1">
                    <label for="message1">Message</label>
                    <textarea class="pure-input-1-2" name="message" id="message1" rows="5" placeholder="Notification message!"></textarea>
</div>
            <div class="clearfix"> </div>
                    <input type="hidden" name="push_type" value="topic"/>
                    <button type="submit" class="btn btn-primary" name="btn-signup">Submit</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>
<?php include('includes/footer.php');?>
<?php include('includes/menu.php');?>

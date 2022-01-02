<?php
date_default_timezone_set('Asia/Calcutta');
 include 'dbconnect.php';
 $date = date('Ymd',strtotime($_GET['date']));
 $today = date('Ymd');
 $time = date('h:i A');
 $time = date('h:i A', strtotime('+1 hour')); // syntax OK
 
 $zone = date('A', strtotime($time));
 $hour = date('h', strtotime($time));
if($date>$today){
echo '<option value="09:00 To 10:00 AM">09:00 To 10:00 AM</option> 
      <option value="10:00 To 11:00 AM">10:00 To 11:00 AM</option> 
      <option value="11:00 To 12:00 AM">11:00 To 12:00 PM </option>    
 	  <option value="12:00 To 1:00 PM">12:00 To 1:00 PM</option>  
 	  <option value="1:00 To 2:00 PM">1:00 To 2:00 PM</option>
	  <option value="2:00 To 3:00 PM">2:00 To 3:00 PM </option>  
	  <option value="3:00 To 4:00 PM">3:00 To 4:00 PM</option>   
	  <option value="4:00 To 5:00 PM">4:00 To 5:00 PM </option>    
	  <option value="5:00 To 6:00 PM">5:00 To 6:00 PM </option>   
	  <option value="6:00 To 7:00 PM">6:00 To 7:00 PM</option>    
	  <option value="7:00 To 8:00 PM">7:00 To 8:00 PM</option> ';
}
else{
	if($zone=='PM'){
	    if($hour>=20){
	        echo "no time slot available";
	    }
	    else
	    {
	    if($hour=='12'){$hour=0;}
	    for($i=$hour+1;$i<=7;$i++){ $k = $i+1;
	    echo '<option value="'.$i.':00 To '.$k.':00 PM">'.$i.':00 To '.$k.':00 PM</option>';
	    }
	    }
	}
	else{
	    $dd= 	'<option value="12:00 To 1:00 PM">12:00 To 1:00 PM</option>  
 							<option value="1:00 To 2:00 PM">1:00 To 2:00 PM</option>
							<option value="2:00 To 3:00 PM">2:00 To 3:00 PM </option>  
							<option value="3:00 To 4:00 PM">3:00 To 4:00 PM</option>   
							<option value="4:00 To 5:00 PM">4:00 To 5:00 PM </option>    
							<option value="5:00 To 6:00 PM">5:00 To 6:00 PM </option>   
							<option value="6:00 To 7:00 PM">6:00 To 7:00 PM</option>    
							<option value="7:00 To 8:00 PM">7:00 To 8:00 PM</option> ';
	     if($hour=='10'){echo '<option value="11:00 To 12:00 AM">11:00 To 12:00 PM </option>'.$dd; }
	    else if($hour==9){echo '<option value="10:00 To 11:00 AM">10:00 To 11:00 AM</option>     
 					<option value="11:00 To 12:00 AM">11:00 To 12:00 AM </option>'.$dd; }
 		else if($hour<9){echo '<option value="09:00 To 10:00 AM">09:00 To 10:00 AM</option><option value="10:00 To 11:00 AM">10:00 To 11:00 AM</option>     
 					<option value="11:00 To 12:00 AM">11:00 To 12:00 AM </option>'.$dd; }   			
	        
	     
	}   
	    }
	    
							
    
?>
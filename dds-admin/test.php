<?php require_once 'common.php'; 
function location($place,$l){
 $details_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$place."&sensor=false&key=AIzaSyBcQ6g445mNn36hHmfWHA2ZUvLLyOoJ64k";

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $details_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $geoloc = json_decode(curl_exec($ch), true);

   $step1 = $geoloc['results'];
   $step2 = $step1['geometry'];
   $coords = $step2['location'];
   $lat= $geoloc['results'][0]['geometry']['location']['lat'];
   $lon= $geoloc['results'][0]['geometry']['location']['lng'];
   if($l=='lat'){return $lat; }
   else{return $lon; }
 }


$address ='Hari Nagar part 2 e block gali no 9 house no 34';
$city = 'new delhi';

  $place =  str_replace(' ','%20',$address).'%20'. str_replace(' ','%20',$city);
   
  $lat= location($place,'lat'); 
  $lon= location($place,'lon');
   
   $ser =', App Development';
   $ser1 = explode(',',$ser);
   $size = sizeof($ser1);
    
    $query = $conn->query("select technician.id,technician.name,technician.phone,technician.state,technician.city,technician.address,technician.pincode,technician.service from technician inner join approval on technician.id=approval.technician_id where technician.status='1'    order by technician.id asc");
 while($data = $query->fetch_array()){ 
    $id = $data['id'];
 	$name = $data['name'];  
	$phone = $data['phone'];
	$state = $data['state'];
	$city = $data['city'];
	$address = $data['address'];
	$pincode = $data['pincode'];
	$service = explode(',',$data['service']);
	$services = array_map('trim', $service);
	$count = sizeof($service);
    
    $tplace=   str_replace(' ','%20',$address).'%20'. str_replace(' ','%20',$city). str_replace(' ','%20',$state);
     
   $s='';
	for($i=0;$i<=$size;$i++){ 
	    if(!empty($ser1)){ $s=trim($ser1[$i]);
	         if(in_array($s,$services)){ 
	            $tlat= location($tplace,'lat'); 
	            $tlon= location($tplace,'lon');
	            $url ='https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$lat.','.$lon.'&destinations='.$tlat.','.$tlon.'&key=AIzaSyBcQ6g445mNn36hHmfWHA2ZUvLLyOoJ64k';
 
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $geoloc = json_decode(curl_exec($ch), true);
                $distance = str_replace('mi','',$geoloc['rows'][0]['elements'][0]['distance']['text']);
                 $distance = trim($distance);
                 if($distance<=15){ echo $id;
                   
                    $post = array('title'=>'You Get A New Lead','login_id'=>$id);
                    $ch = curl_init('https://delhidailyservice.com/api/sendSinglePush.php');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_ENCODING,"");
                    header('Content-Type: text/html');
                    $data = curl_exec($ch);
                    
                    $query = "INSERT INTO lead(lead_id,tech_id,status)VALUES('$lead_id','$id','0')";
			        $res = $conn->query($query);
                 }
	            break;
	        }
	    }
	}
 }
  
 
?>

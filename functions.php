<?php
//error_reporting('0');
session_start();
//-- 1. database details --//
$servername='localhost';
$username='root';
$password='';
$dbname='u656619655_delhiserv';
// include $inclufile."/load_admin.php";
//-- 2. time zone settings --//

//date_default_timezone_set("Asia/Calcutta"); 
if(isset($_COOKIE['timezone'])) {
  $datetime=date_default_timezone_set($_COOKIE['timezone']);
}

//--   3.   Connect the data base        --//

function connectsql()
{
// creat connection
global $servername,$username,$password,$dbname;
global $conn;
$conn=new mysqli($servername,$username,$password,$dbname);

// check connection 
if($conn->connect_error)
{
	echo $conn->connect_error;
	die("<div class=isa_error  id=myEr ><h3><b>Error</b>: Unable to connect database</h3></div>");
}

}

connectsql();

//-- 2. Delete user --//
function delete_user($emailtoload)
{
connectsql();
$table=	'ttg_login';
global $conn;
$sql="DELETE FROM $table WHERE (email='$emailtoload' OR id='$emailtoload')";
$result=$conn->query($sql);
// print_r($result);
log_acivity('delete','','user',$emailtoload);
return $result;	


}


function deletepost($id)
{
    
    if($post=getpost_byuid($id))
{
//    $j=1;
if($single=json_decode($post['files'],true))
{
foreach($single as $photo )
{
     foreach($photo as $key=>$psd)
   {
     $j=  substr($key, 4);
    // break;
     //  $qw[$r]=$psd;
     //  $r=$r+1;
   }
unlink($photo['file'.$j]);
//$j++;
}

}

}
connectsql();
$table=	'ttg_post';
global $conn;
$sql="DELETE FROM $table WHERE id='$id'";
$result=$conn->query($sql);
log_acivity('delete',$id,'post','');
return $result;	

}



//-- 2. load admin --//
function load_admin($emailtoload)
{
connectsql();
$table=	'ttg_login';
global $conn;
$sql="SELECT * FROM $table WHERE email='$emailtoload' OR id='$emailtoload'";
$result=$conn->query($sql);
$retuser=$result->fetch_assoc();
return $retuser;	
}


//-- 2. load users--//
function load_users($query,$type='',$country='')
{
connectsql();
$table=	'ttg_login';
global $conn;

$sql="SELECT * FROM $table WHERE country LIKE '%$country' AND (type LIKE '%$type' AND (name LIKE '%$query%' OR email LIKE '%$query%'OR id LIKE '%$query%'OR country LIKE '%$query%' OR mobile LIKE '%$query%'))";
$result=$conn->query($sql);
//die($sql.$conn->error);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
}

function search_data_byuserid($id)
{
connectsql();
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM ttg_post WHERE  userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND (userid='$id' OR uid = '$id'  OR crn='$id') ORDER BY time DESC";

if($_SESSION['type']=='superadmin')
{
$sql="SELECT * FROM ttg_post WHERE  userid IN (SELECT id FROM ttg_login WHERE lower(country) LIKE lower('$id')) OR (userid='$id' OR uid = '$id'  OR crn='$id') ORDER BY time DESC";
}
$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
}


function search_data_main($id,$limit=0)
{
connectsql();
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$exp=explode(",",$id);
$exp= array_map('test_input',$exp);
$exp= array_filter($exp,'remove_empty');
$id_c=reset($exp);
$exp= array_map('add_colon',$exp);

$imp=implode(",",$exp);
$id=$imp;
if(count($exp)==0)
{
    return false;
}
if(count($exp)==1)
{
    
}
else 
{
  $id_c  =time();
}
$sql="SELECT ttg_post.*,ttg_login.country FROM ttg_post INNER JOIN ttg_login ON ttg_post.userid = ttg_login.id WHERE (ttg_login.country LIKE '%$country') AND (ttg_post.userid IN ($id) OR ttg_post.uid IN ($id)  OR ttg_post.crn IN ($id) ) ORDER BY ttg_post.time DESC";

if($_SESSION['type']=='superadmin')
{
$sql="SELECT ttg_post.*,ttg_login.country FROM ttg_post INNER JOIN ttg_login ON ttg_post.userid = ttg_login.id  WHERE (ttg_login.country LIKE '%$id_c') OR (ttg_post.userid IN ($id) OR ttg_post.uid IN ($id)  OR ttg_post.crn IN ($id) ) ORDER BY ttg_post.time DESC";
}

if(is_numeric($limit) && $limit!=0)
{
    $sql=$sql." LIMIT ".$limit;
}
 $result=$conn->query($sql);
$row_cnt = $result->num_rows;
if($row_cnt)
{
While($retuser[]=$result->fetch_assoc())
{}
    
}
else
{
    return false;
}


return $retuser;
}

function search_data_assetid($id)
{
connectsql();
global $conn;
$sql="SELECT * FROM ttg_post WHERE (uid = '$id' )";

$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
}


function banners()
{
connectsql();
global $conn;
$sql="SELECT * FROM slider";

$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
print_r($result);
}


function Categorys()
{
connectsql();
global $conn;
$sql="SELECT * FROM category where status='1'";

$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
print_r($result);
}
//print_r(banners());


function SubCategorys()
{

connectsql();
global $conn;
echo $id= $_SESSION['id'];
$sql="SELECT * FROM category where cid='$id' and status='1'";
$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}
//header('Location: subcategories.php');
return $retuser;

}
//print_r(SubCategorys());

function wearenow()
{
connectsql();
global $conn;
$sql="SELECT * FROM about where nid=6";

$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
//print_r($result);
}


function directionsections()
{
connectsql();
global $conn;
$sql="SELECT * FROM about where nid=1 or nid=8 or nid=9 or nid=10";

$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
print_r($result);
}

function directionsectionsimg()
{
connectsql();
global $conn;
$sql="SELECT * FROM about where nid=1";

$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
print_r($result);
}

function search_data_bydate($startdate,$enddate)
{
connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
// $sql="SELECT * FROM ttg_post WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND ( time BETWEEN '$startdate' AND '$enddate') ORDER BY time DESC";
$sql="SELECT ttg_post.*,ttg_login.country FROM ttg_post INNER JOIN ttg_login ON ttg_post.userid = ttg_login.id  WHERE ttg_login.country LIKE '%$country'  AND ( ttg_post.time BETWEEN '$startdate' AND '$enddate') ORDER BY ttg_post.time DESC";

$result=$conn->query($sql);
// echo "Error: " . $sql . "<br>" . $conn->error;
//die($sql1.$conn->error);
While($retuser[]=$result->fetch_assoc())
{}
//die($sql1.$conn->error);
return $retuser;
}










//-- 3. Get user by token  --//
function getuser_bytoken($token)
{
connectsql();
$table=	'ttg_login';
global $conn;
$sql="SELECT * FROM $table WHERE token='$token'";
$result=$conn->query($sql);
$retuser=$result->fetch_assoc();
	if(isset($retuser['profile_pic']))
	{
$retuser['profile_pic']="/".$retuser['profile_pic']."?ref=".random_strings();
}
return $retuser;
}

//-5. update token --//
function update_token($userid)
{
$ntoken=generate_token($userid);
connectsql();
$table=	'ttg_login';
global $conn;
global $gate;
$device=$gate['device'] ?? "unknown";
$sql="UPDATE $table SET token='$ntoken', device='$device' WHERE email='$userid'";
$result=$conn->query($sql);
return $ntoken;	
}

//-5. update jason --//
function update_desc($uid,$json)
{


    if($post=getpost_byuid($uid))
{
  //  $j=1;
if($single=json_decode($post['files'],true))
{
  $newjson=$single;
foreach($single as $key=> $photo )
{
     foreach($photo as $ekey=>$psd)
   {
     $j=  substr($ekey, 4);
     //  $qw[$r]=$psd;
     //  $r=$r+1;
   }
$newjson[$key]['desc'.$j]=$json['desc'.$j];
//$j++;
}
}
}
$newjson=json_encode($newjson);
connectsql();
$table= 'ttg_post';
global $conn;
$sql="UPDATE $table SET files='$newjson' WHERE uid='$uid'";
$result=$conn->query($sql);
log_acivity('update',$uid,'post','');
return $result;
}
//-6. generate token --//
function generate_token($userid)
{
$werd=array($userid,time(),rand());
$token=base64_encode(json_encode($werd));
return $token;
}

//-7. code written by Wasim Akram --//
function delete_image_file($uid,$json,$fileRemoveIndex)
{
  $result = null;
  if($post=getpost_byuid($uid))
  {
    if($single=json_decode($post['files'],true))
    {
      if($fileRemoveIndex > 0){
        $fileRemoveIndex = $fileRemoveIndex - 1;//to convert into array index
        unset($single[$fileRemoveIndex]);

        $newjson=json_encode($single);
        connectsql();
        $table= 'ttg_post';
        global $conn;

        $sql="UPDATE $table SET files='$newjson' WHERE uid='$uid'";
        $result=$conn->query($sql);
        log_acivity('update',$uid,'post','');
      }
    }
  }  
  return $result;
}


function verify_Status($uid,$verifyStatus)
{
  // echo $verifyStatus;
  // echo $uid;
        connectsql();
        $table= 'ttg_post';
        global $conn;

        $sql="UPDATE $table SET verifyStatus='$verifyStatus' WHERE (uid='$uid')";
        $result=$conn->query($sql);
// While($retStatus[]=$result->fetch_assoc())
// {}
 return $result;
      }


function add_Objection($uid,$objection)
{
connectsql();
$time_stamp= time();
global $conn;
connectsql();
        $table= 'ttg_post';
        global $conn;

       $sql="UPDATE $table SET objectionContent='".$objection["objectionContent"]."', objectionRecords='".$objection["vedioUrl"]."',datetimes=NOW() WHERE (uid='$uid')";
        $result=$conn->query($sql);
        $sql="SELECT * FROM $table WHERE uid='$uid'";
$result=$conn->query($sql);
$retuser=$result->fetch_assoc();
if(($_SESSION['type']=='admin') OR ($_SESSION['type']=='superadmin' ))
  {
    $alluseradmin = $_SESSION['type'];
  }else{
   //$allusersusers = $_SESSION['type'];
  }
$sql1="INSERT INTO ttg_chate set orderID='".$retuser['uid']."',customerID='".$_SESSION['userid']."', adminID='".$alluseradmin."', messegeAll='".$objection["objectionContent"]."', objectionRecords='".$objection["vedioUrl"]."', RecordTime=NOW()";
  $result=$conn->query($sql1);
}


function add_Objection_status($uid)
{
  $time_stamp= time();
global $conn;
connectsql();
        $table= 'ttg_post';
        global $conn;
  $sql="select * from  $table  WHERE uid='$uid'";
 $result=$conn->query($sql);
$retStatus=$result->fetch_assoc();
if($retStatus['verifyStatus']==0)
{
$Obtext='Add objection';
    
}
else
{
  $Obtext='Re-Add objection';
}
return $Obtext;
}





// function search_data_assetid($id)
// {
// connectsql();
// global $conn;
// $sql="SELECT * FROM ttg_post WHERE (uid = '$id' )";

// $result=$conn->query($sql);
// While($retuser[]=$result->fetch_assoc())
// {}

// return $retuser;
// }


function add_file($file,$user)
{
connectsql();
$time_stamp= time();
global $conn;
$userid=$user['id'];
$filename=$file['name'];
$file_location=$file['location'];
$file_desc=$file['file_desc'];
$uid=$file['uid'];
$sql1="	INSERT INTO ttg_files(userid,filename, time,location,uid,file_desc )
	VALUES ('$userid','$filename','$time_stamp','$file_location','$uid','$file_desc')";
	$result=$conn->query($sql1);
}


function add_post($response)
{
connectsql();
$time_stamp= time();
global $conn;
$defect=$response['defect'];
$device_type=$response['device_type'];
$userid=$response['user']['id'];
$uid=$response['uid'];
$crn=$response['crn'];
$device=$response['user']['device'];
$files=json_encode($response['files_accepted']);
$description=$response['files_desc'];
$sql1="	INSERT INTO ttg_post(userid,files, time,description,uid,crn,device,defect,device_type)
	VALUES ('$userid','$files','$time_stamp','$description','$uid','$crn','$device','$defect','$device_type')";
	$result=$conn->query($sql1);
	log_acivity('add',$uid,'post','');
//	die($sql1.$conn->error);
}


//-- 3. Get post by user  --//
function getpost_byuser($userid)
{
connectsql();
$table=	'ttg_post';
global $conn;
$sql="SELECT * FROM $table WHERE userid='$userid'";
$result=$conn->query($sql);
$retuser=$result->fetch_assoc();
return $retuser;	
}

//-- 3. Get post by user  --//
function getpost_byuid($uid)
{
connectsql();
$table=	'ttg_post';
global $conn;
$sql="SELECT * FROM $table WHERE uid='$uid'";
$result=$conn->query($sql);
$retuser=$result->fetch_assoc();
return $retuser;	
}



function add_user($user)
{
connectsql();
$profile_pic=$user['profile_pic'];
$time_stamp= time();
$id=$user['id'];
$email=$user['email'];
$type=$user['type'];
$country=$user['country'];
$mobile=$user['mobile'];
$pass=$user['pass'];
$firstname=$user['firstname'];
$lastname=$user['lastname'];
$token=generate_token($email);
$name=$firstname." ".$lastname;
global $conn;
if(isset($user['update']))
{
    $sql1="	UPDATE ttg_login SET name='$name',pass='$pass',token='$token',country='$country',mobile='$mobile',profile_pic='$profile_pic' WHERE email='$email'";
    
    if(isset($user['id']))
{
    $sql1="	UPDATE ttg_login SET name='$name',pass='$pass',country='$country',mobile='$mobile', email='$email', profile_pic='$profile_pic'  WHERE id='$id'";
    	
}
    	
}
else
{
$sql1="	INSERT INTO ttg_login(name,email,pass,type,time,firstname,lastname,token,country,mobile )
	VALUES ('$name','$email','$pass','$type','$time_stamp','$firstname','$lastname','$token','$country','$mobile')";

}
	$result=$conn->query($sql1);
//	die($sql1.$conn->error);
	$act='add';
	if(isset($_POST['update']))
	{
	    $act='update';
	}
log_acivity($act,'','user',$email);

}


function random_strings($length_of_string=8) 
{ 
  
    // String of all alphanumeric character 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
    // Shufle the $str_result and returns substring 
    // of specified length 
    return substr(str_shuffle($str_result),  
                       0, $length_of_string).rand(0,9); 
} 

function errors_add_user($user)
{
    /** 1. validate email **/

$email = test_input($user["email"]);

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $Err[] = "Please enter a valid email address";
}

/** check dublicate email **/

$users=load_admin($email);
if(isset($users['email']))
{
    if(!isset($user['update']))
    {
    $Err[]="Email id Already Exists !";
    }
}else if(isset($user['update']))
    {
        if(!isset($user['id']))
        {
    $Err[]="Email id does not exist to update data!";
        }
    }
/**2. Validate Password **/
if((!ctype_alnum($user['pass'])) OR (strlen( $user['pass'])<8)) {
     $Err[] = "Please enter alphanumeric password of minimum 8 characters !" ;
  //   print_r($user);
     
} 
 
/** 3 . Validate Name **/
if(!$user['firstname'])
{
   $Err[] = "Please enter Name";  
}

return $Err;
    
}





function errors_search_user($user)
{
    /** 1. validate email **/

$email = test_input($user["email"]);

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $Err[] = "Please enter a valid email address";
}

return $Err;
    
}



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace('', '', $data);
  return $data;
}

function add_colon($data) {
  $data = str_replace("'", '', $data);
  $data = str_replace("pdfdownload", '', $data);
  $data="'".$data."'";
  return $data;
}

function attachment_size($data)
{
    $size=0;
    foreach($data as $fr)
    {
        
      $ed=  unified(json_decode($fr['files'],true));
      foreach($ed as $rf)
      {
          $size=filesize($rf['file'])+$size;
      }
    }
    return $size;
    
}

function remove_empty($data) {
  if($data!="")
  {
      return true;
  }
  else
  {
      return false;
  }
}

//-- . get uids    --//
function getuids_bycrn($crn)
{
connectsql();
$table= 'ttg_post';
global $conn;
$sql="SELECT uid FROM $table WHERE crn='$crn'";
$result=$conn->query($sql);
While($retuser[]['uid']=$result->fetch_assoc()['uid'])
{

}
array_pop($retuser);
return $retuser;  
}


// 21. add crn 
function add_crn($crn,$userid)
{
connectsql();
$time_stamp= time();
global $conn;
//$userid=$user['id'];
$sql1=" INSERT INTO ttg_crn(userid,crn,time,name,detail1,detail2 )
  VALUES ('$userid','$crn','$time_stamp','','','')";
  $result=$conn->query($sql1);
//  die($sql1.$conn->error);
}
 //22. get crns
function get_crn($userid)
{
connectsql();
$table= 'ttg_crn';
global $conn;
$sql="SELECT crn FROM $table WHERE userid='$userid'";
$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc()['crn'])
{}
return $retuser;  
}

//23. remove crns 
function remove_crn($crn,$userid)
{
connectsql();
$table= 'ttg_crn';
global $conn;
$sql="DELETE FROM $table WHERE (userid='$userid' AND crn='$crn')";
$result=$conn->query($sql);

return $result; 

}


//24. change to super 
function crn_super($userid)
{

connectsql();
$table= 'ttg_login';
global $conn;
$sql="UPDATE $table SET crn_status='super' WHERE (id='$userid' AND type='client')";
$result=$conn->query($sql);
return $result;
}

//25. chnage to normal 
function crn_normal($userid)
{

connectsql();
$table= 'ttg_login';
global $conn;
$sql="UPDATE $table SET crn_status='normal' WHERE (id='$userid' AND type='client')";
$result=$conn->query($sql);
return $result;
}

//25. chnage to normal 
function crn_national($userid)
{

connectsql();
$table= 'ttg_login';
global $conn;
$sql="UPDATE $table SET crn_status='national' WHERE (id='$userid' AND type='client')";
$result=$conn->query($sql);
return $result;
}

// 26. get crn status 
function crn_status($userid)
{

connectsql();
$table= 'ttg_login';
global $conn;
$sql="SELECT crn_status FROM $table WHERE (id='$userid' AND type='client')";
$result=$conn->query($sql);
$retuser=$result->fetch_assoc()['crn_status'];
return $retuser;
}
// 27. authenticate crn

function auth_crn($userid,$crn)
{
if(crn_status($userid)=='super')
{
  return $crn;
}
connectsql();
$table= 'ttg_crn';
global $conn;
$sql="SELECT crn FROM $table WHERE (userid='$userid' AND crn='$crn')";

if(crn_status($userid)=='national')
{
 $country=load_admin($userid)['country'];
 $sql="SELECT crn FROM ttg_post WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND (crn = '$crn' )"; 
}
$result=$conn->query($sql);
$retuser=$result->fetch_assoc()['crn'];
if($retuser!='')
{
return $retuser;
}
}

// 28. search data crn 
function search_data_crn($crn,$userid)
{

$exp=explode(",",$crn);
$exp= array_map('test_input',$exp);
$exp= array_filter($exp,'remove_empty');
$exp= array_map('add_colon',$exp);
if(!count($exp))
{
  return false;
}
$imp=implode(",",$exp);
$crn=$imp;
connectsql();
global $conn;
$country=load_admin($userid)['country'];

$sql="SELECT ttg_post.* FROM ttg_post LEFT JOIN ttg_crn ON ttg_post.crn = ttg_crn.crn WHERE (ttg_post.crn IN ($crn) )  AND ( ( ttg_crn.userid = '$userid') OR ( (ttg_post.userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') ) AND ('national' IN (SELECT crn_status FROM ttg_login WHERE id = '$userid') ) )OR ('super' IN (SELECT crn_status FROM ttg_login WHERE id = '$userid')) ) LIMIT 2000";
$result=$conn->query($sql);

While($retuser[]=$result->fetch_assoc())
{}
return $retuser;
/**
  if(auth_crn($userid,$crn))
  {
    connectsql();
global $conn;
$sql="SELECT * FROM ttg_post WHERE (crn = '$crn' )";

$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;

  }
  else
  {
    return false; 
  }
**/
}
 // 29 pass change 
 
 function errors_add_user_1($user)
{
    /** 1. validate email **/

$email = test_input($user["email"]);

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $Err[] = "Please enter a valid email address";
}

/** check dublicate email **/

$users=load_admin($email);
$current_email=load_admin($user['id'])['email'];
if(isset($users['email']))
{
  if($users['email']==$current_email)
  {

  }
  else
  {
    $Err[]="Email id already exists!";
  }
   
}
/**2. Validate Password **/
if((!ctype_alnum($user['pass'])) OR (strlen( $user['pass'])<8)) {
     $Err[] = "Please enter alphanumeric password of minimum 8 characters." ;
  //   print_r($user);
     
} 
 
/** 3 . Validate Name **/
if(!$user['firstname'])
{
   $Err[] = "Please enter Name";  
}

return $Err;
    
}

//-- 30. get uids    --//
function getcrn_byuid($uid)
{
connectsql();
$table= 'ttg_post';
global $conn;
$sql="SELECT crn FROM $table WHERE uid='$uid'";
$result=$conn->query($sql);
While($retuser[]['crn']=$result->fetch_assoc()['crn'])
{

}
array_pop($retuser);
return $retuser[0]['crn'];  
}

// 31 search data auth asset 
function  search_authuid($uid,$userid)
{
$exp=explode(",",$uid);
$exp= array_map('test_input',$exp);
$exp= array_filter($exp,'remove_empty');
$exp= array_map('add_colon',$exp);
if(!count($exp))
{
  return false;
}
$imp=implode(",",$exp);
$uid=$imp;
connectsql();
global $conn;
$country=load_admin($userid)['country'];

$sql="SELECT ttg_post.* FROM ttg_post LEFT JOIN ttg_crn ON ttg_post.crn = ttg_crn.crn WHERE (ttg_post.uid IN ($uid) )  AND ( ( ttg_crn.userid = '$userid') OR ( (ttg_post.userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') ) AND ('national' IN (SELECT crn_status FROM ttg_login WHERE id = '$userid') ) )OR ('super' IN (SELECT crn_status FROM ttg_login WHERE id = '$userid')) ) LIMIT 2000";
$result=$conn->query($sql);

While($retuser[]=$result->fetch_assoc())
{}
return $retuser;
    /**
  $crn=getcrn_byuid($id);
 // print_r(auth_crn($crn,$userid));
 // print_r(list_user_crn($userid));
 connectsql();
global $conn;

  if(auth_crn($userid,$crn) OR !list_user_crn($userid) OR (crn_status($userid)=='national'))
  {
  //  echo auth_crn($crn,$userid);
   // print_r(list_user_crn($userid));


$sql="SELECT * FROM ttg_post WHERE (uid = '$id' )";
$country=load_admin($userid)['country'];
if(!list_user_crn($userid) AND (crn_status($userid)=='normal'))
{

$sql="SELECT * FROM ttg_post WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND (uid = '$id' )"; 
}
 if(crn_status($userid)=='national')
{
 $sql="SELECT * FROM ttg_post WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND (uid = '$id' )"; 
}
$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
}
else
{
  return false;
}
 **/
}

// 32 list user crn 

function list_user_crn($userid)
{
  connectsql();
$table= 'ttg_crn';
global $conn;
$sql="SELECT crn FROM $table WHERE userid='$userid'";
$result=$conn->query($sql);
While($retuser[]['uid']=$result->fetch_assoc()['crn'])
{

}
array_pop($retuser);
return $retuser;  

}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function pagination($totalitem,$pageitem,$pid)
{
  if(isset($_SESSION['epp']))
  {
    $pageitem=$_SESSION['epp'];
  }
  $nop=ceil($totalitem/$pageitem);
  $divid="this_is_dynamic_".time();
$pa='<div class="pagination" id="pgn'.$divid.'">';
for($i=0;$i<$nop;$i++)
{
  $cLs='';
  if($pid==($i+1))
  {
    $cLs="class='active'";
  }
  $query = $_GET;
// replace parameter(s)
$query['s'] = $i+1;
// rebuild url
$query_result = http_build_query($query);
$query['s'] = 1;
$query_start= http_build_query($query);
$query['s'] =  $nop;
$query_end= http_build_query($query);
if($pid ==($i+6))
{
  $pa.='<a href="?'.$query_start.'" '.$cLs.' >'.'<<'.'</a>';
}
if($pid < ($i+6) AND $pid >($i-4) )
{
  $pa.='<a href="?'.$query_result.'" '.$cLs.' >'.($i+1).'</a>';
}
if($pid ==($i-4))
{
  $pa.='<a href="?'.$query_end.'" '.$cLs.' >'.'>>'.'</a>';
}  
  
}

$pgvalues=array("20","50","100","200");
$pa.='</div>';
$pa.='<div id="nop"><form id="mynop" method="post" action="?'.$query_start.'">Enteries Per Page <select onchange="pagi()" name="epp" id="epp" value="'.$pageitem.'">';
 foreach ($pgvalues as $key => $value) {
  $sl='';
  if($pageitem==$value)
  {
    $sl='selected';
  }
  $pa.='<option value="'.$value.'" '.$sl.'>'.$value.'</option>';
 }
$pa.='</select></form></div>';
if(isset($_GET['s']))
{
  $pa.="<script>
  document.getElementById('pgn".$divid."').scrollIntoView();

  </script>";
}
$pa.="<script> function pagi()
{
document.getElementById('mynop').submit();
}</script>";



return $pa;
}


function log_acivity($event,$datauid,$datatype,$datauserid)
{
    connectsql();
$time_stamp= time();
global $conn;
global $response;


$ipaddress=get_client_ip();
if(isset($_SESSION['userid']))
{
$userid=$_SESSION['userid'];
$device='Web';
}
else
{
$userid=$response['user']['id'];
$device=$response['user']['device'];
}
$sql1="	INSERT INTO ttg_actlogs(userid,event, time,datauid,device,ipaddress,datatype,datauserid )
	VALUES ('$userid','$event','$time_stamp','$datauid','$device','$ipaddress','$datatype','$datauserid')";
	$result=$conn->query($sql1);
//	die($sql.$conn->error);
}


function listcounteries($cnt='IN',$id='country')
{

$countries =
 
array(
"AF" => "Afghanistan",
"AL" => "Albania",
"DZ" => "Algeria",
"AS" => "American Samoa",
"AD" => "Andorra",
"AO" => "Angola",
"AI" => "Anguilla",
"AQ" => "Antarctica",
"AG" => "Antigua and Barbuda",
"AR" => "Argentina",
"AM" => "Armenia",
"AW" => "Aruba",
"AU" => "Australia",
"AT" => "Austria",
"AZ" => "Azerbaijan",
"BS" => "Bahamas",
"BH" => "Bahrain",
"BD" => "Bangladesh",
"BB" => "Barbados",
"BY" => "Belarus",
"BE" => "Belgium",
"BZ" => "Belize",
"BJ" => "Benin",
"BM" => "Bermuda",
"BT" => "Bhutan",
"BO" => "Bolivia",
"BA" => "Bosnia and Herzegovina",
"BW" => "Botswana",
"BV" => "Bouvet Island",
"BR" => "Brazil",
"IO" => "British Indian Ocean Territory",
"BN" => "Brunei Darussalam",
"BG" => "Bulgaria",
"BF" => "Burkina Faso",
"BI" => "Burundi",
"KH" => "Cambodia",
"CM" => "Cameroon",
"CA" => "Canada",
"CV" => "Cape Verde",
"KY" => "Cayman Islands",
"CF" => "Central African Republic",
"TD" => "Chad",
"CL" => "Chile",
"CN" => "China",
"CX" => "Christmas Island",
"CC" => "Cocos (Keeling) Islands",
"CO" => "Colombia",
"KM" => "Comoros",
"CG" => "Congo",
"CD" => "Congo, the Democratic Republic of the",
"CK" => "Cook Islands",
"CR" => "Costa Rica",
"CI" => "Cote D'Ivoire",
"HR" => "Croatia",
"CU" => "Cuba",
"CY" => "Cyprus",
"CZ" => "Czech Republic",
"DK" => "Denmark",
"DJ" => "Djibouti",
"DM" => "Dominica",
"DO" => "Dominican Republic",
"EC" => "Ecuador",
"EG" => "Egypt",
"SV" => "El Salvador",
"GQ" => "Equatorial Guinea",
"ER" => "Eritrea",
"EE" => "Estonia",
"ET" => "Ethiopia",
"FK" => "Falkland Islands (Malvinas)",
"FO" => "Faroe Islands",
"FJ" => "Fiji",
"FI" => "Finland",
"FR" => "France",
"GF" => "French Guiana",
"PF" => "French Polynesia",
"TF" => "French Southern Territories",
"GA" => "Gabon",
"GM" => "Gambia",
"GE" => "Georgia",
"DE" => "Germany",
"GH" => "Ghana",
"GI" => "Gibraltar",
"GR" => "Greece",
"GL" => "Greenland",
"GD" => "Grenada",
"GP" => "Guadeloupe",
"GU" => "Guam",
"GT" => "Guatemala",
"GN" => "Guinea",
"GW" => "Guinea-Bissau",
"GY" => "Guyana",
"HT" => "Haiti",
"HM" => "Heard Island and Mcdonald Islands",
"VA" => "Holy See (Vatican City State)",
"HN" => "Honduras",
"HK" => "Hong Kong",
"HU" => "Hungary",
"IS" => "Iceland",
"IN" => "India",
"ID" => "Indonesia",
"IR" => "Iran, Islamic Republic of",
"IQ" => "Iraq",
"IE" => "Ireland",
"IL" => "Israel",
"IT" => "Italy",
"JM" => "Jamaica",
"JP" => "Japan",
"JO" => "Jordan",
"KZ" => "Kazakhstan",
"KE" => "Kenya",
"KI" => "Kiribati",
"KP" => "Korea, Democratic People's Republic of",
"KR" => "Korea, Republic of",
"KW" => "Kuwait",
"KG" => "Kyrgyzstan",
"LA" => "Lao People's Democratic Republic",
"LV" => "Latvia",
"LB" => "Lebanon",
"LS" => "Lesotho",
"LR" => "Liberia",
"LY" => "Libyan Arab Jamahiriya",
"LI" => "Liechtenstein",
"LT" => "Lithuania",
"LU" => "Luxembourg",
"MO" => "Macao",
"MK" => "Macedonia, the Former Yugoslav Republic of",
"MG" => "Madagascar",
"MW" => "Malawi",
"MY" => "Malaysia",
"MV" => "Maldives",
"ML" => "Mali",
"MT" => "Malta",
"MH" => "Marshall Islands",
"MQ" => "Martinique",
"MR" => "Mauritania",
"MU" => "Mauritius",
"YT" => "Mayotte",
"MX" => "Mexico",
"FM" => "Micronesia, Federated States of",
"MD" => "Moldova, Republic of",
"MC" => "Monaco",
"MN" => "Mongolia",
"MS" => "Montserrat",
"MA" => "Morocco",
"MZ" => "Mozambique",
"MM" => "Myanmar",
"NA" => "Namibia",
"NR" => "Nauru",
"NP" => "Nepal",
"NL" => "Netherlands",
"AN" => "Netherlands Antilles",
"NC" => "New Caledonia",
"NZ" => "New Zealand",
"NI" => "Nicaragua",
"NE" => "Niger",
"NG" => "Nigeria",
"NU" => "Niue",
"NF" => "Norfolk Island",
"MP" => "Northern Mariana Islands",
"NO" => "Norway",
"OM" => "Oman",
"PK" => "Pakistan",
"PW" => "Palau",
"PS" => "Palestinian Territory, Occupied",
"PA" => "Panama",
"PG" => "Papua New Guinea",
"PY" => "Paraguay",
"PE" => "Peru",
"PH" => "Philippines",
"PN" => "Pitcairn",
"PL" => "Poland",
"PT" => "Portugal",
"PR" => "Puerto Rico",
"QA" => "Qatar",
"RE" => "Reunion",
"RO" => "Romania",
"RU" => "Russian Federation",
"RW" => "Rwanda",
"SH" => "Saint Helena",
"KN" => "Saint Kitts and Nevis",
"LC" => "Saint Lucia",
"PM" => "Saint Pierre and Miquelon",
"VC" => "Saint Vincent and the Grenadines",
"WS" => "Samoa",
"SM" => "San Marino",
"ST" => "Sao Tome and Principe",
"SA" => "Saudi Arabia",
"SN" => "Senegal",
"CS" => "Serbia and Montenegro",
"SC" => "Seychelles",
"SL" => "Sierra Leone",
"SG" => "Singapore",
"SK" => "Slovakia",
"SI" => "Slovenia",
"SB" => "Solomon Islands",
"SO" => "Somalia",
"ZA" => "South Africa",
"GS" => "South Georgia and the South Sandwich Islands",
"ES" => "Spain",
"LK" => "Sri Lanka",
"SD" => "Sudan",
"SR" => "Suriname",
"SJ" => "Svalbard and Jan Mayen",
"SZ" => "Swaziland",
"SE" => "Sweden",
"CH" => "Switzerland",
"SY" => "Syrian Arab Republic",
"TW" => "Taiwan, Province of China",
"TJ" => "Tajikistan",
"TZ" => "Tanzania, United Republic of",
"TH" => "Thailand",
"TL" => "Timor-Leste",
"TG" => "Togo",
"TK" => "Tokelau",
"TO" => "Tonga",
"TT" => "Trinidad and Tobago",
"TN" => "Tunisia",
"TR" => "Turkey",
"TM" => "Turkmenistan",
"TC" => "Turks and Caicos Islands",
"TV" => "Tuvalu",
"UG" => "Uganda",
"UA" => "Ukraine",
"AE" => "United Arab Emirates",
"GB" => "United Kingdom",
"US" => "United States",
"UM" => "United States Minor Outlying Islands",
"UY" => "Uruguay",
"UZ" => "Uzbekistan",
"VU" => "Vanuatu",
"VE" => "Venezuela",
"VN" => "Viet Nam",
"VG" => "Virgin Islands, British",
"VI" => "Virgin Islands, U.s.",
"WF" => "Wallis and Futuna",
"EH" => "Western Sahara",
"YE" => "Yemen",
"ZM" => "Zambia",
"ZW" => "Zimbabwe"
);
 $weer="<select id='".$id."' name='country' class='country' >";
 
 foreach ($countries as $key=> $value )
 {
     $selected='';
     if($key==$cnt)
     {
         $selected='selected';
     }
     $weer.="<option value='".$key."' ".$selected.">".$value." </option>\r\n";
}
$weer.="</selected>";
return $weer;
}


function lstcountry($country='India',$id='country')
{
    
    if($_SESSION['type']=='admin')
      {
      $cd="disabled='disabled'";
      return $country;
    }
  $counteries = '<select id="'.$id.'" name="country" class="country" onchange="edituser(this)" '.$cd.'>
         <option value="India">India</option>
      <option value="australia">Australia</option>
      <option value="canada">Canada</option>
      <option value="usa">USA</option>
      <option value="Afghanistan">Afghanistan</option>
   <option value="Albania">Albania</option>
   <option value="Algeria">Algeria</option>
   <option value="American Samoa">American Samoa</option>
   <option value="Andorra">Andorra</option>
   <option value="Angola">Angola</option>
   <option value="Anguilla">Anguilla</option>
   <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
   <option value="Argentina">Argentina</option>
   <option value="Armenia">Armenia</option>
   <option value="Aruba">Aruba</option>
   <option value="Australia">Australia</option>
   <option value="Austria">Austria</option>
   <option value="Azerbaijan">Azerbaijan</option>
   <option value="Bahamas">Bahamas</option>
   <option value="Bahrain">Bahrain</option>
   <option value="Bangladesh">Bangladesh</option>
   <option value="Barbados">Barbados</option>
   <option value="Belarus">Belarus</option>
   <option value="Belgium">Belgium</option>
   <option value="Belize">Belize</option>
   <option value="Benin">Benin</option>
   <option value="Bermuda">Bermuda</option>
   <option value="Bhutan">Bhutan</option>
   <option value="Bolivia">Bolivia</option>
   <option value="Bonaire">Bonaire</option>
   <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
   <option value="Botswana">Botswana</option>
   <option value="Brazil">Brazil</option>
   <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
   <option value="Brunei">Brunei</option>
   <option value="Bulgaria">Bulgaria</option>
   <option value="Burkina Faso">Burkina Faso</option>
   <option value="Burundi">Burundi</option>
   <option value="Cambodia">Cambodia</option>
   <option value="Cameroon">Cameroon</option>
   <option value="Canada">Canada</option>
   <option value="Canary Islands">Canary Islands</option>
   <option value="Cape Verde">Cape Verde</option>
   <option value="Cayman Islands">Cayman Islands</option>
   <option value="Central African Republic">Central African Republic</option>
   <option value="Chad">Chad</option>
   <option value="Channel Islands">Channel Islands</option>
   <option value="Chile">Chile</option>
   <option value="China">China</option>
   <option value="Christmas Island">Christmas Island</option>
   <option value="Cocos Island">Cocos Island</option>
   <option value="Colombia">Colombia</option>
   <option value="Comoros">Comoros</option>
   <option value="Congo">Congo</option>
   <option value="Cook Islands">Cook Islands</option>
   <option value="Costa Rica">Costa Rica</option>
   <option value="Cote DIvoire">Cote DIvoire</option>
   <option value="Croatia">Croatia</option>
   <option value="Cuba">Cuba</option>
   <option value="Curaco">Curacao</option>
   <option value="Cyprus">Cyprus</option>
   <option value="Czech Republic">Czech Republic</option>
   <option value="Denmark">Denmark</option>
   <option value="Djibouti">Djibouti</option>
   <option value="Dominica">Dominica</option>
   <option value="Dominican Republic">Dominican Republic</option>
   <option value="East Timor">East Timor</option>
   <option value="Ecuador">Ecuador</option>
   <option value="Egypt">Egypt</option>
   <option value="El Salvador">El Salvador</option>
   <option value="Equatorial Guinea">Equatorial Guinea</option>
   <option value="Eritrea">Eritrea</option>
   <option value="Estonia">Estonia</option>
   <option value="Ethiopia">Ethiopia</option>
   <option value="Falkland Islands">Falkland Islands</option>
   <option value="Faroe Islands">Faroe Islands</option>
   <option value="Fiji">Fiji</option>
   <option value="Finland">Finland</option>
   <option value="France">France</option>
   <option value="French Guiana">French Guiana</option>
   <option value="French Polynesia">French Polynesia</option>
   <option value="French Southern Ter">French Southern Ter</option>
   <option value="Gabon">Gabon</option>
   <option value="Gambia">Gambia</option>
   <option value="Georgia">Georgia</option>
   <option value="Germany">Germany</option>
   <option value="Ghana">Ghana</option>
   <option value="Gibraltar">Gibraltar</option>
   <option value="Great Britain">Great Britain</option>
   <option value="Greece">Greece</option>
   <option value="Greenland">Greenland</option>
   <option value="Grenada">Grenada</option>
   <option value="Guadeloupe">Guadeloupe</option>
   <option value="Guam">Guam</option>
   <option value="Guatemala">Guatemala</option>
   <option value="Guinea">Guinea</option>
   <option value="Guyana">Guyana</option>
   <option value="Haiti">Haiti</option>
   <option value="Hawaii">Hawaii</option>
   <option value="Honduras">Honduras</option>
   <option value="Hong Kong">Hong Kong</option>
   <option value="Hungary">Hungary</option>
   <option value="Iceland">Iceland</option>
   <option value="Indonesia">Indonesia</option>
   <option value="Iran">Iran</option>
   <option value="Iraq">Iraq</option>
   <option value="Ireland">Ireland</option>
   <option value="Isle of Man">Isle of Man</option>
   <option value="Israel">Israel</option>
   <option value="Italy">Italy</option>
   <option value="Jamaica">Jamaica</option>
   <option value="Japan">Japan</option>
   <option value="Jordan">Jordan</option>
   <option value="Kazakhstan">Kazakhstan</option>
   <option value="Kenya">Kenya</option>
   <option value="Kiribati">Kiribati</option>
   <option value="North Korea">North Korea</option>
   <option value="South Korea">South Korea</option>
   <option value="Kuwait">Kuwait</option>
   <option value="Kyrgyzstan">Kyrgyzstan</option>
   <option value="Laos">Laos</option>
   <option value="Latvia">Latvia</option>
   <option value="Lebanon">Lebanon</option>
   <option value="Lesotho">Lesotho</option>
   <option value="Liberia">Liberia</option>
   <option value="Libya">Libya</option>
   <option value="Liechtenstein">Liechtenstein</option>
   <option value="Lithuania">Lithuania</option>
   <option value="Luxembourg">Luxembourg</option>
   <option value="Macau">Macau</option>
   <option value="Macedonia">Macedonia</option>
   <option value="Madagascar">Madagascar</option>
   <option value="Malaysia">Malaysia</option>
   <option value="Malawi">Malawi</option>
   <option value="Maldives">Maldives</option>
   <option value="Mali">Mali</option>
   <option value="Malta">Malta</option>
   <option value="Marshall Islands">Marshall Islands</option>
   <option value="Martinique">Martinique</option>
   <option value="Mauritania">Mauritania</option>
   <option value="Mauritius">Mauritius</option>
   <option value="Mayotte">Mayotte</option>
   <option value="Mexico">Mexico</option>
   <option value="Midway Islands">Midway Islands</option>
   <option value="Moldova">Moldova</option>
   <option value="Monaco">Monaco</option>
   <option value="Mongolia">Mongolia</option>
   <option value="Montserrat">Montserrat</option>
   <option value="Morocco">Morocco</option>
   <option value="Mozambique">Mozambique</option>
   <option value="Myanmar">Myanmar</option>
   <option value="Nambia">Nambia</option>
   <option value="Nauru">Nauru</option>
   <option value="Nepal">Nepal</option>
   <option value="Netherland Antilles">Netherland Antilles</option>
   <option value="Netherlands">Netherlands (Holland, Europe)</option>
   <option value="Nevis">Nevis</option>
   <option value="New Caledonia">New Caledonia</option>
   <option value="New Zealand">New Zealand</option>
   <option value="Nicaragua">Nicaragua</option>
   <option value="Niger">Niger</option>
   <option value="Nigeria">Nigeria</option>
   <option value="Niue">Niue</option>
   <option value="Norfolk Island">Norfolk Island</option>
   <option value="Norway">Norway</option>
   <option value="Oman">Oman</option>
   <option value="Pakistan">Pakistan</option>
   <option value="Palau Island">Palau Island</option>
   <option value="Palestine">Palestine</option>
   <option value="Panama">Panama</option>
   <option value="Papua New Guinea">Papua New Guinea</option>
   <option value="Paraguay">Paraguay</option>
   <option value="Peru">Peru</option>
   <option value="Phillipines">Philippines</option>
   <option value="Pitcairn Island">Pitcairn Island</option>
   <option value="Poland">Poland</option>
   <option value="Portugal">Portugal</option>
   <option value="Puerto Rico">Puerto Rico</option>
   <option value="Qatar">Qatar</option>
   <option value="Republic of Montenegro">Republic of Montenegro</option>
   <option value="Republic of Serbia">Republic of Serbia</option>
   <option value="Reunion">Reunion</option>
   <option value="Romania">Romania</option>
   <option value="Russia">Russia</option>
   <option value="Rwanda">Rwanda</option>
   <option value="St Barthelemy">St Barthelemy</option>
   <option value="St Eustatius">St Eustatius</option>
   <option value="St Helena">St Helena</option>
   <option value="St Kitts-Nevis">St Kitts-Nevis</option>
   <option value="St Lucia">St Lucia</option>
   <option value="St Maarten">St Maarten</option>
   <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
   <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
   <option value="Saipan">Saipan</option>
   <option value="Samoa">Samoa</option>
   <option value="Samoa American">Samoa American</option>
   <option value="San Marino">San Marino</option>
   <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
   <option value="Saudi Arabia">Saudi Arabia</option>
   <option value="Senegal">Senegal</option>
   <option value="Seychelles">Seychelles</option>
   <option value="Sierra Leone">Sierra Leone</option>
   <option value="Singapore">Singapore</option>
   <option value="Slovakia">Slovakia</option>
   <option value="Slovenia">Slovenia</option>
   <option value="Solomon Islands">Solomon Islands</option>
   <option value="Somalia">Somalia</option>
   <option value="South Africa">South Africa</option>
   <option value="Spain">Spain</option>
   <option value="Sri Lanka">Sri Lanka</option>
   <option value="Sudan">Sudan</option>
   <option value="Suriname">Suriname</option>
   <option value="Swaziland">Swaziland</option>
   <option value="Sweden">Sweden</option>
   <option value="Switzerland">Switzerland</option>
   <option value="Syria">Syria</option>
   <option value="Tahiti">Tahiti</option>
   <option value="Taiwan">Taiwan</option>
   <option value="Tajikistan">Tajikistan</option>
   <option value="Tanzania">Tanzania</option>
   <option value="Thailand">Thailand</option>
   <option value="Togo">Togo</option>
   <option value="Tokelau">Tokelau</option>
   <option value="Tonga">Tonga</option>
   <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
   <option value="Tunisia">Tunisia</option>
   <option value="Turkey">Turkey</option>
   <option value="Turkmenistan">Turkmenistan</option>
   <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
   <option value="Tuvalu">Tuvalu</option>
   <option value="Uganda">Uganda</option>
   <option value="United Kingdom">United Kingdom</option>
   <option value="Ukraine">Ukraine</option>
   <option value="United Arab Erimates">United Arab Emirates</option>
   <option value="Uraguay">Uruguay</option>
   <option value="Uzbekistan">Uzbekistan</option>
   <option value="Vanuatu">Vanuatu</option>
   <option value="Vatican City State">Vatican City State</option>
   <option value="Venezuela">Venezuela</option>
   <option value="Vietnam">Vietnam</option>
   <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
   <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
   <option value="Wake Island">Wake Island</option>
   <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
   <option value="Yemen">Yemen</option>
   <option value="Zaire">Zaire</option>
   <option value="Zambia">Zambia</option>
   <option value="Zimbabwe">Zimbabwe</option>
    </select>';
    $cdata=simplexml_load_string($counteries);
    $strings = $cdata->xpath("//option");
    foreach ($strings as $string) 
    {
      if($string['value']==$country)
      {
      $string['selected']='selected';
      }
    

    }
   
     return $cdata->asXml();
}



//-- 2. load users--//
function load_activity($key,$country='')
{
connectsql();
$table=	'ttg_actlogs';
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM $table WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND ( userid LIKE '%$key%' OR datauid LIKE '%$key%' OR datauserid LIKE '%$key%' OR ipaddress LIKE '%$key%' ) ORDER BY time DESC";
$result=$conn->query($sql);
//die($sql.$conn->error);
While($retuser[]=$result->fetch_assoc())
{}

return $retuser;
}


function update_crn($newcrn,$oldcrn)
{
connectsql();
$table= 'ttg_post';
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
if($uids=getuids_bycrn($oldcrn))
{
$sql="UPDATE $table SET crn='$newcrn' WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND crn='$oldcrn'";
$result=$conn->query($sql);
return $result;      
}
else
{
  return false;
}

 
}

function update_uid($newuid,$olduid)
{
    if($post=getpost_byuid($newuid))
    {
        return false;
    }
connectsql();
$table= 'ttg_post';
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
if($post=getpost_byuid($olduid))
{
$sql="UPDATE $table SET uid='$newuid' WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND uid='$olduid'";
$result=$conn->query($sql);
return $result;      
}
else
{
  return false;
}

 
}

function update_uid_by_id($newuid,$id)
{
     if($post=getpost_byuid($newuid))
    {
        return false;
    }
connectsql();
$table= 'ttg_post';
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}

$sql="UPDATE $table SET uid='$newuid' WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND id='$id'";
$result=$conn->query($sql);
//die($sql.$conn->error);
return $result;      
}


function add_shipment($response)
{
  global $gate;
extract($response);
connectsql();
$time_stamp= time();
global $conn;
$userid=$response['user']['id'];
$crn=$response['crn'];
$device=$response['user']['device'];
$files=json_encode($response['files_accepted']);
$description=$response['files_desc'];
$hash=random_strings();
$org_ship_time =$gate['ship_time'];
$ship_time=$gate['ship_time']=getunixtime($gate['input_time'],$gate['ship_time']);
$logistic_company=$gate['logistic_company'];
$vahicle_type=$gate['vahicle_type'];
$vahicle_container=$gate['vahicle_container'];
$vahicle_number=$gate['vahicle_number'];
$box_condition=$gate['box_condition'];
$supervisor_name=$gate['supervisor_name'];
$supervisor_photo=$response['supervisor_photo'];
$supervisor_sign=$response['supervisor_sign'];
$note=$gate['note'];
$no_of_staff=$gate['no_of_staff'];
$declr_tick=$gate['declr_tick'];
$no_of_pallets=$gate['no_of_pallets'];
$no_of_devices=$gate['no_of_devices'];
$no_of_box=$gate['no_of_box'];
$no_of_staff=$gate['no_of_staff'];
$no_of_vahicle=$gate['no_of_vahicle'];
$supervisor_ph_no=$gate['supervisor_ph_no'];
$input_time=$gate['input_time'];
$is_reject=$gate['is_reject'];
$box_seal=$gate['box_seal'];
$logistic_waybill=$gate['logistic_waybill'];
$sql1=" INSERT INTO ttg_ship(
userid,
crn,
files,
description,
time,
device,
ship_time,
logistic_company,
vahicle_type,
vahicle_container,
vahicle_number,
box_condition,
supervisor_name,
supervisor_photo,
supervisor_sign,
note,
hash,
no_of_staff,
no_of_box,
no_of_pallets,
no_of_devices,
no_of_vahicle,
supervisor_ph_no,
input_time,
is_reject,
declr_tick,
org_ship_time,
box_seal,
logistic_waybill
)
  VALUES (
'$userid',
'$crn',
'$files',
'$description',
'$time_stamp',
'$device',
'$ship_time',
'$logistic_company',
'$vahicle_type',
'$vahicle_container',
'$vahicle_number',
'$box_condition',
'$supervisor_name',
'$supervisor_photo',
'$supervisor_sign',
'$note',
'$hash',
'$no_of_staff',
'$no_of_box',
'$no_of_pallets',
'$no_of_devices',
'$no_of_vahicle',
'$supervisor_ph_no',
'$input_time',
'$is_reject',
'$declr_tick',
'$org_ship_time',
'$box_seal',
'$logistic_waybill'
)";
  if($result=$conn->query($sql1))
  {
      log_acivity('add',$crn,'shipment','');
      return true;
  }
  else
  {
// echo "Failed";
  }
   
// die($sql1.$conn->error);
}

function get_shipment($crn)
{
connectsql();
$table= 'ttg_ship';
global $conn;
$sql="SELECT * FROM $table WHERE crn='$crn'";
$result=$conn->query($sql);
$j=0;
While($retuser[$j]=$result->fetch_assoc())
{
    $retuser[$j]['pdfurl']="https://ttg-photostorage.com/?filehash=". $retuser[$j]['hash'];
    $retuser[$j]['printpdf']="https://ttg-photostorage.com/?print_file=true&filehash=". $retuser[$j]['hash'];
    $retuser[$j]['files']=json_decode( $retuser[$j]['files']);
  $j=$j+1;  
}

return $retuser;  
}


function delete_shipment($id)
{
connectsql();
$table= 'ttg_ship';
global $conn;
$sql="DELETE FROM $table WHERE id='$id'";
$result=$conn->query($sql);
log_acivity('delete',$id,'shipment','');
return $result; 
}

function search_shipment_bydate($startdate,$enddate)
{
connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM ttg_ship WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND ( time BETWEEN '$startdate' AND '$enddate') ORDER BY time DESC";
$result=$conn->query($sql);
//die($sql1.$conn->error);
$j=1;
While($retuser[$j]=$result->fetch_assoc())
{
    $retuser[$j]['pdfurl']="https://ttg-photostorage.com/?filehash=". $retuser[$j]['hash'];
     $retuser[$j]['files']=json_decode( $retuser[$j]['files']);
  $j=$j+1;  
}
//die($sql1.$conn->error);
return $retuser;
}

function search_shipment_byuserid($id)
{
connectsql();
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM ttg_ship WHERE  userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND (userid='$id' OR  crn='$id') ORDER BY time DESC";

if($_SESSION['type']=='superadmin')
{
$sql="SELECT * FROM ttg_ship WHERE  userid IN (SELECT id FROM ttg_login WHERE lower(country) LIKE lower('$id')) OR (userid='$id'  OR crn='$id') ORDER BY time DESC";
}
$result=$conn->query($sql);
$j=1;
While($retuser[$j]=$result->fetch_assoc())
{
    $retuser[$j]['pdfurl']="https://ttg-photostorage.com/?filehash=". $retuser[$j]['hash'];
    $retuser[$j]['printpdf']="https://ttg-photostorage.com/?print_file=true&filehash=". $retuser[$j]['hash'];
    
     $retuser[$j]['files']=json_decode( $retuser[$j]['files'],true);
  $j=$j+1;  
}

return $retuser;
}

//-- 3. Get post by user  --//
function getshipment_byhash($hash)
{
connectsql();
$table= 'ttg_ship';
global $conn;
$sql="SELECT * FROM $table WHERE hash='$hash'";
$result=$conn->query($sql);
$retuser=$result->fetch_assoc();
return $retuser;  
}


function box_condition($condition='Good',$id='box_condition')
{
    if($_SESSION['type']=='client')
    {
        $readonly='disabled="disabled"';
    }
  $counteries = '<select id="'.$id.'" name="box_condition" class="box_condition '.$condition.'" onchange="change_condition(this)"  '.$readonly.'>
  <option value="Unknown">--</option>
         <option value="Poor">Poor</option>
      <option value="Good">Good</option>
      <option value="Fair">Fair</option>
      <option value="Rejected">Rejected</option>
      
    </select>';
    $cdata=simplexml_load_string($counteries);
    $strings = $cdata->xpath("//option");
    foreach ($strings as $string) 
    {
      if($string['value']==$condition)
      {
      $string['selected']='selected';
      }
    

    }
   
     return $cdata->asXml();
}


function change_box_condition($condition,$hash)
{
connectsql();
$table= 'ttg_ship';
global $conn;
$sql="UPDATE $table SET box_condition='$condition' WHERE (hash='$hash')";
$result=$conn->query($sql);

if($condition=='Rejected')
{
  $sql2="UPDATE $table SET is_reject='yes' WHERE (hash='$hash')";  
}
else
{
   $sql2="UPDATE $table SET is_reject='no' WHERE (hash='$hash')"; 
}
$result=$conn->query($sql2);
return $result;
}

function short_shipments($data,$hash)
{
       
$k=1;
foreach($data as $singledata)
{
    if(isset($singledata['crn']))
{
    $time=gettimefromunix($singledata['ship_time'],$_POST['input_time']);
    $snewdata['ship_time_formatted']=$time['time'];
    $snewdata['ship_date_formatted']=$time['date'];
     $singledata['ship_time_formatted']=$time['time'];
     $singledata['ship_date_formatted']=$time['date'];
    $singledata['files']=unified($singledata['files']);
    $snewdata['files']=$singledata['files'];
    $snewdata['ship_time']=$singledata['ship_time'];
    $snewdata['crn']=$singledata['crn'];
    $snewdata['box_condition']=$singledata['box_condition'];
    $snewdata['hash']=$singledata['hash'];
     $snewdata['is_reject']=$singledata['is_reject'];
     $snewdata['input_time']=$singledata['input_time'];
    $newdata[]=$snewdata;
    unset($snewdata);
    if($hash!='')
    {
        if($hash==$singledata['hash'])
        {
            return $singledata;
        }
       
    }
    $k=$k+1;
}
//return $data;

}
return $newdata;
}

function unified($data)
{
    foreach ( $data as $firstdata)
    {
        foreach($firstdata as $key=>$seconddata)
        {
           $key= substr($key,0,4);
           $newseconddata[$key]=$seconddata;
        }
        $newfirstdata[]=$newseconddata;
    }
    
    return $newfirstdata;
}



function update_shipmentimages_desc($uid,$json)
{


    if($post=getshipment_byhash($uid))
{
  //  $j=1;
if($single=json_decode($post['files'],true))
{
  $newjson=$single;
foreach($single as $key=> $photo )
{
     foreach($photo as $ekey=>$psd)
   {
     $j=  substr($ekey, 4);
     //  $qw[$r]=$psd;
     //  $r=$r+1;
   }
$newjson[$key]['desc'.$j]=$json['desc'.$j];
//$j++;
}
}
}
$newjson=json_encode($newjson);
connectsql();
$table= 'ttg_ship';
global $conn;
$sql="UPDATE $table SET files='$newjson' WHERE hash='$uid'";
$result=$conn->query($sql);
// die($sql.$conn->error);
log_acivity('update',$uid,'shipment','');
return $result;
}


function update_shipment($hash,$gate)
{
    $post=getshipment_byhash($hash);
    foreach ($post as $key => $value)
{
    if(!isset($gate[$key]))
    {
       $gate[$key] =$post[$key];
    }
}
connectsql();

global $conn;
$crn=$gate['crn'];
$files=$gate['files'];

if($gate['ship_time']==$post['ship_time'])
{
 $ship_time=$gate['ship_time']; 
}
else
{
 $ship_time=strtotime($gate['ship_time']);
}
$logistic_company=$gate['logistic_company'];
$vahicle_type=$gate['vahicle_type'];
$vahicle_container=$gate['vahicle_container'];
$vahicle_number=$gate['vahicle_number'];
$box_condition=$gate['box_condition'];
$supervisor_name=$gate['supervisor_name'];
$supervisor_sign=$gate['supervisor_sign'];
$note=$gate['note'];
$no_of_staff=$gate['no_of_staff'];
$no_of_pallets=$gate['no_of_pallets'];
$no_of_devices=$gate['no_of_devices'];
$no_of_box=$gate['no_of_box'];
$no_of_staff=$gate['no_of_staff'];
$no_of_vahicle=$gate['no_of_vahicle'];
$supervisor_ph_no=$gate['supervisor_ph_no'];
$box_seal=$gate['box_seal'];
$declr_tick=$gate['declr_tick'];
$logistic_waybill=$gate['logistic_waybill'];
foreach ($post as $key => $value)
{
    if(!isset($get[$key]))
    {
       $gate[$key] =$post[$key];
    }
}
$sql1=" UPDATE ttg_ship SET 
ship_time='$ship_time',
crn='$crn',
logistic_company='$logistic_company',
vahicle_type='$vahicle_type',
vahicle_container='$vahicle_container',
vahicle_number='$vahicle_number',
box_condition='$box_condition',
supervisor_name='$supervisor_name',
supervisor_sign='$supervisor_sign',
note='$note',
no_of_staff='$no_of_staff',
no_of_box='$no_of_box',
no_of_pallets='$no_of_pallets',
no_of_devices='$no_of_devices',
no_of_vahicle='$no_of_vahicle',
supervisor_ph_no='$supervisor_ph_no',
box_seal='$box_seal',
declr_tick='$declr_tick',
logistic_waybill='$logistic_waybill',
files='$files'
 WHERE hash='$hash'";
  if($result=$conn->query($sql1))
  {   update_shipmentimages_desc($hash,$gate);
      log_acivity('update',$hash,'shipment','');
      return true;
  }
  else
  {
 echo "Failed";
  }
   
//die($sql1.$conn->error);
}


function getunixtime($currentdtime,$timetochange)
{
	$currentdtime=strtotime($currentdtime);
	$timetochange=strtotime($timetochange);
	$deff=$currentdtime-time();
	$deff= round($deff / 900) * 900;
	$unix=$timetochange-$deff;
return $unix;
}

function gettimefromunix($unix,$currentdtime)
{
//	echo $currentdtime;
	$currentdtime=strtotime($currentdtime);
//	echo $currentdtime;
	$deff=$currentdtime-time();
	$deff= round($deff / 900) * 900;
	$time=$unix+$deff;
	$date['date']=date("m/d/Y",$time);
$date['time']=date("h:i a",$time);
$date['diff']=$deff;
return $date;
}


//-5. update jason --//
function update_uid_images($uid,$json)
{


    if($post=getpost_byuid($uid))
{
$old_json=json_decode($post['files'],true);    
$newjson= array_merge((array)$old_json,(array)$json);

$newjson=json_encode($newjson);
connectsql();
$table= 'ttg_post';
global $conn;
$sql="UPDATE $table SET files='$newjson' WHERE uid='$uid'";
$result=$conn->query($sql);
log_acivity('update',$old_json,'post','');
return $result;
}
}


function search_data_defect_analysis($id,$defects,$device)
{
   
connectsql();
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM ttg_post WHERE  userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND (userid='$id' OR uid = '$id'  OR crn='$id') ORDER BY time DESC";

if($_SESSION['type']=='superadmin')
{
$sql="SELECT * FROM ttg_post WHERE  userid IN (SELECT id FROM ttg_login WHERE lower(country) LIKE lower('$id')) OR (userid='$id' OR uid = '$id'  OR crn='$id') ORDER BY time DESC";
}
$result=$conn->query($sql);
$f=1;
While($retuser[$f]=$result->fetch_assoc())
{
 $retuser[$f]['defect']=   clean_defects($retuser[$f]['defect']);
   if($retuser[$f]['device_type']==$device)
   {
   $retuser[$f]['dfc'] = array_filter(explode(',', $retuser[$f]['defect']));
   
  $c= array_intersect($retuser[$f]['dfc'], $defects);
  
  if (count($c)==0 ) {
if(($device!='') && ($defects=''))
{
  unset($retuser[$f]);
}
}
$f=$f+1;
}
}

return $retuser;
}


function defect_search_data_bydate($device,$defects)
{
  // print_r($defects);
connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM ttg_post WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') AND ( device_type LIKE '%$device') ORDER BY time DESC";
$result=$conn->query($sql);
//die($sql1.$conn->error);
$f=1;
While($retuser[$f]=$result->fetch_assoc())
{
   
   $retuser[$f]['dfc'] = array_filter(explode(',', $retuser[$f]['defect']));
//   print_r($retuser[$f]['dfc']);
    
  $c= $retuser[$f]['dfc'];
 
  if (count($c)==0 ) {
  unset($retuser[$f]);
   
}
$f=$f+1;
}
return $retuser;
}



function empty_search_defect($device,$defects)
{
  
connectsql();
global $conn;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM ttg_post WHERE  userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country')  ORDER BY time DESC";

if($_SESSION['type']=='superadmin')
{
$sql="SELECT * FROM ttg_post  ORDER BY time DESC";
}
$result=$conn->query($sql);
$f=1;
 // die($sql.$conn->error);
While($retuser[$f]=$result->fetch_assoc())
{
    $retuser[$f]['defect']=   clean_defects($retuser[$f]['defect']);
   if($retuser[$f]['device_type']==$device)
   {
   $retuser[$f]['dfc'] = explode(',', $retuser[$f]['defect']);
   
  $c= array_intersect($retuser[$f]['dfc'], $defects);
  
  
  if ((count($c)==0 ) && !empty($defects)) {
   unset($retuser[$f]);
   
}
$f=$f+1;
}
}
return $retuser;
}

function crndatawise()
{
    connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
if($_SESSION['type']=='superadmin')
{
$country=$_SESSION['data_country'];
}
$sql="SELECT * FROM ttg_post WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country')  ORDER BY time DESC";
$result=$conn->query($sql);
//die($sql1.$conn->error);
$s=0;
While($retuser[$s]=$result->fetch_assoc())
{
    $datacrn[date("Y-m-d",$retuser[$s]['time'])]=$datacrn[date("Y-m-d",$retuser[$s]['time'])]+1;
    $s=$s+1;
}
//die($sql1.$conn->error);
return equalize($datacrn);
}


function crnlist()
{
    connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
if($_SESSION['type']=='superadmin')
{
$country=$_SESSION['data_country'];
}
$sql="SELECT * FROM ttg_post WHERE userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country') GROUP BY crn  ORDER BY time DESC";
$result=$conn->query($sql);
//die($sql1.$conn->error);
$s=0;
While($retuser[$s]=$result->fetch_assoc())
{
    $datacrn[date("Y-m-d",$retuser[$s]['time'])]=$datacrn[date("Y-m-d",$retuser[$s]['time'])]+1;
    $s=$s+1;
}
//die($sql1.$conn->error);
return equalize($datacrn);
}




function listdefects($defects)
{

$countries =
 
array(
"AF" => "Afghanistan",
"AL" => "Albania",
"DZ" => "Algeria",
"AS" => "American Samoa",
"AD" => "Andorra",
"AO" => "Angola",
"AI" => "Anguilla",
"AQ" => "Antarctica",
"AG" => "Antigua and Barbuda",
"AR" => "Argentina",
"AM" => "Armenia",
"AW" => "Aruba",
"AU" => "Australia",
"AT" => "Austria",
"AZ" => "Azerbaijan",
"BS" => "Bahamas",
"BH" => "Bahrain",
"BD" => "Bangladesh",
"BB" => "Barbados",
"BY" => "Belarus",
"BE" => "Belgium",
"BZ" => "Belize",
"BJ" => "Benin",
"BM" => "Bermuda",
"BT" => "Bhutan",
"BO" => "Bolivia",
"BA" => "Bosnia and Herzegovina",
"BW" => "Botswana",
"BV" => "Bouvet Island",
"BR" => "Brazil",
"IO" => "British Indian Ocean Territory",
"BN" => "Brunei Darussalam",
"BG" => "Bulgaria",
"BF" => "Burkina Faso",
"BI" => "Burundi",
"KH" => "Cambodia",
"CM" => "Cameroon",
"CA" => "Canada",
"CV" => "Cape Verde",
"KY" => "Cayman Islands",
"CF" => "Central African Republic",
"TD" => "Chad",
"CL" => "Chile",
"CN" => "China",
"CX" => "Christmas Island",
"CC" => "Cocos (Keeling) Islands",
"CO" => "Colombia",
"KM" => "Comoros",
"CG" => "Congo",
"CD" => "Congo, the Democratic Republic of the",
"CK" => "Cook Islands",
"CR" => "Costa Rica",
"CI" => "Cote D'Ivoire",
"HR" => "Croatia",
"CU" => "Cuba",
"CY" => "Cyprus",
"CZ" => "Czech Republic",
"DK" => "Denmark",
"DJ" => "Djibouti",
"DM" => "Dominica",
"DO" => "Dominican Republic",
"EC" => "Ecuador",
"EG" => "Egypt",
"SV" => "El Salvador",
"GQ" => "Equatorial Guinea",
"ER" => "Eritrea",
"EE" => "Estonia",
"ET" => "Ethiopia",
"FK" => "Falkland Islands (Malvinas)",
"FO" => "Faroe Islands",
"FJ" => "Fiji",
"FI" => "Finland",
"FR" => "France",
"GF" => "French Guiana",
"PF" => "French Polynesia",
"TF" => "French Southern Territories",
"GA" => "Gabon",
"GM" => "Gambia",
"GE" => "Georgia",
"DE" => "Germany",
"GH" => "Ghana",
"GI" => "Gibraltar",
"GR" => "Greece",
"GL" => "Greenland",
"GD" => "Grenada",
"GP" => "Guadeloupe",
"GU" => "Guam",
"GT" => "Guatemala",
"GN" => "Guinea",
"GW" => "Guinea-Bissau",
"GY" => "Guyana",
"HT" => "Haiti",
"HM" => "Heard Island and Mcdonald Islands",
"VA" => "Holy See (Vatican City State)",
"HN" => "Honduras",
"HK" => "Hong Kong",
"HU" => "Hungary",
"IS" => "Iceland",
"IN" => "India",
"ID" => "Indonesia",
"IR" => "Iran, Islamic Republic of",
"IQ" => "Iraq",
"IE" => "Ireland",
"IL" => "Israel",
"IT" => "Italy",
"JM" => "Jamaica",
"JP" => "Japan",
"JO" => "Jordan",
"KZ" => "Kazakhstan",
"KE" => "Kenya",
"KI" => "Kiribati",
"KP" => "Korea, Democratic People's Republic of",
"KR" => "Korea, Republic of",
"KW" => "Kuwait",
"KG" => "Kyrgyzstan",
"LA" => "Lao People's Democratic Republic",
"LV" => "Latvia",
"LB" => "Lebanon",
"LS" => "Lesotho",
"LR" => "Liberia",
"LY" => "Libyan Arab Jamahiriya",
"LI" => "Liechtenstein",
"LT" => "Lithuania",
"LU" => "Luxembourg",
"MO" => "Macao",
"MK" => "Macedonia, the Former Yugoslav Republic of",
"MG" => "Madagascar",
"MW" => "Malawi",
"MY" => "Malaysia",
"MV" => "Maldives",
"ML" => "Mali",
"MT" => "Malta",
"MH" => "Marshall Islands",
"MQ" => "Martinique",
"MR" => "Mauritania",
"MU" => "Mauritius",
"YT" => "Mayotte",
"MX" => "Mexico",
"FM" => "Micronesia, Federated States of",
"MD" => "Moldova, Republic of",
"MC" => "Monaco",
"MN" => "Mongolia",
"MS" => "Montserrat",
"MA" => "Morocco",
"MZ" => "Mozambique",
"MM" => "Myanmar",
"NA" => "Namibia",
"NR" => "Nauru",
"NP" => "Nepal",
"NL" => "Netherlands",
"AN" => "Netherlands Antilles",
"NC" => "New Caledonia",
"NZ" => "New Zealand",
"NI" => "Nicaragua",
"NE" => "Niger",
"NG" => "Nigeria",
"NU" => "Niue",
"NF" => "Norfolk Island",
"MP" => "Northern Mariana Islands",
"NO" => "Norway",
"OM" => "Oman",
"PK" => "Pakistan",
"PW" => "Palau",
"PS" => "Palestinian Territory, Occupied",
"PA" => "Panama",
"PG" => "Papua New Guinea",
"PY" => "Paraguay",
"PE" => "Peru",
"PH" => "Philippines",
"PN" => "Pitcairn",
"PL" => "Poland",
"PT" => "Portugal",
"PR" => "Puerto Rico",
"QA" => "Qatar",
"RE" => "Reunion",
"RO" => "Romania",
"RU" => "Russian Federation",
"RW" => "Rwanda",
"SH" => "Saint Helena",
"KN" => "Saint Kitts and Nevis",
"LC" => "Saint Lucia",
"PM" => "Saint Pierre and Miquelon",
"VC" => "Saint Vincent and the Grenadines",
"WS" => "Samoa",
"SM" => "San Marino",
"ST" => "Sao Tome and Principe",
"SA" => "Saudi Arabia",
"SN" => "Senegal",
"CS" => "Serbia and Montenegro",
"SC" => "Seychelles",
"SL" => "Sierra Leone",
"SG" => "Singapore",
"SK" => "Slovakia",
"SI" => "Slovenia",
"SB" => "Solomon Islands",
"SO" => "Somalia",
"ZA" => "South Africa",
"GS" => "South Georgia and the South Sandwich Islands",
"ES" => "Spain",
"LK" => "Sri Lanka",
"SD" => "Sudan",
"SR" => "Suriname",
"SJ" => "Svalbard and Jan Mayen",
"SZ" => "Swaziland",
"SE" => "Sweden",
"CH" => "Switzerland",
"SY" => "Syrian Arab Republic",
"TW" => "Taiwan, Province of China",
"TJ" => "Tajikistan",
"TZ" => "Tanzania, United Republic of",
"TH" => "Thailand",
"TL" => "Timor-Leste",
"TG" => "Togo",
"TK" => "Tokelau",
"TO" => "Tonga",
"TT" => "Trinidad and Tobago",
"TN" => "Tunisia",
"TR" => "Turkey",
"TM" => "Turkmenistan",
"TC" => "Turks and Caicos Islands",
"TV" => "Tuvalu",
"UG" => "Uganda",
"UA" => "Ukraine",
"AE" => "United Arab Emirates",
"GB" => "United Kingdom",
"US" => "United States",
"UM" => "United States Minor Outlying Islands",
"UY" => "Uruguay",
"UZ" => "Uzbekistan",
"VU" => "Vanuatu",
"VE" => "Venezuela",
"VN" => "Viet Nam",
"VG" => "Virgin Islands, British",
"VI" => "Virgin Islands, U.s.",
"WF" => "Wallis and Futuna",
"EH" => "Western Sahara",
"YE" => "Yemen",
"ZM" => "Zambia",
"ZW" => "Zimbabwe"
);
 $weer="<select id='".$id."' name='country' class='country' >";
 
 foreach ($countries as $key=> $value )
 {
     $selected='';
     if($key==$cnt)
     {
         $selected='selected';
     }
     $weer.="<option value='".$key."' ".$selected.">".$value." </option>\r\n";
}
$weer.="</selected>";
return $weer;
}


function seemore($text)
{
    $lines = explode(',', $text);
    $i=1;
    foreach ($lines as $rt)
    {
        if($rt!='')
        {
            if($i<3)
            {
        $pt[]="<span>".$rt.",</span>";
        
            }else
            {
               $pt[]="<span style='display:none'>".$rt.",</span>";  
            }
            
            $i=$i+1;
            }
    }
    if($i>3)
            {
                 $pt[]="<span onclick='seemore(this.parentElement)'>(".count($pt).")</span>";  
            }
return implode('',$pt);
}



function clean_defects($text)
{
    $lines = explode(',', $text);
    $i=1;
    foreach ($lines as $rt)
    {
        $rt=trim($rt);
        if($rt!='')
        {
           $pt[]=$rt;
        }
return implode(',',$pt);
}
}
function sort_by_date($data,$fromdate,$todate)
{
    $todate=$todate+86400;
    $newdata=$data;
    foreach($data as $key=> $client)
  {
      
      if(($client['time'] <$todate ) &&($client['time'] >$fromdate )) 
      {
          
      }else
      {
          if($todate>8640000)
          {
          unset( $newdata[$key]);
          }
      }
  }
  return $newdata;
}


//-- . get uids    --//
function getposts_bycrn($crn)
{
connectsql();
$table= 'ttg_post';
global $conn;
$sql="SELECT * FROM $table WHERE crn='$crn'";
$result=$conn->query($sql);
While($retuser[]=$result->fetch_assoc())
{

}
array_pop($retuser);
return $retuser;  
}


function get_crn_stats($crn)
{
    $post=getposts_bycrn($crn);
//print_r($post)
$f=0;
foreach( $post as $single )
{
   
    if($single['device_type']!='')
    {
        $parms[$single['device_type']]=$parms[$single['device_type']]+1;
        $defects = array_filter(explode(',', $single['defect']));
       
        foreach($defects as $fault)
        {
            $fault= shortname(test_input($fault));
 /**           if (strpos($fault, 'Bios Locked/Security Feature') !== false) {
    $fault='Bios Locked/Security Feature';
} **/
            $dfs[$single['device_type']][$fault]= $dfs[$single['device_type']][$fault]+1;
        }
         $f=$f+1;
    }
    else
    {
    //    $parms['Unknown']= $parms['Unknown']+1;
    }
    
}
ksort($parms);

$datacrn['parms']=array_filter($parms);
$datacrn['dfs']=$dfs;
$datacrn['ttl']=$f;
return $datacrn;
}

function crn_stats()
{
    connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
$sql="SELECT * FROM ttg_post WHERE ( device_type != '' ) AND (userid IN (SELECT id FROM ttg_login WHERE country LIKE '%$country')) GROUP BY crn  ORDER BY time DESC limit 40";
$result=$conn->query($sql);
//die($sql1.$conn->error);
$s=0;
While($retuser[$s]=$result->fetch_assoc())
{
    if(isset($retuser[$s]['crn']))
    {
        
   $retuser[$s]['states']=get_crn_stats($retuser[$s]['crn']);
   $s=$s+1;
    }
}
//die($sql1.$conn->error);
array_pop($retuser);
shuffle($retuser);
return $retuser;
}

function countrywise()
{
    connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
if($_SESSION['type']=='superadmin')
{
$country=$_SESSION['data_country'];
}
$sql="SELECT ttg_post.crn ,ttg_login.country FROM ttg_post INNER JOIN ttg_login ON  ttg_post.userid=ttg_login.id ORDER BY ttg_post.time DESC";
$result=$conn->query($sql);
//die($sql1.$conn->error);
$s=0;
While($retuser[$s]=$result->fetch_assoc())
{
    $cnt=mapcountry($retuser[$s]['country']);
    $datacrn[$cnt]=$datacrn[$cnt]+1;
    $s=$s+1;
}
//die($sql1.$conn->error);
return $datacrn;
}

function mapcountry($input)
{
    
    $countries =
 
array(
"australia" => "Australia",
"usa" => "United States",
"South Korea" => "Korea",

);
if(isset($countries[$input]))
{
    return  $countries[$input];
}
$countries=array_flip( $countries);
if(isset($countries[$input]))
{
    return  $countries[$input];
}
else
{
    return $input;
}

}

function shortname($rtdf)
{
   return substr($rtdf,0,40);
}



function totalclients()
{
    connectsql();
global $conn;
$enddate=$enddate+86400;
if($_SESSION['type']=='admin')
{
$country=$_SESSION['country'];
}
if($_SESSION['type']=='superadmin')
{
$country=$_SESSION['data_country'];
}
$sql="SELECT id , time FROM ttg_login WHERE country LIKE '%$country' AND type ='client' ORDER BY time DESC";
$result=$conn->query($sql);
//die($sql1.$conn->error);
$s=0;
While($retuser[$s]=$result->fetch_assoc())
{
    $datacrn[date("Y-m-d",$retuser[$s]['time'])]=$datacrn[date("Y-m-d",$retuser[$s]['time'])]+1;
    $s=$s+1;
}
//die($sql1.$conn->error);
return equalize($datacrn);
}
function list_defect($selected)
{
  $rft=  array(
'Motherboard Faulty',
'CPU Missing/Faulty',
'Chassis Broken/Cracked',
'Permanent Marking/Stained/Discolor',
'BIOS Locked/Security Feature Type',
'Does Not Power-up',
'Engraving/Scratch',
'Other Defect',
'No Defect',
'Motherboard Faulty',
'CPU Missing/Faulty',
'Chassis Broken',
'Chassis Cracked',
'Screen Spot/Blemish',
'Screen Broken/Line/Missing',
'Engraving/Scratch',
'Permanent Marking/Stained/Discolor',
'BIOS Locked/Security Feature Type',
'Does Not Power-up',
'Keyboard Faulty/Key Missing',
'Keyboard Panel Missing',
'Other Defect',
'No Defect',
'Parts Missing/Faulty',
'Motherboard Faulty',
'Does Not Power-up',
'Broken/Cracked',
'Other Defect',
'No Defect');
$ech['array']=$rft;
$i=1;
foreach($rft as $rtf) 
{
$ech['radio'].= '<label id="deffect'.$i.'" class="defect"
for="defect'.$i.'"><input onchange="submit_the_formd()" 
type="checkbox" id="defect'.$i.'" name="defect'.$i.'"
value="'.$rtf.'"'.$selected['defect'.$i].'>
'.$rtf.'
</label>';
$i=$i+1;
}
return $ech;
}

function equalize($fdata)
{
    for($i=1577836800;$i<time();$i=$i+86400)
    {
        $d=date("Y-m-d",$i);
       if(!isset($fdata[$d]))
       {
           $frdata[$d]=0;
       }
       else
       {
          $frdata[$d]=$fdata[$d];
       }
    }
    $x = array_reverse($frdata,true);
    return $x;
}


function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    $x_keys = array_keys(reset($array));
    
        // generate csv lines from the inner arrays
        fputcsv($f, $x_keys, $delimiter); 

    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
 //   // make php send the generated csv lines to the browser
    fpassthru($f);
}
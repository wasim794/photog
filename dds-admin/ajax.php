<?php 
require_once 'common.php';  
$fieldNo = !empty($_GET['fieldNo']) ? $_GET['fieldNo'] : '';
$name = !empty($_GET['name']) ? strtolower(trim($_GET['name'])) : '';

$fieldName = 'pack';

switch ($fieldNo) {
    case 1:
        $fieldName = 'pack';
        break;
}
 $data = array();
if (!empty($_GET['name'])) {     
	 
    $pack = strtolower(trim($_GET['name']));
    $sql = "SELECT pack,child,price,id FROM package where LOWER($fieldName) LIKE '%$pack%'";
    $result = mysqli_query($conn, $sql);
    $child='';
    while ($row = mysqli_fetch_assoc($result)) {
		$child = $row['child'];
        $q1= $conn->query("select off from discount where category='$child'");
		$num= $q1->num_rows;
		if($num>0){
          $show1 = $q1->fetch_array();
		  $p =  $row['price'] - $row['price']*$show1['off']/100;
	    }
		else { $p = $row['price'];}
	   
	   $i =  $row['id'];
 	   $u =1;
        $name = $row['pack'].' -('.Child($child,$conn). ')|' .$u. '|' .$p. '|' .$i;
        array_push($data, $name);
	 
    }
}
echo json_encode($data);exit;

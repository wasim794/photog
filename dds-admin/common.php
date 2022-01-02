<?php date_default_timezone_set('Asia/Calcutta');
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	$res=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=$res->fetch_array();
	define("PHOTOURL","uploads/",true);
	
	function SubCategory($cid,$conn){
   $sql2 = $conn->query("select sub from subcategory where cid='$cid'");
   $view = $sql2->fetch_array();
  return $view['sub'];
  }	
  function Category($cid,$conn){
   $sql2 = $conn->query("select cate from category where cid='$cid'");
   $view = $sql2->fetch_array();
  return $view['cate'];
  }	
  
  function Child($cid,$conn){
   $sql2 = $conn->query("select title from child where id='$cid'");
   $view = $sql2->fetch_array();
  return $view['title'];
  }	
  function pack_child($id,$conn){
    $sql2 = $conn->query("select child from package where id='$id'");
    $view = $sql2->fetch_array();
	$p =  Child($view['child'],$conn);
  return $p;
  }
   function State($id,$conn){
   $sql2 = $conn->query("select states from state where id='$id'");
   $view = $sql2->fetch_array();
  return $view['states'];
  }	
  
   function City($id,$conn){
   $sql2 = $conn->query("select cities from child where id='$id'");
   $view = $sql2->fetch_array();
  return $view['cities'];
  }	
?>
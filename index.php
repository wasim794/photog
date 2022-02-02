<?php //include 'home.php';
include 'functions.php';

if($_SESSION['catname']==''){ $Photography="#";  }else{
$Photography = $_SESSION['catname'];
}
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url =$actual_link;
 $keys = parse_url($url); // parse the url
 $path = explode("/", $keys['path']); // splitting the path
 //print_r($path);
  $last = $path[2];
 if($last==''){
  include 'home.php';
} 
if($last=='categories'){
header('Location: categories.php');
}
if($last==$Photography){
include 'sub-categories/index.php';
  //header('Location: https://localhost/photog/hhh');
}

if($last=='about-me'){
  include 'about-me/index.php';
}

if($last=='career'){
  include 'career/index.php';
}

if($last=='works'){
 include 'works/index.php';
}
if($last=='detailpage'){
 include 'detailpage/index.php';
}
?>
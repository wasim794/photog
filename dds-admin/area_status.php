<?PHP include 'dbconnect.php';
/*-------------------------------------		Slider	-----------------------*/

if(isset($_GET['pstatus'])){
	$ph_id=$_GET['pstatus'];
	
	$sql="select status from partner where id='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();
	
	$status=$row['status'];	
	if($status=='1'){$status='0';}
	else{$status='1';}
	
	$sql="UPDATE partner SET status='$status' where id='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-partner.php");	
}
/*-------------------------------------		Testimonials	-----------------------*/


if(isset($_GET['tstatus']))
{
	$ph_id=$_GET['tstatus'];	
	$sql="select status from testimonials where nid='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';}
	else{ $status='1';}
	
	$sql="UPDATE testimonials SET status='$status' where nid='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-testimonials.php");	
}

/*-------------------------------------		Category	-----------------------*/


if(isset($_GET['cstatus'])){
	$ph_id=$_GET['cstatus'];
	
	$sql="select status from category where cid='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE category SET status='$status' where cid='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-category.php");	
}

/*-------------------------------------	Front	Category	-----------------------*/


if(isset($_GET['front'])){
	$ph_id=$_GET['front'];
	
	$sql="select front from category where cid='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['front'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE category SET front='$status' where cid='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-category.php");	
}

/*-------------------------------------	Sub	Category	-----------------------*/


if(isset($_GET['ccstatus'])){
	$ph_id=$_GET['ccstatus'];
	
	$sql="select status from subcategory where cid='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{	$status='1';}
	
	$sql="UPDATE subcategory SET status='$status' where cid='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-subcategory.php");	
}

/*-------------------------------------	Recommended Service	-----------------------*/
if(isset($_GET['hide'])){
	$id=$_GET['hide'];
	
	$sql="select rstatus from service where id='$id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();
	
	$status=$row['rstatus'];
	
	if($status=='1'){$status='0';}
	else {$status='1';	}
	
	$sql="UPDATE service SET rstatus='$status' where id='$id' ";
	$phObj=$conn->query($sql);	
	header("location:view-service.php");
	
}
/*-------------------------------------	Service	-----------------------*/

if(isset($_GET['status'])){
	$ph_id=$_GET['status'];	
	$sql="select status from service where id='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE service SET status='$status' where id='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-service.php");	
}
 
/*-------------------------------------	Review	-----------------------*/

if(isset($_GET['review'])){
	$ph_id=$_GET['review'];	
	$sql="select status from review where id='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE review SET status='$status' where id='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:review.php");	
}
/*-------------------------------------	Service Receiver	-----------------------*/

if(isset($_GET['receiver'])){
	$ph_id=$_GET['receiver'];	
	$sql="select status from registration where id='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE registration SET status='$status' where id='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:service-receiver.php");	
}
 
 
/*-------------------------------------	Service technician	-----------------------*/

if(isset($_GET['hstatus'])){
	$ph_id=$_GET['hstatus'];	
	$sql="select status from technician where id='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE technician SET status='$status' where id='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-technician.php");	
}
if(isset($_GET['sstatus'])){
	$ph_id=$_GET['sstatus'];	
	$sql="select status from slider where fid='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE slider SET status='$status' where fid='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-slider.php");	
}

if(isset($_GET['prstatus'])){
	$ph_id=$_GET['prtatus'];	
	$sql="select status from providers where fid='$ph_id'";
	$phObj=$conn->query($sql);
	$row=$phObj->fetch_array();	
	$status=$row['status'];
	
	if($status=='1'){$status='0';	}
	else{$status='1';}
	
	$sql="UPDATE providers SET status='$status' where fid='$ph_id' ";
	$phObj=$conn->query($sql);	
	header("location:view-provider.php");	
}

?>
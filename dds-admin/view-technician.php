<?php require_once 'common.php';
if (isset($_REQUEST['delete']) ){
$sql=$conn->query("select * FROM `technician` WHERE id='".$_REQUEST['delete']."'");
	$row = $sql->fetch_array();
	$filename = $row['ufile'];	

		$db=$conn->query("DELETE FROM `technician` WHERE id='".$_REQUEST['delete']."'");
		if($db){	
		 unlink(PHOTOURL.$filename);	
		header('location:view-technician.php');	exit;
		}
	}		
include('includes/head.php');
include('includes/header.php');?>
<script>
   function change_status(status){
	window.location = "area_status.php?hstatus="+status;
}

function chkDelete(ids,pid){

	if(confirm("Are you sure you want to delete Record(s)"))	{
		window.location.href="view-technician.php?id="+pid+"&delete="+ids;
	}
	else 	{
		return false;
	}
}
</script>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 500px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>View Technicians</li>
            </ol>
<div class="agile-grids">	
<a href="add-technician.php" class="btn" style="float:right; background:#669900; color:#FFFFFF">Add New Technicians</a>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Technicians Details</h2>
		<table id="table1" class="table table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Profile</th>
							<th>Name</th>	
							<th>Contact No</th>
							<th>State</th>	
 							<th>Service </th>
							<th width="10%"> Date </th>	
							<th>Status</th>	
							<th> KM </th>
							<th width="15%">Action</th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT * FROM technician  order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			 if(!empty($data['ufile'])){$pic = PHOTOURL.$data['ufile'];}
			 else { $pic ='images/user.png'; }
			 ?>
				<tr> <td><?php echo $i;?></td>		
				<td><a href="<?php echo $pic;?>" download="proposed_file_name"><i class="fa fa-download pull-right" aria-hidden="true " style="color:green"></i></a><img src="<?php echo $pic;?>" style="width:100px; height:100px; border-radius:50%" id="myImg<?php echo $i;?>"></td>
					 
					  <td><?php echo $data['name'];?></td>
					  <td><?php echo $data['phone'];?></td>	
					  <td><?php echo $data['state'];?></td>	
 				      <td><?php echo $data['service'];?></td>
					  <td><?php echo date('d-m-Y', strtotime($data['date']));?></td>
				      
					  	
				 <td> <?php if($data['status']==1) {?>
   <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['id']?>)" class="approved" >Active</a>
               <?php } else if($data['status']==2) {?>
  <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['id']?>)" class="ico_pending" >Freeze</a>
                <?php }else{?> 
 <a href="#" style="text-decoration:none;" onClick="change_status(<?=$data['id']?>)" class="ico_pending">Block</a>
                <?php }?> </td>	
                <td><?php echo $data['distance'];?></td>
							<td><a href="add-technician.php?id=<?php echo $data["id"];?>"><i class="fa fa-pencil-square-o edit"></i> &nbsp; Edit</a>  &nbsp;  <a href="javascript:void(0);" onClick="chkDelete(<?php echo $data["id"];?>)" class="font-red"><i class="fa fa-times font-red"></i> Delete  </a></td>
							
						  </tr>
<div id="myModal<?php echo $i;?>" class="modal">
  <span class="close" id="close<?php echo $i;?>">&times;</span>
  <img class="modal-content" id="img01<?php echo $i;?>">
  <div id="caption<?php echo $i;?>"></div>
</div>
<script>
var modal = document.getElementById("myModal<?php echo $i;?>");
var img = document.getElementById("myImg<?php echo $i;?>");
var modalImg = document.getElementById("img01<?php echo $i;?>");
var captionText = document.getElementById("caption<?php echo $i;?>");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}
var span = document.getElementById("close<?php echo $i;?>");
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
					<?php }?>	 						  
						</tbody>
					  </table>	
					</div>
 </div>
			</div>

<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
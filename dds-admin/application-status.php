<?php require_once 'common.php';
include('includes/head.php');
include('includes/header.php');?>
<style>
.Logout{color:red;}
.Login{color:green;}
.Install{color:blue;}
.Uninstall{color:black}
</style>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="control-panel.php">Control Panel</a><i class="fa fa-angle-right"></i>Application Status</li>
            </ol>
<div class="agile-grids">	
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Application Status</h2>
		<table id="table1" class="table-responsive">
						<thead>
						  <tr>
						    <th>#</th>
    					    <th>Profile</th>
							<th>Name</th>	
							<th>Contact No</th>
							<th>Status</th>	
 					     </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT status.view,status.phone,technician.name,technician.ufile FROM status inner join technician on status.phone=technician.phone  order by status.id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			 if(!empty($data['ufile'])){$pic = PHOTOURL.$data['ufile'];}
			 else { $pic ='images/user.png'; } 
			 if($data['view']==0){$status='Logout'; } else if($data['view']==1){$status='Login'; }
			 else if($data['view']==2){$status='Uninstall'; } else if($data['view']==3){$status='Install'; }
			 else {$status=' '; }  
			 ?>
				<tr> <td><?php echo $i;?></td>		
				<td><img src="<?php echo $pic;?>" style="width:80px; height:80px; border-radius:50%" ></td>
					 
					  <td><?php echo $data['name'];?></td>
					  <td><?php echo $data['phone'];?></td>	
  				     <td> <label class="<?php echo  $status;?>"><i class="fa fa-circle <?php echo  $status;?>"></i> <?php echo  $status;?></label> </td>	
							 
							
						  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>	
					</div>
 </div>
			</div>

<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
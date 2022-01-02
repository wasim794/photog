<?php require_once 'common.php';
error_reporting(0);
  include('includes/head.php'); include('includes/header.php');?>

<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i> Technician Earning</li>
            </ol>
<div class="agile-grids">				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h3><strong> Technician Earning</strong> </h3>
					 
		        <table id="table1" class="table-responsive">
						<thead>
						  <tr>
						  <th>#</th>
						  <th>Joining Date </th>	
						  <th>Profile</th>
							<th>Name</th>	
							<th>Contact No</th>
							<th>State</th>	 							
							<th>Earning</th>
                            <th>Credit</th>								
							
							<th width="15%"> </th>
						  </tr>
						</thead>
						<tbody>
																				  
			 <?php 
			 $sql=$conn->query("SELECT ufile,id,name,phone,state,date FROM technician  order by id desc");
			 $i=0;  
	         while($data=$sql->fetch_array()){
			 $i++;
			 $emp_code=$data['id'];
			 echo "SELECT SUM(coin) as credits FROM `credit` WHERE tech_id='$emp_code'";
			     $techsql=$conn->query("SELECT SUM(coin) as credits FROM `credit` WHERE tech_id='$emp_code'");
                  while($viewtech=$techsql->fetch_array()){
					  $coint=$viewtech['credits'];
				  }
			 $emp_code = $data['id'];
			 if(!empty($data['ufile'])){$pic = PHOTOURL.$data['ufile'];} else { $pic ='images/user.png'; }
			 
			 $query = $conn->query("select total,discount from booking  where emp_code='$emp_code' and status='Complete'  order by id desc");			   
              $earning=0;
			  while($view=$query->fetch_array()){
			   $earning = $earning + $view['total'] - $view['discount'];
			  }
			 ?>
				<tr> <td><?php echo $i;?></td>
				  <td><?php echo date('d-m-Y', strtotime($data['date']));?></td>		
				<td><img src="<?php echo $pic;?>" style="width:100px; height:100px; border-radius:50%" ></td>		 
					  <td><?php echo $data['name'];?></td>
					  <td><?php echo $data['phone'];?></td>	
					  <td><?php echo $data['state'];?></td>	
 					  <td><i class="fa fa-inr"></i> <?php echo number_format($earning,2);?></td>
                       <td></i> <?php if($coint==''){ echo "0";}else{ echo $coint;} ?></td>						  
					  <td><a href="earning-info.php?id=<?php echo $data["id"];?>" class="btn btn-primary"> 
					  Earning Details</a>  </td>
 						  </tr>
					<?php }?>	 						  
						</tbody>
					  </table>  
			 			
					</div>
				</div>
			</div>
		<?php include('includes/footer.php');?>	
 <?php include('includes/menu.php');?>
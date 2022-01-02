<div class="sidebar-menu">
   <header class="logo1"><a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> </header>
   <div style="border-top:1px ridge rgba(255, 255, 255, 0.15)"></div>
   <div class="menu">
      <ul id="menu" >
         <li><a href="dashboard.php"><i class="fa fa-tachometer"></i> 
			 <span>Dashboard</span><div class="clearfix"></div></a></li>
			 
		 <li><a href="control-panel.php"><i class="fa fa-calendar"></i> 
			 <span>Control Panel</span><div class="clearfix"></div></a></li>
			 
		<li><a href="application-status.php"><i class="fa fa-eye"></i> 
			 <span>Application Status</span><div class="clearfix"></div></a></li>	 															
		  
		 <li><a href="#"><i class="fa fa-users nav_icon"></i><span> Technicians</span>
			 <span class="fa fa-angle-right" style="float: right"></span>
			 <div class="clearfix"></div></a>
		     <ul>					
				<li><a href="add-technician.php">Add Technicians </a></li>							
				<li><a href="view-technician.php">View Technicians </a></li>
				<li><a href="technician-approval.php"> Technicians Approval Request</a></li>
			</ul>
		</li>
		
		 <li><a href="#"><i class="fa fa-credit-card nav_icon"></i><span> Credit/Debit</span>
			 <span class="fa fa-angle-right" style="float: right"></span>
			 <div class="clearfix"></div></a>
		     <ul>					
				<li><a href="add-credit.php">Add Credit/Debit </a></li>							
				<li><a href="view-credit.php">View Credit/Debit </a></li>
 			</ul>
		</li>	
		<li><a href="booking.php"><i class="fa fa-check-square-o"></i> 
			 <span>Booking</span><div class="clearfix"></div></a></li>
		 <li><a href="#"><i class="fa fa-plus nav_icon"></i><span> Lead</span>
			 <span class="fa fa-angle-right" style="float: right"></span>
			 <div class="clearfix"></div></a>
		     <ul>					
				<li><a href="add-lead.php">Add Lead </a></li>							
				<li><a href="view-lead.php">New Lead </a></li>
				<li><a href="response-lead.php">Response Lead </a></li>
				<li><a href="pending-lead.php">Pending Lead </a></li>
				<li><a href="complete-lead.php">Complete Lead </a></li>
				<li><a href="cancel-lead.php">Cancel Lead </a></li>
				<li><a href="other-lead.php">Other Lead </a></li>
				<li><a href="recomplain.php">Recomplain </a></li>
 			</ul>
		</li>	 
		
		<li><a href="#"><i class="fa fa-users nav_icon"></i><span> Refund</span>
			 <span class="fa fa-angle-right" style="float: right"></span>
			 <div class="clearfix"></div></a>
		     <ul>												
				<li><a href="view-refund.php">View Refund </a></li>
			</ul>
		</li>
		
	    
		<li><a href="part-delivery.php"><i class="fa fa-clock-o"></i> 
			 <span>Part Delivery</span><div class="clearfix"></div></a></li>
			 
			  <li><a href="#"><i class="fa fa-credit-card nav_icon"></i><span> Notification</span>
			 <span class="fa fa-angle-right" style="float: right"></span>
			 <div class="clearfix"></div></a>
		     <ul>					
				<li><a href="notification.php">Send Notification </a></li>							
				<li><a href="view-notification.php">View Notification </a></li>
 			</ul>
		</li>	
			
	   
	   <li><a href="penalty.php"><i class="fa fa-exchange"></i> 
			 <span>Penalty</span><div class="clearfix"></div></a></li>	
	   
	   <li><a href="payment-history.php"><i class="fa fa-credit-card"></i> 
			 <span>Payment History</span><div class="clearfix"></div></a></li>	
			 
	   <li><a href="online-payment.php"><i class="fa fa-desktop"></i> 
			 <span>Online Payment</span><div class="clearfix"></div></a></li>	
	  
	  	 <li><a href="earning.php"><i class="fa fa-inr"></i> 
			 <span>Technician Earning</span><div class="clearfix"></div></a></li>		 		 		 	 
	   
	   						
		<li><a href="review.php"><i class="fa fa-tag"></i> 
			 <span>Review</span><div class="clearfix"></div></a></li>
	   
	    
			 
     </ul>
   </div>
 </div>
 <div class="clearfix"></div>		
</div>
<script>
 var toggle = true;										
 $(".sidebar-icon").click(function() {                
 if (toggle) {
 $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
 $("#menu span").css({"position":"absolute"});
 }
 else {
 $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
 setTimeout(function() {
 $("#menu span").css({"position":"relative"});
 }, 400);
 }
 toggle = !toggle;
 });
 </script>							
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
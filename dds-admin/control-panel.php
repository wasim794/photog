<?php require_once 'common.php'; include('includes/head.php'); include('includes/header.php');?>
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="control-panel.php">Control Panel</a> 
				<i class="fa fa-angle-right"></i></li>
            </ol>
			
  <form action="search.php" method="post" style="margin:20px 10px 0">
  <div class="col-md-3 form-group"><h3 style="margin:0"><strong>Search A Lead</strong></h3> </div>
	 <div class="col-md-4 form-group">
     <input type="text" class="form-control" name="keyword" placeholder="Search By Customer Phone/Complaint No." required/>			     </div>
		 <div class="col-md-4 form-group">
		 <input type="submit" name="search" value="Find Lead" class="btn btn-primary" style="margin:0"/>
		 </div>	
			</form>
			<div class="clearfix"></div>
		<div class="four-grids">
					<div class="col-md-4 four-grid">
					<a href="view-technician.php">
						<div class="four-agileits">
							<div class="icon">
								<i class="fa fa-users" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Technician</h3>
								<?php 
			              $sql3=$conn->query("SELECT id FROM technician");
		                  $num3= $sql3->num_rows;
                              ?> 
								<h4><?php echo $num3;?></h4>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col-md-4 four-grid">
					<a href="view-lead.php" >
						<div class="four-agileinfo">
							<div class="icon">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>New Lead</h3>
								<?php 
			              $sql2=$conn->query("select id from booking where type='offline' and status='request'");
		                  $num2= $sql2->num_rows;
                              ?> 
								<h4><?php echo $num2;?></h4>
							</div>
						</div>
						</a>
					</div>
					<div class="col-md-4 four-grid">
						<a href="complete-lead.php">
						<div class="four-w3ls">
							<div class="icon">
								<i class="fa fa-tag" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Complete Lead</h3>
							<?php 
			              $sql2=$conn->query("select id from booking where  status='Complete' ");
		                  $num2= $sql2->num_rows;?>
								<h4><?php echo $num2;?></h4>
								
							</div>
							
						</div>
						</a>
					</div>
					
					<div class="clearfix"></div>
				</div>
				
				<div class="four-grids">	
				<div class="col-md-4 four-grid">
					<a href="response-lead.php">
						<div class="four-agileinfo">
							<div class="icon">
								<i class="fa fa-list-alt" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Response Lead</h3>
								<?php 
			           $sql2=$conn->query("select id from booking where  status='Processing' or status='Response'");
		                  $num2= $sql2->num_rows;
                              ?> 
								<h4><?php echo $num2;?></h4>
							</div>
							
						</div>
						</a>
					</div>		
					<div class="col-md-4 four-grid">
						<a href="pending-lead.php" >
						<div class="four-wthree">
							<div class="icon">
								<i class="fa fa-comments" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Pending Lead</h3>
								<?php 
			             $sql1=$conn->query("select id from booking where  status='Pending'");
		                  $num1= $sql1->num_rows;
                              ?> 
								<h4><?php echo $num1;?></h4>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col-md-4 four-grid">
					<a href="cancel-lead.php">
						<div class="four-agileits">
							<div class="icon">
								<i class="fa fa-folder" aria-hidden="true"></i>
							</div>
							<div class="four-text">
								<h3>Cancel Lead</h3>
								<?php 
			              $sql3=$conn->query("select id from booking where  status='Cancel'");
		                  $num3= $sql3->num_rows;
                              ?> 
								<h4><?php echo $num3;?></h4>
								</div>
							
						</div>
						</a>
					</div>
					
					
					<div class="clearfix"></div>
				</div>

		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->

<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>	
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
			<!--/sidebar-menu-->
				<?php include('includes/menu.php');?>	
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->	   
<!-- morris JavaScript -->	
<script src="js/raphael-min.js"></script>
<script src="js/morris.js"></script>
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2014 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2014 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2014 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2014 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2015 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2015 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2015 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2015 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2016 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
				{period: '2016 Q2', iphone: 8442, ipad: 5723, itouch: 1801}
			],
			lineColors:['#ff4a43','#a2d200','#22beef'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
</body>
</html>
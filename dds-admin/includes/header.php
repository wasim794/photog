<div class="header-main">
					<div class="logo-w3-agile">
			<a href="dashboard.php"><img src="../images/logo1.png" class="logo"></a> &nbsp; &nbsp;
			<div class="pull-right"><br /><?php echo date('d/M/Y');?> <span id='txt' ></span></div>
							</div>
						<div class="profile_details w3l">		
								<ul>
									<li class="dropdown profile_details_drop">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											<div class="profile_img">	
								<span class="prfil-img"><img src="images/user.png" alt=""> </span> 
												<div class="user-name">
													<p><?php echo $userlg=$userRow['userName']; ?></p>
												
												</div>
												<i class="fa fa-angle-down"></i>
												<i class="fa fa-angle-up"></i>
												<div class="clearfix"></div>	
											</div>	
										</a>
										<ul class="dropdown-menu drp-mnu">
							<li> <a href="setting.php"><i class="fa fa-cog"></i> Setting</a> </li> 
								
								<li> <a href="logout.php?logout"><i class="fa fa-sign-out"></i> Logout</a> </li>
										</ul>
									</li>
								</ul>
							</div>
							
				     <div class="clearfix"> </div>	
				</div>
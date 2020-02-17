<?php

?>
<div  class="imgcont1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row">
				 <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<img src="settings/images/headlogo.jpg"  class="img-responsive"></img>
				</div>
				
				<div class="clearfix visible-xs-block"></div>
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
			</div>
		</div>
<div class="col-xs-12 col-sm-12 navigay">
			<div class="row">
						<nav role="navigation" class="navbar navbar-inverse navedit">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header navedit">
							<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navedit">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="Student_Profile_Home.php" class="navbar-brand">My Home </a>
						</div>
						<!-- Collection of nav links, forms, and other content for toggling -->
						<div id="navbarCollapse" class="collapse navbar-collapse navedit">
							<ul class="nav navbar-nav">
							<li class="active"><a href="sUg_vote_part.php">Cast My Vote</a></li>
							
								<?php 
									//session_start();
									if ($_voter_Pin_Status=="0"){
										echo '<li><a style="background-color:yellow;Color:red;font-weight:bold;" href="Student_Profile_Home.php?checkedosokorovo=s2Ewqirstv%wg!d&reged_to='.$_SESSION['reg_oo'].'">Generate Voting Code</a></li>';
										
									}
									/**if ($_SESSION['voter_vote_code']=="0"){
										echo '<li><a href="Vote_Analysis.php">Log Me Out Of Election Page</a></li>';
									}**/
								?>
								<li><a href="Vote_Analysis.php">View My Vote Statistic</a></li>
								<li><a href="sug_Live_result.php" >View Live Election Result </a></li>
								<li ><a href="sign_logout.php">Sign Out</a></li>
							 </ul>
							<form role="search" class="navbar-form navbar-right">
								<div class="form-group">
								   <input type="text" placeholder="Search" class="form-control">
								</div>
								 <button type="submit" class="btn btn-default">Submit</button>
							</form>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="Admin/index.php">Search :</a></li>
							</ul>
						</div>
					</nav>
			</div>
		</div>
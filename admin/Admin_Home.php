
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: ../sign_logout.php");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin Home | SUG - ATBU E-Voting </title>
<link rel="shortcut icon" href="../settings/images/title.jpg">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-theme.css" >
<script type="text/javascript" src="../settings/js/bootstrap.js"></script>
<script type="text/javascript" src="../settings/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../settings/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="../settings/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../settings/js/bootstrap.min.js"></script>

</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			<div  class="col-sm-2 col-md-2 col-lg-2"  >
				<!-- display user details like passport ..name.. ID ..Class type -->
			</div>
				<div  class="col-sm-8 col-md-8 col-lg-8">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U Election | Admin Control Home</h3>
						<h5 style="text-align:center;color:yellow">Welcome	-	Administrator <?php echo $_SESSION['Admin_user_full_name'];?> - <a style="color:white" href="../sign_logout.php">Log Out</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:0px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%">
						<div  class="col-sm-6 col-md-6 col-lg-6">
						<div class="nav-head"><h4>Admin Control Pannel - Election</h4></div>
							<div class="list-group show" style="margin-bottom:20px">
								<a href="#" class="list-group-item"> </a>
								<a href="sug_register_new_contestant.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Register New Contestant </a>
								<a href="#" class="list-group-item"> </a>
								<a href="sug_register_new_student.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Register New Student </a>
								<a href="#" class="list-group-item"> </a>
								<a href="sug_creat_new_portfolio.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Register New Positions </a>
								<a href="#" class="list-group-item"> </a>
								<a href="#" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Upload News </a>
								<a href="#" class="list-group-item"> </a>
							</div>
						</div>
						<div  class="col-sm-6 col-md-6 col-lg-6">
							<div class="nav-head"><h4>Admin Manage Reports</h4></div>
							<div class="list-group show" style="margin-bottom:20px">
								<a href="#" class="list-group-item"> </a>
								<a href="../store_files/sug_all_contestant.php" target="_blank" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Print All Contestants</a>
								<a href="#" class="list-group-item"> </a>
								<a href="../store_files/sug_acredited_voters.php" target="_blank" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Print All Acredited Voters </a>
								<a href="#" class="list-group-item"> </a>
								<a href="../store_files/sug_download_election_result.php" target="_blank" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download All Election Result </a>
								<a href="#" class="list-group-item"> </a>
								<a href="sug_single_result_step_1.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Signle Election Result </a>
								<a href="#" class="list-group-item"> </a>								
							</div>
						</div>
						<div  class="col-sm-6 col-md-6 col-lg-6">
							<div class="nav-head"><h4>Admin Permission</h4></div>
							<div class="list-group show" style="margin-bottom:20px">
								<a href="#" class="list-group-item"> </a>
								<a href="sug_open_close_election.php?req_letU_o=shsashajs" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Open Election </a>
								<a href="#" class="list-group-item"> </a>
								<a href="sug_open_close_election.php?req_letU_c=shsashajs" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Close Election </a>
								<a href="#" class="list-group-item"> </a>								
							</div>
						</div>
						<div  class="col-sm-6 col-md-6 col-lg-6">
							<div class="nav-head"><h4>Admin Delete</h4></div>
							<div class="list-group show" style="margin-bottom:20px">
								<a href="#" class="list-group-item"> </a>
								<a href="sug_remove_contestant.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Remove Contestant </a>
								<a href="#" class="list-group-item"> </a>
								<a href="sug_remove_port_folio.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Remove Portfolio </a>
								<a href="#" class="list-group-item"> </a>
							</div>
						</div>
						
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>		
				
				<div  class="col-sm-2 col-md-2 col-lg-2"></div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
		<div class="row">
			<div class="col-xs-2 col-sm-2"></div>	
				<div class="col-xs-8 col-sm-8" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2017 - All Rights Reserved - Software Development Unit, A T B U - S U G.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  

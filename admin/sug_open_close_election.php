
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
<title>Admin Permission | SUG - ATBU E-Voting </title>
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
						<h5 style="text-align:center;color:yellow">Welcome	-	Administrator <?php echo $_SESSION['Admin_user_full_name'];?> - <a style="color:white" href="../exam_logout.php">Log Out</a> | <a style="color:white" href="Admin_Home.php">Admin Home</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%">
						<?php
						if(isset($_GET['req_letU_o']) AND !isset($_SESSION['req_letU_c']))
						{
							$elect_st = "0"; // - 0 : election is on and one can get ID and vote - 1 : Election is closed and no id no more vote
							$stmt = $conn->prepare("UPDATE admin_record SET election_status=?, election_pin=?  Limit 1");
							$stmt->execute(array($elect_st,$elect_st));
							$affected_rows = $stmt->rowCount();
							if($stmt == true) 
							{
								$notice_msg_u = "<p style='color:blue;font-weight:bold;'> Success: Election has been Opened Sucesfully!<p>";
								echo '<div class="alert alert-info alert-dismissable">
							   <button type="button" class="close" data-dismiss="alert" 
								  aria-hidden="true">
								  &times;
							   </button>'.$notice_msg_u.'</div>';
							}
						}
						if(isset($_GET['req_letU_c']) AND !isset($_SESSION['req_letU_o']))
						{
							$elect_st = "1"; // - 0 : election is on and one can get ID and vote - 1 : Election is closed and no id no more vote
							$stmt = $conn->prepare("UPDATE admin_record SET election_status=?, election_pin=?  Limit 1");
							$stmt->execute(array($elect_st,$elect_st));
							$affected_rows = $stmt->rowCount();
							if($stmt == true) 
							{
								$notice_msg_u = "<p style='color:blue;font-weight:bold;'> Success: Election has been Closed Sucesfully!<p>";
								echo '<div class="alert alert-info alert-dismissable">
							   <button type="button" class="close" data-dismiss="alert" 
								  aria-hidden="true">
								  &times;
							   </button>'.$notice_msg_u.'</div>';
							}
					   }
						
						
						?>
						
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

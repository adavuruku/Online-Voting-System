<?php

session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title> SUG - ATBU E-Voting </title>
<link rel="shortcut icon" href="settings/images/title.jpg">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.css" >
<script type="text/javascript" src="settings/js/bootstrap.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="settings/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="settings/index.css" >

</head>
<body>
<div class="container">
	<div class="row">
		

		<!-- navigation menu -->
			<!-- navigation menu -->
		<?php require_once 'settings/menu_file.php';?>
	</div>
	
	
	<div class="row" >
        <div class="col-xs-12 col-sm-12">
			<div class="col-xs-12 col-sm-12" style="background-color:grey;font-weight:bold;Color:white;padding-top:15px;">
					
			</div>
			
			<div class="col-xs-12 col-sm-12" style="background-color:white;font-weight:bold;font Colour:red">
				<h4 style="color:blue;text-align:left;font-weight:bold;font-style:italic;">Abubakar Tafawa Balewa University, Bauchi Student Union Government ONLINE VOTING SYSTEM </h4>
						
			</div>
	</div>
	</div>
	<?php require_once 'settings/footer_file.php';?>
<!-- container ends -->
</div>
</body>
</html>  

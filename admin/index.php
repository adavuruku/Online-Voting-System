<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';
$error=$P=$R =$txtPassword=$txtUsername="";
 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
	
	$txtPassword =strip_tags($_POST['txtPassword']);
	$txtUsername = strip_tags($_POST['txtUsername']);
	
	$stmt = $conn->prepare("SELECT * FROM admin_record where Password=? AND User_Name=? Limit 1");
	$stmt->execute(array($txtPassword,$txtUsername));
	$affected_rows = $stmt->rowCount();
	if($affected_rows == 1) 
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$_SESSION['Admin_user_name'] = $txtUsername;
		$_SESSION['Admin_user_full_name'] = $row['Full_Name'];
		header("location: Admin_Home.php");
	}else{
		$error = "<p style='color:white'>Unable To Login, Password or User_Name Incorrect</p>";
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SUG - ATBU E-Voting </title>
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
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
				<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">ATBU - SUG ELECTION 2016 / 2017 </a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:green">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="../index.php">Go to Home Page</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>



<div class="container">
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
				<form role="form" name="Login_form"  id="frm0" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
			
			<div  class="col-sm-3 col-md-3 col-lg-3" style="padding-left:20px;" >
			</div>
					
			<div  class="col-sm-7 col-md-7 col-lg-7">
			<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
							<h3 style="text-align:center;padding-top:5px; padding-bottom:25px;color:yellow" >Admin Login Platform</h3>	
				</div>
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
										
								<div class="form-group">
														<label for="txtUsername" class="control-label col-xs-5">User_Name :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
																<input type="text" class="form-control"  id="txtUsername" name="txtUsername" value="<?php echo $txtUsername; ?>" placeholder="Enter Your User_Name">
															</div>
														</div>
								</div>
				<div class="form-group">
														<label for="txtPassword" class="control-label col-xs-5">Password :<span style="color:red"class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
																<input type="password" class="form-control" id="txtPassword" name="txtPassword" value="" placeholder="Enter Your Password">
															</div>
														</div>
								</div>
				
				
				
				</div>	
							
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-5" style="align:left;">
									<?php echo $error; ?>
								</div>
								<div  class="col-lg-7" >
											<button  type="submit"  name="submit" class="btn btn-success">Login &gt&gt&gt</button>
											<button  type="reset" name="previous"  class="btn btn-success">Clear / Reset</button>
								</div>
							</form>
				</div>
					
			</div>			
			<div  class="col-sm-2 col-md-2 col-lg-2"></div>
						
						<div class="clearfix visible-sm-block"></div>
						<div class="clearfix visible-md-block"></div>
						<div class="clearfix visible-lg-block"></div>
					
		
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		
		<div class="row">
			<div class="col-xs-3 col-sm-3"></div>	
				<div class="col-xs-7 col-sm-7" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2017 - All Rights Reserved - Software Development Unit, A T B U DICT.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  

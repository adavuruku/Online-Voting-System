<?php
session_start();
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$_voter_regno = $perror="";
if(!isset($_GET['re_t']))
{
	$_voter_regno ="";
}else{
	$_voter_regno = $hide=strip_tags($_GET['re_t']);
		if($hide==""){
		header("location: View_Acredited_Voters.php");
	}
}

if((isset($_COOKIE['study'])) && (isset($_COOKIE['stupdy'])))
{
	/**$post_username=$_COOKIE['study'];
	$post_password=$_COOKIE['stupdy'];
	$_SESSION['reg_oo'] = $post_username;
	header("location: Student_Profile_Home.php");**/
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitdetails']))
{
		$u_name =$_POST['inputW'];
		$J = checkempty($_POST['inputP']);
		$K =checkempty($_POST['inputW']);
		$_SESSION['success']="";
		
		if (($J != FALSE) && ($K != FALSE)) {
		
			$u_password = trim($_POST['inputP']);
			$u_name = trim($u_name);
			
			$pword = strip_tags($u_password);
			$pword = SHA1($pword);
			
			$u_name = strip_tags($u_name);
			
			//login_user($u_name,$u_password);
			
			//verify if he user exist
				$f="0";
				$query2 = "SELECT * FROM student_information WHERE reg_No =:reg_No AND p_word=:p_word Limit 1";
				$stmt2 = $conn->prepare($query2);
				$stmt2->bindValue(':reg_No',$u_name, PDO::PARAM_STR);
				$stmt2->bindValue(':p_word',$pword, PDO::PARAM_STR);
				$stmt2->execute();
				$rows3 = $stmt2->fetch(PDO::FETCH_ASSOC);
				$row_count2 = $stmt2->rowCount();
				if($row_count2 == 1)
				{
					$_CA = "Sherif A. A.";
					$_carty = SHA1($_CA);
					$_SESSION['reg_oo'] = $u_name;
					/**setcookie("study", $u_name.$_carty, strtotime( '+30 days' ), "/", "", "", TRUE);
					setcookie("stupdy", $pword, strtotime( '+30 days' ), "/", "", "", TRUE);**/
					$notice_msg_u = "<p style='color:blue;font-weight:bold;'> Success: You are currently Logged In!<p>";
							$_SESSION['message'] = '<div class="alert alert-info alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg_u.'</div>';
					header("location: Student_Profile_Home.php");
				}else{
					$perror = "<p style='color:red'> Error: Invalid User Name or Password</p>";
				}
		}else{
			$perror = "<p style='color:red'> Error: Either Password or Username is wrong<p>";
		}
	
}

//FUNCTION TO LOGIN THE USER


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SUG - ATBU E-Voting </title>
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
		<div class="col-xs-12 col-sm-12" style="padding-top:35px;">
			<div class="col-xs-6 col-sm-6" style="background-color:white;font-weight:bold;Color:BLACK;padding:25px;">
					<h4 style="color:blue;font-weight:bold;">Instructions !</h4>
					<hr />
					<ul>
						<li> Login with Your Registtration Number As User Name
						<li> Your Password as your choice of selected Passowrd
					</ul>
					<hr />
					<h4 style="color:blue;font-weight:bold;">Information !</h4>
					<hr />
					<ol>
						<li> After Login In Succesfully Make sure you update the bellow Informations - for you to be acredited for the election
								<ul>
									<li> A Valid / Functional Email Address
									<li> A Valid / Functional Phone Number (Short message Enabled)
								</ul>
						<li> Having completed the step above you can then Request for a voting Pin to enable you cast your Vote
						<li> Use several Menu Option in your Home page to get any information / operation you may so desire
					</ol>
			</div>
			<div class="col-xs-1 col-sm-1">
			</div>
			<div class="col-xs-5 col-sm-5" style="background-color:white;font-weight:bold;Color:BLACK;border-width:3px;border-style:outset;padding-left:0px;padding-right:0px">
				<div class="col-xs-12 col-sm-12" style="background-color:grey;margin-bottom:10px">
					<h3 style="color:white;text-align:center;">Student Login</h3>
				</div>
				<div class="col-xs-12 col-sm-12" style="font-weight:bold;Color:blue;padding-bottom:35px;padding:15px">
						<form role="form"  name="loginform"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
						<div class="form-group">
							<label for="inputW" class="control-label col-xs-3">User Name :</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" id="inputW" name="inputW" value="<?php echo $_voter_regno; ?>" placeholder="Enter Reg_No As User Name">
							</div>
						</div>
						<div class="form-group">
							<label for="inputP" class="control-label col-xs-3">Password :</label>
							<div class="col-xs-9">
								<input type="password" class="form-control" id="inputP" name="inputP"  placeholder="Enter Password">
							</div>
						</div>
						
						<div class="form-group">
							
							<div class="col-xs-9">
								<?php echo $perror;?>
							</div>
							<div class=" col-lg-3">
								<button type="submit" value="xErWqu" id="submitdetails" name="submitdetails" class="btn btn-success">Proceed >> </button>
							</div>
							
						</div>
					</form>
				</div>
			</div>
				
			
		</div>
	</div>
	<?php require_once 'settings/footer_file.php';?>
<!-- container ends -->
</div>
</body>
</html>  
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
		//verify if election is in progress
		$f="0"; // 0 - election in progress 
		$stmt = $conn->prepare("SELECT * FROM admin_record where election_pin=? And election_status=? Limit 1");
		$stmt->execute(array($f,$f));
		$affected_rows = $stmt->rowCount();
		if($affected_rows == 1) 
		{
			$J = checkempty($_POST['inputP']);
		$K =checkempty($_POST['inputW']);
		$L =checkempty($_POST['inputV']);
		
		$Ko =filterEmail($_POST['inputP']);
		
		$_SESSION['success']="";
		
		if (($J != FALSE) && ($K != FALSE)&& ($L != FALSE) && ($Ko != FALSE)) {
		
			$u_name = trim($_POST['inputW']);
			$u_name = trim($u_name);
			$u_name = strip_tags($u_name);
			
			$email_id = trim($_POST['inputP']);
			$email_id = strip_tags($email_id);
			
			$vote_pin =trim($_POST['inputV']);
			$vote_pin = strip_tags($vote_pin);
			$vote_pin = SHA1($vote_pin);
				$f="1";
				$query2 = "SELECT * FROM student_information WHERE (reg_No =:reg_No AND v_code=:v_code) AND (Email=:Email And v_code_status=:v_code_status) Limit 1";
				$stmt2 = $conn->prepare($query2);
				$stmt2->bindValue(':reg_No',$u_name, PDO::PARAM_STR);
				$stmt2->bindValue(':v_code',$vote_pin, PDO::PARAM_STR);
				$stmt2->bindValue(':Email',$email_id, PDO::PARAM_STR);
				$stmt2->bindValue(':v_code_status',$f, PDO::PARAM_STR);
				$stmt2->execute();
				$row_count2 = $stmt2->rowCount();
				if($row_count2 >= 1)
				{
					$_SESSION['reg_oo'] = $u_name;
					//check if the pin is still valid as at the time of login
					$rows3 = $stmt2->fetch(PDO::FETCH_ASSOC);
					
					//making sure time diff is not more than 1 hour
					$set_time = $rows3['date_vote_code'];
					$end_time = date("Y-m-d H:i:s");
					$str_time_l = strtotime($end_time);
					$str_time = strtotime($set_time);
					
					$hours = abs($str_time_l -$str_time ) /(60*60);
					if($hours>=1){
						//update the vcode status so the user dont come in again till this extent
						$stat="0";
						$stmt = $conn->prepare("UPDATE student_information SET v_code_status=? WHERE reg_No=? Limit 1");
						$stmt->execute(array($stat,$u_name));
						$affected_rows = $stmt->rowCount();
						$perror = "<p style='color:red'> Error: The Pin you are trying to use has expired.. Generate Another Code from Your Portal!</p>";
					}else{
						$_SESSION['vote_details'] =$rows3['vote_details'];
						header("location: SUG_Student_Voting_Home.php");
					}
					
				}else{
					$perror = "<p style='color:red'> Error: Either Invalid User Name, Email or Password or credentials has expired</p>";
				}
		}else{
			$perror = "<p style='color:red'> Error: Either Password, Email or Username is wrong<p>";
		}
					
		}else{
		
			$perror = "<p style='color:red'> Error: Election is Closed or Over and Cant logged you in<p>";
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
						<li> Login with Your Registtration Number As User Name.
						<li> Required Email Address is your Account Email Address.
						<li> Your Password is the Voting Code send to Your Email and Phone Number.
					</ul>
					<hr />
					<h4 style="color:blue;font-weight:bold;">Information !</h4>
					<hr />
					<ol>
						<li> After Login In Succesfully You can Cast your Vote by the bellow Steps.
								<ul>
									<li> Click on Any Portfolio (position) to expand in other to see the contestant.
									<li> Click on Vote Butoon beneath every contestant profile to cast vote for the Contestant.
								</ul>
						<li> If your Pin has expired before you complete Your Voting, you can as well go back to your Profile to request for Another Pin.
						<li> You will be able to view Live result using the Menu Option in the voting Page . to see the current vote gained by each contestants.
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
							<label for="inputW" class="control-label col-xs-4">User Name :</label>
							<div class="col-xs-8">
								<input type="text" class="form-control" id="inputW" name="inputW" value="<?php echo $_voter_regno; ?>" placeholder="Enter Reg_No As User Name">
							</div>
						</div>
						<div class="form-group">
							<label for="inputP" class="control-label col-xs-4">Email Address :</label>
							<div class="col-xs-8">
								<input type="email" class="form-control" id="inputP" name="inputP"  placeholder="Enter Email Address">
							</div>
						</div>
						<div class="form-group">
							<label for="inputP" class="control-label col-xs-4">Voting Pin :</label>
							<div class="col-xs-8">
								<input type="password" class="form-control" id="inputV" name="inputV"  placeholder="Enter Voting Pin">
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
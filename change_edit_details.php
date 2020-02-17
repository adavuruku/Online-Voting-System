<?php
session_start();
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$_voter_regno = $perror=$_voter_email=$_voter_phone=$_voter_Name=$_voter_Level=$_voter_Dept=$_voter_path=$notice_msg=$_voter_path_c=$error=$notice_msg_u=$notice_msg2="";
if(isset($_SESSION['reg_oo']))
{
	$_voter_regno = $hide=strip_tags($_SESSION['reg_oo']);
		if($hide==""){
		header("location: Voters_Login.php");
		}
}else{
	header("location: Voters_Login.php");
}
		
				if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_update']))
				{
					$J = checkempty($_POST['phone']);
					$K =checkempty($_POST['email']);
					$Ko =filterEmail($_POST['email']);
					$Jo = checksize($_POST['phone']);
					if (($J != FALSE) && ($K != FALSE)&&($Jo != FALSE) && ($Ko != FALSE)) {
						$stat = "";
						$_voter_phone=$_POST['phone'];
						$_voter_email=$_POST['email'];
						$stmt = $conn->prepare("UPDATE student_information SET Phone=?,Email=? WHERE reg_No=? Limit 1");
						$stmt->execute(array($_voter_phone,$_voter_email,$_SESSION['reg_oo']));
						$affected_rows = $stmt->rowCount();
						if($stmt == true) 
						{
							$notice_msg_u = "<p style='color:blue;font-weight:bold;'> Success: Record Updated Sucesfully!<p>";
							$_SESSION['message'] = '<div class="alert alert-info alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg_u.'</div>';
							header("location: Student_Profile_Home.php");
						}else{
							$notice_msg_u = "<p style='color:red;font-weight:bold;'> Error: Unable to Update Record!<p>";
							$_SESSION['message'] = '<div class="alert alert-danger alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg_u.'</div>';
						}
					}else{
					
						$notice_msg_u = "<p style='color:red;font-weight:bold;'> Error: Pleae Provide  A Valid Info!<p>";
							$_SESSION['message'] = '<div class="alert alert-danger alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg_u.'</div>';
					
					}
				}
				
				$stud_info="";
				$stmt = $conn->prepare("SELECT * FROM student_information WHERE reg_No=? Limit 1");
				$stmt->execute(array($_voter_regno));
				$affected_rows = $stmt->rowCount();
				if($affected_rows == 1) 
				{
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($row['pics_ext']  !=""){
						$_voter_path_c = str_replace("/","",$row['reg_No']).$row['pics_ext'];
						$_voter_path ='<img src="store_files/stud_pass/'.$_voter_path_c.'" style="height:200px;width:200px;border:4px solid blue;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
					}else{
						$_voter_path ='<img src="store_files/stud_pass/defaultpasport.jpg" style="height:200px;width:200px;border:4px solid blue;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
					}
					
					$_voter_regno=$row['reg_No'];
					$_voter_email=$row['Email'];
					$_voter_phone=$row['Phone'];
					$_voter_Name=$row['Stud_Name'];
					$_voter_Level=$row['Level'];
					$_voter_Dept=$row['Department'];
					$_SESSION['voter_pin_code'] = $_voter_Pin_Status =$row['v_code_status'];
					$_voter_gender=$row['Gender'];
					$_SESSION['voter_vote_code'] = $_voter_Status=$row['vote_status'];
					
					//$_SESSION['voter_pin_code'] ="";
					
					
					  
					if ($_voter_email==""){
						$notice_msg = "<p style='color:red;font-weight:bold;'> Important Notice: Please Upload a Valid Functional Email ID<p>";
					}
					if ($_voter_phone==""){
						$notice_msg = "<p style='color:red;font-weight:bold;'> Important Notice: Please Upload a Valid Phone Number<p>";
					}
					if($_voter_phone=="" and $_voter_email==""){
						$notice_msg = "<p style='color:red;font-weight:bold;'> Important Notice: Please Upload a Valid Phone No and a functional Email Address<p>";
					}
					if($notice_msg !=""){
						$notice_msg2 ='<div class="alert alert-danger alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg.'</div>';
					   }
				}else{
					header("location: sign_logout.php");
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
		<?php require_once 'settings/menu_file_profile.php';?>
	</div>
	
	
	<div class="row" >
	<div class="col-xs-1 col-sm-1"></div>
		<div class="col-xs-10 col-sm-10" style="background-color:white;Color:BLACK;border-width:3px;padding:15px;">
		<?php echo $notice_msg2;?>
			<div class="col-xs-4 col-sm-4">
					<?php 
						$para ='<ul class="nav nav-pills nav-stacked" >
						   <li class="active"><a href="Student_Profile_Home.php">My Home</a></li>
						   <li style="background-color:yellow;Color:red;font-weight:bold;" ><a href="sUg_vote_part.php">Cast My Vote</a></li>
						   <li><a href="change_edit_details.php">Update Phone Number</a></li>
						   <li><a href="change_edit_details.php">Update Email Address</a></li>';
						  if ($_voter_Pin_Status =="0"){
							$para = $para.'<li><a style="background-color:yellow;Color:red;font-weight:bold;" href="Student_Profile_Home.php?checkedosokorovo=s2Ewqirstv%wg!d&reged_to='.$_voter_regno.'">Generate Voting Code</a></li>';
						  }
						  /**if ($_SESSION['voter_vote_code']=="0"){
										echo '<li><a href="Vote_Analysis.php">Log Me Out Of Election Page</a></li>';
							}**/
						  
						$para = $para.'
						<li><a href="Vote_Analysis.php">View My Vote Statistic</a></li>
						<li><a href="sug_Live_result.php">View Live Election Result </a></li>
						<li class="active"><a href="sign_logout.php">Sign Out</a></li></ul>';
						echo $para;
					?>
			</div>
			<div class="col-xs-5 col-sm-5">
					<div class="col-xs-12 col-sm-12">
					<form role="form"  name="loginform"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
							   <caption> - Voters Detail Information Update - </caption>
							   
							   <tbody>
								<tr>
									 <td colspan="2"></td>
								  </tr>
								  <tr>
									 <td>Phone N<u>o</u> :</td>
									 <td><input type="phone" name="phone" value="<?php echo $_voter_phone;?>" ></input></td>
								  </tr>
								  <tr>
									 <td colspan="2"></td>
								  </tr>
								  <tr>
									 <td>Email Address :</td>
									 <td><input type="email" name ="email" value="<?php echo $_voter_email;?>" ></input></td>
								  </tr>
								  <tr>
									 <td colspan="2"></td>
								  </tr>
								  <tr>
									 <td><?php echo $error;?></td>
									 <td><input type="submit" name="edit_update" value="<< Update Record >>" ></input></td>
								  </tr>
								  <tr>
									 <td colspan="2"></td>
								  </tr>
								 
							   </tbody>
							</table>
						</div>
						</form>
					</div>
					<div class="col-xs-12 col-sm-12">
						<?php 
							
							echo $_SESSION['message'];
						?>
					</div>
					<div class="col-xs-12 col-sm-12">
						<?php 
							$date500 = new DateTime("Now");
							$J = date_format($date500,"D");
							$Q = date_format($date500,"d-F-Y, h:i:s A");
							$dateprint =$J.", ".$Q;
							echo '<p style=color:blue;font-weight:bold;font-style:italic;>'.$dateprint.'</p>';
						?>
					</div>
			</div>
			<div class="col-xs-3 col-sm-3">
					<?php echo $_voter_path;?>
			</div>
		</div>
		<div class="col-xs-1 col-sm-1"></div>
	</div>
	<?php require_once 'settings/footer_file.php';?>
<!-- container ends -->
</div>
</body>
</html>  
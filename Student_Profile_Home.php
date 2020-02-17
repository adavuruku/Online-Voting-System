<?php
session_start();
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$_voter_regno = $perror=$_voter_email=$_voter_phone=$_voter_Name=$_voter_Level=$_voter_Dept=$_voter_path=$notice_msg=$_voter_path_c=$notice_msg2="";
if(isset($_SESSION['reg_oo']))
{
	$_voter_regno = $hide=strip_tags($_SESSION['reg_oo']);
		if($hide==""){
		header("location: Voters_Login.php");
		}
}else{
	header("location: Voters_Login.php");
}
				//update the pin
				function update_record_of_pin($reg_no_W,$encoded_code,$expire_code){
					global $conn;
					
				}
				function send_Phone_message_to_user($_voter_email,$reg_no_W, $_voter_phone,$_voter_Name,$generated_code,$encoded_code,$expire_code)
				{
					//send phone message
						
					update_record_of_pin($reg_no_W,$encoded_code,$expire_code);
				}
				

 //generating voting code  
	if(isset($_SESSION['reg_oo']) && isset($_GET['reged_to']) && isset($_GET['checkedosokorovo']) )
	{

		 //verify student regno is same with the regno in session
		if($_SESSION['reg_oo'] != $_GET['reged_to']){
			header("location: sign_logout.php");
		}
		$f="0"; // 0 - election in progress 
		$stmt = $conn->prepare("SELECT * FROM admin_record where election_pin=? And election_status=? Limit 1");
		$stmt->execute(array($f,$f));
		$affected_rows = $stmt->rowCount();
		if($affected_rows >= 1) 
		{
			//verify the user still have an existing voting request
			$stmt = $conn->prepare("SELECT * FROM student_information where reg_No=?  AND v_code_status=? Limit 1");
			$stmt->execute(array($_SESSION['reg_oo'],"0"));
			$affected_rows = $stmt->rowCount();
			if($affected_rows >= 1) 
			{
				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($row['v_code_status']  =="1"){
					$notice_msg = "<p style='color:red;font-weight:bold;'> Error: You still Have a Valid election Pin .. you may check either your email and phone Number to get the PIN !<p>";
					$notice_msg2 ='<div class="alert alert-info alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg.'</div>';
				}else{
						$_voter_regno=$row['reg_No'];
						$_voter_email=$row['Email'];
						$_voter_phone=$row['Phone'];
						$_voter_Name=$row['Stud_Name'];
						$_voter_Level=$row['Level'];
						$_voter_Dept=$row['Department'];
						
						$d = mt_rand(10560,92070) + time();
						$k="";
						$z =str_split($d);
						$add = array("p","L","W9","3","Os","1K","Q8","SH","S","W");
						foreach ($z as $value)
						{
							$f=$add[$value];
							$k=$k.$f;
						}
						$generated_code="SUG".$k;
						//set expiry time - 30 Minute forward
						$startTime = date("d-m-Y h:i:s A");
						$expire_code =date('d-m-Y h:i:s A' , strtotime ('+1 hour', strtotime ($startTime)));
						$expire_code_save =date('Y-m-d H:i:s' , strtotime ('+1 hour', strtotime ($startTime)));	
						$encoded_code = sha1($generated_code);
						$reg_no_W = $_SESSION['reg_oo'];
						
						
						//send mail function
						//send_email_to_user();
						require 'PHPMailer-master/PHPMailerAutoload.php';
					$mail = new PHPMailer();
					$mail->isSMTP();
					$mail->SMTPDebug = 0;
					$mail->Debugoutput = 'html';
					$mail->Host = 'smtp.gmail.com';
					$mail->Port = 587;
					$mail->SMTPSecure = 'tls';
					$mail->SMTPAuth = true;
					$mail->Username = "atbusugevoting@gmail.com";
					$mail->Password = "sugatbu20162017";
					$mail->setFrom('atbusugevoting@gmail.com', 'ATBU - SUG ELECTION 2016 - 2017');
					
					//$mail->addReplyTo('aabdulraheemsherif@gmail.com', 'Federal Polytechnic Idah Hostels');
					$mail->addAddress($_voter_email, $_voter_Name);
					$mail->Subject = 'SUG - ATBU BAUCHI - 2016 / 2017 Election - ELCOM';
					$message = '<html>
						<body bgcolor="#5F9EA0">
						Hi ' .$_voter_Name. ',
						<br /><br />
						<P style="color:black;font-weight:bold">Bellow are the Details you need to Cast Your Vote </P>
						<br /><br />
						
						User Name : ' . $reg_no_W . ' <br />
						Email Address : ' . $_voter_email. ' <br />
						Voting Pin : '.$generated_code.' <br />
						Voting Pin Will Exipire at : '.$expire_code.' <br />
						Phone N<u>o</u> : '.$_voter_phone.'
						<br /><br /> 
						You can Click on these Button Bellow to Proceed to The Balewite E-Voting Site <br /><br /> 
						<a style="color:yellow;background-color:#5F9EA0;padding:10px;text-decoration:none;font-size:25;font-family: comic sans ms;font-weight:bold" href="../Online_Voting_System/Voters_Login.php?re_t='.$reg_no_W.'"> Cast Your Vote </a>
						<br /><br />
						Regards! <br />
						Abdulraheem Sherif A. <br />
						Elcom Chiarman SUG - 16/17 Election.
						</body>
						</html>';
					$mail->Body=$message;
					$mail->AltBody=$message;
					if ($mail->send())
					{
						//caall function to send to phone message
						//send_Phone_message_to_user($_voter_email,$reg_no_W, $_voter_phone,$_voter_Name,$generated_code,$encoded_code,$expire_code);
						$_voter_phone = substr($_voter_phone,1);
						$_voter_phone ="234".$_voter_phone;
						$message ="Your SUG Voting CODE - ".$generated_code ." - Expire - ".$expire_code;
						require ( "Nexmo-PHP-lib-master/src/NexmoMessage.php");
						$nexmo_sms = new NexmoMessage('3d50f545', 'e8cc5e1a1a22338e');
						$info = $nexmo_sms->sendText( $_voter_phone, 'ATBU - SUG - 16/17', $message);
						//echo $nexmo_sms->displayOverview($info);
						$stat = "1";
						$stmt = $conn->prepare("UPDATE student_information SET v_code=?,date_vote_code=?,v_code_status=? WHERE reg_No=? Limit 1");
						$stmt->execute(array($encoded_code,$expire_code_save,$stat,$reg_no_W));
						$affected_rows = $stmt->rowCount();
						if($stmt == true) 
						{
							$notice_msg = "<p style='color:blue;font-weight:bold;'> Success: Your Votin Pin request has been completed and an Email and Shortmessage Containing the Pin and Other Details has been
							been forwarded to your Email and Phone Number! <br />
							The Voting Pin will Expire By : ".$expire_code." <br /> Also please endeavour to keep them save<p>";
						$notice_msg2 ='<div class="alert alert-info alert-dismissable">
							   <button type="button" class="close" data-dismiss="alert" 
								  aria-hidden="true">
								  &times;
							   </button>'.$notice_msg.'</div>';
						}
					}
						
				}
				
				
				
			}else{
				$notice_msg = "<p style='color:red;font-weight:bold;'> Error: You still Have a Valid election Pin .. you may check either your email and phone Number to get the PIN !<p>";
					$notice_msg2 ='<div class="alert alert-info alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg.'</div>';
			
			}
		}else{
				$notice_msg = "<p style='color:red;font-weight:bold;'> Error: Ellection is over and hence Generating of Voting Code is Closed !<p>";
				$notice_msg2 ='<div class="alert alert-info alert-dismissable">
					   <button type="button" class="close" data-dismiss="alert" 
						  aria-hidden="true">
						  &times;
					   </button>'.$notice_msg.'</div>';
		}
	}
		
	
 //verify voting code request is still allowed
 //verify he dont have a valid pin and verify he has not voted
 
 //verify the request is still available
				
				
				
				$stud_info="";
				$stmt = $conn->prepare("SELECT * FROM student_information WHERE reg_No=? Limit 1");
				$stmt->execute(array($_SESSION['reg_oo']));
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
					$_voter_Pin_Status = $row['v_code_status'];
					$_SESSION['voter_pin_code'] = $_voter_Pin_Status ;
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
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
							   <caption> - Voters Detail Information - </caption>
							   
							   <tbody>
								  <tr>
									 <td>Student Name :</td>
									 <td><?php echo $_voter_Name;?></td>
								  </tr>
								  <tr>
									 <td>Registration N<u>o</u> :</td>
									 <td><?php echo $_voter_regno;?></td>
								  </tr>
								  <tr>
									 <td>Department :</td>
									 <td><?php echo $_voter_Dept;?></td>
								  </tr>
								  <tr>
									 <td>Level :</td>
									 <td><?php echo $_voter_Level;?></td>
								  </tr>
								  <tr>
									 <td>Gender :</td>
									 <td><?php echo $_voter_gender;?></td>
								  </tr>
								  <tr>
									 <td>Phone N<u>o</u> :</td>
									 <td><?php echo $_voter_phone;?></td>
								  </tr>
								  <tr>
									 <td>Email Address :</td>
									 <td><?php echo $_voter_email;?></td>
								  </tr>
							   </tbody>
							</table>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12">
						<?php 
							if($_SESSION['message']!=""){
								echo $_SESSION['message'];
							}
							
							$_SESSION['message']="";
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
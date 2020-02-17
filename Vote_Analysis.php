<?php
session_start();
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$_voter_regno = $perror=$_voter_email=$_voter_phone=$_voter_Name=$_voter_Level=$_voter_Dept=$_voter_path=$notice_msg=$_voter_path_c=$vote_details=$notice_msg2="";
if(isset($_SESSION['reg_oo']))
{
	$_voter_regno = $hide=strip_tags($_SESSION['reg_oo']);
		if($hide==""){
		header("location: Voters_Login.php");
		}
}else{
	header("location: Voters_Login.php");
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
					$vote_details =$row['vote_details'];
					
					  
					
						$notice_msg = "<p style='color:red;font-weight:bold;'> Important Notice: Refresh the page to see the recent vote gained by the bellow Contestant !<p>";
					
					if($notice_msg !=""){
					$notice_msg2 ='<div class="alert alert-info alert-dismissable">
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
<div class="container" style="padding:15px;">
	<div class="row">
		<!-- navigation menu -->
			<!-- navigation menu -->
		<?php require_once 'settings/menu_file_profile.php';?>
	</div>
	
	
	<div class="row" >
	<div class="col-xs-12 col-sm-12">
		<div class="col-xs-12 col-sm-12" style="background-color:white;Color:BLACK;border-width:3px;padding:15px;">
		<?php echo $notice_msg2;?>
			<div class="col-xs-3 col-sm-3">
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
						<li><a href="sug_Live_result.php" >View Live Election Result </a></li>
						<li class="active"><a href="sign_logout.php">Sign Out</a></li></ul>';
						echo $para;
					?>
			</div>
			<div class="col-xs-9 col-sm-9">
					<div class="col-xs-12 col-sm-12">
					<div id="accordion" class="panel-group" style="margin-top:10px;">
					<?php
					$display_Title ="<span style='color:blue;font-weight:bold;font-style:italic;'> Click to View the List of Candidtates You Have Voted in Favour</span>";
						$display_all ="";
						if($vote_details!="")
						{
							$verify_all= explode(';',$vote_details);
							$arrlength= count($verify_all);
							$new_list = array();
							for($x=0; $x < $arrlength; $x++)
							{
								$oyiza=explode('-',$verify_all[$x]);
								array_push($new_list,$oyiza[0]);
							}
							$arrlength_y= count($new_list);
							$data="";
							for($y=0; $y < $arrlength_y; $y++)
							{
								$search_id=$new_list[$y];
								$stmt2 = $conn->prepare("SELECT * FROM contestant_list where c_vote_id=? Limit 1");
								$stmt2->execute(array($search_id));
								$affected_rows2 = $stmt2->rowCount();
								if($affected_rows2 >= 1) 
								{
									$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
									$_voter_path_c = $row2['c_vote_id'].$row2['pics_ext'];
									$data =$data. '<div  class="col-sm-3 col-md-3 col-lg-3">
												<a class="thumbnail" href="#thumb">
													<img class="img-responsive img-thumbnail" src="store_files/stud_pass/contestant/'.$_voter_path_c.'"  border="0" />
												</a>
												</div>
												<div  class="col-sm-9 col-md-9 col-lg-9">
													<div class="table-responsive">
														<table class="table table-hover table-condensed">
														   <tbody>
																<tr>
																 <td>Name :</td>
																 <td>'.$row2['c_name'].'</td>
															  </tr>
															  
															  <tr>
																 <td>Registration N<u>o</u> :</td>
																 <td>'.$row2['c_regno'].'</td>
															  </tr>
															  <tr style="background-color:grey;Color:yellow;font-weight:bold;
																 border-width:5px solid;padding:10px;width:auto;">
																 <td>Contesting For : </td>
																 <td>'.$row2['c_position'].'</td>
															  </tr>
															  <tr>
																 <td>Faculty :</td>
																 <td>'.$row2['c_faculty'].'</td>
															  </tr>
															  
															  <tr>
																<td>Department :</td>
																 <td>'.$row2['c_dept'].'</td>
															  </tr>
															  <tr>
																<td>Level :</td>
																 <td>'.$row2['c_level'].'</td>
															  </tr>
															  <tr>
																<td>Email ID :</td>
																 <td>'.$row2['c_email'].'</td>
															  </tr>
															  <tr rowspan="2">
																 <td colspan="2" style="background-color:grey;Color:white;font-weight:bold;
																 border-width:5px solid;padding:10px;width:auto;">Vote Gained : <span >'.$row2['c_vote'].' Votes !</span></td>
															  </tr>
															  <tr rowspan="2">
																 <td colspan="2"></td>
															  </tr></tbody>
														</table>
													</div>
												</div>';
								}
							}
							$display_all =$display_all.'
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">'.$display_Title.'</a>
										</h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse">
										<div class="panel-body">'.
										$data.'
										</div>
									</div>
								</div>
							</div>';
							echo $display_all;
						}else{
					
						$notice_msg = "<p style='color:red;font-weight:bold;'> Information : No record of Voting Analysis for you since you have Not Cast Any Vote !<p>";
						if($notice_msg !=""){
						$notice_msg2 ='<div class="alert alert-danger alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert" 
							  aria-hidden="true">
							  &times;
						   </button>'.$notice_msg.'</div>';
								echo $notice_msg2;
							}
						}
					?>
						
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
		</div>
	</div>
	</div>
		</div>
	<?php require_once 'settings/footer_file.php';?>
<!-- container ends -->
</div>
</body>
</html>  
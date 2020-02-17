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
				$dkk="";$acredited_voters=0;
				$stmt = $conn->prepare("SELECT * FROM student_information WHERE Phone!=? and Email!=?");
				$stmt->execute(array($dkk,$dkk));
				$affected_rows = $stmt->rowCount();
				if($affected_rows >= 1) 
				{
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						$acredited_voters = $acredited_voters+1;
					}
				}
				
				
				$stud_info="";
				$d="1";
				$stmt = $conn->prepare("SELECT reg_No,v_code_status,pics_ext,Stud_Name,date_vote_code,vote_details FROM student_information WHERE reg_No=? Limit 1");
				$stmt->execute(array($_voter_regno));
				$affected_rows = $stmt->rowCount();
				if($affected_rows >= 1) 
				{
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$_SESSION['all_vote_id'] = $row['vote_details'];
					$_voter_Pin_Status =$row['v_code_status'];

					if ($row['pics_ext']  !=""){
						$_voter_path_c = $row['reg_No'].$row['pics_ext'];
						$_voter_path ='<img src="store_files/stud_pass/'.$_voter_path_c.'" style="height:200px;width:200px;border:4px solid blue;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
					}else{
						$_voter_path ='<img src="store_files/stud_pass/defaultpasport.jpg" style="height:200px;width:200px;border:4px solid blue;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
					}
				
				}
					
					//$_SESSION['all_vote_id']=$_SESSION['vote_details'];
					
					if ($_voter_email==""){
						$notice_msg = "<p style='color:brown;font-weight:bold;'> You are Welcome - ".$row['Stud_Name']." - ".$row['reg_No']." - -  Total Number Of Accredited Voters for this election is : ".$acredited_voters."<p>";
					}
					
					$notice_msg2 ='<div class="alert alert-info alert-dismissable">
					   <button type="button" class="close" data-dismiss="alert" 
						  aria-hidden="true">
						  &times;
					   </button>'.$notice_msg.' </div>';
	

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

<script type="text/javascript" src="settings/live_result_javascript.js"></script>

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
		<div class="col-xs-12 col-sm-12" style="background-color:grey;Color:BLACK;border-width:3px;padding:15px;">
		<?php echo $notice_msg2;?>
			<div class="col-xs-2 col-sm-2">
						<?php echo $_voter_path;?>
			</div>
			<div class="col-xs-10 col-sm-10" style="background-color:white;">
			
					<div class="col-xs-12 col-sm-12">
						<div id="accordion" class="panel-group" style="margin-top:10px;">
							<?php
								$stmt = $conn->prepare("SELECT * FROM sug_post_list where del_status=?");
								$stmt->execute(array("0"));
								$affected_rows = $stmt->rowCount();
								if($affected_rows >= 1) 
								{
									$j=0;
									$test_if_available = 0;
									while($row = $stmt->fetch(PDO::FETCH_ASSOC))
									{
										$display_Title ="<span style='color:blue;font-weight:bold;font-style:italic;'> Vote For - ".$row['sug_post'].'</span>';
										$display_all ="";
										$data="";
										$stmt2 = $conn->prepare("SELECT * FROM contestant_list where c_position=? And del_status=?");
										$stmt2->execute(array($row['sug_post'],"0"));
										$affected_rows2 = $stmt2->rowCount();
										if($affected_rows2 >= 1) 
										{
											$total_no_vote =0;
											$tot = 0;
											//$link_id_hide ='id="'.$row['sug_post_code'].'"';
											//$value_link_hide ="";
											
											$link_id_vote ='id="'.$row['sug_post_code'].'"';
											
											//$value_link = "Value=".$row['sug_post_code'];
											while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
											{
												$total_no_vote = $total_no_vote + $row2['c_vote'];
												$test_if_available = $test_if_available +1;
												//generate id for the disables function
												$tot =$tot +1;
												$id_click = $row['sug_post_code'].$tot;
												$link_id ='id="'.$id_click.'"';
												
												//id of user vote gained
												
												$link_id_c_vote ='id="'.$row2['c_vote_id'].'"';
												
												if ($row2['pics_ext']  !=""){
												$_voter_path_c = $row2['c_vote_id'].$row2['pics_ext'];
												$data =$data. '<div  class="col-sm-3 col-md-3 col-lg-3">
												<a class="thumbnail" href="#thumb">
													<img class="img-responsive img-thumbnail" style="height:200px;" src="store_files/stud_pass/contestant/'.$_voter_path_c.'"  border="0" />
												</a>
												</div>
												<div  class="col-sm-3 col-md-3 col-lg-3">
													<div class="table-responsive">
														<table class="table table-hover table-condensed">
														   <tbody>
															  <tr>
																 <td>'.$row2['c_name'].'</td>
															  </tr>
															  <tr>
																 <td>'.$row2['c_regno'].'</td>
															  </tr>
															  <tr>
																 <td>'.$row2['c_dept'].'</td>
															  </tr>
															  <tr>
																 <td>'.$row2['c_level'].'</td>
															  </tr>
															  <tr>
																 <td>'.$row2['c_email'].'</td>
															  </tr>
															  <tr rowspan="2">
																 <td colspan="2"></td>
															  </tr>
															  <tr rowspan="2">
																 <td colspan="2" style="background-color:grey;Color:white;font-weight:bold;
																 border-width:5px solid;padding:10px;width:auto;">Vote Gained : <span '.$link_id_c_vote.' >'.$row2['c_vote'].'</span></td>
															  </tr>
															  <tr rowspan="2">
																 <td colspan="2"></td>
															  </tr>';
															  
														   $data =$data.'</tbody>
														</table>
													</div>
												</div>';
												}
											}
										}
										//this is to make sure the portfolio that has no contestant not to display
										if ($test_if_available >=1)
										{
											$j = $j + 1;
											//$value_link_hide ='Value="'.$tot.'"';
											$display_Title = $display_Title." 	- 	 Total N<u>o</u> of Vote Casted - <span ".$link_id_vote." style='color:red;font-weight:bold;'>".$total_no_vote."  Votes ! </span>";
											$text = "collapseOne".$j;
											$text_2 = "#collapseOne".$j;
											$id="id=".$text;
											$id_two="href=".$text_2;
											$display_all =$display_all.'
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a data-toggle="collapse" data-parent="#accordion"'.$id_two.' >'.$display_Title.'</a>
															</h4>
														</div>
														<div '.$id.' class="panel-collapse collapse">
															<div class="panel-body">'.$data.'
																
															</div>
														</div>
													</div>';
													$test_if_available=0;
										}
										echo $display_all;
									}
								}
							
							?>
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
			
			</div>
	</div>
	<?php require_once 'settings/footer_file.php';?>
<!-- container ends -->
</div>
</body>
</html>  
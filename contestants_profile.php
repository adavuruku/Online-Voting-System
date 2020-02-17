<?php
session_start();
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$_voter_regno = $perror=$_voter_email=$_voter_phone=$_voter_Name=$_voter_Level=$_voter_Dept=$_voter_path=$notice_msg=$_voter_path_c=$notice_msg2="";

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
				
				
				
					
					if ($_voter_email==""){
					$date500 = new DateTime("Now");
							$J = date_format($date500,"D");
							$Q = date_format($date500,"Y-F-d, h:i:s A");
							$dateprint =$J.", ".$Q;
						$notice_msg = "<p style='color:brown;font-weight:bold;'> Total Number of Accredited Voters as at - ".$dateprint." - - is : ".$acredited_voters."<p>";
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

<script type="text/javascript" src="settings/Add_and_Remove_from_Cart.js"></script>

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
		<div class="col-xs-12 col-sm-12" style="background-color:grey;Color:BLACK;border-width:3px;padding:15px;">
		<?php echo $notice_msg2;?>
			<div class="col-xs-12 col-sm-12" style="background-color:white;">
			
					<div class="col-xs-12 col-sm-12">
						<div id="accordion" class="panel-group" style="margin-top:10px;">
							<?php
								$stmt = $conn->prepare("SELECT * FROM sug_post_list where del_status=?");
								$stmt->execute(array("0"));
								$affected_rows = $stmt->rowCount();
								if($affected_rows >= 1) 
								{
									$j=0;
									
									while($row = $stmt->fetch(PDO::FETCH_ASSOC))
									{
										$display_Title ="<span style='color:blue;font-style:italic;'> Canditate for the Post of - ".$row['sug_post'].'</span>';
										$display_all ="";
										$data="";
										$stmt2 = $conn->prepare("SELECT * FROM contestant_list where c_position=? and del_status=?");
										$stmt2->execute(array($row['sug_post'],"0"));
										$affected_rows2 = $stmt2->rowCount();
										if($affected_rows2 >= 1) 
										{
											//$value_link = "Value=".$row['sug_post_code'];
											$total_no_vote=$tot=0;
											while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
											{
												$total_no_vote = $total_no_vote + 1;
												
												//generate id for the disables function
												$tot =$tot + 1;
												if ($row2['pics_ext']  !=""){
												$_voter_path_c = $row2['c_vote_id'].$row2['pics_ext'];
												$data =$data. '<div  class="col-sm-3 col-md-3 col-lg-3">
												<a class="thumbnail" href="#thumb">
													<img class="img-responsive img-thumbnail" style="height:250px;" src="store_files/stud_pass/contestant/'.$_voter_path_c.'"  border="0" />
												</a>
												</div>
												<div  class="col-sm-3 col-md-3 col-lg-3">
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
										$j = $j + 1;
										$display_Title = $display_Title." 	- 	 Total N<u>o</u> of Contestant - <span style='color:red;font-weight:bold;'>".$total_no_vote."  Contesting ! </span>";
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
										echo $display_all;
									}
								}
							}
							?>
						</div>
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
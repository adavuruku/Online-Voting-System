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
<script type="text/javascript">
function track_voting_result()
{
	location.reload(true);
}
setTimeout('track_voting_result();', 5000);
</script>



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
				<h4 style="color:blue;text-align:center;font-weight:bold;font-style:italic;">List Of Ellection Result as At 
				<?php 
							$date500 = new DateTime("Now");
							$J = date_format($date500,"D");
							$Q = date_format($date500,"d-F-Y, h:i:s A");
							$dateprint =$J.", ".$Q;
							echo $dateprint;?></h4>
							<h4 style="text-align:center;"><a style="color:red;text-align:center;font-weight:bold;font-style:italic;"  href="store_files/user_download_result.php" target="_blank">Click to Here to Print Result </a></h4> 
				<?php
						//check if election is in progress or done - show result if in progress also if done but dont show if not any
						$ff="0"; // 0 -in progress 1-not in progress
						$stmt2 = $conn->prepare("SELECT * FROM admin_record where election_status=?");
										$stmt2->execute(array($ff));
										$affected_rows2 = $stmt2->rowCount();
										if($affected_rows2 >= 1) 
										{
												$stmt2 = $conn->prepare("SELECT * FROM contestant_list where del_status=? order by c_position asc");
												$stmt2->execute(array("0"));
												$affected_rows2 = $stmt2->rowCount();
												if($affected_rows2 >= 1) 
												{
													echo '<table class="table table-condensed" style="background-color:#FFFFFF;margin-top:5px">
																				<thead style="background-color:none;color:blue">
																					<tr>
																						<th>S/N<u>o</u>.</th>
																						<th>Contestant Name</th>
																						<td >Faculty</td>
																						<td >Department</td>
																						<td >Level</td>
																						<td >Gender</td>
																						<th>Position</th>
																						<td >Vote Gained</td>
																					</tr>
																				</thead>
																				<tbody>';
													$total_no_vote =0;
													$data="";
													while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
													{
														$total_no_vote = $total_no_vote + 1;
														$data=$data.'<tr > 
																			<td>'.$total_no_vote.'</td> 	
																			<td>'.$row2['c_name'].'</td>
																			
																			<td>'.$row2['c_faculty'].'</td>
																			<td>'.$row2['c_dept'].'</td>
																			<td>'.$row2['c_level'].'</td>
																			<td>'.$row2['c_gender'].'</td>
																			<td>'.$row2['c_position'].'</td>
																			<td>'.$row2['c_vote'].'</td>
																	</tr>';
														
													}
													echo $data.'</tbody></table>';
												}
										}else{
										$notice_msg_u = "<p style='color:blue;font-weight:bold;'> Sorry : No Election result yet .. Result will be available here during and after the election<p>";
										echo '<div class="alert alert-info alert-dismissable">
									   <button type="button" class="close" data-dismiss="alert" 
										  aria-hidden="true">
										  &times;
									   </button>'.$notice_msg_u.'</div>';
										
										}
				?>
			</div>
		</div>
	</div>
	<?php require_once 'settings/footer_file.php';?>
<!-- container ends -->
</div>
</body>
</html>  

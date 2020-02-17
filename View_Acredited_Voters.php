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
<style>

</style>


  <script type="text/javascript">
	/*$(document).ready(function(){
		$("#myModal").modal('show');		
	});*/
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
					<form role="form" name="mailform" class="form-horizontal" action="Search_result.php" enctype="multipart/form-data" method="GET">
						<div class="form-group">
							<label for="inputEmail" class="control-label col-xs-3">Enter Reg_No / Any Part Of your Name :</label>
							<div class="col-xs-7">
								<input type="text" class="form-control" id="inputEmail" name="searchmail" placeholder="Enter Reg_No / Any Part of your Name to Search">
							</div>
							<div class=" col-lg-2">
								<button type="submit" value="xErWqu" name="submitsearch" class="btn btn-success">Search Mail</button>
							</div>
						</div>
					</form>
			</div>
			
			<div class="col-xs-12 col-sm-12" style="background-color:white;font-weight:bold;font Colour:red">
				<h4 style="color:blue;text-align:center;">List Of All Acredited Voters</h4>
				<?php
					//create a mySQL connection
					$dbhost    = 'localhost';
					$dbuser    = 'root';
					$dbpass    = '';
					$conn = mysql_connect($dbhost, $dbuser, $dbpass);
					if (!$conn) {
						die('Could not connect: ' . mysql_error());
					}
					mysql_select_db('online_voting');
					/* Get total number of records */
					$status="";
					$search_2="Documentation";
					$sql = "SELECT count(*) FROM student_information where phone!='".$status."' AND Email!='".$status."'";
					$retval = mysql_query($sql, $conn);
					
					if (!$retval)
					{
						die('Could not get data: ' . mysql_error());
					}
					
					//this is the current page per number ($current_page)
					//anytime u click the program always come here to test if what you click
					//if u have click i.e u click 1 it check if u have click if not it select the first one
					//asive u just reload the page if u click $_GET['page'] will be set but once u statr the
					//page for the first $_GET['page'] will not be set
					
					$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
				
					//record per Page($per_page)	
					$per_page = 50;
					
					//total count record ($total_count) execute the sqlquery set using MYSQL_NUM
					//TO get the total number return from executing Sql in line 47
					$row = mysql_fetch_array($retval, MYSQL_NUM);
					//the total number of page is in this variable bellow $total_count
					$total_count = $row[0];
					
					//it gets the result of total_count over per page
					//i.e it devides the total record according to the number of record you want to
					//dispaly at a time i.e 100/10 = 10 pages
					$total_pages = ceil($total_count/$per_page);
					
					//get the offset current page minus 1 multiply by record per page
					//offset is where the record counting should start and where it should end
					//is always calculate as the number u click on minus one times the number of page that
					//shoul be dispaly in each page i.e (2-1)*10 = 1*10 = 10
					//(3-1)*10 = 20
					//4=30 5=40 e.t.c
					$offset = ($current_page - 1) * $per_page;
					
					//in every click set the previous pages and next page clicking down in case any body click on it
					//move to previous record by subtracting one into the current record
					$previous_page = $current_page - 1;
					//mvove to next record by incrementing the current page by one		
					$next_page = $current_page + 1;
					//check if previous record is still greater than one then it returns to true
					$has_previous_page =  $previous_page >= 1 ? true : false;
					//check if Next record is still lesser than one total pages then it returns to true
					$has_next_page = $next_page <= $total_pages ? true : false;
					
					//find records of employee and we specify the offset and the limit record per page
					$status="";
					$sql = "(SELECT * FROM student_information where phone!='".$status."' AND Email!='".$status."' ORDER BY id ASC LIMIT {$per_page} OFFSET {$offset})"; 
					$retval = mysql_query($sql, $conn);
					if (!$retval) {
						die('Could not get data: ' . mysql_error());
					}else{
						$date500 = new DateTime("Now");
						$J = date_format($date500,"D");
						$Q = date_format($date500,"d-F-Y, h:i:s A");
						$dateprint =$J.", ".$Q;	
						echo '<h5 style="text-align:center;color:brown"> - '.$dateprint.' - </h5><p id="result2"></p>';
						echo '<table class="table table-condensed" style="background-color:#FFFFFF;margin-top:5px">
																		<thead style="background-color:none;color:blue">
																			<tr>
																				<th>S/N<u>o</u>.</th>
																				<th>Student Name</th>
																				<th>Registration N<u>o</u></th>
																				<td >Department</td>
																				<td >Level</td>
																				<td >Gender</td>
																				<td >Phone N<u>o</u></td>
																				<td >Email</td>
																			</tr>
																		</thead>
																		<tbody>';
											
											$j = 1;
											$data="";
											$data_list="";
											while ($row_retrieve = mysql_fetch_array($retval, MYSQL_ASSOC)) 
											{
												$name=$row_retrieve['reg_No'];
												$j="Voters_Login.php?re_t=".$row_retrieve['reg_No'];
												$user_link = '<a class="delpointer" href='.$j.' title='.$row_retrieve['Stud_Name'].' data-toggle="popover">
																  '.$name.'</a>';	
												$data=$data.'<tr >
																	<td>'.$row_retrieve['id'].'</td> 	
																	<td>'.$row_retrieve['Stud_Name'].'</td>
																	<td>'.$user_link.'</td>
																	<td>'.$row_retrieve['Department'].'</td>
																	<td>'.$row_retrieve['Level'].'</td>
																	<td>'.$row_retrieve['Gender'].'</td>
																	<td>'.$row_retrieve['Phone'].'</td>
																	<td>'.$row_retrieve['Email'].'</td>
																	
																	
															</tr>';
													//$j =$j +1;
											}
											echo $data.'</tbody></table>';
											//echo $cart_all_result;
											echo '<ul class="pagination" align="center">';
														
											if ($total_pages > 1)
											{
												//this is for previous record
												if ($has_previous_page)
												{
												echo ' <li><a href=View_Acredited_Voters.php?page='.$previous_page.'>&laquo; </a> </li>';
												}
												 //it loops to all pages
												 for($i = 1; $i <= $total_pages; $i++)
												 {
													//check if the value of i is set to current page	
													if ($i == $current_page)
													{
													//then it sset the i to be active or focused
														echo '<li class="active"><span>'. $i.' <span class="sr-only">(current)</span></span></li>';
													 }
													 else
													 {
													 //display the page number
														echo ' <li><a href=View_Acredited_Voters.php?page='.$i.'> '. $i .' </a></li>';
													 }
												 }
												//this is for next record		
												if ($has_next_page)
												{
													echo ' <li><a href=View_Acredited_Voters.php?page='.$next_page.'>&raquo;</a></li> ';
												}
												
											}
											
											echo '</ul>';
											mysql_close($conn);
							}
					?>
				
				<!-- d end php -->
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
			</div>
		</div>
	</div>
	<?php require_once 'settings/footer_file.php';?>
<!-- container ends -->
</div>
</body>
</html>  

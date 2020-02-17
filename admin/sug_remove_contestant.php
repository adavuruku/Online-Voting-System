
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';
$g_price =$g_subcategory=$g_category=$g_description =$g_name=$goods_id =$folder_name=$err = "";
if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: ../exam_logout.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin Permission | SUG - ATBU E-Voting </title>
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
<script type="text/javascript" src="../settings/edit_goods.js"></script>
</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			
				<div  class="col-sm-11 col-md-11 col-lg-11">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U Election | Remove Contestant</h3>
						<h5 style="text-align:center;color:yellow">Welcome	-	Administrator <?php echo $_SESSION['Admin_user_full_name'];?> - <a style="color:white" href="../exam_logout.php">Log Out</a> | <a style="color:white" href="Admin_Home.php">Admin Home</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%;  padding:10px; background-color:CadetBlue;margin-bottom:1%;">
							<?php
											//create a mySQL conn_twoection
											$dbhost    = 'localhost';
											$dbuser    = 'root';
											$dbpass    = '';
											$conn_two = mysql_connect($dbhost, $dbuser, $dbpass);
											if (!$conn_two) {
												die('Could not conn_twoect: ' . mysql_error());
											}
											mysql_select_db('online_voting');
											/* Get total number of records */
											$sql    = "SELECT count(id) FROM contestant_list";
											$retval = mysql_query($sql, $conn_two);
											
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
											$per_page = 20;
											
											//total count record ($total_count) execute the sqlquery set using MYSQL_NUM
											//TO get the total number return from executing Sql in line 47
											$row = mysql_fetch_array($retval, MYSQL_NUM);
											//the total number of page is in this variable bellow $total_count
											$total_count = $row[0];
											
											//it gets the result of total_count over per page
											//i.e it devides the total record according to the number of record you want to
											//dispaly at a time i.e 100/10 = 10 pages
											$total_pages = $total_count/$per_page;
											
											//get the offset current page minus 1 multiply by record per page
											//offset is where the record counting should statr and where it should end
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
											$status="0";
											$sql = "(SELECT * FROM contestant_list where del_status='".$status."'ORDER BY c_position ASC LIMIT {$per_page} OFFSET {$offset})"; 
											$retval = mysql_query($sql, $conn_two);
											if (!$retval) {
												die('Could not get data: ' . mysql_error());
											}else{
											$date500 = new DateTime("Now");
											$J = date_format($date500,"D");
											$Q = date_format($date500,"d-F-Y, h:i:s A");
											$dateprint = "For : ".$J.", ".$Q;	
											echo '<h4 style="text-align:left;color:yellow">List Of All Contestants - '.$dateprint.'</h4><p id="result2"></p>';
											echo '<table border="1" class="table table-condensed">
																		<thead style="background-color:grey;color:yellow">
																			<tr>
																				<th>S/N<u>o</u>.</th>
																						<th>Contestant Name</th>
																						<th>Position</th>
																						<th>Faculty</th>
																						<th>Department</th>
																						<th>Level</th>
																						<th>Gender</th>
																						<th>Date</th>
																						<th></th>
																			</tr>
																		</thead>
																		<tbody style="background-color:white;">';
											}
											$j = 1;
											$data="";
											$data_list="";
											while ($row_retrieve = mysql_fetch_array($retval, MYSQL_ASSOC)) 
											{
																						
												$data=$data.'<tr >
																	<td>'.$j.'</td>
																	<td>'.$row_retrieve['c_name'].'</td>
																	<td>'.$row_retrieve['c_position'].'</td>
																	<td>'.$row_retrieve['c_faculty'].'</td>
																	<td>'.$row_retrieve['c_dept'].'</td>
																	<td>'.$row_retrieve['c_level'].'</td>
																	<td>'.$row_retrieve['c_gender'].'</td>
																	<td>'.$row_retrieve['c_date_reg'].'</td>
																	<td><a href="#" title="Delete_Item" style="color:yellow" 
																	onclick="delete_Cart(\''.$row_retrieve['c_vote_id'].'\',\''.$row_retrieve['c_name'].'\')">
																	<img src="../store_files/images/delete-icon.jpg" style="height:20px" ></img></a></td>
																	
																	
															</tr>';
													$j =$j +1;
											}
											echo $data.'</table>';
											//echo $cart_all_result;
											echo '<ul class="pagination" align="center">';
														
											if ($total_pages > 1)
											{
												//this is for previous record
												if ($has_previous_page)
												{
												echo ' <li><a href=sug_remove_contestant.php?page='.$previous_page.'>&laquo; </a> </li>';
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
														echo ' <li><a href=sug_remove_contestant.php?page='.$i.'> '. $i .' </a></li>';
													 }
												 }
												//this is for next record		
												if ($has_next_page)
												{
													echo ' <li><a href=sug_remove_contestant.php?page='.$next_page.'>&raquo;</a></li> ';
												}
												
											}
											
											echo '</ul>';
											mysql_close($conn_two);
					?>
							
					</div>
							
				</div>
				<div  class="col-sm-1 col-md-1 col-lg-1"></div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
		<div class="row">
			<div class="col-xs-2 col-sm-2"></div>	
				<div class="col-xs-8 col-sm-8" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2017 - All Rights Reserved - Software Development Unit, A T B U - S U G.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>
<script>
   $(function () { $("[data-toggle='tooltip']").tooltip(); });
</script>		
</div>	
</body>
</html>  

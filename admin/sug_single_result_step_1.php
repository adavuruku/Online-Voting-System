
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';
$err=$err2 =$reg_no=$portfolio= "";
if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: ../exam_logout.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Submit_odas_two']))
{
			$portfolio =$_POST['portfolio'];
			if($portfolio !="")
			{
				$stmt = $conn->prepare("SELECT c_position,c_position_code,del_status FROM contestant_list where c_position_code=? and del_status=?");
				$stmt->execute(array($portfolio,"0"));
				$affected_rows = $stmt->rowCount();
				if($affected_rows >= 1) 
				{	
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
						$_SESSION['c_position_A'] = $row['c_position'];
						header ("location: ../store_files/sug_print_single_portfolio.php");
				}else{
					$err ="No Record Found here";
				}
			}
}



if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Submit_odas']))
{
			$reg_no =$_POST['reg_no'];
			if($reg_no !="")
			{
				$stmt = $conn->prepare("SELECT * FROM contestant_list where c_vote_id=? and del_status=?");
				$stmt->execute(array($reg_no,"0"));
				$affected_rows = $stmt->rowCount();
				if($affected_rows >= 1) 
				{	
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
						$_SESSION['c_vote_id_A'] = $row['c_vote_id'];
						header ("location: ../store_files/sug_print_single_result.php");
				}else{
					$err2 ="No Record Found";
				}
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
</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;" onload="fill_Date_Combo();">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			<div  class="col-sm-2 col-md-2 col-lg-2"  >
				<!-- display user details like passport ..name.. ID ..Class type -->
			</div>
				<div  class="col-sm-8 col-md-8 col-lg-8">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">S U G A T B U - PRINT REPORT </h3>
						<h5 style="text-align:center;color:yellow">Welcome	-	Administrator <?php echo $_SESSION['Admin_user_full_name'];?> - <a style="color:white" href="../exam_logout.php">Log Out</a> | <a style="color:white" href="Admin_Home.php">Admin Home</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:0px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%;color:yellow">
				
							<h4>&darr; Print Reports On (Contestants / Portfolio) &darr; </h4>
						<hr/>
						
						<div class="col-xs-10 col-sm-10" style="//display: none;" >
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
							<div class="form-group">
									<label for="type" class="control-label col-xs-3">Portfolio :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
											<select class="form-control"  id="portfolio" value="<?php echo $portfolio; ?>" name="portfolio">
												<?php
													$stmt2 = $conn->prepare("SELECT * FROM sug_post_list order by sug_post asc");
													$stmt2->execute();
													$affected_rows2 = $stmt2->rowCount();
													if($affected_rows2 >= 1) 
													{
														$sam="";
														while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
														{
															$sam=$sam.'<option value="'.$row2['sug_post_code'].'">'.$row2['sug_post'].'</option>';
														}
														echo $sam;
													}
												?>
											</select>
									</div> 
							</div> 
							<br/>
							<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:0px; background-color:grey;margin-bottom:1%">
								<div class="form-group">
											<label for="" class="control-label col-xs-8"><?php echo $err;?></label>
											<div class="col-xs-4">
												<div class="input-group">
														<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value="Search By Portfolio" name="Submit_odas_two"  ></input>
												</div>
											</div>									
									</div>
							</div>
							
								<div class="form-group">
									<label for="type" class="control-label col-xs-3">Contestant Id :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text"  class="text_field form-control"  id="reg_no" name="reg_no" value="<?php echo $reg_no; ?>" placeholder="Enter Contestant Id" >
											</div>
									</div> 
							</div> 
													
								
							<br/>
							<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:0px; background-color:grey;margin-bottom:1%">
								<div class="form-group">
											<label for="" class="control-label col-xs-8"><?php echo $err2;?></label>
											<div class="col-xs-4">
												<div class="input-group">
														<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value="Search By ID" name="Submit_odas"  ></input>
												</div>
											</div>									
									</div>
							</div>
						</div>
						
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>		
				
				<div  class="col-sm-2 col-md-2 col-lg-2"></div>
				
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
</div>	
</body>
</html>  

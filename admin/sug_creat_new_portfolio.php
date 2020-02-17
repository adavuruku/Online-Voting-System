
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';
$g_price =$g_subcategory=$g_category=$g_description =$g_name=$goods_id =$folder_name=$err = "";
$reg_no =$f_name =$portfolio= $faculty =$department =$level =$gender= $s_origin =$address =$phone =$email="";
if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: exam_logout.php");
}
function verify_existence($search_id){
global $conn;
	$stmt = $conn->prepare("SELECT * FROM sug_post_list WHERE sug_post_code=?  Limit 1");		
	$stmt->execute(array($search_id));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1){
		$row2 = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row2['c_vote_id'];
	}else{
		return "Not Exist";
	}
	
}
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Submit_odas']))
{ 
	$reg_no =$_POST['reg_no'];
	//check for empty
	if($reg_no!="")
	{
		//check if same name dont exist
		$stmt = $conn->prepare("SELECT * FROM sug_post_list WHERE sug_post=?  Limit 1");		
		$stmt->execute(array($reg_no));
		$affected_rows = $stmt->rowCount();
		if($affected_rows >= 1)
		{
			$err = '<p style="color:red">Error :Title already exist</p>';
		}else
			{
				//save Records
				$folder_name = mt_rand(8656230560,9261070347) + time();
				$out_come = verify_existence($folder_name);
				if($out_come != "Not Exist"){
					$folder_name = $out_come + "S";
				}
						
				
				//insert record to Database
				$reg_no =$_POST['reg_no'];
				$sth = $conn->prepare ("INSERT INTO sug_post_list (sug_post_code,sug_post,del_status) VALUES (?,?,?)");
							
							
							$sth->bindValue (1, $folder_name); 
							$sth->bindValue (2, $reg_no); 
							$sth->bindValue (3, "0"); 
							if($sth->execute()){
								$err = '<p style="color:white"> Record Saved - Successfully</p>';
							}
			}
	}
	else
	{
		$err = '<p style="color:red">Error :Some Fields are Empty</p>';
	}
}	
if(isset($_SESSION['u_name']) AND isset($_SESSION['outcome']))
{
	unset($_SESSION['u_name']);
	unset($_SESSION['outcome']);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin Register | SUG - ATBU E-Voting </title>
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
		
			<div  class="col-sm-2 col-md-2 col-lg-2"  >
				<!-- display user details like passport ..name.. ID ..Class type -->
			</div>
				<div  class="col-sm-8 col-md-8 col-lg-8">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">S U G A T B U - Register New Portfolio</h3>
						<h5 style="text-align:center;color:yellow">Welcome	-	Administrator <?php echo $_SESSION['Admin_user_full_name'];?> - <a style="color:white" href="../sign_logout.php">Log Out</a> | <a style="color:white" href="Admin_Home.php">Admin Home</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:0px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%;color:yellow">
				
							<h4>&darr; Register New Contestant &darr;</h4>
						<hr/>
						
						<div class="col-xs-10 col-sm-10" style="//display: none;" >
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
							<div class="form-group"> 
									<label for="reg_no" class="control-label col-xs-3">Title of Portfolio :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text"  class="text_field form-control"  id="reg_no" name="reg_no" value="<?php echo $reg_no; ?>" placeholder="Enter Enter Portfolio Title" >
											</div>
										</div>
							</div>
							
							<br/>
						<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:0px; background-color:grey;margin-bottom:1%">
						<div class="form-group">
									<label for="" class="control-label col-xs-9"><?php echo $err;?></label>
									<div class="col-xs-3">
										<div class="input-group">
												<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value="Save New Record" name="Submit_odas"  ></input>
										</div>
									</div>									
							</div>
						</form>
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

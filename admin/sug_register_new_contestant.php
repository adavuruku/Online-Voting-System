
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
function water_mark_image($moveto2,$ext)
{
		$watermark = imagecreatefrompng('../store_files/images/fpiputme.png');
		$watermark_widht = imagesx($watermark);
		$watermark_height =imagesy($watermark);
		$image =imagecreatetruecolor ($watermark_widht, $watermark_height);
		$image = imagecreatefromjpeg($moveto2);
		$image_size = getimagesize($moveto2);
		$x = $image_size[0] - $watermark_widht - 20;
		$y = $image_size[1] - $watermark_height - 20;
		imagecopymerge($image, $watermark, $x, $y, 0, 0, $watermark_widht, $watermark_height, 50);
		//this saves it to its destination folder
		imagejpeg ($image,$moveto2);
}
function ak_img_resize($target, $newcopy, $w, $h, $ext) 
{
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } else {
           $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
      $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
      $img = imagecreatefrompng($target);
    } else { 
      $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
	water_mark_image($target,$ext);
}
function verify_existence($search_id){
global $conn;
	$stmt = $conn->prepare("SELECT * FROM contestant_list WHERE c_vote_id=?");		
	$stmt->execute(array($search_id));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1){
		$row2 = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row2['c_vote_id'];
	}else{
		return "Not Exist";
	}
	
}
if($_SERVER['REQUEST_METHOD'] == "POST" && $_FILES['photo_one']['name']!="")
{ 
		$f_name=$_POST['f_name'];$reg_no =$_POST['reg_no'];$portfolio =$_POST['portfolio'];$faculty =$_POST['faculty'];$department =$_POST['department'];
					$level =$_POST['level'];$gender =$_POST['gender'];$s_origin =$_POST['s_origin'];$address =$_POST['address'];
					$phone =$_POST['phone'];$email =$_POST['email'];
		
	//check for empty
	if($f_name!="" && $reg_no!="" && $portfolio!="" && $faculty!="" && $department!="" && $level!=""
	&& $gender!="" && $s_origin!="" && $address!="" && $phone!="" && $email!="")
	{
		//save Records
		$folder_name = mt_rand(8230560,9261070) + time();
		$out_come = verify_existence($folder_name);
		if($out_come != "Not Exist"){
			$folder_name = $out_come + "A";
		}
		$goods_id = $fPath = "../store_files/stud_pass/contestant/";
		
		if($_FILES['photo_one']['name']!="")
		{
			$tmpName  = $_FILES['photo_one']['tmp_name'];
			$extension = substr(strrchr($_FILES['photo_one']['name'], "."), 1);
			$newpath= $folder_name.".$extension";
			$moveto= $goods_id."/".$newpath;
			move_uploaded_file($tmpName,$moveto);
			$wmax = 400;
			$hmax = 300;
			ak_img_resize($moveto, $moveto, $wmax, $hmax, $extension);
		}		
		
		//search for position
		$c_position="";
		$stmt = $conn->prepare("SELECT * FROM sug_post_list WHERE sug_post_code=? Limit 1");		
		$stmt->execute(array($portfolio));
		$affected_rows = $stmt->rowCount();
		if($affected_rows >= 1){
		$row2 = $stmt->fetch(PDO::FETCH_ASSOC);
		 $c_position = $row2['sug_post'];
		//return $row2['c_vote_id'];
		}
		
		//insert record to Database
		$f_name=$_POST['f_name'];$reg_no =$_POST['reg_no'];$portfolio =$_POST['portfolio'];$faculty =$_POST['faculty'];$department =$_POST['department'];
					$level =$_POST['level'];$gender =$_POST['gender'];$s_origin =$_POST['s_origin'];$address =$_POST['address'];
					$phone =$_POST['phone'];$email =$_POST['email'];
		$sth = $conn->prepare ("INSERT INTO contestant_list (c_name, c_dept, c_regno, c_level,c_faculty,c_gender,c_phone,c_email,c_state,c_address,
		c_position,c_position_code,c_vote_id,pics_ext,del_status,c_date_reg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())");
					
					
					$sth->bindValue (1, $f_name); 
					$sth->bindValue (2, $department); 
					$sth->bindValue (3, $reg_no); 
					$sth->bindValue (4, $level); 
					$sth->bindValue (5, $faculty);
					$sth->bindValue (6, $gender); 
					$sth->bindValue (7, $phone); 
					$sth->bindValue (8, $email); 
					$sth->bindValue (9, $s_origin); 
					$sth->bindValue (10, $address);
					$sth->bindValue (11, $c_position); 
					$sth->bindValue (12, $portfolio);
					$sth->bindValue (13, $folder_name); 
					$sth->bindValue (14, ".".$extension);
					$sth->bindValue (15, "0"); 
					if($sth->execute()){
						$err = '<p style="color:white"> Record Saved - Successfully</p>';
					}
					//$affected_rows = $sth->rowCount();
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
						<h3 style="text-align:center;color:white">S U G A T B U - Register New Contestant</h3>
						<h5 style="text-align:center;color:yellow">Welcome	-	Administrator <?php echo $_SESSION['Admin_user_full_name'];?> - <a style="color:white" href="../sign_logout.php">Log Out</a> | <a style="color:white" href="Admin_Home.php">Admin Home</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:0px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%;color:yellow">
				
							<h4>&darr; Register New Contestant &darr;</h4>
						<hr/>
						
						<div class="col-xs-10 col-sm-10" style="//display: none;" >
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
							<div class="form-group">
									<label for="f_name" class="control-label col-xs-3">Full Name :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text"  class="text_field form-control"  id="f_name" name="f_name" value="<?php echo $f_name; ?>" placeholder="Enter Contestant Name" >
											</div>
										</div>
							</div>
							<div class="form-group"> 
									<label for="reg_no" class="control-label col-xs-3">Registration N<u>o</u> :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
													<input type="text"  class="text_field form-control"  id="reg_no" name="reg_no" value="<?php echo $reg_no; ?>" placeholder="Enter Registration No" >
											</div>
										</div>
							</div>
							<div class="form-group">
									<label for="portfolio" class="control-label col-xs-3">Portfolio :<span style="color:red;padding:0px"class"require">*</span></label>
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
							
							<div class="form-group">
									<label for="faculty" class="control-label col-xs-3">Faculty :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
											<select class="form-control"  onChange="schoolComboChange();" id="faculty" value="<?php echo $faculty; ?>" name="faculty">
													<option value="Agriculture">Agriculture</option>
													<option value="Bussiness Studies" >Bussiness Studies</option>
													<option value="Engineering" >Engineering</option>
													<option value="Environmental Studies" >Environmental Studies</option>
													<option value="Science" >Science</option>
													<option value="Engineering">Engineering</option>
											</select>
									
									</div>
							</div>
							<div class="form-group">
									<label for="department" class="control-label col-xs-3">Department :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="department" value="<?php echo $department; ?>" name="department">
													
											</select>
									
									</div>
							</div>
							<div class="form-group">
									<label for="level" class="control-label col-xs-3">Level :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="level" value="<?php echo $level; ?>" name="level">
													<option value="100">100</option>
													<option value="200" >200</option>
													<option value="300">300</option>
													<option value="400" >400</option>
													<option value="500">500</option>\
											</select>
									
									</div>
							</div>
							<div class="form-group">
									<label for="gender" class="control-label col-xs-3">Gender :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="gender" value="<?php echo $gender; ?>" name="gender">
													<option value="Male">Male</option>
													<option value="Female" >Female</option>
											</select>
									
									</div>
							</div>
							<div class="form-group">
									<label for="s_origin" class="control-label col-xs-3">State of Origin :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="s_origin" value="<?php echo $s_origin; ?>" name="s_origin">
													<option value="-select state-" title="-select state-">-select state-</option>
									<option value="Abuja" title="Abuja">Abuja</option>
									<option value="Abia" title="Abia">Abia</option>
									<option value="Adamawa" title="Adamawa">Adamawa</option>
									<option value="Akwa Ibom" title="Akwa Ibom">Akwa Ibom</option>
									<option value="Anambra" title="Anambra">Anambra</option>
														<option value="Bauchi" title="Bauchi">Bauchi</option>
										<option value="Bayelsa" title="Bayelsa">Bayelsa</option>
										<option value="Benue" title="Benue">Benue</option>
										<option value="Bornu" title="Bornu">Bornu</option>
										<option value="Cross River" title="Cross River">Cross River</option>
										<option value="Delta" title="Delta">Delta</option>
										<option value="Ebonyi" title="Ebonyi">Ebonyi</option>
														<option value="Edo" title="Edo">Edo</option>
														<option value="Ekiti" title="Ekiti">Ekiti</option>
														<option value="Enugu" title="Enugu">Enugu</option>
										<option value="Gombe" title="Gombe">Gombe</option>
										<option value="Imo" title="Imo">Imo</option>
										<option value="Jigawa" title="Jigawa">Jigawa</option>
														<option value="Kaduna" title="Kaduna">Kaduna</option>
										<option value="Kano" title="Kano">Kano</option>
										<option value="Katsina" title="Katsina">Katsina</option>
										<option value="Kebbi" title="Kebbi">Kebbi</option>
										<option  value="Kogi" title="Kogi">Kogi</option>
										<option value="Kwara" title="Kwara">Kwara</option>
										<option value="Lagos" title="Lagos">Lagos</option>
										<option value="Nassarawa" title="Nassarawa">Nassarawa</option>
										<option value="Niger" title="Niger">Niger</option>
										<option value="Ogun" title="Ogun">Ogun</option>
										<option value="Ondo" title="Ondo">Ondo</option>
										<option value="Osun" title="Osun">Osun</option>
										<option value="Oyo" title="Oyo">Oyo</option>
										<option value="Plateau" title="Plateau">Plateau</option>
										<option value="Rivers" title="Rivers">Rivers</option>
										<option value="Sokoto" title="Sokoto">Sokoto</option>
										<option value="Taraba" title="Taraba">Taraba</option>
										<option value="Yobe" title="Yobe">Yobe</option>
										<option value="Zamfara" title="Zamfara">Zamfara</option>
											</select>
									
									</div>
							</div>
							<div class="form-group">
									<label for="address" class="control-label col-xs-3">Home Address :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<textarea    class="form-control"  id="address" name="address" value="<?php echo $address; ?>" placeholder="Enter Permanent Home Address"></textarea>
											</div>
										</div>
								</div>
								<div class="form-group">
									<label for="phone" class="control-label col-xs-3">Phone N<u>o</u> :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span></span>
													<input type="phone"  class="text_field form-control" onkeydown="return noNumbers(event,this)" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Enter Phone No" >
											</div>
										</div>
							</div>
							<div class="form-group">
									<label for="email" class="control-label col-xs-3">Email Address :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-9">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span></span>
													<input type="email"  class="text_field form-control"  id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter Email Address" >
											</div>
										</div>
							</div>
							<div class="form-group">
									<label for="photo_one" class="control-label col-xs-3"></label>
									<div class="col-xs-9">
										<div class="input-group">
												<input  type="file"   id="photo_one" value="browse" name="photo_one"  ></input>
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

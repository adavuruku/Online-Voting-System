<?php 
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';

if(isset($_POST['c_track']))
{
	$stmt = $conn->prepare("SELECT * FROM sug_post_list where del_status=?");
	$stmt->execute(array("0"));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1) 
	{
		$just_all_total_vote="";
		$single_vote = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$samo =0;
			$stmt2 = $conn->prepare("SELECT * FROM contestant_list where c_position=? And del_status=?");
			$stmt2->execute(array($row['sug_post'],"0"));
			$affected_rows2 = $stmt2->rowCount();
			if($affected_rows2 >= 1) 
			{
				$total_no_vote =0;
				$single_tot = 0;	
				//$value_link = "Value=".$row['sug_post_code'];
				while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
				{
					$samo =$samo +1;
					if($single_vote==""){
						$single_vote= $single_vote.$row2['c_vote_id']."-".$row2['c_vote'];
					}else{
						$single_vote= $single_vote.";".$row2['c_vote_id']."-".$row2['c_vote'];
					}
					$total_no_vote=$total_no_vote + $row2['c_vote'];
				}
			}
			if($samo >=1){
				if($just_all_total_vote==""){
					$just_all_total_vote= $just_all_total_vote.$row['sug_post_code']."-".$total_no_vote;
				}else{
					$just_all_total_vote= $just_all_total_vote.";".$row['sug_post_code']."-".$total_no_vote;
				}
			}
		}
		echo $just_all_total_vote."*".$single_vote;
	}
}
if(isset($_POST['c_vote_id']) && isset($_POST['c_post_id']))
{
	$c_id = $_POST['c_vote_id'];
	$sug_id  = $_POST['c_post_id'];
	
	$stmt = $conn->prepare("UPDATE contestant_list SET c_vote=c_vote + 1 WHERE c_vote_id=? AND c_position_code=? Limit 1");
	$stmt->execute(array($c_id,$sug_id));
	$affected_rows = $stmt->rowCount();
	if($stmt == true) 
	{
		if($_SESSION['all_vote_id']!=""){
			$_SESSION['all_vote_id'] = $_SESSION['all_vote_id'].";".$c_id."-".$sug_id;
		}else{
					$_SESSION['all_vote_id'] = $_SESSION['all_vote_id'].$c_id."-".$sug_id;
		}
		
		$stmt2 = $conn->prepare("UPDATE student_information SET vote_details=? WHERE reg_No=? Limit 1");
		$stmt2->execute(array($_SESSION['all_vote_id'],$_SESSION['reg_oo']));
		$affected_rows2 = $stmt2->rowCount();
		if($stmt2 == true) 
		{
			$stmt = $conn->prepare("SELECT c_vote_id,c_position_code,c_vote FROM contestant_list WHERE c_vote_id=? AND c_position_code=? Limit 1");
			$stmt->execute(array($c_id,$sug_id));
			$affected_rows = $stmt->rowCount();
			if($affected_rows == 1) 
			{
				$row_retrieve = $stmt->fetch(PDO::FETCH_ASSOC);
				
				echo $row_retrieve['c_vote'];
			}else{
				echo "No records";
			}
		}
					
	}
}

?>
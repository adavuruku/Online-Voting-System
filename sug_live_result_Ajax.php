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
?>
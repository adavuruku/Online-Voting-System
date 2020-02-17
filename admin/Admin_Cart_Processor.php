<?php
//update
session_start();
require_once '../settings/connection.php';
require_once '../settings/filter.php';
if(isset($_POST['delete_item']))
{
	$Add_Id = $_POST['goods_id'];
	$goods_name = $_POST['goods_name'];
	//update the quantity
	$stmt = $conn->prepare("UPDATE contestant_list SET del_status= ? WHERE c_vote_id=? Limit 1");
	$stmt->execute(array("1",$Add_Id));
	$affected_rows = $stmt->rowCount();
	echo $goods_name;
}

if(isset($_POST['delete_item_2']))
{
	$Add_Id = $_POST['goods_id'];
	$goods_name = $_POST['goods_name'];
	//update the quantity
	$stmt = $conn->prepare("UPDATE sug_post_list SET del_status= ? WHERE sug_post_code=? Limit 1");
	$stmt->execute(array("1",$Add_Id));
	$affected_rows = $stmt->rowCount();
	echo $goods_name;
}
?>
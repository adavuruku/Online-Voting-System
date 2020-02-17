<?php
session_start();
// Set Session data to an empty array
$_SESSION = array();
// Expire their cookie files
if(isset($_COOKIE["study"]) && isset($_COOKIE["stupdy"])) {
setcookie("study", '', strtotime( '-5 days' ), '/');
    setcookie("stupdy", '', strtotime( '-5 days' ), '/');
}
// Destroy the session variables
session_destroy();
header("location: index.php");
exit();

?>
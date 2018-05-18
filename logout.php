<?php
session_start();
include('system/db_connect.php');
// Using POST because GET is risky
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_SESSION['id'];
  if(session_destroy()) // Destroying All Sessions
  {
    $query    = "DELETE FROM `online_users` WHERE `user_id` = '$id'";
    $result4 = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));
	  header("Location: login.php"); // Redirecting To Home Page
  }
}
else {
  header("Location: index.php");
}
?>

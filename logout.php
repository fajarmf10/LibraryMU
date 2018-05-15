<?php
session_start();
// Using POST because GET is risky
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(session_destroy()) // Destroying All Sessions
  {
	   header("Location: login.php"); // Redirecting To Home Page
  }
}
else {
  header("Location: index.php");
}
?>

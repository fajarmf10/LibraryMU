<?php
include('system/db_connect.php');
if(!isset($_SESSION)){
  session_start();
}
$id = $_SESSION['id'];
$session    = session_id();
$time       = time();
$time_check = $time-300;

$sql   = "SELECT * FROM `online_users` WHERE user_id='$id'";
$result = mysqli_query($db, $sql) or die("Query fail : ".mysqli_error($db));
$count = mysqli_num_rows($result);
if($count == "0"){
  $sql1    = "INSERT INTO `online_users`(user_id, session, `time`) VALUES ('$id', '$session', '$time')";
  $result1 = mysqli_query($db, $sql1) or die("Query fail : ".mysqli_error($db));
}
else {
  $sql2    = "UPDATE `online_users` SET `time`='$time' WHERE user_id = '$id'";
  $result2 = mysqli_query($db, $sql2) or die("Query fail : ".mysqli_error($db));
}

$sql4    = "DELETE FROM `online_users` WHERE `time` < $time_check";
$result4 = mysqli_query($db, $sql4) or die("Query fail : ".mysqli_error($db));

class TestClass {
  static function getOnline(){
    global $db;
    $obj = new stdClass();
    $sql3              = "SELECT * FROM `online_users`";
    $result3           = mysqli_query($db, $sql3) or die("Query fail : ".mysqli_error($db));
    $count_user_online = mysqli_num_rows($result3);
    $obj->online = $count_user_online;
    return json_encode($obj);
  }
}
?>

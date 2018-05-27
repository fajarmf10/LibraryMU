<?php
session_start();
include('../system/db_connect.php');

  if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $query = "CALL sp_addlib('$_SESSION[id]', '$id')";
    $sql = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));

    echo "ok";
  }
  else {
    echo "fail";
  }

?>

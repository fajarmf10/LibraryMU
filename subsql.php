<?php
include('system/db_connect.php');
$title = mysqli_real_escape_string($db, $_POST['formtitle']);
$category = mysqli_real_escape_string($db, $_POST['formcategory']);
$quiz = mysqli_real_escape_string($db, $_POST['formquiz']);

$path = strtolower($_FILES['book']['name']);
$tmp = explode(".", $path);
$type = end($tmp);
$fextensions = array("pdf", "epub");
if(in_array($type, $fextensions) === false){
  $errors[] = "Current file extension is not allowed, please choose PDF or EPUB file.";
}
else{
  $query = "CALL sp_uploadbook('$title', '$category', '$path', '$quiz', '$type')";
  $sql = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));
  $row = mysqli_fetch_array($sql);
}
if(isset($errors)){
  $alert = $errors;
}
else{
  $alert = $row[0];
}
// print_r($arr);
echo json_encode($alert);
?>

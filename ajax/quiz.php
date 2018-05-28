<?php
session_start();
include "../system/db_connect.php";

if(!isset($_SESSION['username'])){
  header("Location: login.php");
  die;
}

//Memproses data ajax ketika memilih salah satu jawaban
if($_GET['action']=="kirim_jawaban"){
   $rnilai = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM nilaitemp WHERE id_quiz='$_POST[quiz]' AND id_user='$_SESSION[id]'"));

   $jawaban = explode(",", $rnilai['arrjawaban']);
   $index = $_POST['index'];
   $jawaban[$index] = $_POST['jawab'];

   $jawabanfix = implode(",", $jawaban);
   mysqli_query($db, "UPDATE nilaitemp SET arrjawaban='$jawabanfix' WHERE id_quiz='$_POST[quiz]' AND id_user='$_SESSION[id]'");

   echo "ok";
}

//Memproses data ajax ketika menyelesaikan ujian
elseif($_GET['action']=="selesai_ujian"){
   $rnilai = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM nilaitemp WHERE id_quiz='$_POST[quiz]' AND id_user='$_SESSION[id]'"));

   $arr_soal = explode(",", $rnilai['arrsoal']);
   $jawaban = explode(",", $rnilai['arrjawaban']);
   $jbenar = 0;
   for($i=0; $i<count($arr_soal); $i++){
      $rsoal = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM soalquiz WHERE id_quiz='$_POST[quiz]' AND id='$arr_soal[$i]'"));
      if($rsoal['kunci'] == $jawaban[$i]){
        $jbenar++;
      }
   }

   $nilai = $jbenar;

   mysqli_query($db, "UPDATE nilaitemp SET jml_benar='$nilai', nilai='$nilai' WHERE id_quiz='$_POST[quiz]' AND id_user='$_SESSION[id]'");

   mysqli_query($db, "UPDATE leaderboard SET score=score+'$nilai'+20 WHERE user_id='$_SESSION[id]'");

   echo "ok";
}
?>

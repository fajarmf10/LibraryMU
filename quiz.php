<script type="text/javascript" src="js/ujian.js"></script>
<?php
if(!isset($_SESSION['username'])){
  header("Location: login.php");
  die;
}

include('system/db_connect.php');

$qquiz = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM quiz WHERE id='$_GET[quiz]'"));
$qsoal = mysqli_query($db, "SELECT * FROM soalquiz WHERE id_quiz='$_GET[quiz]' ORDER BY id LIMIT '$qquiz[jml_soal]'");

if(mysqli_num_rows($qsoal)==0) die('<div class="alert alert-warning">Belum ada soal pada ujian ini</div>');

$arr_soal = array();
$arr_jawaban = array();
while($rsoal = mysqli_fetch_array($qsoal)){
  $arr_soal[] = $rsoal['id_soal'];
  $arr_jawaban[] = 0;
}

$acak_soal = implode(",", $arr_soal);
$jawaban = implode(",", $arr_jawaban);

$qnilai = mysqli_query($db, "SELECT * FROM nilaitemp WHERE id_user='$_SESSION[id]' AND id_quiz='$_GET[quiz]'");
if(mysqli_num_rows($qnilai) < 1){
  mysqli_query($db, "INSERT INTO nilaitemp SET id_user='$_SESSION[id]', id_quiz='$_GET[quiz]', arrsoal='$acak_soal', arrjawaban='$jawaban'");
}

$qnilai = mysqli_query($db, "SELECT * FROM nilaitemp WHERE id_user='$_SESSION[id]' AND id_quiz='$_GET[quiz]'");
$rnilai = mysqli_fetch_array($qnilai);
// $sisa_waktu = explode(":", $rnilai['sisa_waktu']);

// echo '<div class="padding-20">';
// echo '<div class="list-group">';

echo '<div class="list-group-item floating">
	<b>NO SOAL</b><span class="no-soal">1</span>
	<div class="pull-right blok-waktu"><label> Sisa Waktu </label> <span class="waktu"><span class="menit">'.$sisa_waktu[0].'</span> : <span class="detik"> '.$sisa_waktu[1].' </span></span></div>
	</div>';

echo '<div class="list-group-item bg-abu">
		Ukuran font soal : <span class="ukuran-font"><a class="kecil" data-size="16">A</a> <a class="sedang" data-size="18">A</a> <a class="besar" data-size="20">A</a></span>
	</div>';

echo '<div class="list-group-item">';
echo'<input type="hidden" id="ujian" value="'.$_GET['quiz'].'">
	<input type="hidden" id="sisa_waktu">';

echo '<div class="row">
	<div class="col-md-12"><div class="konten-ujian">';

$arr_soal = explode(",", $rnilai['acak_soal']);
$arr_jawaban = explode(",", $rnilai['jawaban']);
$arr_class = array();

for($s=0; $s<count($arr_soal); $s++){
   $rsoal = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM soalquiz WHERE id='$arr_soal[$s]'"));

   $no = $s+1;
   $soal = str_replace("../media", "media", $rsoal['soal']);
   $active = ($no==1) ? "active" : "";
   echo '<div class="blok-soal soal-'.$no.' '.$active.'">
			<div class="box">
			<div class="soal">';
   echo $soal;
   echo'</div>';

	echo '<table class="row pilihan">';

//6 Membuat array pilihan dan mengacak pilihan
   $arr_pilihan = array();
   if($rsoal['pilihan_1']!="")$arr_pilihan[] = array("no" => 1, "pilihan" => $rsoal['pilihan_1']);
   if($rsoal['pilihan_2']!="")$arr_pilihan[] = array("no" => 2, "pilihan" => $rsoal['pilihan_2']);
   if($rsoal['pilihan_3']!="")$arr_pilihan[] = array("no" => 3, "pilihan" => $rsoal['pilihan_3']);
   if($rsoal['pilihan_4']!="")$arr_pilihan[] = array("no" => 4, "pilihan" => $rsoal['pilihan_4']);
   if($rsoal['pilihan_5']!="") $arr_pilihan[] = array("no" => 5, "pilihan" => $rsoal['pilihan_5']);

if($qquiz['acak_jawaban']=='Y') shuffle($arr_pilihan);

//7 Menampilkan pilihan
   $arr_huruf = array("A","B","C","D","E");
   $arr_class[$no] = ($arr_jawaban[$s]!=0) ? "green" : "";
   for($i=0; $i<count($arr_pilihan); $i++){
      $checked = ($arr_jawaban[$s] == $arr_pilihan[$i]['no']) ? "checked" : "";
      $pilihan = str_replace("../media", "media", $arr_pilihan[$i]['pilihan']);
      echo '<tr>
		<td width="50"></td>
		<td width="60">
		   <input type="radio" class="jawab-'.$no.'" data-huruf="'.$arr_huruf[$i].'" name="jawab-'.$no.'" id="huruf-'.$no.'-'.$i.'" '.$checked.'>
		   <label for="huruf-'.$no.'-'.$i.'" class="huruf-pilihan huruf-'.$arr_huruf[$i].'" onclick="kirim_jawaban('.$s.', '.$arr_pilihan[$i]['no'].')"></label>
		</td>
		<td valign="top">
		   <div class="teks">'.$pilihan.' </div>
		</td>
		</tr>';
   }

   echo '</table></div>';

   echo'<br><br><div class="row"><div class="col-md-2">';

   $sebelumnya = $no-1;
   if($no != 1) echo '<a class="btn btn-default btn-block" onclick="tampil_soal('.$sebelumnya.')"><span class="btn-left"></span> SOAL SEBELUMNYA</a>';
   else echo '<a class="btn btn-default btn-block"><span class="btn-left"></span>SOAL SEBELUMNYA</a>';

   echo '</div>
   <div class="col-md-2 col-md-offset-3 geser">';

   $berikutnya = $no+1;
   if($no != count($arr_soal)) echo '<a class="btn btn-primary btn-block" onclick="tampil_soal('.$berikutnya.')"> SOAL BERIKUTNYA <span class="btn-right"></span></a>';
   else echo '<a class="btn btn-danger btn-block" onclick="selesai()"> SELESAI <span class="btn-right"></span> </a>';

   echo '</div>
		</div>
		</div>';
}

echo '</div></div></div>';

echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="tombol1 tombol-sidebar" onclick="masuk()"></div><div class="tombol2 tombol-sidebar" onclick="keluar()">DAFTAR SOAL</div>';
echo '<div class="nomor-ujian"><div class="blok">';

for($j=1; $j<=$s; $j++){
	if($j==1) $cclass = "blue";
	else $cclass = "";

   echo '<div class="blok-nomor"><div class="box"> <a class="tombol-nomor tombol-'.$j.' '.$cclass.' '.$arr_class[$j].'" onclick="tampil_soal('.$j.')" data-id="'.$j.'">'.$j.'</a> <span class="huruf"></span></div></div>';
}

echo '</div></div>';

echo '<div class="modal fade" id="modal-selesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog">
   <div class="modal-content">
   <form  method="post" action="?content=selesai">

<div class="modal-header">
  <h3 class="modal-title">Konfirmasi Test</h3>
</div>

<div class="modal-body">
	<div class="row">
	<div class="col-md-3 text-center">
		<br><br>
		<img src="images/warning.png" width="80">
	</div>
	<div class="col-md-9">
		<br>Apakah anda yakin akan mengakhiri mata uji ini<br>
		Setelah ke mata uji berikutnya anda tidak bisa kembali ke mata uji sebelumnya.

		<br><br>Centang Kemudian tekan tombol Selesai
		<input type="hidden" name="ujian" value="'.$_GET['quiz'].'">
		<div class="chekbox-selesai"><input type="checkbox" required> Anda tidak akan bisa kembali ke soal sudah menekan tombol selesai.</div><br>
	</div>
	</div>
</div>

<div class="modal-footer">
	<div class="row">
	<div class="col-md-6">
		<button type="submit" class="btn btn-success btn-block"> SELESAI </button>
	</div>
	<div class="col-md-6">
		<button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> TIDAK </button>
	</div>
	</div>
</div>

</form></div></div></div>';
?>

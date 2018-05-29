<?php
session_start();
include "../system/db_connect.php";


//Fungsi untuk membuat judul konten
function create_title($icon, $title){
   echo '<h3 class="title"><i class="glyphicon glyphicon-'.$icon.'"></i> '.$title.'</h3>';
}

//Fungsi untuk membuat tombol pada bagian atas tabel
function create_button($color, $icon, $text, $class = "", $action=""){
   echo '<a class="btn btn-'.$color.' '.$class.' btn-top pull-right" onclick="'.$action.'"><i class="glyphicon glyphicon-'.$icon.'"></i> '.$text.'</a>';
}

//Fungsi untuk membuat tabel
function create_table($header){
   echo'<hr/><div class="table-responsive">
   <table class="table table-striped" width="100%">
   <thead><tr>
   <th style="width: 10px">No</th>';

foreach($header as $h){
   echo '<th>'.$h.'</th>';
}

   echo '</tr></thead>
   <tbody></tbody>
   <tfooter><tr>
   <th style="width: 10px">No</th>';

foreach($header as $h){
  echo '<th>'.$h.'</th>';
}

   echo'</tr></tfooter>
   </table>
   </div><br/>';
}


//Fungsi untuk membuat tombol aksi pada tabel
function create_action($id, $edit=true, $delete=true){
   $view = "";
   if($edit) $view .= ' <a class="btn btn-primary btn-edit" onclick="form_edit(\''.$id.'\')"><i class="glyphicon glyphicon-pencil"></i></a>';
   if($delete)	$view .= ' <a class="btn btn-danger btn-delete" onclick="delete_data(\''.$id.'\')"><i class="glyphicon glyphicon-trash"></i></a>';
   return $view;
}

//Menampilkan data ke tabel
if($_GET['action'] == "table_data"){
   $query = mysqli_query($db, "SELECT * FROM soalquiz WHERE id_quiz='$_GET[quiz]' ORDER BY id");
   $data = array();
   $no = 1;
   while($r = mysqli_fetch_array($query)){
      $soal = $r['soal'];
	    $id = $r['id'];
      $soal .= '<ol type="A">';
      for($i=1; $i<=5; $i++){
         $kolom = "pilihan_$i";
         if($r['kunci']==$i) $soal .= '<li class="text-primary" style="font-weight: bold">'.$r[$kolom].'</li>';
         else $soal .= '<li>'.$r[$kolom].'</li>';
      }
      $soal .= '</ol>';

      $row = array();
      $row[] = $no;
      $row[] = $soal;
      $row[] = create_action($r['id']);
      $data[] = $row;
      $no++;
   }
   $output = array("data" => $data);
   echo json_encode($output);
}

//Menampilkan data ke form edit
elseif($_GET['action'] == "form_data"){
   $query = mysqli_query($db, "SELECT * FROM soalquiz WHERE id='$_GET[id]'");
   $data = mysqli_fetch_array($query);
   echo json_encode($data);
}

//Menambahkan data soal ke database
elseif($_GET['action'] == "insert"){
   $soal = addslashes($_POST['soal']);
   $pil_1 = addslashes($_POST['pil_1']);
   $pil_2 = addslashes($_POST['pil_2']);
   $pil_3 = addslashes($_POST['pil_3']);
   $pil_4 = addslashes($_POST['pil_4']);
   $pil_5 = addslashes($_POST['pil_5']);
   mysqli_query($db, "INSERT INTO soalquiz SET
      id_quiz = '$_GET[quiz]',
      soal = '$soal',
      pilihan_1 = '$pil_1',
      pilihan_2 = '$pil_2',
      pilihan_3 = '$pil_3',
      pilihan_4 = '$pil_4',
      pilihan_5 = '$pil_5',
      kunci = '$_POST[kunci]'");
   echo "ok";
}

//Mengedit data soal pada database
elseif($_GET['action'] == "update"){
   $soal = addslashes($_POST['soal']);
   $pil_1 = addslashes($_POST['pil_1']);
   $pil_2 = addslashes($_POST['pil_2']);
   $pil_3 = addslashes($_POST['pil_3']);
   $pil_4 = addslashes($_POST['pil_4']);
   $pil_5 = addslashes($_POST['pil_5']);
   mysqli_query($db, "UPDATE soalquiz SET
      soal = '$soal',
      pilihan_1 = '$pil_1',
      pilihan_2 = '$pil_2',
      pilihan_3 = '$pil_3',
      pilihan_4 = '$pil_4',
      pilihan_5 = '$pil_5',
      kunci = '$_POST[kunci]' WHERE id='$_POST[id]'");
   echo "ok";
}

//Menghapus data
elseif($_GET['action'] == "delete"){
   mysqli_query($db, "DELETE FROM soalquiz WHERE id='$_GET[id]'");
}

?>

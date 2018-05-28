<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
  session_start();
  if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die;
  }
  elseif (empty($_GET['quiz'])) {
    header("location: index.php");
    die;
  }


  include('system/db_connect.php');

  $qquiz = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM quiz WHERE id='$_GET[quiz]'"));
  $qsoal = mysqli_query($db, "SELECT * FROM soalquiz WHERE id_quiz='$_GET[quiz]' ORDER BY id LIMIT $qquiz[jml_soal]");
  // var_dump($qsoal);
  // die();

  if(mysqli_num_rows($qsoal)==0) die('<div class="alert alert-warning">ERROR</div>');

  $arr_soal = array();
  $arr_jawaban = array();
  while($rsoal = mysqli_fetch_array($qsoal)){
    // var_dump($rsoal);
    // die();
    $arr_soal[] = $rsoal['id'];
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


  // $arr_soal = explode(",", $rnilai['acak_soal']);
  $arr_jawaban = explode(",", $rnilai['arrjawaban']);
  $arr_soal = explode(",", $acak_soal);
  // var_dump($arr_soal);die();

  $arr_class = array();


  echo '<div class="modal fade" id="modal-selesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <form onsubmit="return selesai_ujian('.$_GET['quiz'].')">

  <div class="modal-header">
    <h3 class="modal-title">Selesaikan Quiz</h3>
  </div>

  <div class="modal-body">
     <p>Apakah anda yakin untuk menyelesaikan quiz ini? 20 poin akan ditambahkan pada leaderboard anda. Untuk setiap jawaban yang benar, anda akan mendapatkan tambahan poin 1</p>
  </div>

  <div class="modal-footer">
     <button type="submit" class="btn btn-danger" onclick="return selesai_ujian('.$_GET['quiz'].')"> Selesai </button>
     <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal </button>
  </div>

  </form></div></div></div>';


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LibraryMU - <?php echo $qquiz['nama_quiz']; ?></title>
  <?php include('meta.php'); ?>
  <style type="text/css">
    .pie_progress {
      width: 160px;
      margin: 10px auto;
    }

    @media all and (max-width: 768px) {
      .pie_progress {
        width: 80%;
        max-width: 300px;
      }
    }

    pre{
      height: 250px;
      overflow: scroll;
    }

    .title{
      height: 50px;
    }

    .nomor-ujian{
       border: 1px solid #eee;
       padding: 10px;
       height: 100%;
    }


    .blok-nomor{
   width: 20%;
   display: inline-block;
}
.blok-nomor .box{
   padding: 5px;
}


.tombol-nomor{
   display: block;
   width: 100%;
   padding: 10px 0;
   text-align: center;
   background: #fff;
   color: #000;
   border: 2px solid #000;
   cursor: pointer;
}

.tombol-nomor:hover{
	text-decoration: none;
}
/*Mengatur warna tombol nomor soal*/

.tombol-nomor.blue{
	background: #235f9a;
	color: #fff;
}
.tombol-nomor.green{
	background: #000;
	color: #fff;
}
.tombol-nomor.yellow{
	background: yellow;
	color: #000;
}

.blok-soal{
   display: none;
}
/*Menyembunyikan soal yang memiliki class active*/
.blok-soal.active{
	display: block;
}

.nomor, .huruf{
   display: block;
   width: 35px;
   padding: 5px 0;
   text-align: center;
   border: 1px solid #ccc;
   border-radius: 50%;
   cursor: pointer;
}


.nomor{
   background: blue;
   color: #fff;
}

input[type=radio]{
   display: none;
}
/*Mengganti warna background huruf ketika input radio dicentang*/
input[type=radio]:checked ~ .huruf{
   background: green;
   color: #fff;
}
/*Mengatur tampilan pilihan*/
.pilihan{
   margin-bottom: 20px;
}
.pilihan .teks{
   padding-top: 10px;
}

  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php
  include('navbar.php');
  include('sidebar.php');
  echo '<input type="hidden" id="quiz" value="'.$_GET['quiz'].'">';
  ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $qquiz['nama_quiz']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Quiz</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <div class="tab-content">


                  <?php
                  // var_dump(count($arr_soal));
                  // die();
                  for($s=0; $s<count($arr_soal); $s++){
                     // var_dump($arr_soal[0]);die();
                     $rsoal = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM soalquiz WHERE id='$arr_soal[$s]'"));

                     $no = $s+1;
                     $soal = $rsoal['soal'];
                     $active = ($no==1) ? "active" : "";
                     echo  '<div class="blok-soal soal-'.$no.' '.$active.'">
                              <div class="box">
                                <div class="row">
                                  <div class="col-xs-1"><div class="nomor">'. $no .'</div>
                                </div>
                                <div class="col-xs-11"><div class="soal">'. $soal.'</div>

                              </div>
                            </div>';

                     $arr_pilihan = array();
                     if($rsoal['pilihan_1']!="") $arr_pilihan[] = array("no" => 1, "pilihan" => $rsoal['pilihan_1']);
                     if($rsoal['pilihan_2']!="") $arr_pilihan[] = array("no" => 2, "pilihan" => $rsoal['pilihan_2']);
                     if($rsoal['pilihan_3']!="") $arr_pilihan[] = array("no" => 3, "pilihan" => $rsoal['pilihan_3']);
                     if($rsoal['pilihan_4']!="") $arr_pilihan[] = array("no" => 4, "pilihan" => $rsoal['pilihan_4']);
                     if($rsoal['pilihan_5']!="") $arr_pilihan[] = array("no" => 5, "pilihan" => $rsoal['pilihan_5']);

                     $arr_huruf = array("A","B","C","D","E");
                     $arr_class[$no] = ($arr_jawaban[$s]!=0) ? "green" : "";
                     // var_dump($arr_jawaban[$s]);
                     for($i=0; $i<=4; $i++){
                       $checked = ($arr_jawaban[$s] == $arr_pilihan[$i]['no']) ? "checked" : "";
                       $pilihan = $arr_pilihan[$i]['pilihan'];
                       echo '<div class="row pilihan">
                       <div class="col-xs-1 col-xs-offset-1">
                       <input type="radio" name="jawab-'.$no.'" id="huruf-'.$no.'-'.$i.'" '.$checked.'>
                       <label for="huruf-'.$no.'-'.$i.'" class="huruf" onclick="kirim_jawaban('.$s.', '.$arr_pilihan[$i]['no'].')"> '.$arr_huruf[$i].' </label>
                      </div>
                      <div class="col-xs-10">
                         <div class="teks">'.$pilihan.' </div>
                      </div>
                      </div>';
                         }

                            echo '</div><br/><div class="row"><div class="col-md-3">';

                            $sebelumnya = $no-1;
                            if($no != 1) echo '<a class="btn btn-primary btn-blockl" onclick="tampil_soal('.$sebelumnya.')">Sebelumnya</a>';
                            echo '</div>

                         <div class="col-md-3 col-md-offset-1">';

                            $berikutnya = $no+1;
                            if($no != count($arr_soal)) echo '<a class="btn btn-primary btn-block" onclick="tampil_soal('.$berikutnya.')"> Berikutnya </a>';
                            else echo '<a class="btn btn-danger btn-block" onclick="selesai()"> Selesai </a>';

                            echo '</div></div></div>';




                   }
                  ?>



                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        <!-- /.col -->

        <div class="col-md-3">

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Daftar Soal</h3>
              </div>


              <div class="nomor-ujian">
                      <?php
                      for($j=1; $j<=$s; $j++){
                        if($j==1) $cclass = "blue";
                        else $cclass = "";
                        echo '<div class="blok-nomor"><div class="box">
                        <a class="tombol-nomor tombol-'.$j.' '.$arr_class[$j].'" onclick="tampil_soal('.$j.')">'.$j.'</a>
                        </div></div>';
                      }
                      ?>
              </div>


              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <?php include('footer.php'); ?>

</div>
<!-- ./wrapper -->
<?php include('script.php'); ?>
<script type="text/javascript">

function tampil_soal(no){
   $('.blok-soal').removeClass('active');
   $('.soal-'+no).addClass('active');

   $('.tombol-nomor').removeClass("blue");
   $('.tombol-'+no).addClass("blue");

   $('.no-soal').text(no);
}



function kirim_jawaban(index, jawab){
   quiz = $('#quiz').val();
   $.ajax({
      url: "ajax/quiz.php?action=kirim_jawaban",
      type: "POST",
      data: "quiz=" + quiz + "&index=" + index + "&jawab=" + jawab,
      success: function(data){
         if(data=="ok"){
            no = index+1;
            $('.tombol-'+no).addClass("green");
            $('.tombol-'+no).addClass("green");
			hurufpilih = $('.jawab-'+no+':checked').attr('data-huruf');
			$('.tombol-'+no).next().text(hurufpilih);
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat mengirim jawaban!');
      }
   });
}

function selesai(){
   $('#modal-selesai').modal({
      'show' : true,
      'backdrop' : 'static'
   });
}


function selesai_ujian(quiz){
   $.ajax({
      url: "ajax/quiz.php?action=selesai_ujian",
      type: "POST",
      data: "quiz="+quiz,
      success: function(data){
         if(data=="ok"){
            $('#modal-selesai').modal('hide');
            $('#modal-selesai').on('hidden.bs.modal', function(){
               window.location.replace("index.php");
            });
         }else{
            alert(data);
         }
      },
      error: function(){
         alert('Tidak dapat memproses nilai!');
      }
   });
   return false;
}

</script>
</body>
</html>

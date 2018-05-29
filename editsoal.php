<?php
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
     ';


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




  function open_form($modal_id, $action){
     echo '<div class="modal fade" id="'.$modal_id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
     <div class="modal-dialog modal-lg">
        <div class="modal-content">

  <form class="form-horizontal" enctype="multipart/form-data"  onsubmit="'.$action.'">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
        <h3 class="modal-title"></h3>
     </div>

     <div class="modal-body">
        <input type="hidden" name="id" id="id">';
  }

  //Fungsi untuk membuat kotak input
  function create_textbox($label, $name, $type="text", $width='5', $class="", $attr=""){
     echo'<div class="form-group">
     <label for="'.$name.'" class="col-sm-2 control-label"> '.$label.'</label>
     <div class="col-sm-'.$width.'">
        <input type="'.$type.'" class="form-control '.$class.'" id="'.$name.'" name="'.$name.'" '.$attr.'>
     </div> </div>';
  }

  //Fungsi untuk membuat textarea
  function create_textarea($label, $name, $class='', $attr=''){
     echo'<div class="form-group">
     <label for="'.$name.'" class="col-sm-2 control-label"> '.$label.'</label>
     <div class="col-sm-10">
       <textarea class="form-control '.$class.'" id="'.$name.'" rows="8" name="'.$name.'" '.$attr.'></textarea>
     </div> </div>';
  }


  //Fungsi untuk membuat combobox / select box
  function create_combobox($label, $name, $list, $width='5', $class="", $attr=""){
     echo'<div class="form-group">
     <label for="'.$name.'" class="col-sm-2 control-label"> '.$label.'</label>
     <div class="col-sm-'.$width.'">
        <select class="form-control '.$class.'" name="'.$name.'" id="'.$name.'" '.$attr.'>
           <option value="">- Pilih -</option>';

  foreach($list as $ls){
     echo '<option value='.$ls[0].'>'.$ls[1].'</option>';
  }

     echo '</select>
     </div> </div>';
  }


  //Fungsi untuk membuat checkbox
  function create_checkbox($label, $name, $list){
     echo '<div class="form-group" id="'.$name.'">
     <label class="col-sm-2 control-label">'.$label.'</label>
     <div class="col-sm-10">';

  foreach($list as $ls){
     echo' <input type="checkbox" name="'.$name.'[]" value="'.$ls[0].'" style="margin-left: 30px"> '.$ls[1];
  }

     echo '</div></div>';
  }

  //Fungsi untuk membuat media picker
  function create_mediapicker($label, $nama, $lebar='4', $tipe="0", $modal_id="" ){
  	?>
  		<script>
  			$(function(){
  				$('#filemanager-<?php echo $nama; ?>').on('hidden.bs.modal', function (e) {
  					$('#<?php echo $modal_id; ?>').modal('show');
  				})
  			});
  		</script>
  	<?php
  	echo'<div class="form-group">
  			<label for="'.$nama.'" class="col-sm-2 control-label">'.$label.'</label>
  			<div class="col-sm-'.$lebar.'">
  			<div class="input-group">
  			  <input type="text" class="form-control input-'.$nama.'" id="'.$nama.'" name="'.$nama.'"  readonly>
  			  <a data-toggle="modal" data-target="#filemanager-'.$nama.'" class="input-group-addon btn btn-primary pilih-'.$nama.'">...</a>
  			</div>
  			</div>
  			<div class="modal fade mediapicker" id="filemanager-'.$nama.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  				<div class="modal-dialog modal-lg">
  					<div class="modal-content">
  						<div class="modal-header">
  							<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  							<h4 class="modal-title" id="myModalLabel">File Manager</h4>
  						</div>
  						<div class="modal-body">
  							<iframe src="plugins/filemanager/dialog.php?type='.$tipe.'&field_id='.$nama.'&relative_url=1" width="100%" height="400" style="border: 0"></iframe>
  						</div>
  					</div>
  				</div>
  			</div>
  		 </div>';
  }

  //Fungsi untuk menutup form dan modal
  function close_form($icon="floppy-disk", $button="Simpan"){
     echo'</div>
     <div class="modal-footer">
     <button type="submit" class="btn btn-primary btn-save">
     <i class="glyphicon glyphicon-'.$icon.'"></i> '.$button.'
     </button>
     <button type="button" class="btn btn-warning" data-dismiss="modal">
     <i class="glyphicon glyphicon-remove-sign"></i> Close
     </button>
     </div>

     </form></div></div></div>';
  }

  function tgl_indonesia($tgl){
     $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

  	$tanggal = substr($tgl,8,2);
  	$bulan = $nama_bulan[(int)substr($tgl,5,2)];
  	$tahun = substr($tgl,0,4);

  	return $tanggal.' '.$bulan.' '.$tahun;
  }


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LibraryMU - Edit Soal</title>
  <?php include('meta.php'); ?>
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap4.min.css">
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
            <h1>Edit Soal</h1>
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

        <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="tab-content">


                  <?php
                  create_button("success", "plus-sign", "Tambah", "btn-add", "form_add()");
create_button("primary", "import", "Import", "btn-import", "form_import()");

                  //Membuat header dan footer soal
create_table(array("Soal", "Aksi"));

//Membuat form tambah dan edit soal
open_form("modal_soal", "return save_data()");
 create_textarea("Soal", "soal", "richtext");
 create_textarea("Pilihan 1", "pil_1", "richtextsimple");
 create_textarea("Pilihan 2", "pil_2", "richtextsimple");
 create_textarea("Pilihan 3", "pil_3", "richtextsimple");
 create_textarea("Pilihan 4", "pil_4", "richtextsimple");
 create_textarea("Pilihan 5", "pil_5", "richtextsimple");

 $list = array();
 for($i=1; $i<=5; $i++){
    $list[] = array($i, $i);
 }
 create_combobox("Kunci Jawaban", "kunci", $list, 4, "", "required");
close_form();

                  ?>





                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        <!-- /.col -->



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
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="plugins/tinymce/tinymce.min.js"> </script>
<script src="soal.js"></script>
</body>
</html>

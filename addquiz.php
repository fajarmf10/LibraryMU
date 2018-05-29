<?php
  include('system/db_connect.php');
  session_start();
  if(!isset($_SESSION['username']) || $_SESSION['usertype'] == 'user'){
    header("Location: login.php");
    die;
  }
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['formtitle'];
    $jmlsoal = $_POST['formjmlsoal'];
    $eat = $_POST['expiredat'];
    $query = "INSERT INTO quiz(`id`, `nama_quiz`, `jml_soal`, `created_at`, `expired_at`, `winner`) VALUES	(NULL, '$title', '$jmlsoal', NOW(), '$eat', NULL)";
    $sql = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LibraryMU - Add Quiz</title>
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
  </style>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/mint-choc/jquery-ui.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php
  include('navbar.php');
  include('sidebar.php');
  ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Add Quiz</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Add Quiz</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <form method="POST" action="" id="inputBook">
                        <div class="form-group">
                          <label>Nama Quiz</label>
                          <input type="text" class="form-control" name="formtitle" placeholder="Enter book title here..." required>
                        </div>
                        <div class="form-group">
                          <label>Jumlah Soal</label>
                          <input type="text" name="formjmlsoal" class="form-control selectcategory" placeholder="Jumlah Soal">
                        </div>
                        <div class="form-group">
                          <label>Quiz Expired at</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input name="expiredat" id="datemask" type="text" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask>
                          </div>
                        </div>
                </div>
              </div>
              </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
              </form>
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <?php include('footer.php'); ?>

</div>
<!-- ./wrapper -->
<?php include('script.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script><script type="text/javascript">
$(document).ready(function() {
  //Datemask dd/mm/yyyy
  $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'YYYY/MM/DD' })

});

</script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
</script>
</body>
</html>

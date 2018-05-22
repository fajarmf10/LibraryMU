<?php
  session_start();
  if(!isset($_SESSION['username']) || $_SESSION['usertype'] == 'user'){
    header("Location: login.php");
    die;
  }
  include('system/db_connect.php');
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
                      <form enctype="multipart/form-data" method="POST" id="inputBook">
                        <div class="form-group">
                          <label>Title</label>
                          <input type="text" class="form-control" name="formtitle" placeholder="Enter book title here..." required>
                        </div>
                        <div class="form-group">
                          <label>Category</label>
                          <select name="formcategory" class="form-control selectcategory" style="width: 100%;">
                            <?php
                            $queryoption = 'CALL sp_addbook()';
                            $sql = mysqli_query($db, $queryoption) or die("Query fail : ".mysqli_error($db));
                            while($row = mysqli_fetch_assoc($sql)){
                              echo "<option>" . $row['category'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="InputFile">Upload your Book</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" name="book" id="InputFile" required>
                              <label class="custom-file-label" for="InputFile">Choose file</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group text-right">
                          <label>Contain Quiz?</label>
                          <div class="form-group">
                            <label>
                              <input type="radio" value="1" name="formquiz" class="flat-green" required>
                              Yes
                            </label>
                            <label>
                              <input type="radio" value="0" name="formquiz" class="flat-green">
                              No
                            </label>
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
<script type="text/javascript">
$(document).ready(function() {
  // $('.selectcategory').select2({
  //   tags: true,
  // });
  //
  // $('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
  //   checkboxClass: 'icheckbox_flat-green',
  //   radioClass   : 'iradio_flat-green'
  // });

  // $("#submitBtn").click(function (event) {
  //   event.preventDefault(); // Manual submit
  //
  //   var urls = ['//fajarmf.com/.pdf/upfile.php', 'subsql.php'];
  //   var form = $('#inputBook')[0];
  //   var data = new FormData(form);
  //
  //   $("#submitBtn").prop("disabled", true);
  //   $("#submitBtn").html("Uploading File");
  //   $.each(urls, function(i,u){
  //     $.ajax(u, {
  //       type: "POST",
  //       enctype: 'multipart/form-data',
  //       data: data,
  //       processData: false,
  //       contentType: false,
  //       cache: false,
  //       success: function(data){
  //         console.log("SUCCESS : ", data);
  //         alert(jQuery.parseJSON(data));
  //         $("#submitBtn").prop("disabled", false);
  //         $("#submitBtn").html("Submit");
  //       },
  //       error: function(e){
  //         console.log("ERROR : ", e);
  //         alert(e);
  //         $("#submitBtn").prop("disabled", false);
  //         $("#submitBtn").html("Submit");
  //       },
  //     });
  //   });
  // });


  $('#InputFile').change(function() {
    var i = $(this).next('label').clone();
    var file = $('#InputFile')[0].files[0].name;
    $(this).next('label').text(file);
  });


});

</script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
</script>
</body>
</html>

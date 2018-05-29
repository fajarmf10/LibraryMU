<?php
  session_start();
  if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LibraryMU - List Quiz</title>
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
            <h1>LibraryMU's Quiz</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">List Quiz</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List Quiz</h3>
            </div>

            <?php
            include('system/db_connect.php');
            $result =  mysqli_query($db, "SELECT * FROM `quiz` where `expired_at` >= NOW()");
            $total = mysqli_num_rows($result);
            $halaman = 10;
            $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : $_GET["halaman"] = 1;
            $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
            $query = "SELECT * FROM `quiz` where `expired_at` >= NOW()";
            $sql = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));
            $pages = ceil($total/$halaman);
            // print_r($sql);
            ?>

            <!-- /.card-header -->
            <div class="card-body">
              <table id="bookscollection" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>Name</th>
                  <th>Jumlah Soal</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>

                    <?php
                      $no = 1;
                      while ($row = $sql->fetch_assoc()) {
                        echo "<tr><td>" . $no++ . "</td>";
                        echo "<td>" . $row["nama_quiz"] . "</td>";
                        echo "<td>" . $row["jml_soal"] . "</td>";
                        if($_SESSION['usertype'] === "admin"){
                          echo "<td><a href='editsoal.php?quiz=". $row['id'] ."'>Tambah Soal</a></td>";
                        }
                        else{
                          echo "<td><a href='quiz.php?quiz=" . $row['id'] . "'><i class='fa fa-search-plus' title='Kerjakan' aria-hidden='true'></i></a></td>";
                        }
                      }
                    ?>
                </tbody>
              </table>
              <br>
              <?php
              if (isset($_GET['halaman'])) {
                if(isset($_GET['browse']) && $_GET['browse'] == 'today'){
                  echo "<ul class='pagination pagination-md m-0 float-right'>";
                  for($i=1; $i<=$pages; $i++){
                    if($i == (int)$_GET['halaman']){
                      echo "<li class='page-item active'><a class='page-link' href='?browse=today&halaman=" . $i . "'> " . $i ."</a></li>";
                    }
                    else{
                      echo "<li class='page-item'><a class='page-link' href='?browse=today&halaman=" . $i . "'> " . $i ."</a></li>";
                    }
                  }
                  echo "</ul>";
                }
                else{
                  echo "<ul class='pagination pagination-md m-0 float-right'>";
                  for($i=1; $i<=$pages; $i++){
                    if($i == (int)$_GET['halaman']){
                      echo "<li class='page-item active'><a class='page-link' href='?halaman=" . $i . "'> " . $i ."</a></li>";
                    }
                    else{
                      echo "<li class='page-item'><a class='page-link' href='?halaman=" . $i . "'> " . $i ."</a></li>";
                    }
                  }
                  echo "</ul>";
                }
              }
              ?>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

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
</body>
</html>

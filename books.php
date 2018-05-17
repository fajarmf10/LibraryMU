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
  <title>LibraryMU - Books Collection</title>
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
            <h1>LibraryMU's Books Collection</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Books Collection</li>
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


            <?php
            include('system/db_connect.php');
            if(isset($_GET['browse']) && $_GET['browse'] === 'trending'){
              echo '<h3 class="card-title">Hot Trending Books Right Now!</h3>
            </div>';
              $query = "CALL sp_trending()";
            }
            elseif(isset($_GET['browse']) && $_GET['browse'] === 'today'){
              echo '<h3 class="card-title">Hot Trending Books Right Now!</h3>
            </div>';
              $query = "CALL sp_today()";
            }
            else{
              echo '<h3 class="card-title">Books Collections</h3>
            </div>';
              $query = "CALL sp_books()";
            }
            $sql = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));
            // var_dump($rows);
            ?>

            <!-- /.card-header -->
            <div class="card-body">
              <table id="bookscollection" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Book Title</th>
                  <th>Category</th>
                  <th>Uploaded At</th>
                  <th>Total Readers</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    <?php

                      while ($row = $sql->fetch_assoc()) {
                        // var_dump($row);
                        echo "<tr><td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["category"] . "</td>";

                        $parsedate = new DateTime($row['created_at']);
                        echo "<td>" . $parsedate->format('H:i:s&\nb\sp;&\nb\sp;d M Y') . "</td>";

                        echo "<td>" . $row["count"] . "</td>";
                        if($row["type"] === "pdf"){
                          echo "<td><div class='text-center'>
                          <a href='https://fajarmf.com/.pdf/" . $row['path'] . "' target='_blank'><i class='fa fa-search-plus' title='Read Now' aria-hidden='true'></i></a>
                          <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                          <i class='fa fa-plus-circle' title='Add to Library' aria-hidden='true'></i>
                        </div>
                      </td></tr>";
                        } else{
                          echo "<td><div class='text-center'>
                          <a href='epub.php?pdf=" . $row['path'] . "' target='_blank'><i class='fa fa-search-plus' title='Read Now' aria-hidden='true'></i></a>
                          <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                          <i class='fa fa-plus-circle' title='Add to Library' aria-hidden='true'></i>
                          </div>
                          </td></tr>";
                        }
                      }
                    ?>
                </tbody>
              </table>
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
<script src="dist/js/epub.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
</body>
</html>

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
  <title>LibraryMU</title>
  <?php include('meta.php'); ?>
  <link rel="stylesheet" href="dist/css/asPieProgress.css">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">LibraryMU</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a>Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>2525</h3>

                <p>New Books Today</p>
              </div>
              <div class="icon">
                <i class="icon ion-md-book"></i>
              </div>
              <a href="#" class="small-box-footer">Check today's book <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Reading Right Now!</p>
              </div>
              <div class="icon">
                <i class="icon ion-md-glasses"></i>
              </div>
              <a href="#" class="small-box-footer">Check your Library now! <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>21</h3>

                <p>LibraryMU Leaderboard</p>
              </div>
              <div class="icon">
                <i class="icon ion-md-list"></i>
              </div>
              <a href="#" class="small-box-footer">Check your rank <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

          <!-- row -->
          <div class="row">
            <div class="col-12">
              <!-- jQuery Knob -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fa fa-bar-chart-o"></i>
                    LibraryMU's Stats
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse"><i
                        class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="row">
                    <div class="col-6 col-md-4 text-center" id="cpuDiv">
                      <div class="pie_progress_cpu" role="progressbar" data-goal="33">
                        <div class="pie_progress__number">0%</div>
                      </div>
                      <h1>CPU</h1>
                      <div class='title'></div>
                    </div>
                    <!-- ./col -->
                    <div class="col-6 col-md-4 text-center" id="memDiv">
                      <div class="pie_progress_mem" role="progressbar" data-goal="33">
                        <div class="pie_progress__number">0%</div>
                      </div>
                      <h1>Memory</h1>
                      <div class='title'></div>
                    </div>
                    <!-- ./col -->
                    <div class="col-6 col-md-4 text-center" id="diskDiv">
                      <div class="pie_progress_disk" role="progressbar" data-goal="33">
                        <div class="pie_progress__number">0%</div>
                      </div>
                      <h1>Disk</h1>
                      <div class='title'></div>
                    </div>
                    <!-- ./col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('footer.php'); ?>

</div>
<!-- ./wrapper -->

<?php include('script.php'); ?>

<script type="text/javascript" src="dist/js/jquery-asPieProgress.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('.pie_progress_cpu, .pie_progress_mem, .pie_progress_disk').asPieProgress({});
    getCpu();
    getMem();
    getDisk();
  });

  function getCpu() {
    $.ajax({
      url: 'cpu.json.php',
      success: function (response) {
        update('cpu', response);
        setTimeout(function () {
          getCpu();
        }, 1000);
      }
    });
  }

  function getMem() {
    $.ajax({
      url: 'memory.json.php',
      success: function (response) {
        update('mem', response);
        setTimeout(function () {
          getMem();
        }, 1000);
      }
    });
  }

  function getDisk() {
    $.ajax({
      url: 'disk.json.php',
        success: function (response) {
          update('disk', response);
          setTimeout(function () {
            getDisk();
          }, 1000);
        }
    });
  }

  function update(name, response) {
    $('.pie_progress_' + name).asPieProgress('go', response.percent);
    $("#" + name + "Div div.title").text(response.title);
  }
</script>
</body>
</html>

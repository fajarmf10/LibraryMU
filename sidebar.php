<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="dist/img/logo.png" alt="LibraryMU" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">LibraryMU</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/" class="nav-link">
            <i class="nav-icon fa fa-dashboard"></i>
            <p>
              Home
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a class="nav-link">
            <i class="nav-icon fa fa-book"></i>
            <p>
              Books
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="books.php" class="nav-link">
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="fa fa-circle-o nav-icon"></i>
                <p>Browse Books</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="books.php?browse=trending" class="nav-link">
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="fa fa-circle-o nav-icon"></i>
                <p>Top 10 Trending Books!</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="books.php?browse=today" class="nav-link">
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="fa fa-circle-o nav-icon"></i>
                <p>Today's Books</p>
              </a>
            </li>
            <?php
            if($_SESSION['usertype'] === "admin"){
              echo "<li class='nav-item'>
                <a href='addbook.php' class='nav-link'>
                  <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><i class='fa fa-plus nav-icon'></i>
                  <p>Add Book</p>
                </a>
              </li>";
            }
            ?>
          </ul>
        </li>

        <li class="nav-item">
          <a href="leaderboard.php" class="nav-link">
            <i class="nav-icon fa fa-list-ol"></i>
            <p>
              Leaderboard
            </p>
          </a>
        </li>

          <?php
          if($_SESSION['usertype'] === "admin"){
            echo "<li class='nav-item has-treeview'>
                      <a class='nav-link'>
                        <i class='nav-icon fa fa-question-circle'></i>
                        <p>
                          Quiz
                          <i class='right fa fa-angle-left'></i>
                        </p>
                      </a>
                    ";
            echo "<ul class='nav nav-treeview'><li class='nav-item'>
                    <a href='listquiz.php' class='nav-link'>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><i class='fa fa-list-ol nav-icon'></i>
                    <p>List Quiz</p>
                    </a>
                    </li>";
            echo "<li class='nav-item'>
              <a href='addquiz.php' class='nav-link'>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><i class='fa fa-plus nav-icon'></i>
                <p>Add Quiz</p>
              </a>
            </li></ul></li>";
          }
          else {
            echo "<li class='nav-item'>
                      <a href='listquiz.php' class='nav-link'>
                        <i class='nav-icon fa fa-question-circle'></i>
                        <p>
                          Quiz
                        </p>
                      </a>
                    </li>";
          }
          ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

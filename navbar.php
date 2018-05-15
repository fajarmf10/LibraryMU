<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-users"></i>
        <!-- <span class="badge badge-warning navbar-badge">New</span> -->
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">Welcome, <?php echo("{$_SESSION['name']}") ;?></span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fa fa-book mr-2"></i>My Library
          <span class="float-right text-muted text-sm">4 books</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="logout.php" class="dropdown-item dropdown-footer" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">LOGOUT</a>
        <form method="POST" action="logout.php" style="display: none;" id="logout-form"></form>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

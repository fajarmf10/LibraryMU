<?php
  session_start();
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true){
    header("Location: index.php");
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "system/db_connect.php";
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $query = "CALL sp_login('$username','$password')";
    $sql = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));
    $row = mysqli_fetch_array($sql);
    if($row[0] == 0){
      $_SESSION['id'] = $row[1];
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['name'] = $row[3];
      $_SESSION['usertype'] = $row[4];
      $_SESSION['loggedIn'] = true;
      header("Location: index.php");
    }
    else{
      ?>
        <script type="text/javascript">
          alert('<?php echo "$row[1]"; ?>');
        </script>
      <?php
    }
  }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LibraryMU</title>

        <!-- Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Mogra" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #34495e;
                color: white;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }


            .whatis > a {
                color: #ff0000;
                padding: 0 25px;
                font-family: 'Raleway', sans-serif;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }


            .content {
                text-align: center;
            }

            .title {
                color: #D3D3D3;
                font-family: "Mogra", serif;
                font-size: 34px;
            }

            .links{
                color: white;
                font-family: "Ubuntu Mono", monospace;
                padding: 0 25px;
                font-size: 18px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    LibraryMU (Library of Mahasiswa and Umum)
                </div>

                <div class="links">
                  <p><b>To use the LibraryMU, please login first!</b></p>
                  <form method="post" action="">
                    <div class="field">
                        <p class="control has-icons-left"><input class="input is-rounded" type="text" placeholder="Username" name="username"><span class="icon is-small is-left"><i class="fa fa-users"></i></span></p>
                    </div>
                    <div class="field">
                      <p class="control has-icons-left"><input class="input is-rounded" type="password" placeholder="Password" name="password"><span class="icon is-small is-left"><i class="fa fa-key"></i></span></p>
                    </div>
                    <div class="field">
                      <p class="control">
                        <button class="button is-primary">LOGIN</button>
                      </p>
                    </div>
                    <div class="field">
                      <p class="control">
                        Need an account? <a href="register.php">Register</a> right now, and get the benefits!
                      </p>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </body>
</html>

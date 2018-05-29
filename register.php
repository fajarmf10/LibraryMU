<?php
  session_start();
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true){
    header("Location: index.php");
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "system/db_connect.php";
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = md5(mysqli_real_escape_string($db, $_POST['password']));
    $query = "CALL sp_daftar('$username', '$email', '$fullname', '$password')";
    $sql = mysqli_query($db, $query) or die("Query fail : ".mysqli_error($db));
    $row = mysqli_fetch_array($sql);
      ?>
        <script type="text/javascript">
          alert('<?php echo "$row[1]"; ?>');
        </script>
      <?php
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

            section {
	            margin: 0em auto 0;
	            width: 100%;
	            max-width: 800px;
            }

            meter {
            	-webkit-appearance: none;
            	-moz-appearance: none;
            	appearance: none;

            	margin: 0 auto 1em;
            	width: 95%;
            	height: .5em;

              background: none;
            	background-color: rgba(0,0,0,0.1);
            }

            meter::-webkit-meter-bar {
            	background: none;
            	background-color: rgba(0,0,0,0.1);
            }

            meter[value="1"]::-webkit-meter-optimum-value { background: red; }
            meter[value="2"]::-webkit-meter-optimum-value { background: yellow; }
            meter[value="3"]::-webkit-meter-optimum-value { background: orange; }
            meter[value="4"]::-webkit-meter-optimum-value { background: green; }
            meter[value="1"]::-moz-meter-bar { background: red; }
            meter[value="2"]::-moz-meter-bar { background: yellow; }
            meter[value="3"]::-moz-meter-bar { background: orange; }
            meter[value="4"]::-moz-meter-bar { background: green; }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    LibraryMU (Library of Mahasiswa and Umum)
                </div>

                <div class="links">
                  <p><b>Register on LibraryMU, and get a lot of benefits right away!</b></p>
                  <form method="post" action="">
                    <div class="field">
                        <p class="control has-icons-left"><input class="input is-rounded" type="text" placeholder="Your Full Name" name="fullname"><span class="icon is-small is-left"><i class="fa fa-users"></i></span></p>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left"><input class="input is-rounded" type="text" placeholder="Username" name="username"><span class="icon is-small is-left"><i class="fa fa-users"></i></span></p>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left"><input class="input is-rounded" type="text" placeholder="Your E-Mail" name="email"><span class="icon is-small is-left"><i class="fa fa-users"></i></span></p>
                    </div>
                    <div class="field">
                      <p class="control has-icons-left"><input class="input is-rounded" type="password" placeholder="Your Password" name="password" id="password"><span class="icon is-small is-left"><i class="fa fa-key"></i></span></p>
                    </div>
                    <div class="field">
                      <meter max="4" id="password-strength-meter"></meter>
                      <p id="password-strength-text" style="color: white; font-size: 14px"></p>
                    </div>
                    <div class="field">
                      <p class="control">
                        <button class="button is-primary">REGISTER</button>
                      </p>
                    </div>
                    <div class="field">
                      <p class="control">
                        Already have an account? Login <a href="login.php">here</a>.
                      </p>
                    </div>
                  </form>
                </div>
            </div>
        </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
      <script type="text/javascript">
        var strength = {
          0: "Worst Password ☹",
          1: "Bad Password ☹",
          2: "Weak Password ☹",
          3: "Good Password ☺",
          4: "Strong Password ☻"
        }

        var password = document.getElementById('password');
        var meter = document.getElementById('password-strength-meter');
        var text = document.getElementById('password-strength-text');

        password.addEventListener('input', function(){
          var val = password.value;
          var result = zxcvbn(val);
          meter.value = result.score;
          if(val !== "") {
            text.innerHTML = "Password strength: " + strength[result.score];
          }
          else {
            text.innerHTML = "";
          }
        });
      </script>
    </body>
</html>

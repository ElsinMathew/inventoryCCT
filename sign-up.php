<?php
require_once('./inc/config/constants.php');
require_once('./inc/config/db.php');

$resetPasswordUsername = '';
$resetPasswordPassword1 = '';
$resetPasswordPassword2 = '';
$resetPasswordMessage = '';

if (isset($_POST['resetPasswordUsername'])) {
  $resetPasswordUsername = htmlentities($_POST['resetPasswordUsername']);
  $resetPasswordPassword1 = htmlentities($_POST['resetPasswordPassword1']);
  $resetPasswordPassword2 = htmlentities($_POST['resetPasswordPassword2']);

  if (!empty($resetPasswordUsername) && !empty($resetPasswordPassword1) && !empty($resetPasswordPassword2)) {

    // Check if username is empty
    if ($resetPasswordUsername == '') {
      $resetPasswordMessage = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Please enter your username.</div>';
    }

    // Check if passwords are empty
    elseif ($resetPasswordPassword1 == '' || $resetPasswordPassword2 == '') {
      $resetPasswordMessage = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Please enter both passwords.</div>';
    }

    // Check if username is available
    else {
      $usernameCheckingSql = 'SELECT * FROM user WHERE username = :username';
      $usernameCheckingStatement = $conn->prepare($usernameCheckingSql);
      $usernameCheckingStatement->execute(['username' => $resetPasswordUsername]);

      if ($usernameCheckingStatement->rowCount() < 1) {
        // Username doesn't exist. Hence can't reset password
        $resetPasswordMessage = '<div class="alert alert-danger">Username does not exist.</div>';
      } else {
        // Check if passwords are equal
        if ($resetPasswordPassword1 !== $resetPasswordPassword2) {
          $resetPasswordMessage = '<div class="alert alert-danger">Passwords do not match.</div>';
        } else {
          // Start UPDATING password to DB
          // Encrypt the password

          $updatePasswordSql = 'UPDATE user SET password = :password WHERE username = :username';
          $updatePasswordStatement = $conn->prepare($updatePasswordSql);
          $updatePasswordStatement->execute(['password' => $resetPasswordPassword1, 'username' => $resetPasswordUsername]);

          $resetPasswordMessage = '<div class="alert alert-success">Password reset complete. Please login using your new password.</div>';
        }
      }
    }
  } else {
    // One or more mandatory fields are empty. Therefore, display the error message
    $resetPasswordMessage = '<div class="alert alert-danger">Please enter all fields marked with a (*)</div>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    
    <link rel="icon" type="image/png" href="./assets/img/CCTWhiteLOGO.png"  class="h-100 w-30"/>
    <title>WDI AUG@2023</title>
    <!--     Fonts and icons     -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet"
    />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
      src="https://kit.fontawesome.com/42d5adcbca.js"
      crossorigin="anonymous"
    ></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link
      id="pagestyle"
      href="./assets/css/argon-dashboard.css?v=2.0.4"
      rel="stylesheet"
    />
  </head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="sign-up.php">
              CALANJIYAM CONSULTANCIES
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                  <a class="nav-link me-2" href="sign-up.php">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Forgot Password?
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="sign-in.php">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Sign In
                  </a>
                </li>
              </ul>

            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>

  <main class="main-content">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto mt-5">
              <div class="card card-plain mt-5">
                <div class="card-header pb-0 text-start mt-5">
                  <h4 class="font-weight-bolder mt-5">Reset Password</h4>
                  <p class="mb-0">Reset your password to regain access</p>
                </div>
                <div class="card-body shadow-lg rounded">
                  <div id="resetPasswordMessage">
                    <?php echo $resetPasswordMessage ?>
                  </div>
                  <form method="POST"  class=" form-control-lg">
                    <div class="form-group">
                      <label for="resetPasswordUsername">Username</label>
                      <input type="text" class="form-control" id="resetPasswordUsername" name="resetPasswordUsername">
                    </div>
                    <div class="form-group">
                      <label for="resetPasswordPassword1">New Password</label>
                      <input type="password" class="form-control" id="resetPasswordPassword1" name="resetPasswordPassword1">
                    </div>
                    <div class="form-group">
                      <label for="resetPasswordPassword2">Confirm New Password</label>
                      <input type="password" class="form-control" id="resetPasswordPassword2" name="resetPasswordPassword2">
                    </div>


                    <div class="modal" tabindex="-1" role="dialog" id="resetPassModal" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Log-in Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"></span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p><?php echo $resetPasswordMessage  ?></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <style>
                      /* Custom CSS for button colors */
                      #resetPasswordButton {
                        background-color: #0352BD;
                        border-color: #0352BD;
                      }

                      #resetPasswordButton:hover {
                        background-color: #024693;
                        border-color: #024693;
                      }

                      #resetPasswordButton:focus {
                        background-color: #01316a;
                        border-color: #01316a;
                      }

                      #clearButton {
                        background-color: #0352BD;
                        border-color: #0352BD;
                      }

                      #clearButton:hover {
                        background-color: #024693;
                        border-color: #024693;
                      }

                      #clearButton:focus {
                        background-color: #01316a;
                        border-color: #01316a;
                      }
                    </style>
                    <button type="submit" id="resetPasswordButton" data-toggle="modal" data-target="#resetPassModal" class="btn btn-outline-white">Reset Password</button>
                  </form>

                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                </div>
              </div>
            </div>

            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="
                    background-image: url('https://images.unsplash.com/photo-1579548122080-c35fd6820ecb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8YWJzdHJhY3QlMjBibHVlfGVufDB8fDB8fHww&w=1000&q=80');
                    background-size: cover;
                  ">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">
                  Inventory Management System
                </h4>
                <p class="text-white position-relative">

                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  <script>


  </script>
</body>

</html>
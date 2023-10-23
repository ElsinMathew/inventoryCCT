<?php
require_once('./inc/config/constants.php');
require_once('./inc/config/db.php');

$resetPasswordUsername = '';
$resetPasswordMessage = '';

function generateOTP()
{
    return mt_rand(100000, 999999);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="icon" type="image/png" href="./assets/img/CCTWhiteLOGO.png" class="h-100 w-30" />
    <title>WDI AUG@2023</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="forgotPassword.php">
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
                                    <a class="nav-link me-2" href="forgotPassword.php">
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
            </div>
        </div>
    </div>

    <main class="main-content">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto mt-5">
                            <div class="card card-plain mt-5">
                                <div class="card-header pb-0 text-start mt-5">
                                    <h4 class="font-weight-bolder mt-5">Verification</h4>
                                    <p class="mb-0">Enter your email address to verify it's you</p>
                                </div>
                                <div class="card-body shadow-lg rounded">
                                    <div id="resetPasswordMessage">
                                        <?php echo $resetPasswordMessage ?>
                                    </div>
                                    <form method="POST" class=" form-control-lg">
                                        <label for="resetPasswordUsername">Email</label>
                                        <div class="row">
                                            <div class="col-md-10 ">
                                                <input type="text" class="form-control" id="resetPasswordUsername" name="resetPasswordUsername">
                                            </div>

                                            <div class="col-md-1">
                                                <button type="submit" class="btn btn-info btn-md" name="sendOtpButton" data-bs-target="#otpSentModal" id="sendOtpButton">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>

                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                document.getElementById('sendOtpButton').addEventListener('click', function() {
                                                    var email = document.getElementById('resetPasswordEmail').value;
                                                    if (email !== '') {

                                                        var xhr = new XMLHttpRequest();
                                                        xhr.open('POST', 'sendOTP.php');
                                                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                                        xhr.onload = function() {
                                                            if (xhr.status === 200 && xhr.responseText === 'success') {
                                                                alert('OTP sent successfully!');
                                                                var otpSentModal = document.getElementById('otpSentModal');
                                                                    otpSentModal.style.display = 'block';

                                                            } else {
                                                                alert('Failed to send OTP. Please try again.');
                                                                var otpSentModal = document.getElementById('otpSentModal');
                                                                    otpSentModal.style.display = 'block';
                                                            }
                                                        };
                                                        xhr.send('email=' + encodeURIComponent(email));
                                                    }
                                                });

                                                document.getElementById('verifyOtpButton').addEventListener('click', function() {
                                                    var enteredOTP = document.getElementById('resetPasswordPasswordOtp').value;
                                                    if (enteredOTP !== '') {
                                                        // Use AJAX to send the entered OTP for verification
                                                        var xhr = new XMLHttpRequest();
                                                        xhr.open('POST', 'verifyOTP.php'); // Create a PHP script for OTP verification
                                                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                                        xhr.onload = function() {
                                                            if (xhr.status === 200) {
                                                                if (xhr.responseText === 'success') {
                                                                    alert('OTP verified successfully!');
                                                                    // Redirect to the next page
                                                                    window.location.href = 'resetPassword.php';
                                                                    
                                                                } else {
                                                                    alert('Invalid OTP. Please try again.');
                                                                }
                                                            }
                                                        };
                                                        xhr.send('otp=' + encodeURIComponent(enteredOTP));
                                                    }
                                                });
                                            });
                                        </script>

                                        <div class="form-group">
                                            <div class="col-md-10 ">
                                                <label for="resetPasswordPasswordOtp">Enter 6 digit OTP sent to your mail</label>
                                                <input type="password" class="form-control" id="resetPasswordPasswordOtp" name="resetPasswordPasswordOtp">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success" id="verifyOtpButton">Verify</button>
                                        <div class="modal" tabindex="-1" role="dialog" id="otpSentModal" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">OTP Sent</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        OTP has been sent to your email.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
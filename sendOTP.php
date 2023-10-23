<?php
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            
            $db_host = 'sql544.main-hosting.eu';
            $db_user = 'u745359346_inventory';
            $db_pass = 'Calanjiyam_Inventory.2023#AUG23';
            $db_name = 'u745359346_inventory';
        
            // Create a connection
            $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        
            // Perform a query
            $query = "SELECT * FROM  user  WHERE userEmail = '$email'";
            $result = mysqli_query($conn, $query);
        
            if (mysqli_num_rows($result) > 0) {
                
                $otp = rand(100000,999999);
            
                $to = $email; 
                $from = 'admin@crisscrosstamizh.in'; 
                $fromName = 'Calanjiyam Consultancies and Technologies'; 
                $subject = "OTP for reset password"; 
                $htmlContent = "<html><head></head><body><div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
                                  <div style='margin:50px auto;width:70%;padding:20px 0'>
                                    <div style='border-bottom:1px solid #eee'>
                                      <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Calanjiyam Consultancies
                                
                                and Technologies</a>
                                    </div>
                                    <p style='font-size:1.1em'>Hi,</p>
                                    <p>Use the following OTP for reset your password: </p>
                                    <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>".$otp."</h2>
                                  </div>
                                </div></body></html>";
                $headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";
                if(mail($to, $subject, $htmlContent, $headers))
                { 

                    $_SESSION['otp'] = $otp;
                    $_SESSION['email'] = $email;
                    header("Location: resetPassword.php");
                    echo 'success';
                    exit;
                }
                else
                { 
                   echo"<script>
                            alert('Otp Sending Failed try again');
                            window.location.href = 'forgotPassword.php';
                        </script>";
                }
            
            } else {
                mysqli_close($conn);
                echo "<script>
                        alert('Invalid email try again.');
                        window.location.href = 'forgotPassword.php';
                    </script>";
            }
            
        }
    ?>
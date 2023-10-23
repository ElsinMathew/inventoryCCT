<?php
session_start(); 
if (isset($_SESSION['resetPasswordOTP'])) {
    $enteredOTP = $_POST['otp']; 
    $storedOTP = $_SESSION['resetPasswordOTP'];
    if ($enteredOTP === $storedOTP) {
        echo 'success'; 
    } else {
        echo 'error'; 
    }
} else {
    echo 'session_error';
}

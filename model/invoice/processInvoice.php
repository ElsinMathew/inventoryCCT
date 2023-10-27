<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');
$conn=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$customerName = $_POST['customer_name'];
$customerPhone = $_POST['customer_phone'];
$customerEmail = $_POST['customer_email'];
$customerAddress = $_POST['customer_address_1'];
$invoiceType = $_POST['invoice_type'];
$invoiceNumber = $_POST['invoice_id'];
$invoiceDate = $_POST['invoice_date'];
$invoiceStatus = $_POST['invoice_status'];
$subtotal = $_POST['invoice_subtotal'];
$discount = $_POST['invoice_discount'];
$total = $_POST['invoice_total'];
$CustID = $_POST['customer_id'];

$sql = "INSERT INTO sale (customerID,customerName, customerMobile, customerEmail, customerAddress, invoiceType, invoiceNumber, saleDate, invoiceStatus, subtotal, discount, total) 
        VALUES ('$CustID','$customerName', '$customerPhone', '$customerEmail', '$customerAddress', '$invoiceType', '$invoiceNumber', '$invoiceDate', '$invoiceStatus', $subtotal, $discount, $total)";

        if (mysqli_query($conn, $sql)) {
            echo "Invoice created and saved to the database!";
    
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
mysqli_close($conn);
?>
<?php
include_once("../inc/config/constants.php");
require_once('../inc/config/db.php');



?>
<?php
session_start();
if (!isset($_SESSION['loggedIn'])) {
  header('Location: ../sign-in.php');
  exit();
}
?>
<?php
require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['invoice_id']) && is_numeric($_POST['invoice_id'])) {
    $invoiceID = $_POST['invoice_id'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_address_1 = $_POST['customer_address_1'];
    $customer_phone = $_POST['customer_phone'];
    $invoice_date = $_POST['invoice_date'];
    $invoice_subtotal = $_POST['invoice_subtotal'];
    $invoice_discount = $_POST['invoice_discount'];
    $invoice_total = $_POST['invoice_total'];
    $invoice_type = $_POST['invoice_type'];
    $invoice_vat = $invoice_total * 0.18;
    $invoice_status = $_POST['invoice_type'];

    try {
        $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

    $fetchInvoiceNumberQuery = "SELECT invoiceNumber FROM sale WHERE saleID = :invoiceID";
    $stmtFetchInvoiceNumber = $conn->prepare($fetchInvoiceNumberQuery);
    $stmtFetchInvoiceNumber->bindParam(':invoiceID', $invoiceID, PDO::PARAM_INT);
    $stmtFetchInvoiceNumber->execute();
    $invoice_number = $stmtFetchInvoiceNumber->fetchColumn();

    $updateSaleQuery = "UPDATE sale SET 
        customerName = :customer_name,
        customerEmail = :customer_email,
        customerAddress = :customer_address_1,
        customerMobile = :customer_phone,
        saleDate = :invoice_date,
        subtotal = :invoice_subtotal,
        discount = :invoice_discount,
        total = :invoice_total,
        invoiceType = :invoice_type,
        invoiceStatus = :invoice_status
        WHERE saleID = :invoiceID";

    $stmtUpdateSale = $conn->prepare($updateSaleQuery);
    $stmtUpdateSale->bindParam(':customer_name', $customer_name, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':customer_email', $customer_email, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':customer_address_1', $customer_address_1, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':customer_phone', $customer_phone, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':invoice_subtotal', $invoice_subtotal, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':invoice_discount', $invoice_discount, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':invoice_total', $invoice_total, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':invoice_type', $invoice_type, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':invoice_status', $invoice_status, PDO::PARAM_STR);
    $stmtUpdateSale->bindParam(':invoiceID', $invoiceID, PDO::PARAM_INT);

    if ($stmtUpdateSale->execute()) {
      
    } else {
        echo "Error updating invoice: " . $stmtUpdateSale->errorInfo()[2];
    }
} else {
    echo "Invalid or missing data.";
}
?>




<html lang="en">

<head>
  <meta charset="utf-8" />
  <html lang="en">
<link rel="icon" type="image/png" href="../assets/img/CCTWhiteLOGO.png" class="h-100 w-30" />
  <title>WDI AUG@2023</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style type="text/css">
    .Logo {
      position: absolute;
      top: 10px;
      margin-right: 400px;

      max-width: 170px;
      /* Adjust the size as needed */
      padding: 0 35px;
    }

    body {
      margin-top: 20px;
      background-color: #eee;
      align-items: center;
    }

    .certificate {
      position: relative;
      /* Adjust as needed */
      font-family: Arial, sans-serif;

      color: #000;
      position: relative;
    }

    .certificate::after {

      background-position: center center;
      background-size: 70%;
      background-repeat: no-repeat;
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      opacity: 0.07;
    }

    .heading {
      font-size: 20px;
      font-family: 'josefin sans', sans-serif;
      color: #0352bd;
      text-align: center;
      /* Blue color */
      margin-bottom: 20px;
      font-weight: 540;

    }

    .card {
      box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
    }

    .card {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      word-wrap: break-word;
      background-color: #fff;
      background-clip: border-box;
      border: 0 solid rgba(0, 0, 0, 0.125);
      border-radius: 1rem;
    }

    .watermark2 {
      position: absolute;
      left: 15%;
      z-index: 10000;
      font-size: 30px;
      color: lightgray;
      transform: rotate(-360deg);
      text-align: center;
      justify-content: center;
      opacity: 0.07;
    }

    .small-font {
      font-size: 16px;
      /* Adjust the font size as needed */
    }

    .water {
      position: absolute;
      bottom: 500px;
      left: 430px;
      z-index: 10000;
      font-size: 30px;
      color: lightgray;
      transform: rotate(-30deg);
      opacity: 0.6;
    }

    .water2 {
      position: absolute;
      bottom: 300px;
      /* Adjust the position as needed */
      left: 100px;
      /* Adjust the position as needed */
      z-index: 10000;
      font-size: 30px;
      color: lightgray;
      transform: rotate(-30deg);
      opacity: 0.6;
    }
  </style>
</head>


<body>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
  <div class="container ">
    <div class="row">

      <div class="col-lg-2"></div>
      <div class="col-lg-8">
        <div class="card">

          <img class="Logo" src="../assets/img/CCTlogo.png" alt="Logo">
          <h1 class="heading mt-4">Calanjiyam Consultancies <br>and Technologies</h1>
          <div class="card-body">
            <div class="certificate" id="download">

              <div class="invoice-title">
                <h4 class="float-end font-size-15">
                  Invoice #<?php echo $invoice_number ?>

                  <?php if ($invoice_type == 'paid') { ?>
                    <span class="badge bg-success font-size-12 ms-2">Paid</span><?php } else { ?>
                    <span class="badge bg-warning font-size-12 ms-2">Open</span><?php } ?>

                </h4>

                <div class="mb-4">
                  <h2 class="mb-1 text-muted"></h2>
                </div>

                <div class="text-muted">
                  <p class="mb-1"> 316/6, North Street, Sooriampalayam</p>
                  <p class="mb-1">
                    <i class="uil uil-envelope-alt me-1"></i>
                    <a href="/cdn-cgi/l/email-protection" class="cf_email" data-cfemail="0f7776754f363738216c6062">
                      Calanjiyam@gmail.com</a>
                  </p>
                  <p><i class="uil uil-phone me-1"></i>9360223419</p>
                  <div class="water2"> SAMPLE</div>
                  <div class="watermark2"> <img src="../assets/img/CCTlogo.png" alt=""></div>
                </div>
              </div>
              <hr class="my-4" />
              <div class="row">
                <div class="col-sm-6">
                  <div class="text-muted">
                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                    <h5 class="font-size-15 mb-2"><?php echo $customer_name ?></h5>
                    <p class="mb-1"><?php echo $customer_address_1 ?></p>
                    <p class="mb-1">
                      <a href="/cdn-cgi/l/email-protection" class="cf_email" data-cfemail="0f7776754f363738216c6062"><?php echo $customer_email ?></a>
                    </p>
                    <p><?php echo  $customer_phone ?></p>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="text-muted text-sm-end">
                    <div>
                      <h5 class="font-size-15 mb-1">Invoice No:</h5>
                      <p><?php echo $invoice_number ?></p>
                    </div>
                    <div class="mt-4">
                      <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                      <p><?php echo $invoice_date ?></p>
                    </div>
                    <div class="mt-4">
                      <h5 class="font-size-15 mb-1">Greetings CCT</h5>

                      <div class="water">SAMPLE</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="py-2">
                <h5 class="font-size-15">Order Summary</h5>
                <div class="">
                  <table class="table align-middle table-nowrap table-centered mb-0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>

                        <th class="text-end" style="width: 120px">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($_POST['invoice_product'] as $key => $value) {
                        $item_product = $value;

                        $item_qty = $_POST['invoice_product_qty'][$key];
                        $item_price = $_POST['invoice_product_price'][$key];
                        $item_discount = $_POST['invoice_product_discount'][$key];
                      ?>
                        <tr>
                          <th scope="row "><?php echo $key + 1 ?></th>
                          <td>
                            <div>
                              <h5 class="text-truncate  mb-1 small-font">
                                <?php echo  $item_product ?>
                              </h5>

                            </div>
                          </td>
                          <td>$ <?php echo  $item_price ?></td>
                          <td class="text-center"><?php echo  $item_qty ?></td>
                          <td class="text-end">$ <?php echo  $item_price ?></td>
                        </tr>
                      <?php }
                      ?>

                      <tr>
                        <th scope="row" colspan="4" class="text-end">
                          Sub Total
                        </th>
                        <td class="text-end">$<?php echo $invoice_subtotal ?></td>
                      </tr>

                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                          Discount :
                        </th>
                        <td class="border-0 text-end"><?php echo $invoice_discount ?></td>

                      </tr>



                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                          GST Amt
                        </th>
                        <td class="border-0 text-end"><?php echo $invoice_vat ?> </td>

                      </tr>

                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                          Total
                        </th>
                        <td class="border-0 text-end">
                          <h4 class="m-0 fw-semibold"><?php echo $invoice_total ?></h4>

                        </td>
                      </tr>
                    </tbody>

                  </table>
                </div>
                <div class="d-print-none mt-4">
                  <div class="float-end">
                    <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-lg-2"></div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript"></script>
  <script>
    function printAfterDelay() {
      setTimeout(function() {
        window.print();
      }, 1000);
    }
    window.addEventListener('load', printAfterDelay);
  </script>

</body>

</html>
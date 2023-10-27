<?php

include_once("../inc/config/constants.php");
require_once('../inc/config/db.php');



?>
<?php
session_start();
// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
  header('Location: ../sign-in.php');
  exit();
}
?>

<?php
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$invoiceID = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : null;
if ($invoiceID) {

  $fetchInvoiceQuery = "SELECT * FROM sale WHERE saleID = ?";

  $stmtFetchInvoice = mysqli_prepare($conn, $fetchInvoiceQuery);
  mysqli_stmt_bind_param($stmtFetchInvoice, 'i', $invoiceID);

  if (mysqli_stmt_execute($stmtFetchInvoice)) {
    $invoiceData = mysqli_stmt_get_result($stmtFetchInvoice);
    $invoiceData = mysqli_fetch_assoc($invoiceData);

    $customer_name = $invoiceData['customerName'];
    $customer_address_1 = $invoiceData['customerAddress'];
    $customer_email = $invoiceData['customerEmail'];
    $customer_phone = $invoiceData['customerMobile'];

    $invoice_date = $invoiceData['saleDate'];
    $invoice_product_discount = $invoiceData['discount'];
    $invoice_subtotal = $invoiceData['subtotal'];
    $invoice_discount = $invoiceData['discount'];
    $invoice_total = $invoiceData['total'];
    $invoice_vat = $invoice_total * 0.18;
    $invoice_number = $invoiceData['invoiceNumber'];
    $invoice_type = $invoiceData['invoiceType'];
  }
  $fetchLineItemsQuery = "SELECT li.product_name, li.quantity, li.price, li.discount
  FROM line_items li
  WHERE li.invoice_id = ?";

$stmtFetchLineItems = mysqli_prepare($conn, $fetchLineItemsQuery);
mysqli_stmt_bind_param($stmtFetchLineItems, 'i', $invoiceID);

if (mysqli_stmt_execute($stmtFetchLineItems)) {
$lineItemsResult = mysqli_stmt_get_result($stmtFetchLineItems);

$lineItems = array(); // Initialize an array to store line items

while ($lineItemData = mysqli_fetch_assoc($lineItemsResult)) {
$lineItems[] = $lineItemData; // Store each line item in the array
}
} else {
echo "Error executing the fetch query for line items";
}
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
                       $rowNumber = 1; 
                      foreach ($lineItems as $lineItem) {
                        $item_product = $lineItem['product_name'];
                        $item_qty = $lineItem['quantity'];
                        $item_price = $lineItem['price'];
                        $item_discount = $lineItem['discount'];

                      ?>
                        <tr>
                          <th scope="row "><?php echo $rowNumber++; ?></th>
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
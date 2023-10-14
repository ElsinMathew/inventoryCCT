<?php
include('functions.php');
include_once("../../inc/config/constants.php");
require_once('../../inc/config/db.php');

$InvoiceDetailsSearchSql = 'SELECT invoice as InvoiceNo FROM invoices';
$InvoiceDetailsSearchStatement = $conn->prepare($InvoiceDetailsSearchSql);
$InvoiceDetailsSearchStatement->execute();
$InvoiceId = $InvoiceDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)['InvoiceNo'];
?>
<html lang="en">

<head>
  <meta charset="utf-8" />

  <title></title>
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
    font-size: 16px; /* Adjust the font size as needed */
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

          <img class="Logo" src="../../assets/img/CCTlogo.png" alt="Logo">
          <h1 class="heading mt-4">Calanjiyam Consultancies <br>and Technologies</h1>
          <div class="card-body">
            <div class="certificate" id="download">

              <div class="invoice-title">
                <h4 class="float-end font-size-15">
                  Invoice #<?php echo $InvoiceId ?>
                  <span class="badge bg-success font-size-12 ms-2">Paid</span>
                </h4>
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $customer_name = $_POST["customer_name"];
                  $customer_address_1 = $_POST["customer_address_1"];

                  $customer_email = $_POST["customer_email"];

                  $customer_phone = $_POST["customer_phone"];

                  $Invoice_product_price = $_POST["invoice_product_price"];

                  $Invoice_date = $_POST["invoice_date"];
                  $Invoice_product_qty = $_POST["invoice_product_qty"];
                  $Invoice_product_discount = $_POST["invoice_product_discount"];
                  $Invoice_subtotal = $_POST["invoice_subtotal"];
                  $Invoice_discount = $_POST["invoice_discount"];
              
                  $Invoice_vat = $_POST["invoice_vat"];
                  $Invoice_total = $_POST["invoice_total"];


                  $invoice_number = $_POST['invoice_id']; // invoice number
                  $invoice_date = $_POST['invoice_date']; // invoice date

                  $invoice_subtotal = $_POST['invoice_subtotal']; // invoice sub-total
                  $invoice_discount = $_POST['invoice_discount']; // invoice discount
                  $invoice_total = $_POST['invoice_total']; // invoice total
    
                  $invoice_type = $_POST['invoice_type']; // Invoice type
                  $invoice_status = $_POST['invoice_status']; // Invoice status
                ?>
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
                    <div class="watermark2"> <img src="../../assets/img/CCTlogo.png" alt=""></div>
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
                      <p>#DZ0112</p>
                    </div>
                    <div class="mt-4">
                      <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                      <p><?php echo $Invoice_date ?></p>
                    </div>
                    <div class="mt-4">
                      <h5 class="font-size-15 mb-1">Order No:</h5>
                      <p>#1123456</p>
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
                        <th >No.</th>
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
                        <th scope="row " ><?php echo $key+1 ?></th>
                        <td>
                          <div>
                            <h5 class="text-truncate  mb-1 small-font">
                              <?php echo  $item_product?>
                            </h5>

                          </div>
                        </td>
                        <td>$   <?php echo  $item_price?></td>
                        <td class="text-center"><?php  echo  $item_qty ?></td>
                        <td class="text-end">$ <?php echo  $item_price?></td>
                      </tr>
                      <?php }} ?>

                      <tr>
                        <th scope="row" colspan="4" class="text-end">
                          Sub Total
                        </th>
                        <td class="text-end">$<?php echo $Invoice_subtotal ?></td>
                      </tr>

                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                          Discount :
                        </th>
                        <td class="border-0 text-end"><?php echo $Invoice_discount ?></td>

                      </tr>



                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                          GST Amt
                        </th>
                        <td class="border-0 text-end"><?php echo $Invoice_vat ?> </td>

                      </tr>

                      <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                          Total
                        </th>
                        <td class="border-0 text-end">
                          <h4 class="m-0 fw-semibold"><?php echo $Invoice_total ?></h4>

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
  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
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
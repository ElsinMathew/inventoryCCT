<?php
include('functions.php');
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

?>
<?php
session_start();
// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
    header('Location: ../../sign-in.php');
    exit();
}
?>
<?php

if (isset($_GET['invoice_id']) && is_numeric($_GET['invoice_id'])) {
    $invoiceID = $_GET['invoice_id'];

    // Create a PDO database connection
    try {
        $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

    $invoiceDetailsSql = 'SELECT * FROM sale WHERE saleID = :invoiceID';
    $invoiceDetailsStatement = $conn->prepare($invoiceDetailsSql);
    $invoiceDetailsStatement->bindParam(':invoiceID', $invoiceID, PDO::PARAM_INT);
    $invoiceDetailsStatement->execute();
    $invoiceDetails = $invoiceDetailsStatement->fetch(PDO::FETCH_ASSOC);

    if ($invoiceDetails) {
        $customer_name = $invoiceDetails['customerName'];
        $customer_email = $invoiceDetails['customerEmail'];
        $customer_address_1 = $invoiceDetails['customerAddress'];
        $customer_phone = $invoiceDetails['customerMobile'];

        $invoice_number = $invoiceDetails['invoiceNumber'];
        $invoice_date = $invoiceDetails['saleDate'];
        $invoice_subtotal = $invoiceDetails['subtotal'];
        $invoice_discount = $invoiceDetails['discount'];
        $invoice_total = $invoiceDetails['total'];

        $invoice_type = $invoiceDetails['invoiceType'];
        $invoice_status = $invoiceDetails['invoiceStatus']; // Note: This line is corrected to 'invoiceStatus' if that's the correct column name.
    } else {
        echo "Invoice not found.";
    }
} else {
    echo "Invalid or missing invoice ID.";
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <script src="js/scripts.js"></script>


    <!-- AdminLTE App -->
    <script src="js/app.min.js"></script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="../../assets/img/CCTWhiteLOGO.png" class="h-100 w-30" />
    <title>WDI AUG@2023</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <!-- Invoice-Creation Header -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</head>


<div class="min-height-300  position-absolute w-100" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="../../index.php" target="">
            <img src="../../assets/img/CCTlogo.png" class="navbar-brand-img h-100 w-20 " />
            <span class="ms-1 font-weight-bold text-dark"> CCT@TEAM 1</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link " href="../../index.php">
                    <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                        <i class="ni ni-world-2 text-primary text-md opacity-10 "></i>

                    </div>
                    <span class="nav-link-text ms-1 ">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../pages/Items.php">
                    <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-md opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Item</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./invoice-creation.php">
                    <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-md opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Invoices</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../pages/Invoices.php">
                    <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                        <i class="ni ni-app text-info text-md opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Invoices</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../pages/customer.php">
                    <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                        <i class="ni ni-world-2 text-danger text-md opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../model/login/logout.php">
                    <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                        <i class="ni ni-fat-delete text-danger text-md opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<form action="../../pages/invoiceUpdate.php?invoice_id=<?php echo $invoiceID; ?>" method="post" onsubmit="return validateForm();" id="invoiceForm">
    <div class="container">

        <div class="row rounded  justify-content-center">
            <div class="col-lg-1 col-md-0 mt-5"></div>
            <div class="col-lg-6 mt-5 rounded mb-lg-0">
                <div class="card rounded shadow pb-0 pt-3">
                    <div class="card-header">
                        <h4 class="float-left">Customer Information:</h4><br>
                        <a href="#" class="float-left select-customer" name="select-customer" data-bs-toggle="modal" data-bs-target="#insert_customer"><b>OR</b> Select Existing Customer</a>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input required" name="customer_name" id="customer_name" placeholder="Name" tabindex="1" value="<?php echo $customer_name; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input required" name="customer_phone" id="customer_phone" placeholder="Phone Number" tabindex="3" value="<?php echo $customer_phone; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input " name="customer_email" id="customer_email" placeholder="Email" tabindex="5" value="<?php echo $customer_email; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input " name="customer_address_1" id="customer_address_1" placeholder="Address" tabindex="7" value="<?php echo $customer_address_1; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-5">
                <div class="card shadow">
                    <div class="card-body">
                        <form method="post" id="create_invoice">
                            <input type="hidden" name="action" value="create_invoice">
                            <div class="form-group">
                                <label for="invoice_type"> Type:</label>
                                <input type="hidden"  >
                                <input type="text" name="display_invoice_type" class="form-control" placeholder="Invoice Number" disabled aria-describedby="sizing-addon1" value="Invoice">
                            </div>

                            <div class="form-group">
                                <label for="invoice_type">Status:</label>
                                <select name="invoice_type" id="invoice_type" class="form-control" type="submit">
                                    <option value="open" <?php if ($invoice_type === 'open') { ?>selected<?php } ?>>Open</option>
                                    <option value="paid" <?php if ($invoice_type === 'paid') { ?>selected<?php } ?>>Paid</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="invoice_date">Invoice Date:</label>
                                <div class="input-group date" id="invoice_date">
                                    <input type="date" class="form-control required" name="invoice_date" id="invoice_date" placeholder="Invoice Date" value="<?php echo $invoice_date; ?>" />

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="invoice_id">Invoice Number:</label>
                                <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice_number ?>">
                                <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customerID ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control required" placeholder="Invoice Number"  name="invoice_id" id="invoice_id"  disabled aria-describedby="sizing-addon1" value="#<?php echo $invoice_number ?>">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2 ">
            <div class=" col-lg-12" style="left:11%;">
                <div class="card rounded shadow pb-0 pt-3 rounded">
                    <div class="card-body rounded">
                        <div class="table-responsive">
                            <table class="table table-hover invoice_table" id="invoice_table">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">
                                            <h4>Product</h4>
                                        </th>
                                        <th style="width: 10%;">
                                            <h4>Qty</h4>
                                        </th>
                                        <th style="width: 15%;">
                                            <h4>Price</h4>
                                        </th>
                                        <th style="width: 15%;">
                                            <h4>Discount</h4>
                                        </th>
                                        <th style="width: 20%;">
                                            <h4>Sub Total</h4>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (isset($_GET['invoice_id']) && is_numeric($_GET['invoice_id'])) {
                                        $invoiceID = $_GET['invoice_id'];
                                        $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
                                        if ($mysqli->connect_error) {
                                            die('Error: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
                                        }
                                        $query2 = "SELECT li.product_name, li.quantity, li.price, li.discount, s.subtotal AS sale_subtotal
                                        FROM line_items li
                                        LEFT JOIN sale s ON li.invoice_id = s.saleID
                                        WHERE li.invoice_id = '" . $mysqli->real_escape_string($invoiceID) . "'";
                                        $result2 = mysqli_query($mysqli, $query2);
                                        if ($result2) {
                                            while ($rows = mysqli_fetch_assoc($result2)) {
                                                $item_product = $rows['product_name'];
                                                $item_qty = $rows['quantity'];
                                                $item_price = $rows['price'];
                                                $item_discount = $rows['discount'];
                                                    
                                    ?>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <a href="#" class="btn btn-danger btn-md  delete-row">
                                                                <span class="fas fa-trash" aria-hidden="true"></span>
                                                            </a>
                                                        </div>
                                                        <input type="hidden" name="invoice_id" value="<?php echo $invoiceID; ?>" hidden>
                                                        <input type="text" class="form-control item-input invoice_product" name="invoice_product[]" id="invoice_product" placeholder="Enter Product Name OR Select" value="<?php echo $item_product; ?>">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary btn-xs text-xs item-select" data-bs-toggle="modal" data-bs-target="#insert">Select Product</button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control invoice_product_qty calculate" name="invoice_product_qty[]" value="<?php echo  $item_qty; ?>">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text text-xs">
                                                            <?php echo CURRENCY ?>
                                                        </span>
                                                        <input type="number" class="form-control calculate invoice_product_price required" name="invoice_product_price[]" placeholder="0.00" value="<?php echo  $item_price; ?>" >
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control calculate" id="invoice_product_discount" name="invoice_product_discount[]" placeholder="Enter % OR Price" value="<?php echo  $item_discount; ?>" >
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <span class="input-group-text text-xs">
                                                                <?php echo CURRENCY ?>
                                                            </span>
                                                        </span>
                                                        <input type="text" class="form-control calculate-sub" id="invoice_product_sub" name="invoice_product_sub[]" value="0.00" disabled>
                                                    </div>
                                                </td>
                                                <?php }   }
                                    }
                                    ?>
                                            </tr>
                                    
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 float-right" style="left: 12%;">
            <div class="row">
                <div class="col-xs-4 col-xs-offset-5 ">
                    <strong>Sub Total:</strong>
                    <?php echo CURRENCY
                    ?><span class="invoice-sub-total float-right"></span>
                    <input type="hidden" name="invoice_subtotal" id="invoice_subtotal" value="<?php echo $invoice_subtotal; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>Discount:</strong>
                    <?php echo CURRENCY
                    ?> <span class="invoice-discount float-right"></span>
                    <input type="hidden" name="invoice_discount" id="invoice_discount" value="<?php echo $invoice_discount; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>GST </strong>
                    <?php echo CURRENCY ?>
                    <span class="invoice-vat float-right" data-enable-vat="<?php echo ENABLE_VAT ?>" data-vat-rate="<?php echo VAT_RATE ?>" data-vat-method="<?php echo VAT_INCLUDED ?>"></span>
                    <input type="hidden" name="invoice_vat" id="invoice_vat" value="<?php echo $invoice_vat; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5 ">
                    <strong style="font-size:30px;">Total:</strong>
                    <?php echo CURRENCY
                    ?><span class="invoice-total float-right" class="invoice-total " style="font-size:30px;"> </span>
                    <input type="hidden" name="invoice_total" id="invoice_total" value="<?php echo $invoice_total; ?>">
                </div>
                <button href="#" class="btn btn-success btn-sm " type="submit" data-loading-text="Creating..."><span aria-hidden="true"></span> Create Invoice</button>
            </div>

        </div>
    </div>
</form>



<div class="modal fade" id="insert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="exampleModalLabel">Select Product</h5>
            </div>
            <div class="modal-body">
                <?php popProductsList(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="selected">Add</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="insert_customer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: max-content;">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title align-center" id="exampleModalLabel">Select An Existing Customer</h5>
            </div>
            <div class="modal-body">
                <?php popCustomersList(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>




<script>
       

    function updateTotals(row) {
        var tr = $(row).closest('tr');
        var quantityInput = $('[name="invoice_product_qty[]"]', tr);
        var priceInput = $('[name="invoice_product_price[]"]', tr);
        var discountInput = $('[name="invoice_product_discount[]"]', tr);

        // Check if the inputs exist
        if (quantityInput.length === 0 || priceInput.length === 0 || discountInput.length === 0) {
            return; // Return early if any input is missing
        }

        var quantity = parseFloat(quantityInput.val()) || 0;
        var price = parseFloat(priceInput.val()) || 0;
        var discountValue = discountInput.val();

        var isPercent = discountValue.indexOf('%') > -1;
        var percent = $.trim(discountValue.replace('%', ''));
        var subtotal = quantity * price;

        if ($.isNumeric(percent) && percent !== 0) {
            if (isPercent) {
                subtotal -= (parseFloat(percent) / 100) * subtotal;
            } else {
                subtotal -= parseFloat(percent);
            }
        } else {
            discountInput.val('');
        }

        $('.calculate-sub', tr).val(subtotal.toFixed(2));
        calculateTotal();
    }

 
    function calculateTotal() {

        var grandTotal = 0,
            disc = 0,
            c_ship = parseInt($('.calculate.shipping').val()) || 0;

        $('#invoice_table tbody tr').each(function() {
            var c_sbt = $('.calculate-sub', this).val(),
                quantity = $('[name="invoice_product_qty[]"]', this).val(),
                price = $('[name="invoice_product_price[]"]', this).val() || 0,
                subtotal = parseInt(quantity) * parseFloat(price);

            grandTotal += parseFloat(c_sbt);
            disc += subtotal - parseFloat(c_sbt);
        });

        // VAT, DISCOUNT, SHIPPING, TOTAL, SUBTOTAL:
        var subT = parseFloat(grandTotal),
            finalTotal = parseFloat(grandTotal + c_ship),
            vat = parseInt($('.invoice-vat').attr('data-vat-rate'));

        $('.invoice-sub-total').text(subT.toFixed(2));
        $('#invoice_subtotal').val(subT.toFixed(2));
        $('.invoice-discount').text(disc.toFixed(2));
        $('#invoice_discount').val(disc.toFixed(2));

        if ($('.invoice-vat').attr('data-enable-vat') === '1') {

            if ($('.invoice-vat').attr('data-vat-method') === '1') {
                $('.invoice-vat').text(((vat / 100) * finalTotal).toFixed(2));
                $('#invoice_vat').val(((vat / 100) * finalTotal).toFixed(2));
                $('.invoice-total').text((finalTotal).toFixed(2));
                $('#invoice_total').val((finalTotal).toFixed(2));
            } else {
                $('.invoice-vat').text(((vat / 100) * finalTotal).toFixed(2));
                $('#invoice_vat').val(((vat / 100) * finalTotal).toFixed(2));
                $('.invoice-total').text((finalTotal + ((vat / 100) * finalTotal)).toFixed(2));
                $('#invoice_total').val((finalTotal + ((vat / 100) * finalTotal)).toFixed(2));
            }
        } else {
            $('.invoice-total').text((finalTotal).toFixed(2));
            $('#invoice_total').val((finalTotal).toFixed(2));
        }


        if ($('input.remove_vat').is(':checked')) {
            $('.invoice-vat').text("0.00");
            $('#invoice_vat').val("0.00");
            $('.invoice-total').text((finalTotal).toFixed(2));
            $('#invoice_total').val((finalTotal).toFixed(2));
        }

    }
    calculateTotal();

    

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('customer-select')) {
            var customer_name = e.target.getAttribute('data-customer-name');
            var customer_email = e.target.getAttribute('data-customer-email');
            var customer_phone = e.target.getAttribute('data-customer-phone');
            var customer_address_1 = e.target.getAttribute('data-customer-address-1');
            var customer_town = e.target.getAttribute('data-customer-town');
            var customer_county = e.target.getAttribute('data-customer-county');
            var customerID = e.target.getAttribute('data-customer-id');

            document.getElementById('customer_name').value = customer_name;
            document.getElementById('customer_email').value = customer_email;
            document.getElementById('customer_phone').value = customer_phone;
            document.getElementById('customer_address_1').value = customer_address_1;


            document.getElementById('customer_id').value = customerID;
            console.log(customerID);
            console.log(customer_name);
            var modal = document.getElementById('insert_customer');
            if (modal) {
                $('#insert_customer').modal('hide');
            }

        }
    });


    $(document).on('click', ".item-select", function(e) {
        e.preventDefault();

        var product = $(this);

        $('#insert').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#selected', function(e) {
            var itemText = $('#insert').find("option:selected").text();
            var itemValue = $('#insert').find("option:selected").val();

            $(product).closest('tr').find('.invoice_product').val(itemText);
            $(product).closest('tr').find('.invoice_product_price').val(itemValue);

            updateTotals($(product).closest('tr').find('.calculate'));
            calculateTotal();
        });

        return false;
    });

    var cloned = $('#invoice_table tr:last').clone();
    $(".add-row").click(function(e) {
        e.preventDefault();
        cloned.clone().appendTo('#invoice_table');
    });

    $('#invoice_table').on('click', ".delete-row", function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        calculateTotal();
    });



    calculateTotal();

    $('#invoice_table').on('mouseenter', '.calculate', function() {
        updateTotals(this);
        calculateTotal();
    });

    $('#invoice_totals').on('mouseenter', '.calculate', function() {
        calculateTotal();
    });

    $('#invoice_product').on('mouseenter', '.calculate', function() {
        calculateTotal();
    });

</script>
<script>
    function validateForm() {

        var errorCounter = 0;


        $(".required").each(function() {

            if ($(this).val() === '') {
                $(this).addClass("is-invalid");
                errorCounter++;
            } else {
                $(this).removeClass("is-invalid");
            }
        });


        if (errorCounter === 0) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</html>
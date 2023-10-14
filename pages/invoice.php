<!DOCTYPE html>
<html lang="en">

<head>
    
    <link rel="icon" type="image/png" href="../assets/img/CCTWhiteLOGO.png" class="h-100 w-30" />
    <title>WDI AUG@2023</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    
    <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>


<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300  position-absolute w-100"
        style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="index.php" target="">
                <img src="./assets/img/CCTlogo.png" class="navbar-brand-img h-100 w-20 " />
                <span class="ms-1 font-weight-bold text-dark"> CCT@TEAM 1</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0" />
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        <div
                            class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                            <i class="ni ni-world-2 text-primary text-md opacity-10 "></i>

                        </div>
                        <span class="nav-link-text ms-1 ">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pages/Items.php">
                        <div
                            class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-md opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Item</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
            <a class="nav-link" href="../pages/billing.html">
              <div
                class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center"
              >
                <i
                  class="ni ni-credit-card text-success text-md opacity-10"
                ></i>
              </div>
              <span class="nav-link-text ms-1">Billing</span>
            </a>
          </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="">
                        <div
                            class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                            <i class="ni ni-app text-info text-md opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Search</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./pages/customer.php">
                        <div
                            class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                            <i class="ni ni-world-2 text-danger text-md opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Customer</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="model/login/logout.php">
                        <div
                            class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
                            <i class="ni ni-fat-delete text-danger text-md opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    
    <div class="row mt-5 justify-content-center py-4">
        
        <div class="col-lg-5  rounded  mb-lg-0">
            <div class="">
                <div class="card  rounded shadow pb-0 pt-3">
                    <div class="card-header">
                        <h4 class="float-left">Customer Information</h4>
                        <a href="#" class="float-right select-customer"><b>OR</b> Select Existing Customer</a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input required"
                                name="customer_name" id="customer_name" placeholder="Name" tabindex="1">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input required"
                                name="customer_address_1" id="customer_address_1" placeholder="Phone Number"
                                tabindex="3">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input required"
                                name="customer_town" id="customer_town" placeholder="Email" tabindex="5">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom copy-input required"
                                name="customer_town" id="customer_town" placeholder="Address" tabindex="5">
                        </div>

                        <!-- Add more form elements as needed -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <div id="response" class="alert alert-success" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <div class="message"></div>
                    </div>
                    <form method="post" id="create_invoice">
                        <input type="hidden" name="action" value="create_invoice">

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-2 text-center">
                                <div class="form-group">
                                    <label for="invoice_type">Select Type:</label>
                                    <select name="invoice_type" id="invoice_type" class="form-control">
                                        <option value="invoice" selected>Invoice</option>
                                        <option value="quote">Quote</option>
                                        <option value="receipt">Receipt</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="invoice_status">Status:</label>
                                    <select name="invoice_status" id="invoice_status" class="form-control">
                                        <option value="open" selected>Open</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_date">Invoice Date:</label>
                                    <div class="input-group date" id="invoice_date">
                                        <input type="text" class="form-control required" name="invoice_date"
                                            placeholder="Invoice Date" data-date-format="<?php echo DATE_FORMAT ?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_due_date">Due Date:</label>
                                    <div class="input-group date" id="invoice_due_date">
                                        <input type="text" class="form-control required" name="invoice_due_date"
                                            placeholder="Due Date" data-date-format="<?php echo DATE_FORMAT ?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_id">Invoice Number:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">#
                                            <?php //echo 'YOUR_INVOICE_PREFIX_HERE'; 
                                            ?>
                                        </span>
                                        <input type="text" name="invoice_id" id="invoice_id"
                                            class="form-control required" placeholder="Invoice Number"
                                            aria-describedby="sizing-addon1"
                                            value="<?php //getInvoiceId(); 
                                            ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>








    <div class="row mt-5 justify-content-center">
        <div class="col-lg-2"></div>
        <div class="col-lg-10 float-right">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="invoice_table">
                            <thead>
                                <tr>
                                    <th style="width: 30%;">
                                        <h4>Product</h4>
                                        <a href="#" class="btn btn-success btn-sm add-row">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
                                            Product
                                        </a>
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
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <a href="#" class="btn btn-danger btn-sm delete-row">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                            <input type="text" class="form-control form-group-sm item-input invoice_product" 
                                            id="invoice_product" 
                                            name="invoice_product[]" 
                                            placeholder="Enter Product Name OR Select">
                                            <div class="input-group-append">
                                                <input class="btn btn-secondary item-select" type="button"
                                                    id="selectProduct ">Select Product>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control invoice_product_qty calculate"
                                            name="invoice_product_qty[]" value="1">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <?php //echo CURRENCY 
                                                    ?>
                                                </span>
                                            </span>
                                            <input type="number"
                                                class="form-control calculate invoice_product_price required"
                                                name="invoice_product_price[]" placeholder="0.00">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calculate"
                                            name="invoice_product_discount[]"
                                            placeholder="Enter % OR value (ex: 10% or 10.50)">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <?php //echo CURRENCY 
                                                    ?>
                                                </span>
                                            </span>
                                            <input type="text" class="form-control calculate-sub"
                                                name="invoice_product_sub[]" value="0.00" disabled>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>Sub Total:</strong>
                </div>
                <div class="col-xs-3">
                    <?php //echo CURRENCY 
                    ?><span class="invoice-sub-total">0.00</span>
                    <input type="hidden" name="invoice_subtotal" id="invoice_subtotal">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>Discount:</strong>
                </div>
                <div class="col-xs-3">
                    <?php //echo CURRENCY 
                    ?> <span class="invoice-discount">0.00</span>
                    <input type="hidden" name="invoice_discount" id="invoice_discount">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong class="shipping">Shipping:</strong>
                </div>
                <div class="col-xs-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon">
                            <?php //echo CURRENCY 
                            ?>
                        </span>
                        <input type="text" class="form-control calculate shipping" name="invoice_shipping"
                            aria-describedby="sizing-addon1" placeholder="0.00">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>TAX/VAT:</strong><br>Remove TAX/VAT <input type="checkbox" class="remove_vat">
                </div>
                <div class="col-xs-3">
                    <?php //echo CURRENCY 
                    ?><span class="invoice-vat" data-enable-vat="<?php //echo ENABLE_VAT 
                    ?>"
                        data-vat-rate="<?php //echo VAT_RATE 
                        ?>"
                        data-vat-method="<?php //echo VAT_INCLUDED 
                        ?>">0.00</span>
                    <input type="hidden" name="invoice_vat" id="invoice_vat">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>Total:</strong>
                </div>
                <div class="col-xs-3">
                    <?php //echo CURRENCY 
                    ?><span class="invoice-total ">0.00</span>
                    <input type="hidden" name="invoice_total" id="invoice_total">
                </div>
            </div>
        </div>


    </div>
    </div>
    </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




</body>

</html>
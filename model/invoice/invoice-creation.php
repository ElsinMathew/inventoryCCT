<?php
include('functions.php');

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
      <a class="navbar-brand m-0" href="index.php" target="">
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
            <a class="nav-link active" href="invoice.php">
              <div
                class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center"
              >
                <i
                  class="ni ni-credit-card text-success text-md opacity-10"
                ></i>
              </div>
              <span class="nav-link-text ms-1">Invoices</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-app text-info text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Search</span>
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
          <a class="nav-link" href="../../sign-in.php">
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-fat-delete text-danger text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  
  <form action="invoices.php" method="post">
  <div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-0 mt-5"></div>
        <div class="col-lg-5 mt-5 rounded mb-lg-0">
            <div class="card rounded shadow pb-0 pt-3">
                <div class="card-header">
                    <h4 class="float-left">Customer Information:</h4><br>
                    <a href="#" class="float-left select-customer" name="select-customer" data-bs-toggle="modal" data-bs-target="#insert_customer"  ><b>OR</b> Select Existing Customer</a>
                    <div class="clearfix"> </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control margin-bottom copy-input required"
                            name="customer_name" id="customer_name" placeholder="Name" tabindex="1">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control margin-bottom copy-input required"
                            name="customer_phone" id="customer_phone" placeholder="Phone Number"
                            tabindex="3">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control margin-bottom copy-input required"
                            name="customer_email" id="customer_email" placeholder="Email" tabindex="5">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control margin-bottom copy-input required"
                            name="customer_address_1" id="customer_address_1" placeholder="Address" tabindex="7">
                    </div>
             
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-5">
            <div class="card shadow">
                <div class="card-body">
                    <form method="post" id="create_invoice" >
                        <input type="hidden" name="action" value="create_invoice">
                        <div class="form-group">
                            <label for="invoice_type">Select Type:</label>
                            <select name="invoice_type" id="invoice_type" class="form-control">
                                <option value="invoice" selected>Invoice</option>
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
                        <div class="form-group">
                            <label for="invoice_date">Invoice Date:</label>
                            <div class="input-group date" id="invoice_date">
                                <input type="date" class="form-control required" name="invoice_date" id="invoice_date"
                                    placeholder="Invoice Date" data-date-format="<?php echo DATE_FORMAT ?>" />
                              
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="invoice_id">Invoice Number:</label>
                            <div class="input-group">

                                <input type="text" name="invoice_id" id="invoice_id" class="form-control required"
                                    placeholder="Invoice Number" aria-describedby="sizing-addon1"
                                    value="<?php getInvoiceId(); ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-2 ">
        <div class=" col-xl-10 col-lg-12  col-md-12 position-relative align-right  " style="left:21%;">
            <div class="card rounded shadow pb-0 pt-3 rounded">
                <div class="card-body rounded  ">
                    <div class="table-responsive">
                        <table class="table table-hover invoice_table" id="invoice_table">   
                        <a href="#" class="btn btn-success btn-sm add-row  fa-circle-plus" aria-hidden="true">Add product</a>
                            <thead>
                                <tr>
                                    <th style="width: 30%;" >
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
                                <tr> 
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <a href="#" class="btn btn-danger btn-md  delete-row">
                                                    <span class="fas fa-trash" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                            <input type="text" class="form-control item-input invoice_product"
                                                name="invoice_product[]" id="invoice_product"
                                                placeholder="Enter Product Name OR Select">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary btn-xs text-xs item-select" 
                                                    data-bs-toggle="modal" data-bs-target="#insert">Select Product</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control invoice_product_qty calculate"
                                            name="invoice_product_qty[]" value="1">
                                    </td>
                                    <td>
                                        <div class="input-group">

                                                <span class="input-group-text text-xs">
                                                    <?php echo CURRENCY 
                                                    ?>
                                                </span>
                                            <input type="number"
                                                class="form-control calculate invoice_product_price required" 
                                                name="invoice_product_price[]"   placeholder="0.00" >
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calculate"
                                        id="invoice_product_discount"
                                            name="invoice_product_discount[]"
                                            placeholder="Enter % OR Price">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text text-xs">
                                                    <?php echo CURRENCY 
                                                    ?>
                                                </span>
                                            </span>
                                            <input type="text" class="form-control calculate-sub"  id="invoice_product_sub"
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
    </div>
        <div class="col-lg-4 float-right" >
            <div class="row">
                <div class="col-xs-4 col-xs-offset-5 ">
                    <strong>Sub Total:</strong>
                    <?php echo CURRENCY 
                    ?><span class="invoice-sub-total float-right">0.00</span>
                    <input type="hidden" name="invoice_subtotal" id="invoice_subtotal">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>Discount:</strong>
                    <?php echo CURRENCY 
                    ?> <span class="invoice-discount float-right">0.00</span>
                    <input type="hidden" name="invoice_discount" id="invoice_discount">
                </div> 
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong class="shipping">Coupon</strong>
                    <input type="text" class="form-control col-sm-4 calculate coupon float-right" name="invoice_coupon" id="invoice_coupon"
                            aria-describedby="sizing-add" placeholder="0.00">
                    <span class="input-group-addon">
                            <?php echo CURRENCY 
                            ?></span>
                </div>
            </div>

   
            <div class="row">
                <div class="col-xs-4 col-xs-offset-5">
                    <strong>GST </strong>
                    <?php echo CURRENCY ?>
                    <span class="invoice-vat float-right" data-enable-vat="<?php echo ENABLE_VAT ?>"
                        data-vat-rate="<?php echo VAT_RATE ?>"
                        data-vat-method="<?php echo VAT_INCLUDED ?>">0.00</span>
                    <input type="hidden" name="invoice_vat" id="invoice_vat">
                </div> 
            </div>

            <div class="row">
                <div class="col-xs-4 col-xs-offset-5 ">
                    <strong style="font-size:30px;">Total:</strong>
                    <?php echo CURRENCY 
                    ?><span class="invoice-total float-right" class="invoice-total "style="font-size:30px;">0.00</span>
                    <input type="hidden" name="invoice_total" id="invoice_total">
                </div>
                <button href="#" class="btn btn-success btn-sm "  type="submit"   data-loading-text="Creating..."><span aria-hidden="true"></span> Create Invoice</button>
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
            <div class="modal-body" >
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
    var quantity = parseFloat(row.querySelector('[name="invoice_product_qty[]"]').value);
    var price = parseFloat(row.querySelector('[name="invoice_product_price[]"]').value);
    var discountInput = row.querySelector('[name="invoice_product_discount[]"]');
    
    var discount = discountInput.value;
    var isPercent = discount.includes('%');

    // Calculate the original subtotal (before applying the discount)
    var originalSubtotal = quantity * price;

    if (isPercent) {
        // If discount is a percentage, apply the percentage discount
        var percent = parseFloat(discount.replace('%', ''));
        if (!isNaN(percent) && percent !== 0) {
            originalSubtotal -= (percent / 100) * originalSubtotal;
        } else {
            discountInput.value = ''; // Clear the discount input if it's not valid
        }
    } else {
        // If discount is not in percentage form, apply it as a fixed amount
        var fixedDiscount = parseFloat(discount);
        if (!isNaN(fixedDiscount)) {
            originalSubtotal -= fixedDiscount;
        } else {
            discountInput.value = ''; // Clear the discount input if it's not valid
        }

        // Update the discount in the invoice
        var discountValue = parseFloat(document.querySelector('[name="invoice_discount"]').value);
        discountValue = isNaN(discountValue) ? 0 : discountValue;
        discountValue += (originalSubtotal - quantity * price); // Adjust discount based on the change in subtotal
        document.querySelector('.invoice-discount').innerText = discountValue.toFixed(2);
        document.querySelector('[name="invoice_discount"]').value = discountValue.toFixed(2);
    }

    // Update the subtotal display
    row.querySelector('.calculate-sub').value = originalSubtotal.toFixed(2);

    // Calculate the grand total when a product's subtotal changes
    calculateTotal();
}


    // Calculate the total of all products in the invoice
    function calculateTotal() {
        var grandTotal = 0;
        var disc = 0;

        $('#invoice_table tbody tr').each(function() {
            var c_sbt = $('.calculate-sub', this).val();
            var quantity = $('[name="invoice_product_qty[]"]', this).val();
            var price = $('[name="invoice_product_price[]"]', this).val() || 0;
            var subtotal = parseInt(quantity) * parseFloat(price);

            c_sbt = parseInt(quantity) * parseFloat(price);
            grandTotal += parseFloat(c_sbt);
            disc += subtotal - parseFloat(c_sbt);
        });

        // VAT, DISCOUNT, SHIPPING, TOTAL, SUBTOTAL:
        var subT = parseFloat(grandTotal);
        var finalTotal = parseFloat(grandTotal);
        var vat = parseInt($('.invoice-vat').attr('data-vat-rate'));

        // Update sub total
        $('.invoice-sub-total').text(subT.toFixed(2));
        $('#invoice_subtotal').val(subT.toFixed(2));

        // Update discount
        $('.invoice-discount').text(disc.toFixed(2));
        $('#invoice_discount').val(disc.toFixed(2));

        if ($('.invoice-vat').attr('data-enable-vat') === '1') {
            if ($('.invoice-vat').attr('data-vat-method') === '1') {
                var vatAmount = (vat / 100) * finalTotal;
                $('.invoice-vat').text(vatAmount.toFixed(2));
                $('#invoice_vat').val(vatAmount.toFixed(2));
            } else {
                var vatAmount = (vat / 100) * finalTotal;
                var totalWithVat = finalTotal + vatAmount;
                $('.invoice-vat').text(vatAmount.toFixed(2));
                $('#invoice_vat').val(vatAmount.toFixed(2));
                $('.invoice-total').text(totalWithVat.toFixed(2));
                $('#invoice_total').val(totalWithVat.toFixed(2));
            }
        } else {
            $('.invoice-total').text(finalTotal.toFixed(2));
            $('#invoice_total').val(finalTotal.toFixed(2));
        }

        // Remove VAT if necessary
        if ($('input.remove_vat').is(':checked')) {
            $('.invoice-vat').text("0.00");
            $('#invoice_vat').val("0.00");
            $('.invoice-total').text(finalTotal.toFixed(2));
            $('#invoice_total').val(finalTotal.toFixed(2));
        }
    }

    // Add event listeners to all input elements in the table
    var rows = document.querySelectorAll('#invoice_table tbody tr');
    rows.forEach(function(row) {
        var inputs = row.querySelectorAll('input');
        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                updateTotals(row);
            });
        });
    });
    
    // Add an input event listener for discount inputs
    var discountInputs = document.querySelectorAll('[name="invoice_product_discount[]"]');
    discountInputs.forEach(function(discountInput) {
        discountInput.addEventListener('input', function() {
            updateTotals(discountInput.closest('tr'));
        });
    });
</script>

<script>
function calculateTotal() {
            var grandTotal = 0;
            var discountTotal = 0;

            var rows = document.querySelectorAll('#invoice_table tbody tr');
            var vatRate = parseFloat(document.querySelector('.invoice-vat').getAttribute('data-vat-rate'));
            var vatEnabled = document.querySelector('.invoice-vat').getAttribute('data-enable-vat') === '1';
            var vatMethod = document.querySelector('.invoice-vat').getAttribute('data-vat-method');
            var vatAmount = 0;

            rows.forEach(function(row) {
                var quantity = parseInt(row.querySelector('[name="invoice_product_qty[]"]').value);
                var price = parseFloat(row.querySelector('[name="invoice_product_price[]"]').value) || 0;
                var discountInput = row.querySelector('[name="invoice_product_discount[]"]');
                var discountValue = discountInput.value;
                var isPercent = discountValue.includes('%');
                var subtotal = quantity * price;

                if (isPercent) {
                    var discountPercent = parseFloat(discountValue.replace('%', ''));
                    if (!isNaN(discountPercent) && discountPercent > 0) {
                        subtotal -= (discountPercent / 100) * subtotal;
                        discountTotal += quantity * price - subtotal;
                    }
                } else {
                    var fixedDiscount = parseFloat(discountValue);
                    if (!isNaN(fixedDiscount) && fixedDiscount > 0) {
                        subtotal -= fixedDiscount;
                        discountTotal += fixedDiscount;
                    }
                }

                row.querySelector('.calculate-sub').value = subtotal.toFixed(2);
                grandTotal += subtotal;
                vatAmount = (vatRate / 100) * grandTotal;
            });

            var finalTotal = grandTotal + vatAmount;
            document.querySelector('.invoice-sub-total').textContent = grandTotal.toFixed(2);
            document.querySelector('#invoice_subtotal').value = grandTotal.toFixed(2);
            document.querySelector('.invoice-discount').textContent = discountTotal.toFixed(2);
            document.querySelector('#invoice_discount').value = discountTotal.toFixed(2);
            document.querySelector('.invoice-vat').textContent = vatAmount.toFixed(2);
            document.querySelector('#invoice_vat').value = vatAmount.toFixed(2);
            document.querySelector('.invoice-total').textContent = finalTotal.toFixed(2);
            document.querySelector('#invoice_total').value = finalTotal.toFixed(2);
        }
</script>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('customer-select')) {
        var customer_name = e.target.getAttribute('data-customer-name');
        var customer_email = e.target.getAttribute('data-customer-email');
        var customer_phone = e.target.getAttribute('data-customer-phone');
        var customer_address_1 = e.target.getAttribute('data-customer-address-1');
        var customer_town = e.target.getAttribute('data-customer-town');
        var customer_county = e.target.getAttribute('data-customer-county');
        
        document.getElementById('customer_name').value = customer_name;
        document.getElementById('customer_email').value = customer_email;
        document.getElementById('customer_phone').value = customer_phone;
        document.getElementById('customer_address_1').value = customer_address_1;
        document.getElementById('customer_town').value = customer_town;
        document.getElementById('customer_county').value = customer_county;
        
        var modal = document.getElementById('insert_customer');
        if (modal) {
            $('#insert_customer').modal('hide'); 
        }
      
    }  
});

// Assuming your dropdown has the ID "item-select"


// Add an event listener to the document and delegate it to elements with the "item-select" class
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('item-select')) {
        e.preventDefault();

        // Get the parent input group element
        var parentInputGroup = e.target.closest('.input-group');

        // Assuming the input elements are within the same input group
        var invoiceProductInput = document.getElementById('invoice_product'); // Using class selector
        var invoiceProductPriceInput =document.querySelector('.invoice_product_price'); // Using class selector

        console.log('invoiceProductInput:', invoiceProductInput);
        console.log('invoiceProductPriceInput:', invoiceProductPriceInput);

        // Open the modal (if not already open)
        var insertModal = document.getElementById('insert');
        var selectedButton = insertModal.querySelector('#selected');

        console.log('insertModal:', insertModal);
        console.log('selectedButton:', selectedButton);

        if (selectedButton) {
            selectedButton.addEventListener('click', function (e) {
                var itemSelect = insertModal.querySelector('.item-select'); // Correct ID for the dropdown
                var selectedItem = itemSelect.options[itemSelect.selectedIndex];
                var itemText = selectedItem.text;
                var itemValue = selectedItem.value;

                console.log('itemText:', itemText);
                console.log('itemValue:', itemValue);

                invoiceProductInput.value = itemText;
                invoiceProductPriceInput.value = itemValue;

               
                calculateTotal();
            });
        }
    }

    
    if (e.target.classList.contains('add-row')) {
        // Handle the addition of a new row here
        // You can clone the last row and clear input values as needed
        var lastRow = document.querySelector('#invoice_table tbody tr:last-child');
        var newRow = lastRow.cloneNode(true);
        // Clear input values in the new row if needed

        // Add the new row to the table
        document.querySelector('#invoice_table tbody').appendChild(newRow);
    }

    if (e.target.classList.contains('delete-row')) {
        // Handle row deletion here
        var row = e.target.closest('tr');
        if (row) {
            row.remove();
            calculateTotal();
        }
    }
});
</script>
</html>
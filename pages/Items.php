<?php
session_start();
// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
  header('Location: ../sign-in.php');
  exit();
} 

require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');
$itemDetailsSearchSql = 'SELECT * FROM item';
$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
$itemDetailsSearchStatement->execute();



require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');

$initialStock = 0;
$message = ''; // Initialize the message variable

if (isset($_POST['additem'])) {
  $itemNumber = htmlentities($_POST['itemDetailsItemNumber']);
  $itemName = htmlentities($_POST['itemDetailsItemName']);
  $discount = htmlentities($_POST['itemDetailsDiscount']);
  $quantity = htmlentities($_POST['itemDetailsTotalQuantity']);
  $unitPrice = htmlentities($_POST['itemDetailsUnitPrice']);
  $status = isset($_POST['itemDetailsStatus']) ? htmlentities($_POST['itemDetailsStatus']) : 'Active'; // Check if 'itemDetailsStatus' is set
  $description = htmlentities($_POST['itemDetailsDescription']);
  $message = ''; // Initialize the message variable

  // Check if mandatory fields are not empty
  if (!empty($itemNumber) && !empty($itemName) && isset($quantity) && isset($unitPrice)) {
      // Sanitize item number
      $itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

      // Validate item quantity. It has to be a number
      if (filter_var($quantity, FILTER_VALIDATE_INT) === 0 || filter_var($quantity, FILTER_VALIDATE_INT)) {
          // Valid quantity
      } else {
          // Quantity is not a valid number
          $message = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Please enter a valid number for quantity</div>';
      }

      // Validate unit price. It has to be a number or floating point value
      if (filter_var($unitPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($unitPrice, FILTER_VALIDATE_FLOAT)) {
          // Valid float (unit price)
      } else {
          // Unit price is not a valid number
          $message = '<div class="alert alert-danger">Please enter a valid number for unit price</div>';
      }

      // Validate discount only if it's provided
      if (!empty($discount)) {
          if (filter_var($discount, FILTER_VALIDATE_FLOAT) === false) {
              // Discount is not a valid floating point number
              $message = '<div class="alert alert-danger">Please enter a valid discount amount</div>';
          }
      }

      // Check if the item already exists based on itemNumber
      $checkItemSql = 'SELECT itemNumber FROM item WHERE itemNumber = :itemNumber';
      $checkItemStatement = $conn->prepare($checkItemSql);
      $checkItemStatement->execute(['itemNumber' => $itemNumber]);

      if ($checkItemStatement->rowCount() > 0) {
          $message = '<div class="alert alert-danger">Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
      } else {

          $insertItemSql = 'INSERT INTO item(itemNumber, itemName, discount, stock, unitPrice, status, description) VALUES(:itemNumber, :itemName, :discount, :stock, :unitPrice, :status, :description)';
          $insertItemStatement = $conn->prepare($insertItemSql);
          $insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'discount' => $discount, 'stock' => $quantity, 'unitPrice' => $unitPrice, 'status' => $status, 'description' => $description]);
          $message = '<div class="alert alert-success">Item added to the database.</div>';
      }
  } else {
      // One or more mandatory fields are empty. Therefore, set the error message
      $message = '<div class="alert alert-danger">Please enter all fields marked with a (*)</div>';
  }
}



$SucessMessage = ''; // Initialize a variable to store the response SucessMessage

// Check if the POST query is received
if (isset($_POST['updateitem'])) {
    try {
        $itemDetailsItemNumber = htmlentities($_POST['itemDetailsItemNumber']);
        $itemDetailsItemName = htmlentities($_POST['itemDetailsItemName']);
        $itemDetailsStatus = htmlentities($_POST['itemDetailsStatus']);
        $itemDetailsDescription = htmlentities($_POST['itemDetailsDescription']);
        $itemDetailsDiscount = htmlentities($_POST['itemDetailsDiscount']);
        $itemDetailsUnitPrice = htmlentities($_POST['itemDetailsUnitPrice']);
        $itemDetailsTotalStock = htmlentities($_POST['itemDetailsTotalStock']);

        // Check if mandatory fields are not empty
        if (isset($itemDetailsItemNumber) && isset($itemDetailsItemName) && isset($itemDetailsUnitPrice)) {
            if (empty($itemDetailsItemNumber)) {
                $SucessMessage = '<div class="alert alert-danger">Please enter the Item Number to update the item.</div>';
            } else {
                // Check if the given item number exists in the database
                $itemNumberSelectSql = 'SELECT itemNumber FROM item WHERE itemNumber = :itemDetailsItemNumber';
                $itemNumberSelectStatement = $conn->prepare($itemNumberSelectSql);
                $itemNumberSelectStatement->execute(['itemDetailsItemNumber' => $itemDetailsItemNumber]);

                if ($itemNumberSelectStatement->rowCount() > 0) {
                    // Item number exists in the database, proceed with the update
                    // Construct the UPDATE query
                    $updateItemDetailsSql = 'UPDATE item SET itemNumber = :itemNumber, itemName = :itemName, status = :status, description = :description, discount = :discount, unitPrice = :unitPrice, stock = :stock WHERE itemNumber = :itemNumber';
                    $updateItemDetailsStatement = $conn->prepare($updateItemDetailsSql);
                    $updateItemDetailsStatement->execute([
                        'itemNumber' => $itemDetailsItemNumber,
                        'itemName' => $itemDetailsItemName,
                        'status' => $itemDetailsStatus,
                        'description' => $itemDetailsDescription,
                        'discount' => $itemDetailsDiscount,
                        'unitPrice' => $itemDetailsUnitPrice,
                        'stock' => $itemDetailsTotalStock,
                    ]);

                    $SucessMessage = '<div class="alert alert-success">Item details updated.</div>';
                } else {
                    // Item number does not exist in the database, stop the update
                    $SucessMessage = '<div class="alert alert-danger">Item Number does not exist in the database. Update not possible.</div>';
                }
            }
        } else {
            // One or more mandatory fields are empty, display an error SucessMessage
            $SucessMessage = '<div class="alert alert-danger">Please fill in all required fields.</div>';
        }
    } catch (Exception $e) {
        $SucessMessage = '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }

    // Send the response message back to the client

}


$deleteMessage=''; // Initialize the delete message variable
if (isset($_POST['deleteitem'])) {
    $itemNumber = htmlentities($_POST['itemDetailsItemNumber']);

    // Check if mandatory fields are not empty
    if (!empty($itemNumber)) {
        // Sanitize item number
        $itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

        // Check if the item exists in the database
        $itemSql = 'SELECT itemNumber FROM item WHERE itemNumber = :itemNumber';
        $itemStatement = $conn->prepare($itemSql);
        $itemStatement->execute(['itemNumber' => $itemNumber]);

        if ($itemStatement->rowCount() > 0) {
            // Item exists in the DB, so start the DELETE process
            $deleteItemSql = 'DELETE FROM item WHERE itemNumber = :itemNumber';
            $deleteItemStatement = $conn->prepare($deleteItemSql);
            $deleteItemStatement->execute(['itemNumber' => $itemNumber]);

            // Set the delete message
            $deleteMessage = '<div class="alert alert-success">Item deleted.</div>';
        } else {
            // Item does not exist, set the error message
            $deleteMessage = '<div class="alert alert-danger">Item does not exist in the DB. Therefore, can\'t delete.</div>';
        }
    } else {
        // Item number is empty, set the error message
        $deleteMessage = '<div class="alert alert-danger">Please enter the Item Number</div>';
    }
}
?>


<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/CCTWhiteLOGO.png" />
  <title>WDI TEAM 1</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
  table {
    table-layout: auto;
    /* Let the table adapt to content */
    width: 100%;
    /* Set a maximum width for the table */
  }

  td.description {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
    height: max-content;

  }
</style>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300  position-absolute w-100 " style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0">
        <img src="../assets/img/CCTlogo.png" class="navbar-brand-img h-100 w-20" />
        <span class="ms-1 font-weight-bold">CCT@TEAM 1</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../index.php">
            <div class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="../pages/Items.php">
            <div class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-Item-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Item</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../model/invoice/invoice-creation.php">
            <div class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-credit-card text-success text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Invoices</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./Invoices.php">
            <div class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-app text-info text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Manage Invoices</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="customer.php">
            <div class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Customer</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../model/login/logout.php">
            <div class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-fat-delete text-danger text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>

      </ul>
    </div>

  </aside>
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-white" href="javascript:;">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
              Tables
            </li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Tables</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-tables-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search text-lg" aria-hidden="true"></i></span>
              <input type="text" class="form-control searchBox" placeholder="Type here..." />
            </div>
          </div>

        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <div class="modal fade" id="itemDetailsModal" tabindex="-1" role="dialog" aria-labelledby="itemDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="itemDetailsModalLabel">Item Details Form</h5>
            <button type="button" class="btn btn-secondary" style="justify-content:flex-end;" data-dismiss="modal">Close</button>
          
          </div>
         

          <div class="modal-body">
            <div class="tab-content">
              <div id="itemDetailsTab" class="container tab-pane active">
                <br>
                <div id="itemDetailsMessage"></div>
                <form method="POST" onsubmit="return validateForm();">
                  <div class="row" style="justify-content:space-between;">
                    <div class="col-md-6">
                      <label for="itemDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
                      <input type="text" class="form-control required" name="itemDetailsItemNumber" id="itemDetailsItemNumber" autocomplete="off">
                      <div id="itemDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
                    </div>
                    <div class="col-lg-5">
                      <label for="itemDetailsProductID">Product ID</label>
                      <input class="form-control invTooltip " type="number" readonly id="itemDetailsProductID" name="itemDetailsProductID" title="This will be auto-generated when you add a new item">
                    </div>
                  </div>
                  <div class="row" style="justify-content:space-between;">
                    <div class="col-md-6">
                      <label for="itemDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
                      <input type="text" class="form-control required" name="itemDetailsItemName" id="itemDetailsItemName" autocomplete="off">
                      <div id="itemDetailsItemNameSuggestionsDiv " class="customListDivWidth"></div>
                    </div>
                    <div class="col-md-5">
                      <label for="itemDetailsStatus">Status</label>
                      <select id="itemDetailsStatus" name="itemDetailsStatus" class="form-control chosenSelect">
                        <option value="Active" selected>Active</option>
                        <option value="Disabled">Disabled</option>
                      </select>
                    </div>
                  </div><br>
                  <div class="row">
                    <label for="itemDescription">Item Description</label>
                    <div class="col-md-12" style="display:inline-block">
                      <textarea rows="5" class="form-control required" placeholder="Description" name="itemDetailsDescription" id="itemDetailsDescription"></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label for="itemDetailsDiscount">Discount %</label>
                      <input type="text" class="form-control required" value="0" name="itemDetailsDiscount" id="itemDetailsDiscount">
                    </div>

                    <div class="col-md-3">
                      <label for="itemDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
                      <input type="text" class="form-control required" value="0" name="itemDetailsUnitPrice" id="itemDetailsUnitPrice">
                    </div>
                    <div class="col-md-3">
                      <label for="itemDetailsTotalStock">Total Stock</label>
                      <input type="number" class="form-control required" name="itemDetailsTotalStock" value="0" id="itemDetailsTotalStock">
                    </div>
                    <div class="col-md-3">
                      <label for="itemDetailsTotalQuantity"> Quantity</label>
                      <input type="number" class="form-control required" name="itemDetailsTotalQuantity" value="0" id="itemDetailsTotalQuantity">
                    </div>
                  </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="additem" name="additem" class="btn btn-success">Add Item</button>
            <button type="submit" id="updateitem" name="updateitem" class="btn btn-primary">Update</button>
            <button type="submit" id="deleteitem" name="deleteitem" class="btn btn-danger">Delete</button>
          </div>
          </form>
        </div>
      </div>
    </div>


    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 text-center  text-uppercase font-weight-bolder opacity-10 ">
              <h6 class="text-center">Items table</h6>
              <div id="successMessage">
                <?php echo $message; ?> <?php echo $SucessMessage; ?><?php echo $deleteMessage; ?> </div>
             
              <div id="pagination" class="text-center">
  <button id="prevBtn" class="btn btn-primary" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; "><i class="fa fa-angle-left"></i></button>
  <span id="paginationText" class="mx-2"></span>
  <button id="nextBtn" class="btn btn-primary" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; " ><i class="fa fa-angle-right"></i></button>

            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                    
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                  var successMessage = document.getElementById("successMessage");
                  if (successMessage) {
                    successMessage.addEventListener("click", function() {
                      successMessage.parentNode.removeChild(successMessage);  });}});</script>
               
    
                <div class="row mb-3" style="justify-content:space-between;">
              
                  <div class="col-md-2">
                    <div class="col-md-2">
                  
                      <button style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);" id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-info float-right btn-sm">Refresh</button>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <select class="form-select blur rounded font-weight-bolder " id="sortSelect" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; ">
                      <div style="color: black;">
                        <option value="0" style="color: black; font-weight:600;">Sort by Item Number (Ascending)</option>
                        <option value="1" style="color: black; font-weight:600;">Sort by Item Number (Descending)</option>
                        <option value="2" style="color: black; font-weight:600;">Sort by Stock (Ascending)</option>
                        <option value="3" style="color: black; font-weight:600;">Sort by Stock (Descending)</option>
                      </div>
                    </select>
                  </div>
                  <div class="col-md-3" style="margin-right:10px;">
                    <select class="form-select blur rounded font-weight-bolder" id="statusSelect" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; ">
                      <option value="" style="color: black; font-weight:600;">Show All Status</option>
                      <option value="Active" style="color: black; font-weight:600;">Active</option>
                      <option value="Disabled" style="color: black; font-weight:600;">Disabled</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn " data-toggle="modal" data-target="#itemDetailsModal" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; ">
                      Add Items
                    </button>
                  </div>
                </div>

                <table class="table-responsive table align-tables-center mb-0" id="itemDetailsTable">
                  <thead>
                    <tr>

                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        ItemNumber
                      </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Name
                      </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                        Discount
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Stock
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Unit-Price
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Status
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Description
                      </th>

                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
                      echo '<tr>' .
                        '<td>
                          <div
                            class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm text-center text-secondary">' . $row['itemNumber'] . '</h6>
                            
                          </div>
                        </div>
                      </td>' .
                        '<td>
                        <p class="text-sm font-weight-bold mb-0 text-left"><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0 text-center text-secondary">' . $row['discount'] . '</p>
                       
                      </td>' .
                        '<td class="align-middle text-center text-secondary">
                        <span class="text-secondary text-sm font-weight-bold"
                          >' . $row['stock'] . '</span
                        ></td>' .
                        '<td class="align-middle text-center text-secondary">
                        <span class="text-secondary text-sm font-weight-bold"
                          >' . $row['unitPrice'] . '</span
                        ></td>' .
                        '<td class="align-middle text-center text-sm text-secondary">';

                      if ($row['status'] == 'Disabled') {
                        echo '<span class="badge badge-sm bg-gradient-danger">' . $row['status'] . '</span>';
                      } else {
                        echo '<span class="badge badge-sm bg-gradient-success">' . $row['status'] . '</span>';
                      }

                      echo '</td>'
                        .
                        '<td class="text-sm description">
                        <span class="text-secondary text-xs font-weight-bold  "
                          >' . $row['description'] . '</span
                        ></td>' .

                        '</tr>';
                    } ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr class="horizontal dark my-1" />
    <div class="card-body pt-sm-3 pt-0 overflow-auto">
    </div>
    </div>
    </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../js/scripts.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var tableRows = Array.from(document.querySelectorAll('#itemDetailsTable tbody tr'));
        var itemsPerPage = 11;
        var currentPage = 1;

        function showPage(page) {
          var startIdx = (page - 1) * itemsPerPage;
          var endIdx = startIdx + itemsPerPage;
          tableRows.forEach(function(row, idx) {
            if (idx >= startIdx && idx < endIdx) {
              row.style.display = 'table-row';
            } else {
              row.style.display = 'none';
            }
          });

          updatePaginationText();
        }

        function updatePaginationText() {
          var totalItems = tableRows.length;
          var totalPages = Math.ceil(totalItems / itemsPerPage);
          var startItem = (currentPage - 1) * itemsPerPage + 1;
          var endItem = Math.min(currentPage * itemsPerPage, totalItems);
          var paginationText = document.getElementById('paginationText');
          paginationText.textContent = startItem + ' to ' + endItem + ' of ' + totalItems + ' total entries';
        }

        function prevPage() {
          if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
          }
        }

        function nextPage() {
          var totalItems = tableRows.length;
          var totalPages = Math.ceil(totalItems / itemsPerPage);
          if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
          }
        }

        showPage(currentPage);

        document.getElementById('prevBtn').addEventListener('click', prevPage);
        document.getElementById('nextBtn').addEventListener('click', nextPage);
      });
      document.addEventListener('DOMContentLoaded', function() {
        var tableBody = document.querySelector('#itemDetailsTable tbody');
        var rows = Array.from(tableBody.querySelectorAll('tr'));

        function sortTable(column, order) {
          rows.sort(function(a, b) {
            var valueA = a.querySelector('td:nth-child(' + (column + 1) + ')').textContent.trim();
            var valueB = b.querySelector('td:nth-child(' + (column + 1) + ')').textContent.trim();
            if (column === 0) {
              // If sorting by the first column (Item Number)
              return (order === 'asc') ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
            } else {
              // For other columns, use numeric comparison
              return (order === 'asc') ? (parseFloat(valueA) - parseFloat(valueB)) : (parseFloat(valueB) - parseFloat(valueA));
            }
          });

          rows.forEach(function(row) {
            tableBody.appendChild(row);
          });
        }

        function filterTable(status) {
          rows.forEach(function(row) {
            var rowStatus = row.querySelector('td:nth-child(6)').textContent.trim(); // Assuming status is in the 6th column
            if (status === '' || status === rowStatus) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });
        }

        var sortSelect = document.getElementById('sortSelect');
        var statusSelect = document.getElementById('statusSelect');

        sortSelect.addEventListener('change', function() {
          var sortValue = sortSelect.value;
          if (sortValue === '0') {
            sortTable(0, 'asc'); // Sort by Item Number (Ascending)
          } else if (sortValue === '1') {
            sortTable(0, 'desc'); // Sort by Item Number (Descending)
          } else if (sortValue === '2') {
            sortTable(3, 'asc'); // Sort by Stock (Ascending)
          } else if (sortValue === '3') {
            sortTable(3, 'desc');
          }
        });

        statusSelect.addEventListener('change', function() {
          var statusValue = statusSelect.value;
          filterTable(statusValue);
        });
      });



      document.addEventListener('DOMContentLoaded', function() {
        // Function to handle search by name
        function searchByName() {
          var searchTerm = document.querySelector('.searchBox').value.toUpperCase();
          var tableRows = document.querySelectorAll('#itemDetailsTable tbody tr');

          tableRows.forEach(function(row) {
            var name = row.children[1].textContent.toUpperCase(); // Adjust the index if needed
            if (name.includes(searchTerm)) {
              row.style.display = ''; // Show the row
            } else {
              row.style.display = 'none'; // Hide the row
            }
          });
        }

        // Attach the searchByName function to the input's input event
        var searchInput = document.querySelector('.searchBox');
        searchInput.addEventListener('input', searchByName);
      });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>
<script>
  // Add an event listener to the button with the id "searchTablesRefresh"
  document.getElementById("searchTablesRefresh").addEventListener("click", function() {
    location.reload(); // This will refresh the page
  });
  function validateForm() {
    // Initialize an error counter
    var errorCounter = 0;

    // Iterate over all elements with the "required" class
    $(".required").each(function() {
        // Check if the input is empty
        if ($(this).val() === '') {
            $(this).addClass("is-invalid"); // Add a class to highlight the field
            errorCounter++;
        } else {
            $(this).removeClass("is-invalid"); // Remove the error class if the field is filled
        }
    });

    // Return true if there are no errors, otherwise return false
    if (errorCounter === 0) {
        return true; // Form will submit
        console.log("Form submission will be prevented");
    } else {
        return false; // Form submission will be prevented
    }
}
</script>
<script>document.addEventListener("DOMContentLoaded", function() {
    const itemNumberInput = document.getElementById("itemDetailsItemNumber");
    const productIDInput = document.getElementById("itemDetailsProductID");
    const itemNameInput = document.getElementById("itemDetailsItemName");
    const statusInput = document.getElementById("itemDetailsStatus");
    const descriptionInput = document.getElementById("itemDetailsDescription");
    const discountInput = document.getElementById("itemDetailsDiscount");
    const unitPriceInput = document.getElementById("itemDetailsUnitPrice");
    const totalStockInput = document.getElementById("itemDetailsTotalStock");
 

    // Add an input event listener to the item number input
    itemNumberInput.addEventListener("input", function() {
        const itemNumber = itemNumberInput.value;
        if (itemNumber) {
            fetchItemDetails(itemNumber);
        } else {
            // Clear the other input fields when item number is empty
            productIDInput.value = "";
            itemNameInput.value = "";
            statusInput.value = "";
            descriptionInput.value = "";
            discountInput.value = "";
            unitPriceInput.value = "";
            totalStockInput.value = "";

        }
    });

    function fetchItemDetails(itemNumber) {
        fetch("itemsPopulate.php", {
            method: "POST",
            body: new URLSearchParams({ itemDetailsItemNumber: itemNumber }), // Correct the parameter name
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.log(data.error);
            } else {
                populateForm(data);
            }
        })
        .catch(error => {
            console.log(error);
        });
    }

    function populateForm(itemDetails) {
        productIDInput.value = itemDetails.productID;
        itemNameInput.value = itemDetails.itemName;
        statusInput.value = itemDetails.status;
        descriptionInput.value = itemDetails.description;
        discountInput.value = itemDetails.discount;
        unitPriceInput.value = itemDetails.unitPrice;
        totalStockInput.value = itemDetails.stock;

    }
});
</script>



</html>
<?php
require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');

$customerDetailsSearchSql = 'SELECT * FROM customer';
$customerDetailsSearchStatement = $conn->prepare($customerDetailsSearchSql);
$customerDetailsSearchStatement->execute(); 

$AddMessage = '';

if (isset($_POST['addCustomer'])) {
    $customerNo = htmlentities($_POST['customerDetailsCustomerNumber']);
    $fullName = htmlentities($_POST['customerDetailsCustomerFullName']);
    $email = htmlentities($_POST['customerDetailsCustomerEmail']);
    $mobile = htmlentities($_POST['customerDetailsCustomerMobile']);
    $address = htmlentities($_POST['customerDetailsCustomerAddress']);
    $city = htmlentities($_POST['customerDetailsCustomerCity']);
    $district = htmlentities($_POST['customerDetailsCustomerDistrict']);
    $status = htmlentities($_POST['customerDetailsStatus']);

    // Check if the customer with the same customer number or full name already exists
    $checkCustomerSql = 'SELECT customerNo, fullName FROM customer WHERE customerNo = :customerNo OR fullName = :fullName';
    $checkCustomerStatement = $conn->prepare($checkCustomerSql);
    $checkCustomerStatement->execute(['customerNo' => $customerNo, 'fullName' => $fullName]);

    if ($checkCustomerStatement->rowCount() > 0) {
        $AddMessage = '<div class="alert alert-danger">Customer with the same customer number or full name already exists. Please provide a unique customer number or full name.</div>';
    } else {
        // Validation checks passed, proceed with insertion
        $insertCustomerSql = 'INSERT INTO customer (customerNo, fullName, email, mobile, address, city, district, status) VALUES (:customerNo, :fullName, :email, :mobile, :address, :city, :district, :status)';
        $insertCustomerStatement = $conn->prepare($insertCustomerSql);
        $insertCustomerStatement->execute([
            'customerNo' => $customerNo,
            'fullName' => $fullName,
            'email' => $email,
            'mobile' => $mobile,
            'address' => $address,
            'city' => $city,
            'district' => $district,
            'status' => $status,
        ]);

        if ($insertCustomerStatement->rowCount() > 0) {
            $AddMessage = '<div class="alert alert-success">Customer added to the database.</div>';
        } else {
            $AddMessage = '<div class="alert alert-danger">Failed to add the customer. Please try again.</div>';
        }
    }
}


$message = ''; 
if (isset($_POST['updatecustomer'])) {
  $customerDetailsCustomerNumber = htmlentities($_POST['customerDetailsCustomerNumber']);
  $customerDetailsCustomerFullName = htmlentities($_POST['customerDetailsCustomerFullName']);
  $customerDetailsCustomerMobile = htmlentities($_POST['customerDetailsCustomerMobile']);

  $customerDetailsCustomerEmail = htmlentities($_POST['customerDetailsCustomerEmail']);
  $customerDetailsCustomerAddress = htmlentities($_POST['customerDetailsCustomerAddress']);

  $customerDetailsCustomerCity = htmlentities($_POST['customerDetailsCustomerCity']);
  $customerDetailsCustomerDistrict = htmlentities($_POST['customerDetailsCustomerDistrict']);
  $customerDetailsStatus = htmlentities($_POST['customerDetailsStatus']);

  if (
    isset($customerDetailsCustomerFullName) &&
    isset($customerDetailsCustomerMobile) &&
    isset($customerDetailsCustomerAddress)
  ) {
    // Validate mobile number
    if (filter_var($customerDetailsCustomerMobile, FILTER_VALIDATE_INT) === 0 || filter_var($customerDetailsCustomerMobile, FILTER_VALIDATE_INT)) {
      // Mobile number is valid
    } else {
      // Mobile number is not valid
      $message = '<div class="alert alert-danger">Please enter a valid mobile number</div>';
    }

    // Check if the given customer number is in the DB
    $customerNumberSelectSql = 'SELECT customerNo FROM customer WHERE customerNo = :customerNo';
    $customerNumberSelectStatement = $conn->prepare($customerNumberSelectSql);
    $customerNumberSelectStatement->execute(['customerNo' => $customerDetailsCustomerNumber]);

    if ($customerNumberSelectStatement->rowCount() > 0) {
      // Customer number is available in DB. Therefore, we can go ahead and UPDATE its details
      // Construct the UPDATE query
      $updateCustomerDetailsSql = 'UPDATE customer SET fullName = :fullName, email = :email, mobile = :mobile, address = :address, city = :city, district = :district, status = :status WHERE customerNo = :customerNo';
      $updateCustomerDetailsStatement = $conn->prepare($updateCustomerDetailsSql);
      $updateCustomerDetailsStatement->execute([
        'fullName' => $customerDetailsCustomerFullName,
        'email' => $customerDetailsCustomerEmail,
        'mobile' => $customerDetailsCustomerMobile,
        'address' => $customerDetailsCustomerAddress,
        'city' => $customerDetailsCustomerCity,
        'district' => $customerDetailsCustomerDistrict,
        'status' => $customerDetailsStatus,
        'customerNo' => $customerDetailsCustomerNumber
      ]);
      $message = '<div class="alert alert-success">Customer details updated.</div>';
    } else {
      // Customer number is not in DB. Therefore, stop the update and quit
      $message = '<div class="alert alert-danger">Customer number does not exist in DB. Therefore, update not possible.</div>';
    }
  } else {
    // One or more mandatory fields are empty. Therefore, set an error message
    $message = '<div class="alert alert-danger">Please enter all required fields.</div>';
  }
}


$deleteMessage = ''; // Initialize the delete message variable
if (isset($_POST['deleteCustomer'])) {
    $customerDetailsCustomerNumber = htmlentities($_POST['customerDetailsCustomerNumber']);

    // Check if mandatory fields are not empty
    if (!empty($customerDetailsCustomerNumber)) {
        // Sanitize customer number
        $customerDetailsCustomerNumber = filter_var($customerDetailsCustomerNumber, FILTER_SANITIZE_STRING);

        // Check if the customer exists in the database
        $customerSql = 'SELECT customerNo FROM customer WHERE customerNo = :customerNo';
        $customerStatement = $conn->prepare($customerSql);
        $customerStatement->execute(['customerNo' => $customerDetailsCustomerNumber]);

        if ($customerStatement->rowCount() > 0) {
            // Customer exists in the DB, so start the DELETE process
            $deleteCustomerSql = 'DELETE FROM customer WHERE customerNo = :customerNo';
            $deleteCustomerStatement = $conn->prepare($deleteCustomerSql);
            $deleteCustomerStatement->execute(['customerNo' => $customerDetailsCustomerNumber]);

            // Set the delete message
            $deleteMessage = '<div class="alert alert-success">Customer deleted.</div>';
        } 
    } else {
        // Customer number is empty, set the error message
        $deleteMessage = '<div class="alert alert-success">Please enter the Customer Number</div>';
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
    /* Prevent line breaks within the cell */
    overflow: hidden;
    /* Hide overflow text */
    text-overflow: ellipsis;
    /* Add ellipsis (...) to indicate text overflow */
    max-width: 200px;
    height: max-content;
    /* Adjust the maximum width as needed */
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
          <a class="nav-link " href="../pages/Items.php">
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
          <a class="nav-link active" href="customer.php">
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
              Customer
            </li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Customer</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-tables-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control searchBox" id="searchBox" placeholder="Type here..." />
            </div>
          </div>

        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 text-center text-uppercase font-weight-bolder opacity-10">
              <h3>Customers table</h3>
              <div id="successMessage"><?php echo $message; ?> <?php echo $AddMessage; ?><?php echo $deleteMessage; ?></div>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  var successMessage = document.getElementById("successMessage");
                  if (successMessage) {
                    successMessage.addEventListener("click", function() {
                      successMessage.parentNode.removeChild(successMessage);  });}});</script>
              <div id="pagination" class="text-center">
                <button id="prevBtn" class="btn btn-primary" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; "><i class="fa fa-angle-left"></i></button>
                <span id="paginationText" class="mx-2"></span>
                <button id="nextBtn" class="btn btn-primary" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; "><i class="fa fa-angle-right"></i></button>
              </div>

              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content rounded">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>

                    </div>
                    <div class="modal-body">
                      <form method="POST" onsubmit="return validateForm();">
                        <div class="row">
                          <div class=" col-md-3 mx-auto">
                            <label for="customerDetailsCustomerNumber">Cust No</label>
                            <input type="text" class="form-control required" id="customerDetailsCustomerNumber" name="customerDetailsCustomerNumber">
                          </div>
                          <div class=" col-md-6 mx-auto">
                            <label for="customerDetailsCustomerFullName">Full Name<span class="requiredIcon">*</span></label>
                            <input type="text" class="form-control required" id="customerDetailsCustomerFullName" name="customerDetailsCustomerFullName">
                          </div>
                          <div class=" col-md-3 mx-auto">
                            <label for="customerDetailsStatus">Status</label>
                            <select id="customerDetailsStatus" name="customerDetailsStatus" class="form-control chosenSelect">
                              <option value="active" selected>Active</option>
                              <option value="disabled">Disabled</option>
                            </select>
                          </div>

                        </div>
                        <div class="row">
                          <div class=" col-md-5 mx-auto">
                            <label for="customerDetailsCustomerMobile ">Mobile No <span class="requiredIcon">*</span></label>
                            <input type="text" class="form-control invTooltip required" id="customerDetailsCustomerMobile" name="customerDetailsCustomerMobile" title="Do not enter leading 0">
                          </div>

                          <div class=" col-md-5 mx-auto">
                            <label for="customerDetailsCustomerEmail">Email</label>
                            <input type="email" class="form-control required" id="customerDetailsCustomerEmail" name="customerDetailsCustomerEmail">
                          </div>

                          <div class=" col-md-2 mx-auto">
                            <label for="customerDetailsCustomerID">Cust ID</label>
                            <input type="text" class="form-control invTooltip" id="customerDetailsCustomerID" name="customerDetailsCustomerID" title="This will be auto-generated when you add a new customer" autocomplete="off" disabled>
                            <div id="customerDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
                          </div>

                        </div>
                        <div class="">
                          <label for="customerDetailsCustomerAddress">Address<span class="requiredIcon">*</span></label>
                          <textarea rows="3" class="form-control form-control-lg required" id="customerDetailsCustomerAddress" name="customerDetailsCustomerAddress"></textarea>
                        </div>

                        <div class="row">
                          <div class=" col-md-6">
                            <label for="customerDetailsCustomerCity">City</label>
                            <input type="text" class="form-control required" id="customerDetailsCustomerCity" name="customerDetailsCustomerCity">
                          </div>
                          <div class=" col-md-6">
                            <label for="customerDetailsCustomerDistrict">District</label>
                            <select id="customerDetailsCustomerDistrict" name="customerDetailsCustomerDistrict" class="form-control chosenSelect ">
                              <?php include('../inc/districtlist.html') ?>
                            </select>
                          </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="submit" id="addCustomer" name="addCustomer" class="btn btn-success">Add
                        Customer</button>
                      <button type="submit" id="updatecustomer" name="updatecustomer" class="btn btn-primary">Update</button>
                      <button type="submit" id="deleteCustomer" name="deleteCustomer" class="btn btn-danger">Delete</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-2">
                  <div class="row mb-3" style="justify-content:space-between;">
                    <div class="col-md-2">

                      <button style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);" id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-info float-right btn-sm">Refresh</button>
                    </div>
                    <script>
                      // Add an event listener to the button with the id "searchTablesRefresh"
                      document.getElementById("searchTablesRefresh").addEventListener("click", function() {
                        location.reload(); // This will refresh the page
                      });
                    </script>

                    <div class="col-md-3">
                      <select class="form-select blur rounded font-weight-bolder" id="sortSelect" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; ">
                        <option style="color: black; font-weight:600;" value="0">Sort by Customer No (Ascending)</option>
                        <option style="color: black; font-weight:600;" value="1">Sort by Customer No (Descending)</option>
                        <option style="color: black; font-weight:600;" value="2">Sort by City (Ascending)</option>
                        <option style="color: black; font-weight:600;" value="3">Sort by City (Descending)</option>
                        <option style="color: black; font-weight:600;" value="4">Sort by Name (Ascending)</option>
                        <option style="color: black; font-weight:600;" value="5">Sort by Name (Descending)</option>

                      </select>
                    </div>
                    <div class="col-md-3">
                      <select class="form-select blur rounded font-weight-bolder" id="statusSelect" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; ">
                        <option style="color: black; font-weight:600;" value="">Show All Status</option>
                        <option style="color: black; font-weight:600;" value="Active">Active</option>
                        <option style="color: black; font-weight:600;" value="Disabled">Disabled</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-primary text-sm btn-xs" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); justify-content:flex-start;" data-toggle="modal" data-target="#exampleModal">
                        Add Customer
                      </button>
                    </div>

                  </div>
                  <table class="table-responsive table align-tables-center mb-0" id="CustomerDetailsTable">
                    <thead>
                      <tr>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Customer No
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Full Name
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Email
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                          Mobile No
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Address
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          City
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Status
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          District
                        </th>

                        <th class="text-secondary opacity-7"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while ($row = $customerDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>' .
                          '<td>
                              <p class="text-xs font-weight-bold mb-0 text-center">' . $row['customerNo'] . '</p>
                            </td>' .
                          '<td>
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm text-center">' . $row['fullName'] . '</h6>
                              </div>
                            </td>' .
                          '<td>
                              <div class="d-flex flex-column  justify-content-center">
                                <h6 class="mb-0 text-sm text-center text-secondary">' . $row['email'] . '</h6>
                              </div>
                            </td>' .
                          '<td>
                              <p class="text-xs font-weight-bold mb-0 text-secondary text-center">' . $row['mobile'] . '</p>
                            </td>' .
                          '<td class="align-middle text-center">
                              <span class="text-secondary text-xs font-weight-bold">
                                ' . $row['address'] . '
                              </span>
                            </td>' .
                          '<td class="align-middle text-center">
                              <span class="text-secondary text-xs font-weight-bold">
                                ' . $row['city'] . '
                              </span>
                            </td>' .
                          '<td class="align-middle text-center text-sm">';

                        if ($row['status'] == 'Disabled') {
                          echo '<span class="badge badge-sm bg-gradient-danger">' . $row['status'] . '</span>';
                        } else {
                          echo '<span class="badge badge-sm bg-gradient-success">' . $row['status'] . '</span>';
                        }

                        echo '</td>' .
                          '<td class="text-sm description">
                              <span class="text-secondary text-xs font-weight-bold">
                                ' . $row['district'] . '
                              </span>
                            </td>' .
                          '</tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
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
        var tableRows = Array.from(document.querySelectorAll('#CustomerDetailsTable tbody tr'));
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
        } else {
          return false; // Form submission will be prevented
        }
      }
      document.addEventListener('DOMContentLoaded', function() {
        var tableBody = document.querySelector('#CustomerDetailsTable tbody');
        var rows = Array.from(tableBody.querySelectorAll('tr'));

        function sortTable(column, order) {
          rows.sort(function(a, b) {
            var valueA = a.children[column].textContent.trim();
            var valueB = b.children[column].textContent.trim();
            if (order === 'asc') {
              return valueA.localeCompare(valueB);
            } else {
              return valueB.localeCompare(valueA);
            }
          });

          rows.forEach(function(row) {
            tableBody.appendChild(row);
          });
        }

        function filterTable(status) {
          rows.forEach(function(row) {
            var rowStatus = row.children[6].textContent.trim(); // Assuming status is in the 7th column
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
            sortTable(0, 'asc'); // Sort by Customer No (Ascending)
          } else if (sortValue === '1') {
            sortTable(0, 'desc'); // Sort by Customer No (Descending)
          } else if (sortValue === '2') {
            sortTable(5, 'asc'); // Sort by City (Ascending)
          } else if (sortValue === '3') {
            sortTable(5, 'desc'); // Sort by City (Descending)
          } else if (sortValue === '4') {
            sortTable(1, 'asc'); // Sort by Name (Ascending)
          } else if (sortValue === '5') {
            sortTable(1, 'desc'); // Sort by Name (Descending)
          }
          // Add more sorting options as needed
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
          var tableRows = document.querySelectorAll('#customerDetailsTable tbody tr');

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
      document.addEventListener('DOMContentLoaded', function() {
        // Function to handle search by various attributes
        function searchByAttributes() {
          var searchTerm = document.querySelector('.searchBox').value.toUpperCase();
          var tableRows = document.querySelectorAll('#customerDetailsTable tbody tr');

          tableRows.forEach(function(row) {
            var fullName = row.children[1].textContent.toUpperCase(); // Full Name
            var email = row.children[2].textContent.toUpperCase(); // Email
            var mobile = row.children[3].textContent.toUpperCase(); // Mobile No
            var address = row.children[4].textContent.toUpperCase(); // Address
            var city = row.children[5].textContent.toUpperCase(); // City
            var status = row.children[6].textContent.toUpperCase(); // Status
            var district = row.children[7].textContent.toUpperCase(); // District

            if (
              fullName.includes(searchTerm) ||
              email.includes(searchTerm) ||
              mobile.includes(searchTerm) ||
              address.includes(searchTerm) ||
              city.includes(searchTerm) ||
              status.includes(searchTerm) ||
              district.includes(searchTerm)
            ) {
              row.style.display = ''; // Show the row
            } else {
              row.style.display = 'none'; // Hide the row
            }
          });
        }

        // Attach the searchByAttributes function to the input's input event
        var searchInput = document.querySelector('.searchBox');
        searchInput.addEventListener('input', searchByAttributes);
      });
    </script>

    <script>
      // Define your customer form elements
      const customerNumberInput = document.getElementById("customerDetailsCustomerNumber");
      const customerIDInput = document.getElementById("customerDetailsCustomerID");
      const customerFullNameInput = document.getElementById("customerDetailsCustomerFullName");
      const statusInput = document.getElementById("customerDetailsStatus");
      const customerMobileInput = document.getElementById("customerDetailsCustomerMobile");
      const customerEmailInput = document.getElementById("customerDetailsCustomerEmail");
      const customerAddressInput = document.getElementById("customerDetailsCustomerAddress");
      const customerCityInput = document.getElementById("customerDetailsCustomerCity");
      const customerDistrictInput = document.getElementById("customerDetailsCustomerDistrict");

      // Add an input event listener to the customer number input
      customerNumberInput.addEventListener("input", function() {
        const customerNumber = customerNumberInput.value;
        if (customerNumber) {
          fetchCustomerDetails(customerNumber);
        } else {
          // Clear the other input fields when customer number is empty
          customerIDInput.value = "";
          customerFullNameInput.value = "";
          statusInput.value = "";
          customerMobileInput.value = "";
          customerEmailInput.value = "";
          customerAddressInput.value = "";
          customerCityInput.value = "";
          customerDistrictInput.value = "";
        }
      });

      function fetchCustomerDetails(customerNumber) {
        fetch("customerPop.php", {
            method: "POST",
            body: new URLSearchParams({
              customerDetailsCustomerNumber: customerNumber
            }),
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          })
          .then(response => response.json())
          .then(data => {
            console.log(data);
            populateCustomerForm(data);
          })
          .catch(error => {
            console.log(error);
          });
      }

      function populateCustomerForm(customerDetails) {
        customerIDInput.value = customerDetails.customerID;
        customerFullNameInput.value = customerDetails.fullName;
        statusInput.value = customerDetails.status;
        customerMobileInput.value = customerDetails.mobile;
        customerEmailInput.value = customerDetails.email;
        customerAddressInput.value = customerDetails.address;
        customerCityInput.value = customerDetails.city;
        customerDistrictInput.value = customerDetails.district;
      }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
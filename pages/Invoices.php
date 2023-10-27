<?php
session_start();
// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
    header('Location: ../sign-in.php');
    exit();
}

require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');
$itemDetailsSearchSql = 'SELECT * FROM sale';
$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
$itemDetailsSearchStatement->execute();
$itemDetailsSearchStatement->setFetchMode(PDO::FETCH_ASSOC);
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
                    <a class="nav-link active" href="./Invoices.php">
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
                            Invoices
                        </li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Manage Invoices</h6>
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

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 text-center  text-uppercase font-weight-bolder opacity-10 ">
                            <h6 class="text-center">Invoices Table</h6>

                            <div id="pagination" class="text-center">
                                <button id="prevBtn" class="btn btn-primary" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; "><i class="fa fa-angle-left"></i></button>
                                <span id="paginationText" class="mx-2"></span>
                                <button id="nextBtn" class="btn btn-primary" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; "><i class="fa fa-angle-right"></i></button>

                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">


                                    <div class="row mb-3" style="justify-content:space-between;">

                                        <div class="col-md-2">
                                            <div class="col-md-2">

                                                <button style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);" id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-info float-right btn-sm">Refresh</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select blur rounded font-weight-bolder " id="sortSelect" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; ">
                                                <div style="color: black;">
                                                    <option value="0" style="color: black; font-weight:600;">Sort by Date (Ascending)</option>
                                                    <option value="1" style="color: black; font-weight:600;">Sort by Date (Descending)</option>
                                                    <option value="2" style="color: black; font-weight:600;">Sort by Customer (Ascending)</option>
                                                    <option value="3" style="color: black; font-weight:600;">Sort by Customer (Descending)</option>
                                                    <option value="4" style="color: black; font-weight:600;">Sort by Total (Ascending)</option>
                                                    <option value="5" style="color: black; font-weight:600;">Sort by Total (Descending)</option>
                                                </div>
                                            </select>
                                        </div>
                                        <div class="col-md-3" style="margin-right:10px;">
                                            <select class="form-select blur rounded font-weight-bolder" id="statusSelect" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; ">
                                                <option value="" style="color: black; font-weight:600;">Show All Status</option>
                                                <option value="open" style="color: black; font-weight:600;">Open</option>
                                                <option value="paid" style="color: black; font-weight:600;">Paid</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn " style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%); color:white; " href="../model/invoice/invoice-creation.php">
                                                Create Invoice
                                            </button>
                                        </div>
                                    </div>

                                    <table class="table-responsive table align-tables-center mb-0 text-center" id="itemDetailsTable">
                                        <thead>
                                            <tr>

                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Invoice Number
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Invoice Date
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Customer Name
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Customer Email
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Custome Mobile
                                                </th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Discount
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Total
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Invoice Status
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
                            <h6 class="mb-0 text-sm text-center text-secondary">#' . $row['invoiceNumber'] . '</h6>
                            
                          </div>
                        </div>
                      </td>' .
                                                    '<td>
                        <p class="text-sm font-weight-bold mb-0  text-center">' . $row['saleDate'] . '</p>
                      </td>
                      </td>' .
                                                    '<td>
                        <p class="text-sm font-weight-bold mb-0  text-center">' . $row['customerName'] . '</p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0 text-center text-secondary">' . $row['customerEmail'] . '</p>
                       
                      </td>' .
                                                    '<td class="align-middle text-center text-secondary">
                        <span class="text-secondary text-sm font-weight-bold"
                          >' . $row['customerMobile'] . '</span
                        ></td>' .
                                                    '<td class="align-middle text-center text-secondary">
                        <span class="text-secondary text-sm font-weight-bold"
                          >' . $row['discount'] . '</span
                        ></td>'
                                                    .
                                                    '<td class="text-sm description">
                        <span class="text-secondary text-xs font-weight-bold text-center  "
                          >' . $row['total'] . '</span
                        ></td>' .
                                                    '<td class="align-middle text-center text-sm text-secondary">';

                                                if ($row['invoiceType'] == 'open') {
                                                    echo '<span class="badge badge-sm bg-gradient-warning">' . $row['invoiceType'] . '</span>';
                                                } else {
                                                    echo '<span class="badge badge-sm bg-gradient-success">' . $row['invoiceType'] . '</span>';
                                                }

                                                echo '</td>' .

                                                    '<td class="text-md description"><a href="./invoicePrint.php?invoice_id=' . $row['saleID'] . '"><i class="fas fa-print"></i></a>' .
                                                    '<td class="text-md description"><a href="../model/invoice/invoice-edit.php?invoice_id=' . $row['saleID'] . '"><i class="fas fa-edit"></i></a></td>';

                                                '</td>';

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
                        if (column === 1) {
                            var dateA = new Date(valueA);
                            var dateB = new Date(valueB);
                            return (order === 'asc') ? dateA - dateB : dateB - dateA;
                        } else if (column === 2) {
                            // If sorting by the third column (Customer)
                            return (order === 'asc') ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
                        } else if (column === 4) {
                            // If sorting by the fifth column (Total)
                            return (order === 'asc') ? (parseFloat(valueA) - parseFloat(valueB)) : (parseFloat(valueB) - parseFloat(valueA));
                        }
                    });

                    rows.forEach(function(row) {
                        tableBody.appendChild(row);
                    });
                }


                function filterTable(status) {
                    rows.forEach(function(row) {
                        var rowStatus = row.querySelector('td:nth-child(8)').textContent.trim(); // Assuming status is in the 6th column
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
                        sortTable(1, 'asc'); // Sort by Date (Ascending)
                    } else if (sortValue === '1') {
                        sortTable(1, 'desc'); // Sort by Date (Descending)
                    } else if (sortValue === '2') {
                        sortTable(2, 'asc'); // Sort by Customer (Ascending)
                    } else if (sortValue === '3') {
                        sortTable(2, 'desc'); // Sort by Customer (Descending)
                    } else if (sortValue === '4') {
                        sortTable(4, 'asc'); // Sort by Total (Ascending)
                    } else if (sortValue === '5') {
                        sortTable(4, 'desc'); // Sort by Total (Descending)
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
                    body: new URLSearchParams({
                        itemDetailsItemNumber: itemNumber
                    }), // Correct the parameter name
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
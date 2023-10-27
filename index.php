<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
  header('Location: sign-in.php');
  exit();
}
?>
<?php
require_once('./inc/config/constants.php');
require_once('./inc/config/db.php');

$itemDetailsSearchSql = 'SELECT SUM(unitPrice) as totalProfit FROM item WHERE stock > 0';
$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
$itemDetailsSearchStatement->execute();
$totalProfit = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)['totalProfit'];

$activeCustomersSql = 'SELECT COUNT(*) as activeCustomers FROM customer WHERE status="Active"';
$activeCustomersStatement = $conn->prepare($activeCustomersSql);
$activeCustomersStatement->execute();
$activeCustomersCount = $activeCustomersStatement->fetch(PDO::FETCH_ASSOC)['activeCustomers'];

$DisabledCustomersSql = 'SELECT COUNT(*) as disabledCustomers FROM customer WHERE status="Disabled"';
$DisabledCustomersStatement = $conn->prepare($DisabledCustomersSql);
$DisabledCustomersStatement->execute();
$DisabledCustomersCount = $DisabledCustomersStatement->fetch(PDO::FETCH_ASSOC)['disabledCustomers'];


$saleTotalProfitSql = 'SELECT SUM(total) as TotalProfit FROM sale';
$saleTotalProfitStatement = $conn->prepare($saleTotalProfitSql);
$saleTotalProfitStatement->execute();
$saleTotalProfit = $saleTotalProfitStatement->fetch(PDO::FETCH_ASSOC)['TotalProfit'];

$saleTotalProductsSql = 'SELECT SUM(stock) as TotalProducts FROM item';
$saleTotalProductsStatement = $conn->prepare($saleTotalProductsSql);
$saleTotalProductsStatement->execute();
$saleTotalProducts = $saleTotalProductsStatement->fetch(PDO::FETCH_ASSOC)['TotalProducts'];

$purchaseTotalCostSql = 'SELECT SUM(price) as totalCost FROM line_items';
$purchaseTotalCostStatement = $conn->prepare($purchaseTotalCostSql);
$purchaseTotalCostStatement->execute();
$purchaseTotalCost = $purchaseTotalCostStatement->fetch(PDO::FETCH_ASSOC)['totalCost'];

$highestSalesQuery = "
  SELECT DAY(s.saleDate) AS day, SUM(li.quantity) AS totalSales
  FROM sale AS s
  JOIN line_items AS li ON s.saleID = li.invoice_id
  WHERE YEAR(s.saleDate) = 2023 AND MONTH(s.saleDate) = 10
  GROUP BY day
  ORDER BY totalSales DESC
  LIMIT 1";
$highestSalesStatement = $conn->prepare($highestSalesQuery);
$highestSalesStatement->execute();
$highestSalesData = $highestSalesStatement->fetch(PDO::FETCH_ASSOC);


?>




<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="icon" type="image/png" href="./assets/img/CCTWhiteLOGO.png" class="h-100 w-30" />
  <title>WDI AUG@2023</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300  position-absolute w-100" style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
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
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-world-2 text-primary text-md opacity-10 "></i>

            </div>
            <span class="nav-link-text ms-1 ">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./pages/Items.php">
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Item</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./model/invoice/invoice-creation.php">
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-credit-card text-success text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Invoice</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="pages/Invoices.php">
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-app text-info text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Manage Invoices</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./pages/customer.php">
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Customer</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="model/login/logout.php">
            <div class="icon icon-shape icon-md border-radius-md text-center mb-1 d-flex align-tables-center justify-content-center">
              <i class="ni ni-fat-delete text-danger text-md opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>

      </ul>
    </div>
  </aside>
  <!-- Sidebar Ends -->
  <main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-md-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-white" href="index.php">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">
              Dashboard
            </li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Welcome <?php echo $_SESSION['fullName'] ?> </h6>
        </nav>
        <div class="collapse navbar-collapse mt-md-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-6 d-flex align-tables-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here..." />
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 ">
          <div class="card">
            <div class="card-body p-3 rounded-3 bg-white shadow">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Total Sales </p>
                    <h5 class="font-weight-bolder">₹<?php echo number_format($saleTotalProfit, 2); ?></h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+55%</span>
                      since last week
                    </p>
                  </div>
                </div>
                <div class="col-2 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3 rounded-3 bg-white shadow">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Customers
                    </p>
                    <h5 class="font-weight-bolder"><?php echo $activeCustomersCount; ?>+</h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+3%</span>
                      since last week
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3 rounded-3 bg-white shadow">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Purchased
                    </p>
                    <h5 class="font-weight-bolder">+<?php echo number_format($purchaseTotalCost, 2); ?></h5>
                    <p class="mb-0">
                      <span class="text-danger text-sm font-weight-bolder">-2%</span>
                      since last quarter
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3 rounded-3 bg-white shadow">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
                      Total Products
                    </p>
                    <h5 class="font-weight-bolder"><?php echo number_format($saleTotalProducts);  ?>+ Products</h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+5%</span>
                      than last month
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Sales overview</h6>
              <?php
              if ($highestSalesData) {
                $highestSalesDay = $highestSalesData['day'];
              }
              ?>

              <p class="text-sm mb-0">
                <i class="fa fa-arrow-up text-success"></i>
                <span class="font-weight-bold"><?php echo date("F j, Y", strtotime("2023-10-$highestSalesDay")); ?></span>
              </p>

            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Best Selling Products</h6>
              </div>
            </div>
            <?php $recentProductsQuery = "WITH RankedSales AS (
    SELECT li.item_id, i.itemName,i.unitPrice, i.discount, SUM(li.quantity) AS total_quantity
    FROM line_items li
    JOIN item i ON li.item_id = i.productID
    GROUP BY li.item_id, i.itemName, i.discount,i.unitPrice
    ORDER BY total_quantity DESC
    LIMIT 6
)
SELECT itemName, discount,unitPrice, total_quantity
FROM RankedSales";
            $recentProductsStatement = $conn->prepare($recentProductsQuery);
            $recentProductsStatement->execute();
            $recentProductsData = $recentProductsStatement->fetchAll(PDO::FETCH_ASSOC); ?>
            <div class="table-responsive">
              <table class="table align-tables-center">
                <tbody>
                  <?php foreach ($recentProductsData as $product) : ?>
                    <tr>
                      <td class="w-30">
                        <div class="d-flex px-2 py-1 align-tables-center">
                          <div class="ms-4">
                            <p class="text-xs font-weight-bold mb-0">
                              Product name:
                            </p>
                            <h6 class="text-sm mb-0 text-center"><?php echo $product['itemName']; ?></h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <p class="text-xs font-weight-bold mb-0">Discount</p>
                          <h6 class="text-sm mb-0"><?php echo $product['discount']; ?>%</h6>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <p class="text-xs font-weight-bold mb-0">Value:</p>
                          <h6 class="text-sm mb-0">₹<?php echo number_format($product['unitPrice'], 2); ?></h6>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header pb-0 p-3 ">
              <h6 class="mb-0">Categories</h6>
            </div>
            <div class="card-body p-3">
              <ul class="list-group mb-4">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-tables-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-mobile-button text-white opacity-10 text-sm"></i>
                    </div>

                    <?php  // for stock
                    $categoriesQuerysql = 'Select SUM(stock) as total_stock from item ';
                    $stockDetails = $conn->prepare($categoriesQuerysql);
                    $stockDetails->execute();
                    $stockDetailsItem = $stockDetails->fetch(PDO::FETCH_ASSOC);

                    //for sold 
                    $SoldQuerysql = 'Select SUM(quantity) as total_sold from line_items ';
                    $SoldDetails = $conn->prepare($SoldQuerysql);
                    $SoldDetails->execute();
                    $SoldDetailsItem = $SoldDetails->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Merchandise</h6>
                      <span class="text-xs"><?php echo number_format($stockDetailsItem['total_stock']); ?> in Stock,
                        <span class="font-weight-bold"><?php echo number_format($SoldDetailsItem['total_sold']); ?> +sold</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-tables-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-tag text-white opacity-10 text-sm"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Customers</h6>
                      <span class="text-xs"><?php echo $activeCustomersCount; ?> active,
                        <span class="font-weight-bold"><?php echo $DisabledCustomersCount; ?> closed</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-tables-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-box-2 text-white opacity-10 text-sm"></i>
                    </div>
                    <?php
                    $activeVendorsSql = 'SELECT COUNT(*) as activeVendors FROM sale WHERE invoiceType="open"';
                    $activeVendorsStatement = $conn->prepare($activeVendorsSql);
                    $activeVendorsStatement->execute();
                    $activeVendorsCount = $activeVendorsStatement->fetch(PDO::FETCH_ASSOC)['activeVendors'];

                    $DisabledVendorsSql = 'SELECT COUNT(*) as disabledVendors FROM sale WHERE invoiceType="paid"';
                    $DisabledVendorsStatement = $conn->prepare($DisabledVendorsSql);
                    $DisabledVendorsStatement->execute();
                    $DisabledVendorsCount = $DisabledVendorsStatement->fetch(PDO::FETCH_ASSOC)['disabledVendors'];

                    $soldVendorsSql = 'SELECT SUM(quantity) as soldVendors FROM line_items';
                    $soldVendorsStatement = $conn->prepare($soldVendorsSql);
                    $soldVendorsStatement->execute();
                    $soldVendorsCount = $soldVendorsStatement->fetch(PDO::FETCH_ASSOC)['soldVendors']; ?>

                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Invoices</h6>
                      <span class="text-xs"><?php echo $activeVendorsCount; ?> open,
                        <span class="font-weight-bold"><?php echo $DisabledVendorsCount; ?> paid</span></span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                  <div class="d-flex align-tables-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                      <i class="ni ni-satisfied text-white opacity-10 text-sm"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <?php
                      $StockDetailssql = "SELECT SUM(stock) AS saleTotalProducts FROM item WHERE stock < 10 ORDER BY stock ASC LIMIT 3";
                      $StockDetailsCat = $conn->prepare($StockDetailssql);
                      $StockDetailsCat->execute();
                      $StockDetailsCategory = $StockDetailsCat->fetch(PDO::FETCH_ASSOC)['saleTotalProducts'];
                      ?>
                      <?php
                      $StockDetailssql = "SELECT SUM(stock) AS saleTotalProducts FROM item WHERE stock > 10 ORDER BY stock ASC LIMIT 3";
                      $StockDetailsCat = $conn->prepare($StockDetailssql);
                      $StockDetailsCat->execute();
                      $StockDetailsCate = $StockDetailsCat->fetch(PDO::FETCH_ASSOC)['saleTotalProducts'];
                      ?>

                      <h6 class="mb-1 text-dark text-sm">Stocks</h6>
                      <span class="text-xs font-weight-bold"> <?php echo  $StockDetailsCategory; ?> Low↓,
                        <span class="font-weight-bold"><?php echo $StockDetailsCate; ?> High↑</span></span>

                    </div>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                      <i class="ni ni-bold-right" aria-hidden="true"></i>
                    </button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-7 ">
          <div class="card h-100 ">
            <div class="card-header pb-0 ">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Stock's Availability</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                  <i class="far fa-calendar-alt me-2"></i>
                  <?php $StockQuerysql = "SELECT itemName, stock FROM item WHERE stock < 10 ORDER BY stock ASC LIMIT 3";
                  $StockDetails = $conn->prepare($StockQuerysql);
                  $StockDetails->execute();
                  $UpStockQuerysql = "SELECT itemName, stock FROM item WHERE stock > 20 ORDER BY stock ASC LIMIT 3";
                  $UpStockDetails = $conn->prepare($UpStockQuerysql);
                  $UpStockDetails->execute();
                  ?>
                </div>
              </div>
            </div>
            <div class="card-body  p-3">
              <ul class="list-group">
                <?php while ($StockDetailsItem = $StockDetails->fetch(PDO::FETCH_ASSOC)) { ?>
                  <li class="list-group-item border-0 d-flex justify-content-between ps-0  border-radius-lg">
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-down"></i></button>
                      <div class="d-flex flex-column">

                        <h6 class="mb-1 text-dark text-sm"><?php echo $StockDetailsItem['itemName']; ?></h6>
                        <span class="text-xs">stock need to be refilled</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                      -<?php echo $StockDetailsItem['stock']; ?>
                    </div>
                  </li>
                <?php }; ?>
                <?php while ($UpStockDetailsItem = $UpStockDetails->fetch(PDO::FETCH_ASSOC)) { ?>
                  <li class="list-group-item border-0 d-flex justify-content-between ps-0  border-radius-lg">

                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                      <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm"><?php echo $UpStockDetailsItem['itemName']; ?></h6>
                        <span class="text-xs">stock is upto date</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                      + <?php echo $UpStockDetailsItem['stock']; ?>
                    </div>
                  <?php }; ?>
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <?php

  $salesDayOfWeekQuery = "
SELECT DAYOFWEEK(s.saleDate) AS dayOfWeek, SUM(li.quantity) AS totalSales
FROM line_items li
JOIN sale s ON s.saleID=li.invoice_id
GROUP BY dayOfWeek";


  $salesDayOfWeekStatement = $conn->prepare($salesDayOfWeekQuery);
  $salesDayOfWeekStatement->execute();
  $salesData = $salesDayOfWeekStatement->fetchAll(PDO::FETCH_ASSOC);

  $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  $salesByDayOfWeek = array_fill(0, 7, 0);

  foreach ($salesData as $row) {
    $dayOfWeek = $row['dayOfWeek'] - 1;
    $salesByDayOfWeek[$dayOfWeek] = (float) $row['totalSales'];
  }

  ?>
  <script>
    var daysOfWeek = <?php echo json_encode($daysOfWeek); ?>;
    var salesData = <?php echo json_encode($salesByDayOfWeek); ?>;
  </script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, "rgba(94, 114, 228, 0.2)");
    gradientStroke1.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
    gradientStroke1.addColorStop(0, "rgba(94, 114, 228, 0)");
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",

        ],
        datasets: [{
          label: "Product Sales",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: salesData,
          maxBarThickness: 6,
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              padding: 10,
              color: "#fbfbfb",
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              color: "#ccc",
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
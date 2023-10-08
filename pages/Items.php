<?php
require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');
$itemDetailsSearchSql = 'SELECT * FROM item';
$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
$itemDetailsSearchStatement->execute(); 
?>

<!DOCTYPE html>
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
    table-layout: auto; /* Let the table adapt to content */
    width: 100%; /* Set a maximum width for the table */
  }

  td.description {
    white-space: nowrap; /* Prevent line breaks within the cell */
    overflow: hidden; /* Hide overflow text */
    text-overflow: ellipsis; /* Add ellipsis (...) to indicate text overflow */
    max-width: 200px;
    height: max-content; /* Adjust the maximum width as needed */
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
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="../pages/Items.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-Item-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Item</span>
          </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" href="../pages/billing.html">
              <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-tables-center justify-content-center"
              >
                <i
                  class="ni ni-credit-card text-success text-sm opacity-10"
                ></i>
              </div>
              <span class="nav-link-text ms-1">Billing</span>
            </a>
          </li>-->
        <li class="nav-item">
          <a class="nav-link" href="#Search">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Search</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="customer.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Customer</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../model/login/logout.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-tables-center justify-content-center">
              <i class="ni ni-fat-delete text-danger text-sm opacity-10"></i>
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
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0  text-uppercase font-weight-bolder opacity-10 ">
              <h6 class="text-center">Items table</h6>
              <div
                class="icon icon-shape icon-md px-1 floatt-right border-radius-md text-center  d-flex ">

                <button style="background: linear-gradient(to bottom, #0352bd 0%, #00ccff 100%);" id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-info float-right btn-sm">Refresh</button> </div>
              </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
              
                <table class="table-responsive table align-tables-center mb-0" id="itemDetailsTable" >
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
                          >'. $row['stock'] .'</span
                        ></td>' . 
                        '<td class="align-middle text-center text-secondary">
                        <span class="text-secondary text-sm font-weight-bold"
                          >'. $row['unitPrice'] .'</span
                        ></td>' .
                        '<td class="align-middle text-center text-sm text-secondary">';
                  
                      if($row['status'] == 'Disabled') {
                          echo '<span class="badge badge-sm bg-gradient-danger">'. $row['status'] .'</span>';
                      } else {
                          echo '<span class="badge badge-sm bg-gradient-success">'. $row['status'] .'</span>';
                      }
                  
                      echo '</td>' 
                      . 
                        '<td class="text-sm description">
                        <span class="text-secondary text-xs font-weight-bold  "
                          >'. $row['description'] .'</span
                        ></td>'.
                        
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


    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
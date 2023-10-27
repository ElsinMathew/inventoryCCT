<?php
// Include necessary files
include_once("../../inc/config/constants.php");
include_once("./includes/config.php");

// Get invoice list
function getInvoices()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // The query to retrieve invoices and related customer data
    $query = "SELECT * 
        FROM invoices i
        JOIN customers c
        ON c.invoice = i.invoice
        WHERE i.invoice = c.invoice
        ORDER BY i.invoice";

    // Execute the query
    $results = $mysqli->query($query);

    // Output table structure for displaying data
    if ($results) {
        print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Issue Date</th>
                <th>Due Date</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
              </tr></thead><tbody>';

        // Loop through the results and print each row
        while ($row = $results->fetch_assoc()) {
            print '
                <tr>
                    <td>' . $row["invoice"] . '</td>
                    <td>' . $row["customerName"] . '</td>
                    <td>' . $row["invoice_date"] . '</td>
                    <td>' . $row["invoice_due_date"] . '</td>
                    <td>' . $row["invoice_type"] . '</td>';

            // Check the status and display a label
            if ($row['status'] == "open") {
                print '<td><span class="label label-primary">' . $row['status'] . '</span></td>';
            } elseif ($row['status'] == "paid") {
                print '<td><span class="label label-success">' . $row['status'] . '</span></td>';
            }

            print '
                    <td>
                        <a href="invoice-edit.php?id=' . $row["invoice"] . '" class="btn btn-primary btn-xs">
                            <span class="fa fa-edit" aria-hidden="true"></span>
                        </a>
                        <a href="#" data-invoice-id="' . $row['invoice'] . '" data-email="' . $row['email'] . '" data-invoice-type="' . $row['invoice_type'] . '" data-custom-email="' . $row['custom_email'] . '" class="btn btn-success btn-xs email-invoice">
                            <span class="fa fa-envelope" aria-hidden="true"></span>
                        </a>
                        <a href="invoices/' . $row["invoice"] . '.pdf" class="btn btn-info btn-xs" target="_blank">
                            <span class="fa fa-download-alt" aria-hidden="true"></span>
                        </a>
                        <a data-invoice-id="' . $row['invoice'] . '" class="btn btn-danger btn-xs delete-invoice">
                            <span class="fa fa-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            ';
        }

        print '</tr></tbody></table>';
    } else {
        echo "<p>There are no invoices to display.</p>";
    }

    // Free the memory associated with the result
    $results->free();

    // Close the database connection
    $mysqli->close();
}

// Initial invoice number
function getInvoiceId()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Query to get the latest invoice number
    $query = "SELECT invoice FROM invoices ORDER BY invoice DESC LIMIT 1";

    if ($result = $mysqli->query($query)) {
        $row_cnt = $result->num_rows;
        $row = mysqli_fetch_assoc($result);

        if ($row_cnt == 0) {
            echo INVOICE_INITIAL_VALUE;
        } else {
            echo $row['invoice'] + 1;
        }

        // Free the memory associated with the result
        $result->free();

        // Close the database connection
        $mysqli->close();
    }
}

// Populate product dropdown for invoice creation
function popProductsList()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Query to retrieve product data
    $query = "SELECT * FROM item WHERE stock > 0 ORDER BY itemName ASC";

    // Execute the query
    $results = $mysqli->query($query);

    if ($results) {
        echo '<select class="form-control item-select productSelect" id="productSelect">';
        while ($row = $results->fetch_assoc()) {
            $maxDescriptionLength = 28; // Adjust this to your desired length
            $description = strlen($row['description']) > $maxDescriptionLength ? substr($row['description'], 0, $maxDescriptionLength) . '...' : $row['description'];
            $itemNameParts = explode('-', $row['itemName']);
            $itemName = trim($itemNameParts[0]);
            echo '<option value="' . $row['unitPrice'] . '" data-itemid="' . $row['itemID'] . '">' . $itemName . ' - ' . $description . '</option>';
        }

        echo '</select>';
    } else {
        echo "<p>There are no products, please add a product.</p>";
    }

    // Free the memory associated with the result
    $results->free();

    // Close the database connection
    $mysqli->close();
}


// Populate customer dropdown for invoice creation
function popCustomersList()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Query to retrieve customer data
    $query = "SELECT * FROM customer ORDER BY fullName ASC";

    // Execute the query
    $results = $mysqli->query($query);

    if ($results) {
        print '<table class="table table-bordered" id="data-table"><thead><tr>
                <th class="table table-bordered">Name</th>
                <th class="table table-bordered">Email</th>
                <th class="table table-bordered">Phone</th>
                <th class="table table-bordered">Action</th>
              </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            print '
                <tr>
                    <td>' . $row["fullName"] . '</td>
					<td>' . $row["email"] . '</td>
                    <td>' . $row["mobile"] . '</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-xs customer-select"
                            data-customer-name="' . $row['fullName'] . '"
                            data-customer-email="' . $row['email'] . '"
                            data-customer-phone="' . $row['mobile'] . '"
                            data-customer-address-1="' . $row['address'] . '"
                            data-customer-town="' . $row['city'] . '"
                            data-customer-county="' . $row['district'] . '"
                            data-customer-postcode="' . $row['postcode'] . '
                            data-customer-id="' . $row['customerID'] . '">Select</a>
                    </td>
                </tr>
            ';
        }

        print '</tr></tbody></table>';
    } else {
        echo "<p>There are no customers to display.</p>";
    }

    // Free the memory associated with the result
    $results->free();

    // Close the database connection
    $mysqli->close();
}

// Get products list
function getProducts()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Query to retrieve product data
    $query = "SELECT * FROM item ORDER BY itemName ASC";

    // Execute the query
    $results = $mysqli->query($query);

    if ($results) {
        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
                <th>Product</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
              </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            $maxDescriptionLength = 50; // Adjust this to your desired length
            $description = strlen($row['description']) > $maxDescriptionLength ? substr($row['description'], 0, $maxDescriptionLength) . '...' : $row['description'];

            print '
                <tr>
                    <td>' . $row["itemName"] . '</td>
                    <td>' . $row['description'] . '</td>
                    <td>$' . $row["unitPrice"] . '</td>
                    <td>
                        <a href="product-edit.php?id=' . $row["productID"] . '" class="btn btn-primary btn-xs">
                            <span class="fa fa-edit" aria-hidden="true"></span>
                        </a>
                        <a data-product-id="' . $row['productID'] . '" class="btn btn-danger btn-xs delete-product">
                            <span class="fa fa-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            ';
        }

        print '</tr></tbody></table>';
    } else {
        echo "<p>There are no products to display.</p>";
    }

    // Free the memory associated with the result
    $results->free();

    // Close the database connection
    $mysqli->close();
}

// Get user list
function getUsers()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Query to retrieve user data
    $query = "SELECT * FROM users ORDER BY username ASC";

    // Execute the query
    $results = $mysqli->query($query);

    if ($results) {
        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
              </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            print '
                <tr>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row["username"] . '</td>
                    <td>' . $row["email"] . '</td>
                    <td>' . $row["phone"] . '</td>
                    <td>
                        <a href="user-edit.php?id=' . $row["id"] . '" class="btn btn-primary btn-xs">
                            <span class="fa fa-edit" aria-hidden="true"></span>
                        </a>
                        <a data-user-id="' . $row['id'] . '" class="btn btn-danger btn-xs delete-user">
                            <span class="fa fa-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            ';
        }

        print '</tr></tbody></table>';
    } else {
        echo "<p>There are no users to display.</p>";
    }

    // Free the memory associated with the result
    $results->free();

    // Close the database connection
    $mysqli->close();
}

// Get customer list
function getCustomers()
{
    // Connect to the database
    $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Query to retrieve customer data
    $query = "SELECT * FROM customer ORDER BY name ASC";

    // Execute the query
    $results = $mysqli->query($query);

    if ($results) {
        print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
              </tr></thead><tbody>';

        while ($row = $results->fetch_assoc()) {
            print '
                <tr>
                    <td>' . $row["fullName"] . '</td>
                    <td>' . $row["email"] . '</td>
                    <td>' . $row["mobile"] . '</td>
                    <td>
                        <a href="customer-edit.php?id=' . $row["customerID"] . '" class="btn btn-primary btn-xs">
                            <span class="fa fa-edit" aria-hidden="true"></span>
                        </a>
                        <a data-customer-id="' . $row['customerID'] . '" class="btn btn-danger btn-xs delete-customer">
                            <span class="fa fa-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            ';
        }

        print '</tr></tbody></table>';
    } else {
        echo "<p>There are no customers to display.</p>";
    }

    // Free the memory associated    // Free the memory associated with the result
    $results->free();

    // Close the database connection
    $mysqli->close();
}

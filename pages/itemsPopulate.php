<?php
require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');

$response = [
    'productID' => '',
    'itemName' => '',
    'status' => '',
    'description' => '',
    'discount' => '',
    'unitPrice' => '',
    'totalStock' => ''
];

if (isset($_POST['itemDetailsItemNumber'])) {
    $itemNumber = htmlentities($_POST['itemDetailsItemNumber']);
    $itemDetailsSql = 'SELECT * FROM item WHERE itemNumber = :itemNumber';
    $itemDetailsStatement = $conn->prepare($itemDetailsSql);
    $itemDetailsStatement->execute(['itemNumber' => $itemNumber]);

    if ($itemDetailsStatement->rowCount() > 0) {
        $row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        http_response_code(404); // Set the HTTP status code to 404 Not Found
        echo json_encode($response); // Clear the other input fields when no data is found
    }

    $itemDetailsStatement->closeCursor();
} else {
    // If item number is not set, return the default empty values
    echo json_encode($response);
}
?>

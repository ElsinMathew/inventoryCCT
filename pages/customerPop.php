<?php
require_once('../inc/config/constants.php');
require_once('../inc/config/db.php');

$response = [
    'customerNo' => '',
    'fullName' => '',
    'mobile' => '',
    'email' => '',
    'address' => '',
    'city' => '',
    'district' => '',
    'status' => '',
    'customerID' => '',
];

if (isset($_POST['customerDetailsCustomerNumber'])) {
    $customerNumber = htmlentities($_POST['customerDetailsCustomerNumber']);
    $customerDetailsSql = 'SELECT * FROM customer WHERE customerNo = :customerNo';
    $customerDetailsStatement = $conn->prepare($customerDetailsSql);
    $customerDetailsStatement->execute(['customerNo' => $customerNumber]);

    if ($customerDetailsStatement->rowCount() > 0) {
        $row = $customerDetailsStatement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        http_response_code(404); // Set the HTTP status code to 404 Not Found
        echo json_encode($response); // Clear the other input fields when no data is found
    }

    $customerDetailsStatement->closeCursor();
} else {
    // If customer number is not set, return the default empty values
    echo json_encode($response);
}
?>

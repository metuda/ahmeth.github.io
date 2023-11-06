<?php
// Check if the API key is provided in the request header
$apiKey = $_SERVER['HTTP_API_KEY'] ?? '';

// Replace 'YOUR_API_KEY' with your actual API key
$validApiKey = 'magelcoapikey';

if ($apiKey !== $validApiKey) {
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(array("error" => "Unauthorized - Invalid API key"));
    exit;
}

// Database connection
include 'config.php';

if ($conn) {
    // Get the account number sent via POST request
    $accountNumber = $_POST['account_number'] ?? '';

    if ($accountNumber === '') {
        echo json_encode(["error" => "Invalid account number"]);
        exit;
    }

    // Check if the provided account number exists in the 'customers' table
    $customerQuery = "SELECT * FROM customers WHERE account_id = '$accountNumber'";
    $customerResult = $conn->query($customerQuery);

    if ($customerResult && $customerResult->num_rows > 0) {
        // Account found, retrieve bills for the matched account_id
        $billsQuery = "SELECT * FROM bills WHERE account_id = '$accountNumber'";
        $billsResult = $conn->query($billsQuery);

        $billsData = array();
        if ($billsResult && $billsResult->num_rows > 0) {
            while ($bill = $billsResult->fetch_assoc()) {
                $billsData[] = $bill;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($billsData);
    } else {
        // Account not found
        echo json_encode(["error" => "Account not found"]);
    }
} else {
    echo json_encode(["error" => "Database connection error"]);
}
?>
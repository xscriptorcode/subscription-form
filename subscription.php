<?php
// Enable error reporting (development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load database credentials
$dbConfig = include($_SERVER['DOCUMENT_ROOT'] . '/database.php');

// Database connection
$conn = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['pass'], $dbConfig['name']);

// Verify the connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection error: " . $conn->connect_error]);
    exit;
}

// Check if email was received
if (isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "error" => "Invalid email address."]);
        exit;
    }

    // Count the number of records for the current date
    $currentDate = date('Y-m-d');
    $query = "SELECT COUNT(*) AS total FROM NewsletterSubscriber WHERE DATE(date) = '$currentDate'";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $totalRecordsToday = (int) $row['total'];

        // Check if the 100 records limit has been reached
        if ($totalRecordsToday >= 100) {
            echo json_encode(["success" => false, "error" => "The daily limit of 100 registrations has been reached."]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "error" => "Error querying the database."]);
        exit;
    }

    // Perform the insertion if the limit hasn't been reached
    $sql = "INSERT INTO NewsletterSubscriber (email) VALUES ('$email')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Thank you for subscribing!"]);
    } else {
        echo json_encode(["success" => false, "error" => "Error saving to the database: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No email address was received."]);
}

// Close the connection
$conn->close();
?>

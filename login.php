<?php
// Include the database connection file
include 'db.php';

// Start a new or resume an existing session
session_start();

// Check if data was received from JavaScript
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];  // Get email from the form
    $password = $_POST["password"];  // Get password from the form

    // Query to check if user exists
    $query = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password (for demonstration purposes, no hashing)
        if ($password == $user["password"]) {
            // Password is correct, create a session
            $_SESSION["user_id"] = $user["id"];

            // Prepare the JavaScript variable
            $js_session = json_encode($_SESSION);

            // Return success response with the session data
            echo json_encode(["success" => true, "message" => "Login successful", "session" => $js_session]);
        } else {
            // Password is incorrect, return error response
            echo json_encode(["success" => false, "message" => "Incorrect password"]);
        }
    } else {
        // User does not exist, return error response
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
} elseif (isset($_SESSION["user_id"])) {
    // Session is available, user is already logged in
    // Prepare the JavaScript variable
    $js_session = json_encode($_SESSION);

    // Return success response with the session data
    echo json_encode(["success" => true, "message" => "Already logged in", "session" => $js_session]);
} else {
    // Invalid request method, return error response
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

// Close the database connection
$conn->close();
?>
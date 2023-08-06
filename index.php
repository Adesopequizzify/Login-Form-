<?php
session_start();

// Check if a session is available
if (isset($_SESSION['user_id'])) {
    // Retrieve user ID from the session
    $userId = $_SESSION['user_id'];

    // Include the database connection file
    require_once 'db.php';

    // Query the database to retrieve user email based on user ID
    $sql = "SELECT email FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userEmail = $row['email'];
    } else {
        $userEmail = 'User not found';
    }
} else {
    $userEmail = 'Session not available';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Index Page</title>
</head>
<body>
    <h1>Welcome to the Test Index Page</h1>
    <p>User Email: <?php echo $userEmail; ?></p>
</body>
</html>
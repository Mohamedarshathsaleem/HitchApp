<?php
session_start();
require 'php/config.php';

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $start_location = htmlspecialchars($_POST['start_location']);
    $end_location = htmlspecialchars($_POST['end_location']);
    $date_time = $_POST['date_time'];
    $available_seats = intval($_POST['available_seats']);

    $user_id = $_SESSION['id'];

    // Prepare SQL query
    $sql = "INSERT INTO rides (name, start_location, end_location, date_time, available_seats, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssii", $name, $start_location, $end_location, $date_time, $available_seats, $user_id);

    // Execute SQL query
    if ($stmt->execute()) {
        echo "<script>window.alert('Ride published successfully.');</script>";
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Ride - HitchApp</title>
    <link rel="stylesheet" href="style/styles2.css">
</head>
<body>
    <div class="container">
        <h1>Publish a Ride</h1>
        <form method="post" action="publish_ride.php">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="start_location">Start Location:</label><br>
            <input type="text" id="start_location" name="start_location" required><br>
            <label for="end_location">End Location:</label><br>
            <input type="text" id="end_location" name="end_location" required><br>
            <label for="date_time">Date and Time:</label><br>
            <input type="datetime-local" id="date_time" name="date_time" required><br>
            <label for="available_seats">Available Seats:</label><br>
            <input type="number" id="available_seats" name="available_seats" required><br>
            <input type="submit" value="Publish Ride">
        </form>
        <p class="back"><a href="home.php">Back to Home</a></p>
    </div>
</body>
</html>

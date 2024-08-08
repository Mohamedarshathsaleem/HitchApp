<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Ride</title>
    <link rel="stylesheet" href="style/styles4.css">

</head>
<body>
    <div class="container">
    <?php
session_start();
require 'php/config.php';

$user_id = $_SESSION['id'] ?? null;
$ride_id = $_POST['ride_id'] ?? null;

if (!$user_id || !$ride_id) {
    header("Location: login.php");
    exit;
}

// Check if the ride belongs to the user
$sql = "SELECT * FROM rides WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ride_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Delete the ride
    $delete_sql = "DELETE FROM rides WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $ride_id);

    if ($delete_stmt->execute()) {
        echo "<p>Ride deleted successfully.</p>";
        echo '<button><a id="popup" href="activity.php">OK</a></button>';
    } else {
        echo "<p>Error deleting ride.</p>";
        echo '<button><a id="popup" href="activity.php">OK</a></button>';
    }

    $delete_stmt->close();
} else {
    echo "<p>Unauthorized access or ride not found.</p>";
    echo '<button><a id="popup" href="activity.php">OK</a></button>';
}

$conn->close();
?>

    </div>
</body>
</html>
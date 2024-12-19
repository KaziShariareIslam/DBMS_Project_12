<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$package_id = $_GET['id'];

// Fetch the specific package
$query = "SELECT * FROM packages WHERE id = '$package_id'";
$result = mysqli_query($conn, $query);
$package = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Package</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>View Package</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td><?php echo $package['id']; ?></td>
            </tr>
            <tr>
                <th>Package Name</th>
                <td><?php echo $package['package_name']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$package_id = $_GET['id'];

// Delete the package
$query = "DELETE FROM packages WHERE id = '$package_id'";
if (mysqli_query($conn, $query)) {
    header('Location: index.php');
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

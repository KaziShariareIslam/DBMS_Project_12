<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$grade_id = $_GET['id'];

// Delete the grade
$query = "DELETE FROM grades WHERE id = '$grade_id'";
if (mysqli_query($conn, $query)) {
    header('Location: index.php');
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

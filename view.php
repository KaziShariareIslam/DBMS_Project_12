<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$grade_id = $_GET['id'];

// Fetch the specific grade
$query = "SELECT * FROM grades WHERE id = '$grade_id'";
$result = mysqli_query($conn, $query);
$grade = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grade</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>View Grade</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td><?php echo $grade['id']; ?></td>
            </tr>
            <tr>
                <th>Grade</th>
                <td><?php echo $grade['grade']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$package_id = $_GET['id'];

// Fetch the package to edit
$query = "SELECT * FROM packages WHERE id = '$package_id'";
$result = mysqli_query($conn, $query);
$package = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
    
    $query = "UPDATE packages SET package_name = '$new_package_name' WHERE id = '$package_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Package</h1>
        <form action="edit-package.php?id=<?php echo $package['id']; ?>" method="POST">
            <input type="text" name="package_name" value="<?php echo $package['package_name']; ?>" required>
            <button type="submit" class="btn">Update Package</button>
        </form>
    </div>
</body>
</html>

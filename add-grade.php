<?php
session_start();
include '../config/db.php';

$error_msg = null;

// Fetch crop names from the database to populate the dropdown
$query_crops = "SELECT id, crop_name FROM crops";
$crops_result = mysqli_query($conn, $query_crops);
if (!$crops_result) {
    die("Error fetching crops: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grade']) && !empty(trim($_POST['grade'])) && isset($_POST['crop_id']) && !empty($_POST['crop_id'])) {
        $grade = mysqli_real_escape_string($conn, trim($_POST['grade']));
        $crop_id = mysqli_real_escape_string($conn, $_POST['crop_id']);
        
        if ($conn) {
            // Insert grade and crop_id into the grades table
            $query = "INSERT INTO grades (crop_id, grade) VALUES ('$crop_id', '$grade')";
            if (mysqli_query($conn, $query)) {
                header('Location: index.php');  // Redirect to the index page after successful insertion
                exit();
            } else {
                $error_msg = "Error: " . mysqli_error($conn);
            }
        } else {
            $error_msg = "Database connection error.";
        }
    } else {
        $error_msg = "Grade name and Crop must be selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Grade</title>
    <link rel="stylesheet" href="../assets/css/styles.css">  <!-- Assuming you have a CSS file for styling -->
</head>
<body>
    <div class="container">
        <h1>Add New Grade</h1>
        <?php if ($error_msg): ?>
            <div class="error-msg"><?= htmlspecialchars($error_msg) ?></div>
        <?php endif; ?>
        <form action="add-grade.php" method="POST">
            <div>
                <label for="crop_id">Select Crop</label>
                <select name="crop_id" id="crop_id" required>
                    <option value="" disabled selected>Select a Crop</option>
                    <?php while ($row = mysqli_fetch_assoc($crops_result)): ?>
                        <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['crop_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label for="grade">Grade</label>
                <input type="text" name="grade" id="grade" placeholder="Enter grade name" required>
            </div>
            <button type="submit" class="btn">Add Grade</button>
        </form>
    </div>
</body>
</html>

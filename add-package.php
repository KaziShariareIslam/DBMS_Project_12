<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
    $package_description = mysqli_real_escape_string($conn, $_POST['description']);  // Get description from the form

    // Insert the data into the 'packages' table
    $query = "INSERT INTO packages (package_name, description) VALUES ('$package_name', '$package_description')";

    if (mysqli_query($conn, $query)) {
        header('Location: index.php');  // Redirect to a page after successful insert
        exit();
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
    <title>Add Package</title>
    <style>
        /* Styling for the form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Add Package</h2>
        <input type="text" name="package_name" placeholder="Package Name" required>
        <textarea name="description" placeholder="Package Description" required></textarea>
        <button type="submit">Add Package</button>
    </form>
</body>
</html>

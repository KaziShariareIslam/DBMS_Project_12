<?php 
session_start();
include '../config/db.php';

// Check if the user is logged in and has admin rights
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

// Fetch all packages from the database
$query = "SELECT id, package_name FROM packages";
$result = mysqli_query($conn, $query);

// Error handling for the database query
if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}

// Prepare data for the chart
$packageNames = [];
$packageCounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $packageNames[] = $row['package_name'];
    $packageCounts[] = 1; // Assuming each package is counted as 1
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packaging Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js Library -->

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn:active {
            transform: scale(0.98);
        }

        /* Chart Container */
        .chart-container {
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .table td a.btn {
            padding: 5px 10px;
            font-size: 12px;
        }

        .table td {
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chart-container {
                width: 90%;
            }

            .btn {
                font-size: 12px;
                padding: 8px 15px;
            }

            .table th,
            .table td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Packaging Dashboard</h1>
        <a href="add-package.php" class="btn">Add New Package</a>

        <div class="chart-container" style="width: 50%; margin: auto;">
            <canvas id="packageChart"></canvas>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Package Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php mysqli_data_seek($result, 0); // Reset pointer for reuse ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['package_name']; ?></td>
                        <td>
                            <a href="edit-package.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                            <a href="delete-package.php?id=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this package?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const packageNames = <?php echo json_encode($packageNames); ?>;
        const packageCounts = <?php echo json_encode($packageCounts); ?>;

        // Generate random colors for the pie chart
        const colors = packageNames.map(() => 
            `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`
        );

        // Create the Chart.js pie chart
        const ctx = document.getElementById('packageChart').getContext('2d');
        const packageChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: packageNames,
                datasets: [{
                    data: packageCounts,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.6', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
</body>
</html>

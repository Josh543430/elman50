<?php
session_start();
include 'db.php';

// Check if cookies exist and log the user in automatically
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* Background Image */
        body {
            background: url('images/hotel.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        /* Main Container */
        .container {
            max-width: 900px;
            background: rgba(255, 255, 255, 0.85);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            position: relative; /* For positioning the logout button */
        }

        /* Form Styling */
        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn-primary, .btn-warning, .btn-danger, .btn-logout {
            border-radius: 8px;
            padding: 10px 15px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        /* Logout Button */
        .btn-logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        /* Table Styling */
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background: #343a40 !important;
            color: white !important;
        }

        .table td {
            background: rgba(255, 255, 255, 0.8);
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
                padding: 15px;
            }

            .row {
                flex-direction: column;
            }

            .btn-logout {
                position: static;
                margin-bottom: 15px;
            }
        }
    </style>

</head>
<body>

<div class="container">
    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-logout">Logout</a>

    <h2 class="text-center mb-4">🏨 Hotel Booking Management</h2>

    <!-- Booking Form -->
    <form action="create.php" method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Guest Name</label>
                <input type="text" name="guest_name" class="form-control" placeholder="Enter guest name" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Room Number</label>
                <input type="number" name="room_number" class="form-control" placeholder="Room No." required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Check-In Date</label>
                <input type="date" name="check_in" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Check-Out Date</label>
                <input type="date" name="check_out" class="form-control" required>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary mt-3">Book Now</button>
            </div>
        </div>
    </form>

    <!-- Booking Table -->
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Guest Name</th>
                    <th>Room Number</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM bookings";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['guest_name']}</td>
                                <td>{$row['room_number']}</td>
                                <td>{$row['check_in']}</td>
                                <td>{$row['check_out']}</td>
                                <td>
                                    <a href='update.php?id={$row['id']}' class='btn btn-warning btn-sm'>✏ Edit</a>
                                    <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>🗑 Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No bookings found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
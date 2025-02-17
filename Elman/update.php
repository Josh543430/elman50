<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM bookings WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_name = $_POST["guest_name"];
    $room_number = $_POST["room_number"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];

    $sql = "UPDATE bookings SET guest_name='$guest_name', room_number='$room_number', check_in='$check_in', check_out='$check_out' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        /* Background image */
        body {
            background: url('images/formm.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Center the form card */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Styling the form card */
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            width: 500px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Update Booking</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Guest Name</label>
                <input type="text" name="guest_name" class="form-control" value="<?= $row['guest_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Room Number</label>
                <input type="number" name="room_number" class="form-control" value="<?= $row['room_number'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Check-In Date</label>
                <input type="date" name="check_in" class="form-control" value="<?= $row['check_in'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Check-Out Date</label>
                <input type="date" name="check_out" class="form-control" value="<?= $row['check_out'] ?>" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Booking</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

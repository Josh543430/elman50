<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_name = $_POST["guest_name"];
    $room_number = $_POST["room_number"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];

    $sql = "INSERT INTO bookings (guest_name, room_number, check_in, check_out) 
            VALUES ('$guest_name', '$room_number', '$check_in', '$check_out')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<head>
<style>
        /* Background image */
        body {
            
            background: url('images/hotel.jpg') no-repeat center center fixed ;
            background-size: cover;
            
        }
</style>
</head>
<body>
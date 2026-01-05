<?php
session_start();
include 'config.php';

if (isset($_GET['doctor_id'])) {
    $user_id = $_SESSION['user_id'];
    $doctor_id = $_GET['doctor_id'];

    $date = new DateTime();
    $date->modify('+10 days');
    $appointment_date = $date->format('Y-m-d');

    $sql = "INSERT INTO appointments (user_id, doctor_id, appointment_time) VALUES ('$user_id', '$doctor_id', '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        // echo "Appointment booked successfully for " . $appointment_date . ".";
        header('Location: profile.php');
    } else {
        echo "Error booking appointment: " . $conn->error;
    }
} else {
    echo "Doctor ID not provided.";
}

$conn->close();
?>
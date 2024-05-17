<?php
session_start();
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    $sql = "INSERT INTO events_participants (event_id, name, email, telephone) VALUES ('$event_id', '$name', '$email', '$telephone')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: participant_dashboard.php?message=Booking successful");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: participant_dashboard.php");
    exit();
}
?>

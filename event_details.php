<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['participant_username'])) {
    header("Location: participant_login.php");
    exit();
}

if (!isset($_GET['event_id']) || empty($_GET['event_id'])) {
    header("Location: participant_dashboard.php");
    exit();
}

$event_id = $_GET['event_id'];
$sql = "SELECT * FROM events WHERE event_id = $event_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: participant_dashboard.php");
    exit();
}

$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-4">Event Details</h2>
        
        <div class="mb-4 border border-gray-300 p-4 rounded-lg">
            <?php if (!empty($event['image'])) { ?>
                <img src="<?php echo $event['image']; ?>" alt="Event Image" class="mb-2 max-w-full h-auto">
            <?php } else { ?>
                <p>No image available</p>
            <?php } ?>
            <h3 class="text-xl font-semibold mb-2"><?php echo $event['title']; ?></h3>
            <p class="mb-2"><?php echo $event['description']; ?></p>
            <p class="mb-2">Date: <?php echo $event['date']; ?></p>
            <p class="mb-2">Location: <?php echo $event['location']; ?></p>
        </div>

        <!-- Booking Button -->
        <form method="post" action="book_event.php">
            <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Book Event</button>
        </form>

        <p class="mt-8"><a href="participant_dashboard.php" class="text-blue-500 hover:underline">Back to Dashboard</a></p>
    </div>
</body>
</html>

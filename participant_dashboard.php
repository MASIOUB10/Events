<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['participant_username'])) {
    header("Location: participant_login.php");
    exit();
}

if (isset($_GET['message'])) {
    echo "<p class='bg-green-100 text-green-700 p-4 rounded-lg'>{$_GET['message']}</p>";
}

// Fetch events relevant to the participant
$participant_id = $_SESSION['participant_username']; // Assuming you have participant_id stored in the session
$sql = "SELECT * FROM events";
$result = $conn->query($sql);


$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-4">Welcome, <?php echo $_SESSION['participant_username']; ?></h2>
        
        <h3 class="text-xl font-semibold mb-4">Events</h3>
        <!-- Wrap the list of events in a div and apply grid classes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($events as $event) { ?>
                <div class="mb-4 border border-gray-300 p-4 rounded-lg">
                    <!-- Display image -->
                    <?php if (!empty($event['image'])) { ?>
                        <img src="<?php echo $event['image']; ?>" alt="Event Image" class="mb-2 max-w-full h-auto">
                    <?php } else { ?>
                        <p>No image available</p>
                    <?php } ?>
                    <h4 class="text-lg font-semibold mb-2"><?php echo $event['title']; ?></h4>
                    <p class="mb-2">Date: <?php echo $event['date']; ?></p>
                    <!-- Add a link to the event details page -->
                    <a href="event_details.php?event_id=<?php echo $event['event_id']; ?>" class="text-blue-500 hover:underline">View Details</a>
                </div>
            <?php } ?>
        </div>

        <p class="mt-8"><a href="participant_logout.php" class="text-blue-500 hover:underline">Logout</a></p>
    </div>
</body>

</html>


<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['event_id'])) {
    header("Location: admin_panel.php");
    exit();
}

$event_id = $_GET['event_id'];

// Fetch event details
$sql = "SELECT * FROM events WHERE event_id=$event_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: admin_panel.php");
    exit();
}

$event = $result->fetch_assoc();

// Update event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_event'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    $sql = "UPDATE events SET title='$title', description='$description', date='$date', location='$location' WHERE event_id=$event_id";
    $conn->query($sql);
    header("Location: admin_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<header class="bg-blue-500 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <nav>
                <ul class="flex">
                    <li class="mr-4"><a href="admin_panel.php" class="hover:underline">Home</a></li>
                    <li class="mr-4"><a href="#" class="hover:underline">Search Events</a></li>
                    <li class="mr-4"><a href="admin_logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-8">Edit Event</h2>
        <form method="post" class="max-w-lg mx-auto">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $event['title']; ?>" required class="mt-1 px-4 py-2 w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                <textarea name="description" id="description" required class="mt-1 px-4 py-2 w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500"><?php echo $event['description']; ?></textarea>
            </div>
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
                <input type="date" name="date" id="date" value="<?php echo $event['date']; ?>" required class="mt-1 px-4 py-2 w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Location:</label>
                <input type="text" name="location" id="location" value="<?php echo $event['location']; ?>" required class="mt-1 px-4 py-2 w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" name="update_event" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Update Event</button>
        </form>
    </div>
</body>
</html>


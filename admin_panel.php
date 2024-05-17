<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT * FROM events";
$events = [];

// Check if search query is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    
    $sql = "SELECT * FROM events WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Add new event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $images = $_POST['image']; // Get image URL directly from the form

    $sql = "INSERT INTO events (title, description, date, location, image) VALUES ('$title', '$description', '$date', '$location', '$images')";
    $conn->query($sql);
    header("Location: admin_panel.php");
    exit();
}

// Delete event
if (isset($_GET['delete_event'])) {
    $event_id = $_GET['delete_event'];
    $sql = "DELETE FROM events WHERE event_id=$event_id";
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
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-blue-500 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <nav>
                <ul class="flex">
                    <li class="mr-4"><a href="admin_panel.php" class="hover:underline">Home</a></li>
                    <!-- <li class="mr-4"><a href="#" class="hover:underline">Search Events</a></li> -->
                    <li class="mr-4"><a href="admin_logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-4">Welcome, <?php echo $_SESSION['admin_username']; ?></h2>
        
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-2">Search Events</h3>
            <form method="GET">
                <div class="flex items-center">
                    <input type="text" name="search" placeholder="Search by title or description" class="px-4 py-2 w-64 border rounded-l-lg focus:outline-none focus:ring focus:border-blue-300">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 transition duration-300">Search</button>
                </div>
            </form>
        </div>

        <h3 class="text-xl font-semibold mb-4">Events</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <?php foreach ($events as $event) { ?>
                <div class="border border-gray-300 p-4 rounded-lg">
                    <!-- Display image -->
                    <?php if (!empty($event['image'])) { ?>
                        <img src="<?php echo $event['image']; ?>" alt="Event Image" class="mb-2 max-w-full h-auto">
                    <?php } else { ?>
                        <p>No image available</p>
                    <?php } ?>
                    <h4 class="text-lg font-semibold mb-2"><?php echo $event['title']; ?></h4>
                    <p class="mb-2"><?php echo $event['description']; ?></p>
                    <p class="mb-2">Date: <?php echo $event['date']; ?></p>
                    <p class="mb-2">Location: <?php echo $event['location']; ?></p>
                    <div class="flex">
                        <a href="edit_event.php?event_id=<?php echo $event['event_id']; ?>" class="text-blue-500 hover:underline mr-2">Edit</a>
                        <a href="admin_panel.php?delete_event=<?php echo $event['event_id']; ?>" class="text-red-500 hover:underline">Delete</a>
                    </div>
                </div>
            <?php } ?>
        </div>

        <h3 class="text-xl font-semibold mb-2">Add New Event</h3>
        <form method="post" class="mb-8">
            <div class="flex mb-4">
                <label class="w-24 flex-shrink-0 mr-4">Title:</label>
                <input type="text" name="title" required class="px-4 py-2 border rounded-lg flex-grow">
            </div>
            <div class="flex mb-4">
                <label class="w-24 flex-shrink-0 mr-4">Description:</label>
                <textarea name="description" required class="px-4 py-2 border rounded-lg flex-grow"></textarea>
            </div>
            <div class="flex mb-4">
                <label class="w-24 flex-shrink-0 mr-4">Date:</label>
                <input type="date" name="date" required class="px-4 py-2 border rounded-lg flex-grow">
            </div>
            <div class="flex mb-4">
                <label class="w-24 flex-shrink-0 mr-4">Location:</label>
                <input type="text" name="location" required class="px-4 py-2 border rounded-lg flex-grow">
            </div>
            <div class="flex mb-4">
                <label class="w-24 flex-shrink-0 mr-4">Image URL:</label>
                <input type="text" name="image" required class="px-4 py-2 border rounded-lg flex-grow">
            </div>
            <button type="submit" name="add_event" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Add Event</button>
        </form>

        
    </div>
</body>
</html>

<?php
session_start();
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    // Validate form data
    if (!empty($name) && !empty($email) && !empty($telephone)) {
        // Prepare SQL query to insert the data into the event_participant table
        $sql = "INSERT INTO events_participants (event_id, name, email, telephone) VALUES ('$event_id', '$name', '$email', '$telephone')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            header("Location: book_event.php?event_id=$event_id&message=Booking successful");
            exit();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error_message = "All fields are required.";
    }
} else {
    if (!isset($_GET['event_id']) || empty($_GET['event_id'])) {
        header("Location: participant_dashboard.php");
        exit();
    }

    $event_id = $_GET['event_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Event</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-4">Book Event</h2>

        <?php if (isset($_GET['message'])) { ?>
            <p class="bg-green-100 text-green-700 p-4 rounded-lg"><?php echo $_GET['message']; ?></p>
        <?php } elseif (isset($error_message)) { ?>
            <p class="bg-red-100 text-red-700 p-4 rounded-lg"><?php echo $error_message; ?></p>
        <?php } ?>

        <form method="post" action="book_event.php" class="max-w-md mx-auto">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            
            <div class="mb-4">
                <label class="block mb-2" for="name">Name:</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            
            <div class="mb-4">
                <label class="block mb-2" for="email">Email:</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            
            <div class="mb-4">
                <label class="block mb-2" for="telephone">Telephone:</label>
                <input type="text" name="telephone" id="telephone" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Book</button>
        </form>
    </div>
</body>
</html>

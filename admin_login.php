<?php
session_start();
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_username'] = $username;
        header("Location: admin_panel.php");
        exit();
    } else {
        $login_error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-80">
        <h2 class="text-2xl font-semibold mb-6">Admin Login</h2>
        <?php if(isset($login_error)) { echo "<p class='text-red-500 mb-4'>$login_error</p>"; } ?>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-2" for="username">Username:</label>
                <input type="text" name="username" id="username" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2" for="password">Password:</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Login</button>
        </form>
    </div>
</body>
</html>


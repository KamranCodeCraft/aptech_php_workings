<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug POST data
    // var_dump($_POST); exit;

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Use prepared statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        if (!$stmt) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    
                    // Redirect to dashboard before any output
                    header('Location:parent_dashboard.php');
                    exit;
                } else {
                    $error = "Invalid password.";
                }
            } else {
                $error = "Invalid username.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Child Vaccination System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Login</h1>
        <?php if ($error) { ?>
            <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div>
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 w-full">Login</button>
        </form>
        <p class="text-center mt-4">Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register</a></p>
    </div>
</body>
</html>
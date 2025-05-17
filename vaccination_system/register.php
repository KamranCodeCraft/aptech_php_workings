<?php
include 'config.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    if (empty($username) || empty($password) || empty($role) || empty($email) || empty($phone)) {
        $error = "All fields are required";
    } else {
        $check_query = "SELECT username FROM users WHERE username='$username'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password, role, email, phone) VALUES ('$username', '$hashed_password', '$role', '$email', '$phone')";
            if (mysqli_query($conn, $query)) {
                header('Location: login.php');
                exit;
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
<title>Register - Child Vaccination System</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">    
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h1 class="text-2xl font-bold text-center mb-6">Register</h1>
            <?php if ($error) { ?>
    <p class="text-red-500 text-center mb-4"><?php echo $error; ?></p>
<?php } ?>
<form action="" method="POST" class="space-y-4">
    <div>
        <label for="username" class="block text-gray-700">Username</label>
        <input type="text" name="username" id="username" class="w-full p-2 border border-gray-300 rounded" required>
    </div>
    <div>
        <label for="password" class="block text-gray-700">Password</label>
        <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded" required>
    </div>
    <div>
        <label for="role" class="block text-gray-700">Role</label>
        <select name="role" id="role" class="w-full p-2 border border-gray-300 rounded" required>
            <option value="parent">Parent</option>
            <option value="hospital">Hospital</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div>
        <label for="email" class="block text-gray-700">Email</label>
        <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded" required>
    </div>
    <div>
        <label for="phone" class="block text-gray-700">Phone</label>
        <input type="text" name="phone" id="phone" class="w-full p-2 border border-gray-300 rounded">
    </div>
    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 w-full">Register</button>
    <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login</a></p>
</form>
</body>
</html>

<?php include 'connection/connect_to_db.php' ?>
<?php
$field_error = "";
$database_error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['username'];
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    if (!empty($name) && !empty($email) && !empty($password)) {
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_register_query = "INSERT INTO `users` (name,email,password) VALUES ('$name' , '$email' , '$hash_password')";

        try {
            mysqli_query($conn, $sql_register_query);
            header("location:login.php");
        } catch (mysqli_sql_exception $e) {
            $database_error = $e->getMessage();
        }
    } else {
        $field_error = "All fields are required";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 grid place-items-center h-screen">

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="grid gap-3 bg-white w-96 p-4 rounded-md">

        <h1 class="font-bold text-center text-2xl">Register</h1>
        <?= "<p class='text-red-700 bg-red-50 text-center font-semibold'>$field_error</p>" ?>
        <?= "<p class='text-red-700 bg-red-50 text-center font-semibold'>$database_error</p>" ?>

        <div class="grid">
            <label for="name">Name:</label>
            <input type="text" name="username" class="border border-gray-400 p-1 rounded-sm">
        </div>

        <div class="grid">
            <label for="email">Email:</label>
            <input type="email" name="useremail" class="border border-gray-400 p-1 rounded-sm">
        </div>

        <div class="grid">
            <label for="password">Password:</label>
            <input type="password" name="userpassword" class="border border-gray-400 p-1 rounded-sm">
        </div>

        <div class="grid">
            <input type="submit" value="Register" name="submit" class="bg-blue-500 py-1 text-white rounded-sm cursor-pointer hover:bg-blue-600 mt-3">
            <p class="text-center text-sm text-gray-600 mt-2">Already have an account? <a href="login.php" class="text-blue-500">Login</a></p>
        </div>

    </form>

</body>

</html>
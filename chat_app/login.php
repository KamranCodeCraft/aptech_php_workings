<?php include 'connection/connect_to_db.php' ?>

<?php
$field_error = "";
$user_exist = "";
$user_error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    if (!empty($email) && !empty($password)) {

        $sql_fetch_auth = "SELECT * FROM `users` WHERE email = '$email'";

        try {

            $result =  mysqli_query($conn, $sql_fetch_auth);
            if (mysqli_num_rows($result) == 1) {

                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    header("location:chat.php");
                } else {
                    $user_error = "Invalid credintials";
                }
            } else {
                $user_exist = "User does not exist";
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
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
    <title>login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 grid place-items-center h-screen">

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="grid gap-3 bg-white w-96 p-4 rounded-md">

        <h1 class="font-bold text-center text-2xl">login</h1>
        <?= "<p class='text-red-700 bg-red-50 text-center font-semibold'>$field_error</p>" ?>
        <?= "<p class='text-red-700 bg-red-50 text-center font-semibold'>$user_exist</p>" ?>
        <?= "<p class='text-red-700 bg-red-50 text-center font-semibold'>$user_error </p>" ?>
        <div class="grid">
            <label for="email">Email:</label>
            <input type="email" name="useremail" class="border border-gray-400 p-1 rounded-sm">
        </div>

        <div class="grid">
            <label for="password">Password:</label>
            <input type="password" name="userpassword" class="border border-gray-400 p-1 rounded-sm">
        </div>

        <div class="grid">
            <input type="submit" value="login" name="login" class="bg-blue-500 py-1 text-white rounded-sm cursor-pointer hover:bg-blue-600 mt-3">
            <p class="text-center text-sm text-gray-600 mt-2">Don't have an account? <a href="register.php" class="text-blue-500">Register</a></p>
        </div>

    </form>

</body>

</html>
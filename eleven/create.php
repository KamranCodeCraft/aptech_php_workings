<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include 'navbar.php' ?>
    <?php include 'connection/connect_to_db.php' ?>

    <form action="create.php" method="post">

        <label for="name">Name:</label> <br>
        <input type="text" name="username" placeholder="Enter Username..."> <br>

        <label for="email">Email:</label> <br>
        <input type="email" name="useremail" placeholder="Enter Useremail..."> <br>

        <label for="age">Age:</label> <br>
        <input type="number" name="userage" placeholder="Enter Userage..."><br>
        <br>
        <select name="usercity">
            <option value="karachi" disabled selected>Select city</option>
            <option value="karachi">Karachi</option>
            <option value="lahore ">Lahore</option>
            <option value="multan">Multan</option>
            <option value="quetta">Quetta</option>
        </select>
        <br>
        <br>
        <input type="submit" name="submit" value="Create...">
    </form>


    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $name =  $_POST['username'];
        $email =  $_POST['useremail'];
        $age =  $_POST['userage'];
        $city =  $_POST['usercity'];

        if (!empty($name) && !empty($email) && !empty($age) && !empty($city)) {
            $sql = "INSERT INTO `users` (name,email,age,city) VALUES ('$name' , '$email' , '$age' , '$city')";
            try {
                mysqli_query($conn, $sql);
            } catch (mysqli_sql_exception $e) {
                echo "<p style='color:red'>" . $e->getMessage() . "</p>";
            }
        } else {
            echo "Please fill the given fields.";
        }
    }

    ?>

</body>

</html>
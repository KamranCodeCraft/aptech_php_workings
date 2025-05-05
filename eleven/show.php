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
    <table border="1">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>City</th>
            <th>Created_at</th>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `users`";

            try {
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["age"] . "</td>";
                        echo "<td>" . $row["city"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "</tr>";
                    }
                }
            } catch (mysqli_sql_exception $e) {
                echo "<p style='color:red'>" . $e->getMessage() . "</p>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
<?php include 'connection/connect_to_db.php' ?>

<?php
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["submit"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $day = $_POST["day"] ?? '';

    if (!empty($title) && !empty($description) && !empty($day)) {

        $sql = "INSERT INTO `todo` (title,description,day) VALUES ('$title' , '$description' , '$day')";

        try {
            mysqli_query($conn, $sql);
            $success =  "Successfully created todo";
            // header("location:show.php");
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    } else {
        $error = "Please fill all the given fields";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include 'components/navbar.php' ?>
    <div class="h-screen">
        <h1 class="text-3xl font-bold text-center">Create todo</h1>
        <form action="create.php" method="post" class="w-[300px] grid gap-3 p-2 shadow-xl rounded mx-auto mt-45">
            <?= "<p class='text-green-700 bg-green-100 text-center font-semibold'>$success</p>" ?>
            <!-- ================================================ -->
            <div class="grid">
                <label for="title" class="font-semibold">Title:</label>
                <input type="text"
                    name="title"
                    class="border rounded text-xl p-1"
                    placeholder="Enter title...">
            </div>
            <!-- ================================================ -->
            <div class="grid">
                <label for="description" class="font-semibold">Description:</label>
                <textarea
                    name="description"
                    class="border rounded text-xl p-1"
                    placeholder="Enter description..."></textarea>
            </div>
            <!-- ================================================ -->
            <div class="grid">
                <label for="description" class="font-semibold">Select day:</label>
                <select name="day" class="border rounded p-2">
                    <option disabled selected>Select day</option>
                    <option value="monday">monday</option>
                    <option value="tuesday">tuesday</option>
                    <option value="wednesday">wednesday</option>
                    <option value="thursday">thursday</option>
                    <option value="friday">friday</option>
                    <option value="saturday">saturday</option>
                    <option value="sunday">sunday</option>
                </select>
            </div>
            <!-- ================================================ -->
            <div class="grid">
                <input type="submit" value="Add todo" name="submit" class="bg-blue-600 p-2 text-white rounded font-semibold cursor-pointer hover:bg-blue-700">
            </div>
            <!-- ================================================ -->
            <?php echo "<p class='text-red-700 bg-red-100 text-center font-semibold'>$error </p>" ?>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>

</html>
<?php
include 'connection/connect_to_db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $row_id = $_POST['row_id'];

    $sql_delete = "DELETE FROM `todo` WHERE id = '$row_id'";

    try {
        mysqli_query($conn, $sql_delete);
    } catch (mysqli_sql_exception $e) {
        echo $e->getMessage();
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

    <table class="w-[85%] mx-auto mt-[50px] divide-y divide-gray-200 shadow-md rounded-md overflow-hidden">
        <thead class="bg-gray-100 text-gray-700 uppercase text-sm font-medium">
            <tr>
                <th class="px-6 py-3 text-left">Title</th>
                <th class="px-6 py-3 text-left">Description</th>
                <th class="px-6 py-3 text-left">Day</th>
                <th class="px-6 py-3 text-left">Task Created</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php


            $sql_fetch = "SELECT * FROM `todo`";

            try {
                $result =  mysqli_query($conn, $sql_fetch);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class='hover:bg-gray-50'>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" .  $row["title"] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" .  $row["description"] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" .  $row["day"] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" .  $row["created_at"] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap flex gap-2'>
                               <form method='post' onsubmit=' return confirm(\"Are you sure?\")'>
                               <input type='hidden' value='" . $row['id'] . "' name='row_id' >
                                <input 
                                type='submit'
                                class='px-2 py-1 rounded bg-red-700 text-white cursor-pointer font-semibold' 
                                value='Delete'
                                 name='delete' >
                               </form>
                                <button class='px-2 py-1 rounded bg-green-700 text-white cursor-pointer font-semibold' >Edit</button>
                            </td>";
                        echo "</tr>";
                    }
                }
            } catch (mysqli_sql_exception $e) {
                echo "<tr><td colspan='4' class='text-red-500 px-6 py-4'>" . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</body>

</html>
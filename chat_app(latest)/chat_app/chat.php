<?php

include 'connection/connect_to_db.php';

session_start();

if (empty($_SESSION['username']) && empty($_SESSION['user_id'])) {
    header("location:login.php");
}

if (isset($_POST['logout'])) {
    session_reset();
    session_unset();
    session_destroy();
    header("location:login.php");
}

$name = $_SESSION['username'];
$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == "POST" &&  isset($_POST['send'])) {
    $message = $_POST['message'];

    if (!empty($message)) {

        $message_sql_query = "INSERT INTO `messages` (sender_id , message) VALUES ('$user_id' , '$message')";

        try {
            mysqli_query($conn, $message_sql_query);
        } catch (mysqli_sql_exception $e) {
            echo $e;
        }

        //////asodijaskldjasojdklasjdijjk
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="h-screen w-screen bg-gray-50 flex">
        <aside class="bg-blue-600 min-w-64">
            <h1 class="font-bold text-3xl p-2 mt-4 text-white text-center"> <?php echo $name ?> 👋</h1>
            <div class="mt-8 grid px-4 gap-3">
                <a href="chat.php" class="p-1 rounded-xl font-semibold text-white hover:bg-white hover:text-black duration-500">Chat</a>
                <form method="post">
                    <button name="logout" class="p-1 rounded-xl font-semibold text-white hover:bg-white hover:text-black duration-500 w-full text-start cursor-pointer">Logout</button>
                </form>
            </div>
        </aside>
        <main class="flex-1 m-4 flex flex-col">
            <div class="bg-gray-200  w-full rounded-lg p-2 flex-1">

                <?php
                $sql_all_messages = "SELECT messages.* , users.name FROM messages 
                                 INNER JOIN users ON messages.sender_id = users.id 
                                 ORDER BY messages.id ASC";

                $result = mysqli_query($conn, $sql_all_messages);
                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {

                        $is_me = $row['sender_id'] == $user_id;
                        $msg = $row['message'];

                        echo '<div class="flex ' . ($is_me ? 'justify-end' : 'justify-start') . '">
                                <div class="' . ($is_me ? 'bg-blue-400' : 'bg-gray-400') . '">
                                    <span class="text-sm text-white">' . $row['name'] . '</span>
                                    <p>' . $row['message'] . '</p>
                                </div>
                            </div>';
                    }
                } else {
                    echo "no messages found.";
                }
                ?>

            </div>
            <form action="chat.php" method="post" class="flex p-2">
                <input type="text" class="border border-gray-500 flex-1 p-1 px-2" name="message">
                <button class="bg-blue-500 px-4 py-2 text-white cursor-pointer" name="send">Send</button>
            </form>
        </main>
    </div>
</body>

</html>
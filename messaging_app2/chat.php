<?php
require 'config.php';

// Only allow access if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$current_user_id = $_SESSION['user_id'];
$current_username = $_SESSION['username'];

// Fetch users (excluding current user)
$stmt = $conn->prepare("SELECT id, username FROM users WHERE id != ?");
$stmt->execute([$current_user_id]);
$users = $stmt->fetchAll();

// Fetch messages if receiver is selected
$messages = [];
$selected_user = isset($_GET['receiver_id']) ? (int)$_GET['receiver_id'] : 0;

if ($selected_user) {
    $stmt = $conn->prepare("
        SELECT m.*, u.username 
        FROM messages m 
        JOIN users u ON m.sender_id = u.id 
        WHERE (m.sender_id = ? AND m.receiver_id = ?) 
           OR (m.sender_id = ? AND m.receiver_id = ?)
        ORDER BY m.sent_at ASC
    ");
    $stmt->execute([$current_user_id, $selected_user, $selected_user, $current_user_id]);
    $messages = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Real-Time Chat</title>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-xl bg-white rounded-lg shadow-md p-6 space-y-4">
        <h2 class="text-xl font-semibold text-gray-700">Welcome, <?= htmlspecialchars($current_username) ?>!</h2>

        <!-- Chat Form -->
        <form id="chat-form" class="flex space-x-2">
            <select id="receiver_id" required onchange="updateChat(this.value)" class="w-1/3 p-2 border rounded">
                <option value="">Select a user</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $selected_user == $user['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="text" id="message" placeholder="Type your message" required
                class="flex-grow p-2 border rounded" />

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                Send
            </button>
        </form>

        <!-- Messages Box -->
        <h3 class="text-lg font-medium text-gray-600">Messages</h3>
        <div id="messages" class="h-80 overflow-y-scroll border border-gray-300 p-4 rounded space-y-2 bg-gray-50">
            <?php foreach ($messages as $msg): ?>
                <p>
                    <strong class="text-blue-700"><?= htmlspecialchars($msg['username']) ?>:</strong>
                    <?= htmlspecialchars($msg['message']) ?>
                    <em class="text-sm text-gray-400">(<?= $msg['sent_at'] ?>)</em>
                </p>
            <?php endforeach; ?>
        </div>

        <!-- Logout Button -->
        <div class="text-right">
            <a href="logout.php"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded inline-block">
               Logout
            </a>
        </div>
    </div>

    <script>
        const currentUserId = <?= json_encode($current_user_id) ?>;
    </script>
    <script src="script.js"></script>

</body>
</html>



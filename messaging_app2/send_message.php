<?php
session_start();
require 'config.php';
require 'vendor/autoload.php';

if (isset($_POST['receiver_id'], $_POST['message'], $_SESSION['user_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = (int)$_POST['receiver_id'];
    $message = trim($_POST['message']);

    // Save to DB
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$sender_id, $receiver_id, $message]);

    // Get sender username
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([$sender_id]);
    $sender_username = $stmt->fetchColumn();

    // Pusher trigger
    $pusher = new Pusher\Pusher(
        '50e87d771d20a81c9591',
        'bb5f1152e692998804ba',
        '1997059',
        ['cluster' => 'ap1', 'useTLS' => true]
    );

    $data = [
        'sender_id' => $sender_id,
        'username' => $sender_username,
        'message' => $message,
        'sent_at' => date('Y-m-d H:i:s'),
        'receiver_id' => $receiver_id
    ];

    $pusher->trigger('chat-channel', 'new-message', $data);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}

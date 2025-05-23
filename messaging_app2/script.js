const form = document.getElementById("chat-form");
const messageInput = document.getElementById("message");
const receiverSelect = document.getElementById("receiver_id");
const messagesDiv = document.getElementById("messages");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const receiverId = receiverSelect.value;
    const message = messageInput.value.trim();

    if (!receiverId || !message) return;

    const res = await fetch("send_message.php", {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ receiver_id: receiverId, message })
    });

    const data = await res.json();
    if (data.status === "success") {
        messageInput.value = '';
    }
});

function updateChat(receiverId) {
    if (receiverId) {
        window.location.href = `chat.php?receiver_id=${receiverId}`;
    }
}

// Pusher client
const pusher = new Pusher("50e87d771d20a81c9591", {
    cluster: "ap1"
});

const channel = pusher.subscribe("chat-channel");
channel.bind("new-message", function(data) {
    if ((data.sender_id === selectedReceiverId && data.receiver_id === currentUserId) ||
        (data.sender_id === currentUserId && data.receiver_id === selectedReceiverId)) {
        const p = document.createElement("p");
        p.innerHTML = `<strong>${data.username}:</strong> ${data.message} <em>(${data.sent_at})</em>`;
        messagesDiv.appendChild(p);
    }
});

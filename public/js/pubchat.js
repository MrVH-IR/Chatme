document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const textarea = document.querySelector('textarea[name="message"]');
    const chatHistory = document.getElementById('chat-history');
    let lastMessageId = 0;

    // Handle form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        sendMessage();
    });

    // Handle Enter key press
    textarea.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    function sendMessage() {
        const message = textarea.value.trim();
        if (!message) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: message })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    textarea.value = '';
                    appendMessage(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function appendMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message';
        messageDiv.innerHTML = `
            <strong>${message.user.name}:</strong>
            <p>${message.content}</p>
        `;
        chatHistory.appendChild(messageDiv);
        chatHistory.scrollTop = chatHistory.scrollHeight;
        lastMessageId = message.id;
    }

    // Fetch only new messages
    function fetchNewMessages() {
        fetch(`/chat/messages?after=${lastMessageId}`)
            .then(response => response.json())
            .then(messages => {
                messages.forEach(message => {
                    if (message.id > lastMessageId) {
                        appendMessage(message);
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Start polling for new messages
    setInterval(fetchNewMessages, 3000);

    fetch("{{ route('chat.status') }}")
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));

    // Example JavaScript code to dynamically add users to the user list
    const usersList = document.getElementById('users-list');
    const users = JSON.parse(document.getElementById('users-data').textContent); // Pass the users data from PHP to JavaScript

    usersList.innerHTML = ''; // Clear the current list
    users.forEach(user => {
        const userItem = document.createElement('div');
        userItem.classList.add('user-item', 'p-2', 'hover:bg-gray-100', 'cursor-pointer', 'border-b');
        userItem.dataset.userId = user.user_id;
        userItem.dataset.userName = `${user.name} ${user.lastname}`;
        userItem.innerHTML = `<i class="fas fa-user mr-2 text-[#fdcb6e]"></i> ${user.name} ${user.lastname}`;
        usersList.appendChild(userItem);
    });
});

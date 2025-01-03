document.addEventListener('DOMContentLoaded', function () {
    const usersList = document.getElementById('users-list');
    const chatArea = document.getElementById('chat-area');
    const chatForm = document.getElementById('chat-form');
    const notificationArea = document.getElementById('notification-area');
    let currentRoom = null;
    let currentReceiver = null;

    const invitePanelToggle = document.getElementById('invitePanelToggle');
    const invitePanel = document.getElementById('invitePanel');
    const inviteForm = document.getElementById('inviteForm');

    // Toggle invite panel
    invitePanelToggle.addEventListener('click', () => {
        invitePanel.classList.toggle('hidden');
    });

    // Handle invite form submission
    inviteForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const identifier = this.elements.identifier.value.trim();

        fetch('/api/invite/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ identifier: identifier })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Invitation sent successfully!');
                    invitePanel.classList.add('hidden');
                    this.reset();
                } else {
                    showNotification(data.error, 'error');
                }
            })
            .catch(error => {
                showNotification('Failed to send invitation', 'error');
            });
    });

    // Handle user selection
    usersList.addEventListener('click', function (e) {
        const userItem = e.target.closest('.user-item');
        if (!userItem) return;

        const userId = userItem.dataset.userId;
        const userName = userItem.dataset.userName;
        sendInvitation(userId, userName);
    });

    function sendInvitation(userId, userName) {
        fetch('/chat/private/invite', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ receiver_id: userId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Invitation sent to ${userName}`);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Handle incoming invitations
    const invitationChannel = Echo.private(`invitations.${userId}`);
    invitationChannel.listen('InvitationReceived', (data) => {
        showInvitationNotification(data);
    });

    function showInvitationNotification(data) {
        const notification = document.createElement('div');
        notification.className = 'bg-white p-4 rounded shadow-lg mb-2';
        notification.innerHTML = `
            <p>${data.senderName} wants to chat with you</p>
            <button class="accept bg-green-500 text-white px-2 py-1 rounded mr-2">Accept</button>
            <button class="reject bg-red-500 text-white px-2 py-1 rounded">Reject</button>
        `;

        notificationArea.appendChild(notification);

        notification.querySelector('.accept').onclick = () => handleInvitation(data.invitationId, true);
        notification.querySelector('.reject').onclick = () => handleInvitation(data.invitationId, false);
    }

    function handleInvitation(invitationId, accept) {
        fetch('/chat/private/handle-invite', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                invitation_id: invitationId,
                accept: accept
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success && accept) {
                    initializeChat(data.invitation.room_id, data.invitation.sender_id);
                }
            });
    }

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification p-4 rounded-lg shadow-lg mb-2 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
        notification.textContent = message;
        notificationArea.appendChild(notification);
        setTimeout(() => notification.remove(), 5000);
    }
});

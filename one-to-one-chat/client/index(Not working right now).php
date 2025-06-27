<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One-to-One Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Socket.io client library -->
    <script src="/socket.io/socket.io.js"></script>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #f5f5f5;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    .sidebar {
        width: 30%;
        background-color: #fff;
        border-right: 1px solid #ddd;
        padding: 20px;
        overflow-y: auto;
    }

    .sidebar h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .search-bar {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .contact {
        display: flex;
        align-items: center;
        padding: 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .contact:hover {
        background-color: #f0f0f0;
    }

    .contact img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .contact-info {
        flex: 1;
    }

    .contact-name {
        font-weight: bold;
    }

    .chat-window {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: #fff;
    }

    .chat-header {
        padding: 20px;
        border-bottom: 1px solid #ddd;
        display: flex;
        align-items: center;
    }

    .chat-header h3 {
        flex: 1;
    }

    .status {
        color: green;
        font-size: 14px;
    }

    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        overflow-x: hidden;
        /* Prevent horizontal overflow */
        width: 100%;
        /* Ensure the container takes the full width of its parent */
        box-sizing: border-box;
        /* Include padding in width calculation */
    }

    .message-container {
        display: flex;
        margin-bottom: 15px;
        width: 100%;
        /* Ensure the container takes full width */
        max-width: 100%;
        /* Prevent the container from exceeding the parent width */
        overflow-x: hidden;
        /* Prevent horizontal overflow */
        box-sizing: border-box;
        /* Include padding in width calculation */
    }

    .message {
        padding: 10px;
        border-radius: 10px;
        min-width: 30%;
        /* Minimum width for short messages */
        max-width: 50%;
        /* Maximum width for longer messages */
        overflow-wrap: break-word;
        /* Wrap text if it exceeds max-width */
        height: auto;
        /* Allow height to adjust dynamically */
        width: auto;
        /* Let the width adjust within min and max */
        box-sizing: border-box;
        /* Ensure padding is included in width */
        white-space: normal;
        /* Ensure text wraps normally */
        word-break: break-all;
        /* Break long words to prevent overflow */
    }

    .message.sent {
        background-color: #007bff;
        color: white;
        margin-left: auto;
    }

    .message.received {
        background-color: #333;
        color: white;
        margin-right: auto;
    }

    .chat-input {
        display: flex;
        padding: 20px;
        border-top: 1px solid #ddd;
    }

    .chat-input input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-right: 10px;
    }

    .chat-input button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .chat-input button:hover {
        background-color: #0056b3;
    }

    /* Login overlay */
    .login-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box {
        background: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .login-box input {
        padding: 10px;
        margin: 10px 0;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .login-box button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .login-box button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <!-- Login overlay -->
    <div id="login-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center">
        <div class="bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Enter Your Username</h2>
            <input id="username-input" type="text" placeholder="Your username"
                class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">
            <button onclick="login()"
                class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition">Login</button>
        </div>
    </div>

    <!-- Main chat container -->
    <div id="chat-container" class="flex h-screen" style="display: none;">
        <!-- Sidebar -->
        <div class="w-1/3 bg-white shadow-md p-6 overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Messaging</h2>
                <div class="relative">
                    <button class="text-gray-600 font-medium">Agents</button>
                </div>
            </div>
            <input type="text" placeholder="Search in dashboard..."
                class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mb-6">
            <div id="contact-list" class="space-y-3">
                <!-- Contacts will be dynamically added here -->
            </div>
        </div>

        <!-- Chat window -->
        <div class="flex-1 flex flex-col bg-gray-50">
            <div class="bg-white shadow-sm p-4 flex items-center justify-between border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <img src="https://icons.veryicon.com/png/o/miscellaneous/two-color-icon-library/user-286.png"
                        alt="Profile" class="w-10 h-10 rounded-full">
                    <div>
                        <h3 id="chat-with" class="text-xl font-semibold text-gray-800">Select a user to chat</h3>
                        <span class="text-green-500 text-sm">Online</span>
                    </div>
                </div>
            </div>
            <div id="chat-messages" class="flex-1 p-6 overflow-y-auto relative">
                <!-- Date separator -->
                <div class="text-center my-4">
                    <span class="bg-gray-200 text-gray-600 text-sm px-4 py-1 rounded-full">Today</span>
                </div>
                <!-- Messages will be dynamically added here -->
            </div>
            <div class="p-4 bg-white border-t border-gray-200 flex items-center space-x-3">
                <input id="message-input" type="text" placeholder="Type your message"
                    class="flex-1 p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button onclick="sendMessage()"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
    // Connect to the Socket.io server
    const socket = io('http://localhost:3000');

    let currentUser = null;
    let currentChat = null;
    let latestMessages = {};

    function login() {
        const usernameInput = document.getElementById('username-input');
        const username = usernameInput.value.trim();
        if (username === '') return;

        currentUser = username;
        socket.emit('login', username);

        document.getElementById('login-overlay').style.display = 'none';
        document.getElementById('chat-container').style.display = 'flex';
    }

    socket.on('updateUsers', (users) => {
        const contactList = document.getElementById('contact-list');
        contactList.innerHTML = '';

        users.forEach((user) => {
            if (user !== currentUser) {
                const contactDiv = document.createElement('div');
                contactDiv.classList.add('contact');
                contactDiv.onclick = () => openChat(user);
                contactDiv.innerHTML = `
                        <img src="https://icons.veryicon.com/png/o/miscellaneous/two-color-icon-library/user-286.png" alt="Profile">
                        <div class="contact-info">
                            <p class="contact-name">${user}</p>
                            <p class="last-message">${latestMessages[user] || 'Start chatting...'}</p>
                        </div>
                    `;
                contactList.appendChild(contactDiv);
            }
        });
    });

    function openChat(contactName) {
        currentChat = contactName;
        document.getElementById('chat-with').textContent = contactName;
        socket.emit('joinRoom', {
            fromUser: currentUser,
            toUser: contactName
        });
    }

    function sendMessage() {
        const input = document.getElementById('message-input');
        const messageText = input.value.trim();
        if (messageText === '' || !currentChat) return;

        socket.emit('sendMessage', {
            fromUser: currentUser,
            toUser: currentChat,
            message: messageText,
        });

        input.value = '';
    }

    socket.on('loadMessages', (messages) => {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.innerHTML =
            '<div class="text-center my-4"><span class="bg-gray-200 text-gray-600 text-sm px-4 py-1 rounded-full">Today</span></div>';

        messages.forEach((msg) => {
            const messageDiv = document.createElement('div');
            const isSent = msg.sender === currentUser;
            messageDiv.classList.add('message-container', isSent ? 'justify-end' : 'justify-start');
            messageDiv.innerHTML = `
                    <div class="message ${isSent ? 'sent' : 'received'}">
                        <p>${msg.text}</p>
                        <small>${msg.time}</small>
                    </div>
                `;
            chatMessages.appendChild(messageDiv);

            const contact = isSent ? currentChat : msg.sender;
            latestMessages[contact] = msg.text;
        });

        socket.emit('updateUsers', Object.keys(latestMessages));
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    socket.on('receiveMessage', (msg) => {
        const chatMessages = document.getElementById('chat-messages');
        const messageDiv = document.createElement('div');
        const isSent = msg.sender === currentUser;
        messageDiv.classList.add('message-container', isSent ? 'justify-end' : 'justify-start');
        messageDiv.innerHTML = `
                <div class="message ${isSent ? 'sent' : 'received'}">
                    <p>${msg.text}</p>
                    <small>${msg.time}</small>
                </div>
            `;
        chatMessages.appendChild(messageDiv);

        const contact = isSent ? currentChat : msg.sender;
        latestMessages[contact] = msg.text;
        socket.emit('updateUsers', Object.keys(latestMessages));
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    document.getElementById('message-input').addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
    });
    </script>
</body>

</html>
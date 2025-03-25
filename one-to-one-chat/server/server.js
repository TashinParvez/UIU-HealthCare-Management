const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const path = require('path');
const fs = require('fs');

const app = express();
const server = http.createServer(app);
const io = new Server(server); // Initialize io here

// File to store chat history
const chatHistoryFile = path.join(__dirname, 'chatHistory.json');

// Initialize chat history
let messages = {};
if (fs.existsSync(chatHistoryFile)) {
    messages = JSON.parse(fs.readFileSync(chatHistoryFile, 'utf8'));
}

app.use(express.static(path.join(__dirname, '../client')));

const users = {};

io.on('connection', (socket) => {
    console.log('A user connected:', socket.id);

    socket.on('login', (username) => {
        users[username] = socket.id;
        socket.username = username;
        console.log(`${username} logged in with socket ID: ${socket.id}`);
        io.emit('updateUsers', Object.keys(users));
    });

    socket.on('joinRoom', ({ fromUser, toUser }) => {
        const room = [fromUser, toUser].sort().join('-');
        socket.join(room);
        console.log(`${fromUser} joined room: ${room}`);

        const roomMessages = messages[room] || [];
        socket.emit('loadMessages', roomMessages);
    });

    socket.on('sendMessage', ({ fromUser, toUser, message }) => {
        const room = [fromUser, toUser].sort().join('-');
        const newMessage = {
            text: message,
            sender: fromUser,
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        };

        if (!messages[room]) {
            messages[room] = [];
        }
        messages[room].push(newMessage);

        // Save to file
        fs.writeFileSync(chatHistoryFile, JSON.stringify(messages, null, 2));

        io.to(room).emit('receiveMessage', newMessage);
    });

    socket.on('disconnect', () => {
        if (socket.username) {
            delete users[socket.username];
            console.log(`${socket.username} disconnected`);
            io.emit('updateUsers', Object.keys(users));
        }
    });
});

const PORT = 4000;
server.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});

// cd one-to-one-chat/server
// npm install express socket.io
// node server.js
// Go to http://localhost:4000 in your browser
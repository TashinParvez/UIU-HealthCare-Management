const express = require('express');
const http = require('http');
const WebSocket = require('ws');
const mysql = require('mysql2/promise');
const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// MySQL connection configuration (match with Database_connection.php)
const dbConfig = {
  host: 'localhost', // Update with your MySQL host
  user: 'your_username', // Update with your MySQL username
  password: 'your_password', // Update with your MySQL password
  database: 'your_database' // Update with your MySQL database name
};

// WebSocket connection handling
const clients = new Set();
wss.on('connection', (ws) => {
  clients.add(ws);
  console.log('New WebSocket connection');
  ws.on('close', () => {
    clients.delete(ws);
    console.log('WebSocket connection closed');
  });
});

// Endpoint to submit emergency alerts
app.post('/submit_alert', async (req, res) => {
  const { patient_situation = '', additional_details = '', address, additional_location_info = '' } = req.body;

  if (!address) {
    return res.status(400).json({ success: false, message: 'Address is required' });
  }

  try {
    const connection = await mysql.createConnection(dbConfig);
    const [result] = await connection.execute(
      `
      INSERT INTO emergency_alerts (patient_situation, additional_details, address, additional_location_info)
      VALUES (?, ?, ?, ?)
      `,
      [patient_situation, additional_details, address, additional_location_info]
    );

    const alertData = {
      id: result.insertId,
      patient_situation,
      additional_details,
      address,
      additional_location_info,
      created_at: new Date().toLocaleString('en-US', { timeZone: 'Asia/Dhaka' })
    };

    // Broadcast to all WebSocket clients
    clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify(alertData));
      }
    });

    await connection.end();
    res.json({ success: true, message: 'Alert submitted successfully' });
  } catch (err) {
    console.error('Error inserting alert:', err);
    res.status(500).json({ success: false, message: 'Failed to submit alert' });
  }
});

// Serve static files (if needed, e.g., for the sound file)
app.use(express.static('public'));

server.listen(8080, () => {
  console.log('Server running on http://localhost:8080');
});
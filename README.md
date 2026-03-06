# 🏥 UIU Health Care Management

A web-based healthcare management system designed for **United International University (UIU)**.  
This project helps **patients** book appointments, **doctors** manage visits and schedules, and **admins** monitor the overall healthcare workflow.

<p>
  <a href="https://github.com/TashinParvez/UIU-HealthCare-Management/stargazers">
    <img src="https://img.shields.io/github/stars/TashinParvez/UIU-HealthCare-Management?style=for-the-badge" alt="Stars" />
  </a>
  <a href="https://github.com/TashinParvez/UIU-HealthCare-Management/network/members">
    <img src="https://img.shields.io/github/forks/TashinParvez/UIU-HealthCare-Management?style=for-the-badge" alt="Forks" />
  </a>
  <a href="https://github.com/TashinParvez/UIU-HealthCare-Management/issues">
    <img src="https://img.shields.io/github/issues/TashinParvez/UIU-HealthCare-Management?style=for-the-badge" alt="Issues" />
  </a>
  <a href="https://github.com/TashinParvez/UIU-HealthCare-Management/commits/main">
    <img src="https://img.shields.io/github/last-commit/TashinParvez/UIU-HealthCare-Management?style=for-the-badge" alt="Last Commit" />
  </a>
  <img src="https://img.shields.io/github/languages/top/TashinParvez/UIU-HealthCare-Management?style=for-the-badge" alt="Top Language" />
</p>

<p>
  <img src="https://img.shields.io/badge/PHP-Backend-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/JavaScript-Frontend-F7DF1E?style=flat-square&logo=javascript&logoColor=black" alt="JavaScript" />
  <img src="https://img.shields.io/badge/HTML-Markup-E34F26?style=flat-square&logo=html5&logoColor=white" alt="HTML5" />
  <img src="https://img.shields.io/badge/CSS-Styling-1572B6?style=flat-square&logo=css3&logoColor=white" alt="CSS3" />
  <img src="https://img.shields.io/badge/Socket.IO-Chat-010101?style=flat-square&logo=socketdotio&logoColor=white" alt="Socket.IO" />
  <img src="https://img.shields.io/badge/Express-Server-000000?style=flat-square&logo=express&logoColor=white" alt="Express" />
</p>

</div>

---

## 📖 Overview

**UIU Health Care Management** is a role-based healthcare platform built to streamline medical service management inside a university environment. It centralizes appointment booking, doctor-patient interaction, emergency-related features, and administrative monitoring in one system.

The project is organized into separate modules for **authentication**, **patient activities**, **doctor workflows**, **admin operations**, and **real-time chat**.

---

## ✨ Key Features

- 👤 **Role-based system**
  - Admin
  - Doctor
  - Patient

- 📅 **Appointment management**
  - Book appointments
  - View appointment records
  - Track previous history

- 💳 **Payment handling**
  - Cash payment
  - Card payment
  - Mobile banking support

- 🩺 **Doctor dashboard**
  - View today’s patients
  - View upcoming appointments
  - Manage patient-related data

- 🧑‍💼 **Admin dashboard**
  - Monitor doctors
  - View traffic/statistics
  - Emergency alerts management

- 📚 **Patient services**
  - Booking system
  - Appointment records
  - FAQ
  - Previous medical/appointment history
  - Profile management

- 💬 **One-to-one chat module**
  - Separate chat service using **Node.js + Express + Socket.IO**

- 🚨 **Emergency support**
  - Emergency alerts / emergency-related pages

- 📝 **Additional utilities**
  - Blog-related pages
  - Doctor listing
  - Profile pages
  - Auth flow

---

## 🗂️ Project Structure

```bash
UIU-HealthCare-Management/
│
├── admin/                  # Admin panel and dashboard
├── auth/                   # Authentication modules
├── doctor/                 # Doctor dashboard and related pages
├── patient/                # Patient booking, records, profile, FAQ
├── one-to-one-chat/        # Real-time chat module
├── emergency/              # Emergency-related pages
├── Includes/               # Shared reusable components
├── Hero/                   # UI/landing related files
├── Others/                 # Supporting files
├── database/               # Database-related folder
│
├── README.md
├── structure.md
├── gitCommand.md
└── better_Comment.md
```

---

## 🛠️ Tech Stack

### Backend

- PHP

### Frontend

- HTML
- CSS
- JavaScript

### Database

- MySQL / MariaDB

### Real-time Communication

- Node.js
- Express.js
- Socket.IO

---

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- **XAMPP / Laragon / WAMP** or any PHP local server
- **PHP**
- **MySQL / MariaDB**
- **Node.js & npm** _(for the chat module only)_

---

## ⚙️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/TashinParvez/UIU-HealthCare-Management.git
cd UIU-HealthCare-Management
```

### 2. Move the project to your local server directory

For example, if you use XAMPP:

```bash
C:/xampp/htdocs/UIU-HealthCare-Management
```

### 3. Configure the database connection

Update your database credentials in the project’s PHP database/config connection files.

Example values:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "uiu_healthcare";
```

### 4. Set up the database

Create a MySQL database, for example:

```sql
CREATE DATABASE uiu_healthcare;
```

Then import your project SQL file if you have one available.
If your SQL schema is not yet added to the repository, create/import the required tables manually before running the app.

### 5. Start Apache and MySQL

Run both services from your local environment.

### 6. Open the project in your browser

```bash
http://localhost/UIU-HealthCare-Management/
```

---

## 💬 Chat Module Setup

The repository also contains a separate **one-to-one chat** service.

### Install dependencies

```bash
cd one-to-one-chat
npm install
```

### Run the chat server

```bash
node server/server.js
```

Then open the relevant client/chat page from the project.

---

## 👥 User Roles

### Admin

- Manage doctor-related data
- View dashboards and statistics
- Monitor emergency alerts
- Review system activity

### Doctor

- View patient appointments
- Access dashboard insights
- Manage upcoming consultations
- Interact with patient-related records

### Patient

- Book appointments
- View records/history
- Access FAQ and profile features
- Read blog/information pages

---

## 📌 Current Notes

- The project is under active academic/development progress.
- Some modules may still be experimental or incomplete.
- The chat module is separated from the main PHP application.
- Database setup documentation can be improved further by adding a full SQL schema to the repository.

---

## 🧭 Future Improvements

- Full database schema export
- Better environment/config setup guide
- Improved UI consistency
- Stronger validation and security checks
- Full deployment documentation
- Screenshots and demo section

---

## 🤝 Contributing

Contributions are welcome.

1. Fork the repository
2. Create a new feature branch
3. Commit your changes
4. Push to your branch
5. Open a Pull Request

---

## 📚 Helpful Project References

- [Project Structure](https://github.com/TashinParvez/UIU-HealthCare-Management/blob/main/structure.md)
- [Useful Git Commands](https://github.com/TashinParvez/UIU-HealthCare-Management/blob/main/gitCommand.md)

---

## 🌟 Contributors

A big thanks to all the people who contribute to this project!

[![Contributors](https://contrib.rocks/image?repo=TashinParvez/UIU-HealthCare-Management)](https://github.com/TashinParvez/UIU-HealthCare-Management/graphs/contributors)

---

## 📬 Contact

For academic collaboration, improvements, or project discussion, please open an issue in this repository.

---




### We are following this file structure : [LINK](https://github.com/TashinParvez/UIU-HealthCare-Management/blob/main/structure.md?plain=1)

### Useful Git Commands : [LINK](https://github.com/TashinParvez/UIU-HealthCare-Management/blob/main/gitCommand.md)

### File Path Problem Solve: [LINK](https://github.com/TashinParvez/UIU-Web-Programming/blob/main/Others/FilePath.md)

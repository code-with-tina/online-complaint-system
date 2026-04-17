📝 Online Complaint Management System

 📌 Overview

The **Online Complaint Management System** is a web-based application developed using PHP and MySQL that allows users to register complaints and track their status. It also provides an admin dashboard for managing, updating, and resolving complaints efficiently.



🚀 Features

👤 User Module

📝 Submit complaints
🔍 Track complaint status
🔐 User login & logout system

🔧 Admin Module

🔐 Secure admin login
📊 Dashboard with complaint statistics
✔️ Update complaint status (Pending, In Progress, Resolved)
❌ Delete complaints
🔎 Search and filter complaints


🛠️ Tech Stack

**Frontend:** HTML, CSS, Bootstrap
**Backend:** PHP
**Database:** MySQL
**Server:** XAMPP (Local Development)


📂 Project Structure

online-complaint-system/
│
├── index.php
├── db.php
│
├── admin/
│   ├── admin_login.php
│   ├── dashboard.php
│   ├── update_status.php
│   ├── delete.php
│
├── user/
│   ├── login.php
│   ├── logout.php
│   ├── submit_complaint.php
│   ├── update.php
│
├── css/
│   └── style.css

⚙️ Setup Instructions

1. Install XAMPP and start Apache & MySQL
2. Place project folder inside:

   htdocs/
3. Import database in phpMyAdmin
4. Update `db.php` with your database credentials
5. Run project:

   http://localhost/online-complaint-system
   
 📸 Screenshots

![Home](screenshots/home.png)
![Dashboard](screenshots/dashboard.png)

💡 Future Enhancements

📧 Email notifications for complaint updates
📱 Fully responsive UI improvements
🔔 Real-time complaint tracking


👩‍💻 Author

**Tina Naik**
🔗 GitHub: https://github.com/code-with-tina


## ⭐ If you like this project

Give it a star ⭐ on GitHub!

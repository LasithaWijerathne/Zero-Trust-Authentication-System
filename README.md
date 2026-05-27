# Context-Aware Zero-Trust Authentication System

A secure, enterprise-level authentication system built with PHP and MySQL that implements modern Zero-Trust architecture principles. 

## 🛡️ Core Features
* **Context-Aware Authentication:** Goes beyond just checking passwords. It evaluates the context of every login attempt.
* **Environment Fingerprinting:** Automatically detects and analyzes the user's IP Address, Operating System, and Device details (User-Agent).
* **Automated Threat Prevention:** Blocks access and alerts the system if a login attempt comes from an unrecognized IP or Device, even if the user provides the correct password.
* **Secure Data Handling:** Passwords are securely hashed before being stored in the database.
* **Session Management:** Securely passes authenticated context to a protected dashboard.

## 💻 Technologies Used
* **Backend:** PHP
* **Database:** MySQL
* **Frontend:** HTML5, CSS3

## 🚀 How to Run Locally
1. Clone this repository to your local machine (inside the `htdocs` directory if using XAMPP).
2. Import the provided `zero_trust_auth.sql` file into your MySQL database using phpMyAdmin.
3. Access the system via `http://localhost/zero_trust/login.php`


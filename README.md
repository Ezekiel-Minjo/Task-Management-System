# Task Management System

## 💼 Overview

This is a Task Management System built using **Laravel (PHP)** and **Vue.js**.  
It allows administrators to manage users and assign tasks with deadlines, while users can view, update, and receive notifications for their tasks.

---

## 🚀 Features

-   **Administrator**
    -   Add, edit, delete users
    -   Assign tasks with deadlines
-   **Users**
    -   View assigned tasks
    -   Update task status: Pending, In Progress, Completed
    -   Receive email notifications on new assignments
-   Clean and modern UI with Vue.js

---

## ⚙️ Tech Stack

-   Laravel (PHP framework)
-   Vue.js
-   MySQL (using XAMPP locally)

---

## 🗂️ Installation

### Prerequisites

-   PHP >= 8.1
-   Composer
-   Node.js & npm
-   MySQL (e.g., XAMPP)

### Steps

1️⃣ **Clone or extract**

git clone <your-repo-url>
or extract this zip file.

2️⃣ **Install PHP dependencies**

composer install

3️⃣ **Install Node dependencies**

npm install

4️⃣ **Copy `.env` file**

cp .env.example .env

5️⃣ **Set up your database**

-   Create a database (e.g., `task_management`)
-   Import `task_management.sql` provided in this zip

6️⃣ **Generate application key**

php artisan key:generate

bash
Copy
Edit

7️⃣ **Update `.env` file**

DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=

scss
Copy
Edit

(Adjust DB credentials if different.)

8️⃣ **Run migrations (if needed)**

php artisan migrate

pgsql
Copy
Edit

9️⃣ **Start the server**

php artisan serve

markdown
Copy
Edit

10️⃣ **Compile assets**

npm run dev

yaml
Copy
Edit

---

## 💬 Usage

-   Admin can manage users and assign tasks from the dashboard.
-   Users can view and update task statuses on their dashboard.
-   Email notifications will be sent when a task is assigned (configure mail settings in `.env`).

---

## 🗄️ SQL Dump

**File**: `task_management.sql`  
Import via phpMyAdmin or:

mysql -u root -p task_management < task_management.sql

yaml
Copy
Edit

---

## ✉️ Contact

For any questions, email: [your-email@example.com]

---

## ✅ License

This project is for demonstration and internship assessment purposes.

---

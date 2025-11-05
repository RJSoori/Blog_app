# Blog App

A minimal blog application built with PHP, MySQL, and HTML/CSS.

## 🚀 Live Demo

Go check it out! The app is hosted live on InfinityFree:

**[https://sooris-blog.rf.gd](https://sooris-blog.rf.gd)**

## Features

- User registration and login
- Create, edit, delete personal posts
- View all posts from all users
- Dark minimal dashboard UI
- Single-page view for individual posts

## Technologies Used

- PHP (with prepared statements to prevent SQL injection)
- MySQL
- HTML & CSS (Dark Minimal Theme)
- Git for version control

## Setup

1.  **Clone the repository:**
    ```sh
    git clone [https://github.com/RJSoori/Blog_app.git](https://github.com/RJSoori/Blog_app.git)
    ```
2.  **Import Database:** Import the `database.sql` file into your local MySQL server (e.g., via phpMyAdmin).
3.  **Update Credentials:**
    - **For Local:** Update `db.php` with your local database credentials.
    - **For Production:** This project uses a `db.php` connection for simplicity, but for a secure deployment, it's recommended to use environment variables (`.env`) which are excluded via `.gitignore`.
4.  **Run Server:** Open the project in your local server (XAMPP, WAMP, MAMP, etc.).

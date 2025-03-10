# University Online Learning System

## Project Overview
This **University Online Learning System** is a web-based platform designed to help students and lecturers manage online courses, assignments, and learning materials. The system provides an interactive and user-friendly interface for academic activities.

## Features
- **User Roles:** Separate access for students and lecturers.
- **Course Management:** Lecturers can create and manage courses.
- **Assignment Submission:** Students can submit assignments online.
- **Material Sharing:** Lecturers can upload course materials (PDFs, videos, etc.).
- **Announcements & Notifications:** Important updates from lecturers.
- **Basic Authentication:** Users need to log in to access their dashboard.
- **Responsive Design:** Works on both desktop and mobile devices.

## Technologies Used
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** phpMyAdmin (MySQL)
- **Styling Framework:** Bootstrap (for layout and UI design)

## Installation & Setup
1. **Download the project files** and extract them.
2. **Set up the database:**
   - Open **phpMyAdmin**.
   - Create a new database (e.g., `university_lms`).
   - Import the provided SQL file (`assignment3.sql`).
3. **Configure database connection in `config.php`:**
   ```php
   $host = "localhost";
   $user = "root"; // Change if necessary
   $password = "";
   $database = "university_lms";

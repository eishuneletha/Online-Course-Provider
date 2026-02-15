# Online Course Provider Platform

## Overview
The Online Course Provider Platform is a full-stack web application that enables instructors to create and sell online courses while allowing students to browse, enroll, and access course content securely. The system provides role-based functionality, secure authentication, and responsive user interfaces to support scalable online learning.

This project was developed using pure PHP for backend logic, MySQL for database management, and Bootstrap with JavaScript for responsive front-end design.

---

## Features

### User Features
- User registration and secure login authentication
- Browse available courses
- Enroll in courses
- Access enrolled course content
- Comment and Rate courses

### Instructor Features
- Create and manage courses
- Upload course content
- Manage student enrollments
- Reply student feedbacks

### Admin/System Features
- Role-based access control
- Secure session management
- Database-driven dynamic content
- Responsive design for mobile and desktop devices

---

## Technologies Used

**Frontend**
- HTML5
- CSS3
- Bootstrap
- JavaScript

**Backend**
- PHP (Pure PHP, no frameworks)

**Database**
- MySQL

**Development Tools**
- VS Code
- XAMPP / Localhost environment

---

## System Architecture

The platform follows a traditional client-server architecture:

- Frontend handles user interaction and UI rendering
- Backend PHP processes business logic, authentication, and database operations
- MySQL stores user data, course information, and enrollment records

---

## Installation Guide

### Prerequisites
- XAMPP, WAMP, or any PHP local server
- PHP 7.0+
- MySQL
- Web browser

### Steps

1. Clone the repository 'https://github.com/eishuneletha/Online-Course-Provider.git'
2. Move project folder to your server directory
3. Install XAMPP for hosting the project
4. Import the database
- Open phpMyAdmin
- Create a new database (example: online_course_db)
- Import the provided `.sql` file
5.  Configure database connection
    Edit: config.php 
    Update:host, username, password, database name
6. Run the project
  Open browser: http://localhost/'project-folder-name'


This project was developed using the Waterfall model:

1. Requirements analysis  
2. System design  
3. Implementation  
4. Testing  
5. Deployment  

---

## Security Features

- Password authentication
- Session management
- Role-based access control
- Protected routes

---

## Learning Outcomes

This project demonstrates:

- Full-stack web development using PHP, Bootstrap and MySQL
- Database design and integration
- Authentication and authorization implementation
- Responsive front-end development
- Structured software development lifecycle

---

## Future Improvements

- Payment gateway integration
- Video hosting support
- REST API integration
- Improved UI/UX design
- Admin analytics dashboard

---

## Author

Ei Shune Le Tha  
LinkedIn: https://linkedin.com/in/eishunele-tha



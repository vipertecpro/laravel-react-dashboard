## Laravel-React Dashboard: A Full-Stack Web Application for Book Reviews and User Management

## Introduction
This project is built using Laravel and React, serving as the backend for a 3-tier application architecture. The frontend application is developed using Next.js and can be found [here](https://github.com/vipertecpro/nextjs-app-for-laravel-apis). This backend application provides a comprehensive dashboard for managing book reviews and user roles, as well as a set of APIs to seamlessly connect with the Next.js frontend.

## Features
- **User Authentication**: Secure login, registration, and password management.
- **JWT Authentication for APIs**: Provides JWT-authenticated APIs for secure communication with the frontend application.
- **Books**: Complete CRUD (Create, Read, Update, Delete) operations for managing books.
- **Book Reviews**: Allows users to view and remove book reviews, as well as change their status.
- **User Roles and Permissions**: Admin can assign roles and permissions to users.
- **Global Settings**: Manage global settings like themes and notifications.
- **State Management**:  Inertia.js for client-side state management.
- **UI Components**:  Utilizes Headless UI and Hero Icons for a sleek user interface.

## Technologies Used
- **Backend**: Laravel
- **Frontend**: React.js
- **Database**: MySQL
- **Styling**: Tailwind CSS and Headless UI
- **Package Manager**: npm
- **Build Tool**: Vite
- **HTTP Client**: Axios
- **UI Alerts**: SweetAlert2

## Code Highlights
- **Inertia.js**: For seamless navigation without full page reloads.

## Future Enhancements
- Implement real-time notifications.
- Add social media login options.

## How to Run
1. Clone the repository.
2. Run `composer install` and `npm install`.
3. Set up your `.env` file.
4. Run `php artisan serve` and `npm run dev`.

****************************************************************************************** 
CS234 - Database and Web Development
Semester project
***********************************************************************************************

# SwiftNotes Web Application

SwiftNotes is a web application designed for easy note-taking, developed in 2023 as a project. The application is powered by a MySQL database and written in PHP for server-side scripting. It allows registered users to log in, create, and delete notes securely. The project folder, named "project," includes the final database file "project.sql" for delivery.


## Project Requirements

### MySQL Database:

- **Database:** `project`
- **Tables:** `users` (for registered users), at least two more tables in a one-to-many relationship.
- **Admin CRUD functionality:** Add, Retrieve, Update, Delete records.

### Login Form:

- First page for users.
- Username and password required.
- Redirects users not logged in to the login page.
- Error message if user is not in system, or credentials are incorrect.
  ![login page](https://github.com/ggboyles/projects/assets/152362542/f56fe488-5dbe-45f7-98e6-4f41596454a3)


### Register Form:

- Allows users to register.
- Asks for a unique username and password.
- Error message if password and confirm password are not the same.
- Error message if username is taken already.

### Home Page:

- First page for registered users.
- Access restricted for non-logged-in users.
- Allows you to create notes and delete them.

### Other Pages:

- About page simply describes the web application.
- Contact page gives email contact information.
- Access restricted for non-logged-in users.

## Server-side Scripting

- **PHP:**
  - Handles server-side scripting.

- **PHP PDO:**
  - Accesses the database and executes queries.

- **Form Validation:**
  - Uses regular expressions.
  - Authenticates registered users.
  - Hashes passwords using bcrypt.

- **Session Management:**
  - Prevents direct access to pages without logging in.

## Presentation

- **Styling:**
  - Uses the W3.CSS framework for site styling.

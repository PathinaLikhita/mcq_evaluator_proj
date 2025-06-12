
# MCQ Evaluator System

## Project Overview
The **MCQ Evaluator System** is a web-based application designed to simplify quiz management and enhance the learning experience. It allows users to register, log in, and take subject-specific quizzes while automatically evaluating their performance. The system is suitable for academic and professional environments where efficient assessment tools are required.

---

## Features
- **User Authentication**: Secure registration and login system.
- **Subject Selection**: Users can choose from a variety of topics, including:
  - C++
  - Python
  - SQL
  - HTML & CSS
  - Data Structures and Algorithms
- **Dynamic Quiz Interface**: Real-time question answering with user-friendly navigation.
- **Quiz Evaluation**: Instant scoring upon submission.
- **Admin Controls**: View and manage user details and quiz submissions.

---

## Project Structure

### Frontend Files
- **`Index.html`**: Main landing page of the application.
- **Quiz Pages**: Separate HTML files for each subject quiz.
  - `cppquiz.html`, `pythonquiz.html`, `sqlquiz.html`, etc.
- **`Rules.html`**: Displays the guidelines and rules before starting a quiz.
- **`Subject_selection.html`**: Facilitates subject selection for users.

### Backend Files
- **`login.php`**: Manages user authentication.
- **`register.php`**: Handles new user registrations.
- **`quiz.php`**: Processes quiz submissions and calculates scores.
- **`view_login_details.php`**: Displays login details for admin review.
- **`view_registered_users.php`**: Lists all registered users.

### Database
- **`setup.sql`**: SQL script for initializing the database schema.

### Media Assets
- **Logo**: `QuizMate_WhiteLogo.png`
- **Backgrounds and Banners**: `Quizbg.jpg`, `banner.png`

---

## Installation Guide

### Prerequisites
- **XAMPP** or equivalent server for running PHP and MySQL.
- **Web Browser** to access the application.
- Basic knowledge of PHP, MySQL, and web development.

### Steps to Install
1. **Download the Project**: Extract the provided zip file.
2. **Set Up XAMPP**:
   - Place the project folder in the `htdocs` directory of your XAMPP installation.
   - Start the Apache and MySQL services.
3. **Import Database**:
   - Open `phpMyAdmin` (via XAMPP).
   - Import the `setup.sql` file to create the required tables.
4. **Launch the Application**:
   - Open your browser and navigate to `http://localhost/mcq_evaluator_proj-main/Frontend-MCQ.html`.

---

## Usage Instructions

1. **Register**: Create a new account to access the quizzes.
2. **Log In**: Use your credentials to log in to the platform.
3. **Select Subject**: Choose your desired subject from the subject selection page.
4. **Start Quiz**: Answer the questions and submit the quiz.
5. **View Results**: Review your score immediately after submission.

---

## Planned Enhancements
- **Timer Integration**: Add a countdown timer for quizzes.
- **Responsive Design**: Make the UI adaptable to mobile and tablet devices.
- **Enhanced Security**: Implement password hashing and session handling.
- **User Profiles**: Allow users to track their quiz history and progress.

---

## Developer Contact
- **Developer**: Pathina Likhita  
- **Email**: likhithapathina@gmail.com  
- **GitHub**: [https://github.com/PathinaLikhita/mcq_evaluator_proj](https://github.com/PathinaLikhita/mcq_evaluator_proj)

---

## Acknowledgments
- Special thanks to all contributors and mentors who supported this project.
- Feedback is highly appreciated to improve functionality and usability.

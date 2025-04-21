# PHP/SQL Trivia Quiz Game

Challenge yourself or your friends with this web-based trivia quiz game, built entirely with PHP and SQL. Choose your favorite category, answer questions, and see if you can make it onto the high score list.

## Features

* **Category Selection:** Choose from various trivia categories or play questions from all categories.
* **Dynamic Question Loading:** Questions and answers are pulled directly from the database.
* **Multiple Choice Format:** Answer questions using radio buttons.
* **Scoring:** Keep track of your score as you progress through the quiz.
* **Progress Bar:** Visual indicator of your progress within the current quiz round.
* **Immediate Feedback:** See if your answer was correct or incorrect after each submission.
* **High Score Tracking:** Save your score with your name at the end of the quiz.
* **High Score Display:** View the top scores for each category or overall.
* **Session-Based:** Uses PHP sessions to manage the quiz state for each user.
* **Pure PHP/SQL:** Core game logic relies entirely on server-side processing.
* **Simple & Extendable:** Easy to add more questions and categories directly into the database.

## Tech Stack

* **PHP:** Handles all application logic, session management, and database interaction.
* **SQL (MySQL/MariaDB):** Stores questions, answers, categories, and high scores.
* **HTML:** Structures the web pages.
* **CSS:** Styles the user interface for a clean look.

## Requirements

* A web server supporting PHP (e.g., Apache via XAMPP, MAMP, WAMP, or a standard Linux setup).
* A MySQL or MariaDB database server.
* PHP Data Objects (PDO) extension enabled (typically default).
* A modern web browser.

## Setup Instructions

1.  **Download Files:** Clone this repository or download the source code ZIP file.
2.  **Place Files:** Extract and place the entire project folder (e.g., `php_quiz_game`) into your web server's document root (like `htdocs` in XAMPP). The structure should be:
    ```
    /your-web-root/
    └── php_quiz_game/
        ├── config.php
        ├── includes/
        │   ├── db.php
        │   └── functions.php
        ├── templates/
        │   ├── header.php
        │   ├── footer.php
        │   ├── question_form.php
        │   ├── results.php
        │   ├── messages.php
        │   ├── start_screen.php
        │   └── high_scores.php
        ├── quiz.php
        ├── db_setup.sql
        └── reset.php
    ```
3.  **Database Setup:**
    * Open your database management tool (e.g., phpMyAdmin at `http://localhost/phpmyadmin`).
    * Create a new database. The default name expected by `config.php` is `php_quiz`.
    * Select the newly created `php_quiz` database.
    * Go to the "SQL" tab or use the "Import" function.
    * Open the `db_setup.sql` file from the project, copy its contents, and paste/run it in the SQL tab. Alternatively, import the `db_setup.sql` file directly. This creates the `questions` and `high_scores` tables and adds sample questions.
4.  **Configuration (Optional):**
    * Edit `config.php` if your database connection details (host, username, password) differ from the XAMPP defaults (`localhost`, `root`, empty password). You can also adjust `NUM_QUESTIONS_PER_QUIZ` here.
5.  **Run the Game:**
    * Ensure your Apache and MySQL services are running (via XAMPP Control Panel or similar).
    * Open your web browser and navigate to the main `quiz.php` file. Example: `http://localhost/php_quiz_game/quiz.php`

## How to Play

1.  **Start Screen:** You'll first see a screen asking you to choose a category. Select one from the dropdown (or 'all categories') and click "Start Quiz!". You might also see overall high scores here.
2.  **Answering Questions:**
    * You'll be presented with questions one by one.
    * Read the question and select the radio button next to your chosen answer.
    * Click "Submit Answer".
3.  **Feedback:** After submitting, the page will reload. You'll see a message indicating if you were correct or incorrect (and showing the right answer if you were wrong). The next question will then be displayed.
4.  **Progress:** Keep an eye on the progress bar and score indicator at the top.
5.  **Results:** Once you've answered all questions for the round, you'll see the results screen showing your final score for the chosen category.
6.  **Save Score:** If you want to save your score, enter your name in the provided box and click "Save High Score".
7.  **High Scores:** The results screen also displays the current high scores for that category.
8.  **Play Again:** Click one of the "Play Again" buttons to either restart the same category or go back to the category selection screen.

## Adding Questions

Simply insert new rows into the `questions` table in your database using a tool like phpMyAdmin. Make sure to provide the `question_text`, `correct_answer`, three `wrong_answer` options, and a `category`.

---

Enjoy the quiz! Feel free to fork, modify, and improve the game.

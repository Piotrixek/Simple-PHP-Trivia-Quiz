<?php
// --- db stuff ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'php_quiz'); // db name from sql setup
define('DB_USER', 'root');      // default xampp user
define('DB_PASS', '');          // default xampp pass is empty

// --- game settings ---
define('NUM_QUESTIONS_PER_QUIZ', 5); // how many questions to ask
define('MAX_HIGH_SCORES_TO_SHOW', 10); // how many scores to list

// error reporting helps during dev
error_reporting(E_ALL);
ini_set('display_errors', 1);
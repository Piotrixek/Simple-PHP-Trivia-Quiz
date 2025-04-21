<?php
// main quiz controller
session_start(); // track quiz state

// include essentials
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// get db connection
$pdo = getdb();

// --- handle actions before setting up quiz state ---
$action = $_POST['action'] ?? null;
$message = $_SESSION['message'] ?? null; // get init/reset message if any
unset($_SESSION['message']); // clear it after getting

if ($action === 'start_quiz') {
    // user chose a category start the quiz
    $chosen_category = $_POST['category'] ?? 'all';
    // clear any previous quiz state before starting new one
    unset($_SESSION['quiz_started']);
    unset($_SESSION['score']);
    unset($_SESSION['question_ids']);
    unset($_SESSION['current_q_index']);
    unset($_SESSION['last_answer_feedback']);
    // initquiz will set session vars
    if(!initquiz($pdo, $chosen_category)){
         // init failed probably no questions message set in initquiz
         // fall through will show start screen again
    } else {
         $message = $_SESSION['message'] ?? "quiz started for category: ".htmlspecialchars($chosen_category);
         unset($_SESSION['message']); // clear init message
    }

} elseif ($action === 'save_score') {
    // user finished and submitted name
    $player_name = $_POST['player_name'] ?? null;
    $score = $_POST['score'] ?? null;
    $category_from_form = $_POST['category'] ?? null; // Get category from form
    if ($player_name && $score !== null && $category_from_form) {
        // Use category from form for saving
        if (savescore($pdo, $player_name, (int)$score, $category_from_form)) {
            $message = "high score saved!";
        } else {
            $message = "failed to save score maybe invalid name?";
        }
        // Ensure category is set in session for display consistency after saving
        $_SESSION['category'] = $category_from_form;
    } else {
         $message = "missing data to save score";
    }
    // after saving score we stay on results page but show message
    // force quiz state to finished so results show
    $_SESSION['current_q_index'] = count($_SESSION['question_ids'] ?? []); // set index past the end

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    // --- handle regular answer submission ---
    $submitted_answer = $_POST['answer'] ?? null;
    $question_id = $_POST['question_id'] ?? null;

    if ($submitted_answer && $question_id) {
        // process the answer updates score index stores feedback in session
        processanswer($pdo, $submitted_answer, $question_id);
        // message will be retrieved from session feedback below
    } else if (isset($_POST['question_id'])){ // check if form submitted without answer
        $_SESSION['last_answer_feedback'] = ['correct' => false, 'message' => 'please select an answer'];
    }
    // message for display comes from $_SESSION['last_answer_feedback'] now
    $message = null; // clear any previous non-feedback message
}


// --- determine current state ---
$quiz_started = isset($_SESSION['quiz_started']) && $_SESSION['quiz_started'];
$last_answer_feedback = $_SESSION['last_answer_feedback'] ?? null; // get feedback if exists

// --- render page based on state ---
include 'templates/header.php';

// show feedback from last answer OR general messages
include 'templates/messages.php'; // pass $last_answer_feedback $message

if (!$quiz_started) {
    // show category selection screen
    $categories = getcategories($pdo);
    include 'templates/start_screen.php'; // pass $categories
} else {
    // quiz is in progress or just finished
    $current_q_index = $_SESSION['current_q_index'] ?? 0; // Default index if not set
    $total_questions = count($_SESSION['question_ids'] ?? []); // Default empty array if not set
    $quiz_finished = ($current_q_index >= $total_questions);

    if ($quiz_finished) {
        // show final results and high score form/list
        $final_score = $_SESSION['score'] ?? 0; // Default score if not set

        $category = $_SESSION['category'] ?? 'all'; // Default to 'all' if not set in session

        // high scores fetched within results template now using the safe $category
        include 'templates/results.php'; // pass $final_score $total_questions $category
    } else {
        // show the next question
        // Ensure question_ids exists before accessing index
        if (isset($_SESSION['question_ids'][$current_q_index])) {
            $question_id = $_SESSION['question_ids'][$current_q_index];
            $question_data = getquestiondata($pdo, $question_id);
            $question_num = $current_q_index + 1; // user friendly 1-based index
            $current_score = $_SESSION['score'] ?? 0;
            // Check if question data was actually fetched
            if ($question_data) {
                 include 'templates/question_form.php'; // pass vars
            } else {
                 // Handle case where question ID exists but data fetch failed
                 echo "<div class='message error'>Error: Could not load question data for ID: " . htmlspecialchars($question_id) . ". Maybe it was deleted?</div>";
                 echo "<p><a href='reset.php?action=choose_category' class='button-link'>Start Over</a></p>";
            }
        } else {
             // Handle case where index is out of bounds or question_ids is missing
             echo "<div class='message error'>Error: Quiz state is inconsistent. Cannot find the next question.</div>";
             echo "<p><a href='reset.php?action=choose_category' class='button-link'>Start Over</a></p>";
             // Optionally reset the quiz state here
             // unset($_SESSION['quiz_started']);
        }
    }
}

include 'templates/footer.php';

?>

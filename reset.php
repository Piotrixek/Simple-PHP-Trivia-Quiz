<?php
session_start(); // need session access

$action = $_GET['action'] ?? 'restart'; // default is just restart same category

// clear common quiz vars
unset($_SESSION['score']);
unset($_SESSION['question_ids']);
unset($_SESSION['current_q_index']);
unset($_SESSION['last_answer_feedback']);
unset($_SESSION['message']);

// only clear category and started flag if choosing new category
if ($action === 'choose_category') {
    unset($_SESSION['quiz_started']);
    unset($_SESSION['category']);
    $_SESSION['message'] = "choose a new category!";
} else {
    // keep category reset index etc
    $_SESSION['current_q_index'] = 0;
     $_SESSION['score'] = 0;
    $_SESSION['message'] = "quiz reset! playing category: ".htmlspecialchars($_SESSION['category'] ?? 'all')." again.";
    // re-fetch and shuffle question ids for the same category
    if (isset($_SESSION['category'])) {
         $pdo = getdb(); // need db connection here now
         require_once 'config.php'; // need constants
         require_once 'includes/functions.php'; // need functions
         // rebuild question list for the category
         $category = $_SESSION['category'];
         $sql = "SELECT id FROM questions";
         $params = [];
         if ($category !== 'all') {
             $sql .= " WHERE category = ?";
             $params[] = $category;
         }
         $sql .= " ORDER BY RAND() LIMIT " . NUM_QUESTIONS_PER_QUIZ;
         $stmt = $pdo->prepare($sql);
         $stmt->execute($params);
         $_SESSION['question_ids'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
         // check if questions still exist
         if(count($_SESSION['question_ids']) == 0){
             unset($_SESSION['quiz_started']); // force back to start screen
             $_SESSION['message'] = "oops no questions found for category: ".htmlspecialchars($category)." choose another.";
         }

    } else {
         // if category wasnt set somehow force full reset
         unset($_SESSION['quiz_started']);
    }


}


// send player back to main quiz page
header('Location: quiz.php');
exit();
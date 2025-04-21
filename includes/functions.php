<?php
// --- session and quiz init ---

// setup quiz state based on chosen category
function initquiz($pdo, $category) {
    if (!isset($_SESSION['quiz_started'])) {
        $_SESSION['score'] = 0;
        $_SESSION['category'] = $category; // store chosen category

        // build query based on category
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

        // check if enough questions found
        if(count($_SESSION['question_ids']) < NUM_QUESTIONS_PER_QUIZ && $category !== 'all'){
             // fallback maybe? or show error? simpler: just run with fewer questions
             // or maybe fetch remaining from 'all' to top up? lets keep simple for now
             if(count($_SESSION['question_ids']) == 0){
                 $_SESSION['message'] = "oops no questions found for category: ".htmlspecialchars($category);
                 // unset quiz started to show start screen again
                 unset($_SESSION['quiz_started']);
                 return false; // indicate init failed
             }
        } else if (count($_SESSION['question_ids']) == 0) {
             $_SESSION['message'] = "oops no questions found at all in the database!";
             unset($_SESSION['quiz_started']);
             return false; // indicate init failed
        }


        $_SESSION['current_q_index'] = 0; // start at the first question
        $_SESSION['quiz_started'] = true;
        $_SESSION['last_answer_feedback'] = null; // store feedback for display
        $_SESSION['message'] = "quiz started for category: " . htmlspecialchars($category) . " good luck!";
    }
    return true; // init ok or already started
}

// --- data fetching ---

// get data for a specific question id
function getquestiondata($pdo, $question_id) {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    return $stmt->fetch();
}

// get distinct categories from db
function getcategories($pdo) {
    $stmt = $pdo->query("SELECT DISTINCT category FROM questions ORDER BY category");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// --- answer processing ---

// check submitted answer update score and index store feedback
function processanswer($pdo, $submitted_answer, $question_id) {
    $feedback = ['correct' => false, 'message' => ''];
    $question_data = getquestiondata($pdo, $question_id);

    if (!$question_data) {
        $feedback['message'] = "oops couldnt find that question data";
        $_SESSION['last_answer_feedback'] = $feedback;
        return; // exit early
    }

    $correct_answer = $question_data['correct_answer'];

    if ($submitted_answer === $correct_answer) {
        $_SESSION['score']++;
        $feedback['correct'] = true;
        $feedback['message'] = "correct! nice one.";
    } else {
        $feedback['message'] = "oops wrong! the answer was: <strong>" . htmlspecialchars($correct_answer) . "</strong>";
    }

    // store feedback for display on next page load
    $_SESSION['last_answer_feedback'] = $feedback;
    // move to next question index
    $_SESSION['current_q_index']++;
}

// --- high score functions ---

// save a score to the db
function savescore($pdo, $name, $score, $category) {
    // basic validation maybe trim name
    $name = trim(substr($name, 0, 50)); // limit name length
    if (empty($name) || !is_numeric($score)) {
        return false; // invalid data
    }
    $stmt = $pdo->prepare("INSERT INTO high_scores (player_name, score, category) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $score, $category]);
}

// get top scores for a category or all
function gethighscores($pdo, $category = 'all', $limit = MAX_HIGH_SCORES_TO_SHOW) {
    $sql = "SELECT player_name, score, played_on FROM high_scores";
    $params = [];
    if ($category !== 'all') {
        $sql .= " WHERE category = ?";
        $params[] = $category;
    }
    $sql .= " ORDER BY score DESC, played_on DESC LIMIT " . (int)$limit; // cast limit just in case

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}


// --- utility ---

// takes question data returns shuffled array of answers
function getshuffledanswers($question_data) {
    if (!$question_data) return [];
    $answers = [
        $question_data['correct_answer'],
        $question_data['wrong_answer1'],
        $question_data['wrong_answer2'],
        $question_data['wrong_answer3']
    ];
    // remove empty answers if any were missing in db
    $answers = array_filter($answers, function($a) { return !empty($a); });
    shuffle($answers); // mix em up
    return $answers;
}

?>
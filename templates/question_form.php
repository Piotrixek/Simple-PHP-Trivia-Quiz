<?php
// expects $question_data (current question)
// expects $question_num (current question number)
// expects $total_questions (total in quiz)
// expects $current_score

$shuffled_answers = getshuffledanswers($question_data);
$progress_percent = ($total_questions > 0) ? (($question_num - 1) / $total_questions) * 100 : 0;
?>
<div class="score-info">
    question <?php echo $question_num; ?> of <?php echo $total_questions; ?> | current score: <?php echo $current_score; ?>
</div>

<div class="progress-container">
    <div class="progress-bar" style="width: <?php echo $progress_percent; ?>%;"></div>
</div>

<div class="question-box">
    <form method="post" action="quiz.php">
        <div class="question-text" style="text-align: left; margin-bottom: 20px;"><?php echo htmlspecialchars($question_data['question_text']); ?></div>
        <div class="answers">
            <?php foreach ($shuffled_answers as $index => $answer): ?>
                <label>
                    <input type="radio" name="answer" value="<?php echo htmlspecialchars($answer); ?>" required>
                    <?php echo htmlspecialchars($answer); ?>
                </label>
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="question_id" value="<?php echo $question_data['id']; ?>">
        <br>
        <button type="submit">submit answer</button>
    </form>
</div>
<?php
// expects $final_score
// expects $total_questions
// expects $category
// expects $high_scores array

$pdo = getdb(); // need db connection if not already available
$high_scores = gethighscores($pdo, $category); // fetch scores for this category

?>
<div class="results-box">
    <h2>quiz complete!</h2>
    <p>category: <strong><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $category))); ?></strong></p>
    <p style="font-size: 1.8em; margin-bottom: 30px;">your final score: <span style="color: var(--primary-color); font-weight: 700;"><?php echo $final_score; ?></span> out of <?php echo $total_questions; ?></p>

    <hr style="border: none; border-top: 1px solid var(--border-color); margin: 30px 0;">

    <?php // --- high score submission form --- ?>
    <h3>save your score?</h3>
    <form method="post" action="quiz.php" style="margin-bottom: 30px;">
        <input type="text" name="player_name" placeholder="enter your name (max 50 chars)" required maxlength="50" style="text-align: center; margin-bottom: 10px;">
        <input type="hidden" name="action" value="save_score">
        <input type="hidden" name="score" value="<?php echo $final_score; ?>">
        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
        <button type="submit">save high score</button>
    </form>

    <a href="reset.php?action=choose_category" class="button-link play-again-link">play again? (choose category)</a>
    <a href="reset.php" class="button-link" style="background-color: #7f8c8d; margin-left: 10px;">play same category</a>


    <?php // --- display high scores --- ?>
    <?php include 'high_scores.php'; // pass $high_scores $category ?>

</div>
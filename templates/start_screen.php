<?php
// expects $categories array
?>
<div class="start-screen" style="text-align: center;">
    <h2>choose a quiz category!</h2>
    <form method="post" action="quiz.php">
        <select name="category" required>
            <option value="all">all categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat); ?>">
                    <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $cat))); // make it pretty ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="action" value="start_quiz">
        <br>
        <button type="submit">start quiz!</button>
    </form>

     <?php
        // optionally show all-time high scores here too?
        $pdo = getdb();
        $high_scores = gethighscores($pdo, 'all'); // get top scores overall
        $category = 'all'; // for the template context
        if(!empty($high_scores)){
            echo "<hr style='border: none; border-top: 1px solid var(--border-color); margin: 30px 0;'>";
             include 'high_scores.php';
        }
     ?>
</div>
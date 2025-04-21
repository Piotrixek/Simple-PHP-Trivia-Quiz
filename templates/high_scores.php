<?php
// expects $high_scores array
// expects $category string (for title)
?>
<div class="high-scores-section" style="margin-top: 30px;">
    <h3>high scores (<?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $category))); ?>)</h3>
    <?php if (empty($high_scores)): ?>
        <p>no high scores yet for this category!</p>
    <?php else: ?>
        <table class="high-scores-table">
            <thead>
                <tr>
                    <th>rank</th>
                    <th>score</th>
                    <th>name</th>
                    <th>date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($high_scores as $index => $score_entry): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $score_entry['score']; ?></td>
                        <td><?php echo htmlspecialchars($score_entry['player_name']); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($score_entry['played_on'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
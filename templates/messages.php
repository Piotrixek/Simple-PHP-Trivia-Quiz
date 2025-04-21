<?php
// expects $last_answer_feedback array from session OR $message string
$display_message = '';
$message_class = 'message info'; // default class

if (isset($last_answer_feedback) && is_array($last_answer_feedback)) {
    $display_message = $last_answer_feedback['message'];
    if ($last_answer_feedback['correct']) {
        $message_class = 'message feedback-correct';
    } else {
        $message_class = 'message feedback-wrong';
    }
} elseif (!empty($message)) {
    // handle general info messages (like quiz start)
    $display_message = $message;
    // could add logic here to detect error words if needed
}

// clear feedback after getting it
unset($_SESSION['last_answer_feedback']);

?>
<?php if (!empty($display_message)): ?>
    <div class="<?php echo $message_class; ?>"><?php echo $display_message; // message contains html ok ?></div>
<?php endif; ?>
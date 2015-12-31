<?php
require_once('includes/functions.php');
require_once('includes/session.php');
require_once('includes/database.php');
require_once('includes/code.php');
require_once('includes/user.php');

if(!$session->is_logged_in()) redirect_to('browse.php');

$user = User::find_by_id($session->user_id);
$codes = Code::find_by_user_id($user->id);

include('includes/header.php');
?>

<div class="container">
    <h2>All codes shared by <?php echo $user->fullname; ?></h2>
    <ul>
        <?php foreach($codes as $code): ?>
        <li><a href="http://localhost/simpleshare/code.php?id=<?php echo $code->id; ?>"><?php echo $code->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>

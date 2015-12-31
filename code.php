<?php
require_once('includes/functions.php');

require_once('includes/session.php');
require_once('includes/database.php');
require_once('includes/code.php');
require_once('includes/user.php');


if(!isset($_GET['id'])) {
    redirect_to('browse.php');
}

$code = Code::find_by_id($_GET['id']);

$user = new User(0, 'Unregistered User');
if($code->user_id > 0) {
    $user = User::find_by_id($code->user_id);
}




include('includes/header.php');
?>
<div class="container">
    <?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['message'];
        unset($_SESSION['message']); ?>
    </div>
    <?php endif; ?>

    <?php
    if($code != false) {
        if($code->privacy== 1 || ($session->is_logged_in() && $session->user_id == $code->user_id)) {
            echo("<h2>{$code->title}</h2><p>by <strong>{$user->fullname}</strong></p>");
            // only public codes can be shared
            if ($code->privacy == 1)
                // TODO: Convert static site name to dynamic
                echo("<p>Share Link: <a href=\"./code.php?id={$code->id}\">http://localhost/SimpleShare/code.php?id={$code->id}</a></p>");
            echo "<pre class=\"prettyprint\">".htmlspecialchars($code->code)."</pre>";
        }
        else {
            echo "<div class=\"alert alert-danger\">Sorry! Either this link is invalid or you are not authorised to see this code!</div>";
        }
    }
    else {
        echo "<div class=\"alert alert-danger\">Sorry! Either this link is invalid or you are not authorised to see this code!</div>";
    }
    ?>
</div>

</body>
</html>
<?php include('includes/footer.php'); ?>
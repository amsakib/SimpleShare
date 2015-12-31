<?php
require_once 'includes/functions.php';

require_once 'includes/session.php';
require_once 'includes/database.php';
require_once 'includes/code.php';
require_once 'includes/user.php';


include('includes/header.php'); 
?>

<?php
    $codes = Code::find_all_public();
?>


<div class="container">
    <h2>Browse all public codes</h2>
    <ul>
        <?php foreach($codes as $code): ?>
        <li>
            <?php
                $user = new User(0, 'Unregistered User');
                if($code->user_id > 0) {
                    $user = User::find_by_id($code->user_id);
                }
            ?>
            <a href="./code.php?id=<?php echo $code->id; ?>"><?php echo $code->title . " by " . $user->fullname; ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>
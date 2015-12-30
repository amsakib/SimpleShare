<?php 
require_once 'includes/session.php';
require_once 'includes/database.php';
require_once 'includes/code.php';

require_once 'includes/functions.php';

include('includes/header.php'); 
?>

<div class="container">
    <h2>Browse all public codes</h2>
    <?php
        $sql = "SELECT * FROM codes WHERE privacy = 1 ORDER BY id DESC";
        $codes = Code::find_by_sql($sql);
    ?>
    <ul>
        <?php foreach($codes as $code): ?>
        <li>
            <a href="./code.php?id=<?php echo $code->id; ?>"><?php echo $code->title . " by " . $code->name; ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>
<?php 
require_once 'includes/session.php';
require_once 'includes/connections.php';
require_once 'includes/functions.php';
include('includes/header.php'); 
?>

<div class="container">
    <h2>Browse all public codes</h2>
    <?php
        $query = "SELECT * FROM codes WHERE privacy = 1 ORDER BY id DESC";
        $result = mysqli_query($connection, $query);
        confirm_query($result);                
    ?>
    <ul>
        <?php while($code = mysqli_fetch_assoc($result)): ?>
        <li>
            <a href="code.php?id=<?php echo $code['id']; ?>"><?php echo $code['title'] . " by " . $code['name']; ?></a>
        </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>
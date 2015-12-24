<?php
require_once('includes/session.php');
require_once('includes/connections.php');
require_once('includes/functions.php');
if(!logged_in()) redirect_to('browse.php');
include('includes/header.php');
?>

<div class="container">
    <h2>All codes shared by <?php echo $_SESSION['fullname']; ?></h2>
    <?php
        $query = "SELECT * FROM codes WHERE user_id = " . $_SESSION['user_id'] . " ORDER BY id DESC";
        $result = mysqli_query($connection, $query);
        confirm_query($result);        
    ?>
    <ul>
        <?php while($code = mysqli_fetch_assoc($result)): ?>
    <li><a href="http://localhost/simpleshare/code.php?id=<?php echo $code['id']; ?>"><?php echo $code['title']; ?></a></li>
    <?php endwhile; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>

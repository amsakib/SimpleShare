<?php
    require_once('includes/session.php');
    require_once('includes/connections.php');
    require_once('includes/functions.php');
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
    if(!isset($_GET['id'])) {
        redirect_to('browse.php');
    }
    $id = $_GET['id'];
    $query = 'Select * from codes where id = ' . $_GET['id'];

    if($result = mysqli_query($connection, $query)) {
        if($code = mysqli_fetch_assoc($result)) {
            if($code['privacy']==1 || (logged_in() && ($code['user_id'] == $_SESSION['user_id']))) {
                echo("<h2>{$code['title']}</h2><p>by <strong>{$code['name']}</strong></p>");
                // only public codes can be shared
                if ($code['privacy'] == 1)
                    echo("<p>Share Link: <a href=\"http://localhost/SimpleShare/code.php?id={$code['id']}\">http://localhost/SimpleShare/code.php?id={$code['id']}</a></p>");
                echo "<pre class=\"prettyprint\">" . htmlspecialchars($code['code']) . "</pre>";
            } else {
                echo "<div class=\"alert alert-danger\">Sorry! Either this link is invalid or you are not authorised to see this code!</div>";
            }
        } else {
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
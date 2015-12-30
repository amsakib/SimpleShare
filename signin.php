<?php
require_once('includes/session.php');
require_once('includes/database.php');
require_once('includes/user.php');

require_once('includes/functions.php');

if($session->is_logged_in())
    redirect_to('index.php');

include('includes/header.php');
?>
<?php
$usernameError = $passwordError = $message ="";
$error = false;
$username = $password = "";
if($_SERVER['REQUEST_METHOD']=='POST'){

    if(empty($_POST['username'])){
        $usernameError = "User Name is required!";
        $error = true;
    } else {
        $username = trim($database->escape_string($_POST['username']));

        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameError = "Only letters and numbers are allowed!";
            $error = true;
        }
    }

    if(empty($_POST['password'])){
        $passwordError = "Password is required!";
        $error = true;
    } else {
        $password = trim($database->escape_string($_POST['password']));
        $len = strlen($password);
        if($len <5 || $len > 12) {
            $passwordError = "Password length must be greater than 4 and less than 13!";
            $error = true;
        }
    }

    if(!$error) {
        $user = User::authenticate($username, $password);
        if(!$user) {
            $message = "Username-Password combination does not match!";
        } else {
            $session->login($user);
            $session->set_message('You are successfully signed in!');
            redirect_to('index.php');
        }
    }

}
?>
    <div class="container">
        <?php if($session->has_message()): ?>
            <div class="alert alert-success">
                 <?php echo $session->get_message();
                $session->remove_message(); ?>
            </div>
        <?php endif; ?>
        <h2>Sign In to Simple Share!</h2>
        <span class="error"><?php echo $message; ?></span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" role="form">
            <div class="form-group">
                <label for="username">Username:</label> <span class="error"><?php echo $usernameError; ?></span>
                <input id="username" type="text" name="username" class="form-control"
                       placeholder="Enter your Username" />
            </div>
            <div class="form-group">
                <label for="password">Password:</label> <span class="error"><?php echo $passwordError; ?></span>
                <input id="password" type="password" name="password" class="form-control"
                       placeholder="Enter your password" />
            </div>
            <button type="submit" class="btn btn-primary">Sign In!</button>
        </form>
    </div>

<?php include('includes/footer.php'); ?>
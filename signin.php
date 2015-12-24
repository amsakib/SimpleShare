<?php
require_once('includes/session.php');
require_once('includes/connections.php');
require_once('includes/functions.php');
if(logged_in()) redirect_to('index.php');
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
        $username = trim(mysql_prep($_POST['username'], $connection));

        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameError = "Only letters and numbers are allowed!";
            $error = true;
        }
    }

    if(empty($_POST['password'])){
        $passwordError = "Password is required!";
        $error = true;
    } else {
        $password = trim(mysql_prep($_POST['password'], $connection));
        $len = strlen($password);
        if($len <5 || $len > 12) {
            $passwordError = "Password length must be greater than 4 and less than 13!";
            $error = true;
        }
    }

    if(!$error) {
        $query = "SELECT id, fullname, username FROM users ";
        $query .= "WHERE username = '" . $username . "' ";
        $query .= "AND password = '" . sha1($password) . "' ";
        $query .= "LIMIT 1";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if(mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['message'] = 'You are successfully signed in!';
            redirect_to('index.php');
        } else {
            $message = "Username / Password does not exist!";
        }
    }

}
?>
    <div class="container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                 <?php echo $_SESSION['message'];
                unset($_SESSION['message']); ?>
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
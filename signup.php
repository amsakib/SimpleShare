<?php
require_once('includes/session.php');
require_once('includes/database.php');
require_once('includes/user.php');

require_once('includes/functions.php');

if($session->is_logged_in()) redirect_to('index.php');

include('includes/header.php');
?>
<?php
$fullnameError = $usernameError = $passwordError = $emailError = "";
$error = false;
$fullname = $username = $password = $email = "";
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(empty($_POST['fullName'])){
        $fullnameError = "Full Name is required!";
        $error = true;
    }else {
        $fullname = trim($_POST['fullName']);

        if (!preg_match("/^[a-zA-Z. ]*$/",$fullname)) {
            $fullnameError = "Only letters, period and white spaces are allowed!";
            $error = true;
        }
    }

    if(empty($_POST['username'])){
        $usernameError = "User Name is required!";
        $error = true;
    } else {
        $username = trim($_POST['username']);

        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameError = "Only letters and numbers are allowed!";
            $error = true;
        }
    }

    if(empty($_POST['password'])){
        $passwordError = "Password is required!";
        $error = true;
    } else {
        $password = trim($_POST['password']);
        $len = strlen($password);
        if($len <5 || $len > 12) {
            $passwordError = "Password length must be greater than 4 and less than 13!";
            $error = true;
        }
        else {
            $password = sha1($password);
        }
    }

    if(empty($_POST['email'])){
        $emailError = "Email is required!";
        $error = true;
    } else {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format";
            $error = true;
        }
    }

    if(!$error) {
        $dup = User::find_by_sql("SELECT * FROM users WHERE username= '{$username}'");

        if(!empty($dup)) {
            $usernameError = "Username Already Exists!";
        }
        else {
            $dup = User::find_by_sql("SELECT * FROM users WHERE email = '{$email}'");
            if(!empty($dup)){
                $emailError = "Email id already used!";
            } else {
                $user = new User( 0, $fullname, $username, $password, $email);
                if($user->save()) {
                    $session->set_message('You signed up successfully! Please login.');
                    redirect_to('signin.php');
                }
                else {
                    $error = true;
                    die($database->check_error());
                }


            }
        }
    }

}
?>
<div class="container">
    <h2>Sign Up!</h2>
    <p>All fields are required!</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" role="form">
        <div class="form-group">
            <label for="fullName">Full Name:</label> <span class="error"><?php echo $fullnameError; ?></span>
            <input id="fullName" type="text" name="fullName" class="form-control" value="<?php echo $fullname; ?>"
                   placeholder="Full Name (Only letters, period and spaces are allowed)" required />
        </div>
        <div class="form-group">
            <label for="username">Username:</label> <span class="error"><?php echo $usernameError; ?></span>
            <input id="username" type="text" name="username" class="form-control" value="<?php echo $username; ?>"
                   placeholder="Username, Only letters and numbers are allowed" required />
        </div>
        <div class="form-group">
            <label for="password">Password:</label> <span class="error"><?php echo $passwordError; ?></span>
            <input id="password" type="password" name="password" class="form-control"
                   placeholder="Password(minimum length:5, maximum:12)"required />
        </div>
        <div class="form-group">
            <label for="email">Email Id:</label> <span class="error"><?php echo $emailError; ?></span>
            <input id="email" type="email" name="email" class="form-control" value="<?php echo $email; ?>"
             placeholder="yourname@something.domain" required />
        </div>
        <button type="submit" class="btn btn-primary">Sign Up!</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Share</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/default.css">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
</head>
<body>
<!-- Navigation Bar-->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Simple Share</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="browse.php">Browse Codes</a>
                </li>
                <?php if ($session->is_logged_in()): ?>
                <li>
                    <a href="mycodes.php">My Codes</a>
                </li>
                <li>
                    <a href="signout.php">Sign Out</a>
                </li>
                <?php else: ?>
                <li>
                    <a href="signup.php">Sign Up</a>
                </li>
                <li>
                    <a href="signin.php">Sign In</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 
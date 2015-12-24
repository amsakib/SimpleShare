<?php
    require_once('includes/session.php');
    require_once('includes/connections.php');
    require_once('includes/functions.php');
    include('includes/header.php');
?>

<?php
$title = $name = $code = $lang = $privacy = "";
$titleError = $nameError = $codeError =  "";
$user_id = 0;
$privacy = 1;
$error = false;

if($_SERVER['REQUEST_METHOD']=='POST') {
    if(!empty($_POST['title'])){
        $title = trim(mysql_prep($_POST['title'], $connection));
        if(!preg_match("/^[a-zA-Z0-9.-_ ]*$/", $title)) {
            $titleError = "Only letters, period, numbers and spaces are allowed!";
            $error = true;
        }
    } else {
        $titleError = "Code Title is required!";
        $error = true;
    }

    if(logged_in()) {
        $name = $_SESSION['fullname'];
        $user_id = $_SESSION['user_id'];
        $privacy = $_POST['privacy'];
    } else {
        if(!empty($_POST['name'])){
            $name = trim(mysql_prep($_POST['name'], $connection));
            if(!preg_match("/^[a-zA-Z. ]*$/", $name)) {
                $nameError = "Only letters, period and spaces are allowed!";
                $error = true;
            }
        } else {
            $nameError = "Your Full Name is required!";
            $error = true;
        }
    }

    if(!empty($_POST['code'])) {
        $code = mysql_prep($_POST['code'], $connection);
    } else {
        $codeError = "Code field is required!";
        $error = true;
    }

    $lang = $_POST['lang'];

    if(!$error) {
        $query = "INSERT INTO codes (user_id, title, name, code, lang, privacy) VALUES "
            . "( {$user_id}, '{$title}', '{$name}', '" . $code . "', '{$lang}', '{$privacy}' )";
        echo $query;
        if($result = mysqli_query($connection, $query)) {
            $id = mysqli_insert_id($connection);
            $_SESSION['message'] = 'Hoorah! Your code is saved and ready to share!';
            header('Location: code.php?id=' . $id);
            exit;
        } else {
            die('Error! ' . mysqli_error($connection) );
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
    <div class="row">
        <div class="col-md-8">
            <h2>Share your code</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="post" role="form">
                <div class="form-group">
                    <label>Code Title:</label> <span class="error"><?php echo $titleError; ?></span>
                    <input type="text" name="title" class="form-control" placeholder="Code Title"
                        value = "<?php echo $title; ?>" />
                </div>
                <?php if(!logged_in()): ?>
                <div class="form-group">
                    <label for="name">Your Name:</label>  <span class="error"><?php echo $nameError; ?></span>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Your Full Name"
                           value = "<?php echo $name; ?>"/>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Paste your code:</label>  <span class="error"><?php echo $codeError; ?></span>
                    <textarea name="code" id="code" class="form-control code" rows="8" placeholder="Paste your code here!"><?php echo $code; ?></textarea>
                </div>
                <div class="form-group form-inline">
                    <div class="form-group form-inline">
                        <label>Language:</label>
                        <select class="form-control" name="lang">
                            <option value="c">C</option>
                            <option value="cpp">C++</option>
                            <option value="java">Java</option>
                            <option value="js">JavaScript</option>
                            <option value="php">PHP</option>
                            <option value="python">Python</option>
                            <option value="other">Others</option>
                        </select>
                    </div>
                    <?php if(logged_in()): ?>
                    <div class="form-group form-inline">
                        <label>Privacy:</label>
                        <select class="form-control" name="privacy">
                            <option value="1">Public</option>
                            <option value="0">Private</option>
                        </select>
                    </div>
                    <?php endif; ?>
                    <div class="form-group right">
                        <button type="submit" class="btn btn-primary btn-lgk">Share It!</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-4">
            <h3>Recent Shares</h3>
            <ul>
                <?php
                $query = "SELECT id, title FROM codes WHERE privacy = 1 ORDER by id DESC LIMIT 5";
                $result = mysqli_query($connection, $query);
                confirm_query($result);
                while($code = mysqli_fetch_assoc($result)) {
                    echo "<li><a href=\"code.php?id={$code['id']}\">{$code['title']}</a></li>";
                }
                ?>
            </ul>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>


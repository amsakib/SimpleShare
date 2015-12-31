<?php
    require_once('includes/session.php');
    require_once('includes/database.php');
    require_once('includes/code.php');

    require_once('includes/functions.php');

    include('includes/header.php');
?>

<?php
$code = new Code();
$titleError = $codeError =  "";
$error = false;

if($_SERVER['REQUEST_METHOD']=='POST') {
    if(!empty($_POST['title'])){
        $code->title = trim($_POST['title']);
        if(!preg_match("/^[a-zA-Z0-9.-_ ]*$/", $code->title)) {
            $titleError = "Only letters, period, numbers and spaces are allowed!";
            $error = true;
        }
    } else {
        $titleError = "Code Title is required!";
        $error = true;
    }

    if($session->is_logged_in()) {
        $code->user_id = $session->user_id;
        $code->privacy = $_POST['privacy'];
    }

    if(!empty($_POST['code'])) {
        $code->code = $_POST['code'];
    } else {
        $codeError = "Code field is required!";
        $error = true;
    }

    $code->lang = $_POST['lang'];

    if(!$error) {
        if($code->save()) {
            $_SESSION['message'] = 'Horrah! Your code is saved and ready to share!';
            header('Location: code.php?id=' . $code->id);
            exit;
        } else {
            $database->check_error();
        }
    }
}

?>

<div class="container">

    <?php if($session->has_message()): ?>
        <div class="alert alert-success">
            <?php
            echo $session->get_message();
            $session->remove_message();
            ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <h2>Share your code</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="post" role="form">
                <div class="form-group">
                    <label>Code Title:</label> <span class="error"><?php echo $titleError; ?></span>
                    <input type="text" name="title" class="form-control" placeholder="Code Title"
                        value = "<?php echo $code->title; ?>" required />
                </div>

                <div class="form-group">
                    <label>Paste your code:</label>  <span class="error"><?php echo $codeError; ?></span>
                    <textarea name="code" id="code" class="form-control code" rows="8"
                              placeholder="Paste your code here!" required><?php echo $code->code; ?></textarea>
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
                    <?php if($session->is_logged_in()): ?>
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
                $sql= "SELECT * FROM codes WHERE privacy = 1 ORDER by id DESC LIMIT 10";
                $codes = Code::find_by_sql($sql);

                foreach($codes as $code){
                    echo "<li><a href=\"./code.php?id={$code->id}\">{$code->title}</a></li>";
                }
                ?>
            </ul>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
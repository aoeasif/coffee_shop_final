<?php 
require_once("includes/header.php");
require_once("utils/function.php");
$error = array();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    redirect("home.php");
    exit(0);
}

if(isset($_POST['login_submit']) && isset($_POST['username']) && isset($_POST['password'])) {
    $error = array();
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if(empty($username)) {
        $error["username_error"] = "Username is required.";
        $error["login_failed"] = "All fields are required.";
    }
    if(empty($password)) {
        $error["password_error"] = "Password is required.";
        $error["login_failed"] = "All fields are required.";
    }
    if(empty($error)) {
        // $password = md5($password);
        $sql = "SELECT id, password FROM user WHERE userName = '{$username}' LIMIT 1";
        $user = db_get_result_array($sql);
        if(empty($user)) {
            $error["login_failed"] = "Authetication failled.";
            $error["username_error"] = "Username is not registered.";
        }else{
            $user = $user[0];
            if($password == $user["password"]) {
                $_SESSION["logged_in"] = true;
                redirect_msg("home.php", $user["id"]);
                exit(0);
            } else {
                $error["login_failed"] = "Authetication failled.";
                $error["password_error"] = "Password incorrect.";
            }
        }
    }
}
?>

<div id="main_container">
<div class="wrapper main_content">
    <div class="card card_fit">
        <div id="login_section">
            <h2>Login</h2>
            <p>Enter your registered username and password</p>
            <form action="#" method="post" name="login_form" onsubmit="return login_form_field_validation()">
                <span id="login_submit_error" class="form_error">
                    <?php echo_var($error["login_failed"]); ?>
                </span>
                <div id="username" class="form_field">
                    <label for="username">Username:</label>
                    <input type="text" name="username">
                    <span id="username_error" class="form_error clearfix">
                        <?php echo_var($error["username_error"]); ?>
                    </span>
                </div>
                <div id="password" class="form_field">
                    <label for="password">Password:</label>
                    <input type="password" name="password">
                    <span id="password_error" class="form_error clearfix">
                        <?php echo_var($error["password_error"]); ?>
                    </span>
                </div>
                <div id="submit_button" class="form_field">
                    <input type="submit" name="login_submit" value="Login">
                </div>
                <div class="form_extra">
                    <span class="forgot_password">
                        <p>
                            <a href="forgot_password.php">Forgot password?</a>
                        </p>
                    </span>
                    <span class="create_new_account_link">
                        <p>
                            <a href="signup.php">Create a new account</a>
                        </p>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script language="javascript">
function login_form_field_validation() {
    var err = 0;
    var username = document.login_form.username.value;
    var password = document.login_form.password.value;

    var username_error = document.getElementById("username_error");
    var password_error = document.getElementById("password_error");
    var form_error = document.getElementById("login_submit_error");
    
    form_error.innerHTML = "";
    username_error.innerHTML = "";
    password_error.innerHTML = "";
    if(username.length == 0) {
        username_error.innerHTML = "Username is required.";
        err = 1;
    }
    if(password.length == 0) {
        password_error.innerHTML = "Password is required.";
        err = 1;
    }
    if(err == 0) {
        return true;
    }
    return false;
}
</script>
<?php require_once("includes/footer.php"); ?>
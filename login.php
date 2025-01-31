<?php
    session_start();
    if (isset($_POST['cancel']))
    {
        header("Location: app.php");
        return;
    }

    $salt = 'XyZzy12*_';
    $stored_hash = hash('md5', 'XyZzy12*_php123');;  // Password is php123
    $failure = false;

    if (isset($_POST['email']) && isset($_POST['pass']))
    {
        if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1)
        {
            $_SESSION['error'] = "User name and password are required";
        }
        else if (strpos($_POST['email'], "@") === false)
        {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        else
        {
            $check = hash('md5', $salt . $_POST['pass']);
            if ($check == $stored_hash)
            {
                error_log("Login success ".$_POST['email']);
                $_SESSION['name'] = $_POST['email'];
                header("Location: index.php");
                return;
            }
            else
            {
                $_SESSION['error'] = "Incorrect password";
                error_log("Login fail ".$_POST['email']." $check");
                header("Location: login.php");
                return;
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
  <title>4b34e3d7</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>

    <?php
    if ( isset($_SESSION['error']) )
    {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="POST" action="login.php">
      User Name <input type="text" name="email"><br/>
      Password <input type="text" name="pass"><br/>
      <input type="submit" value="Log In">
      <input type="submit" name="cancel" value="Cancel">

    </form>
    
</div>
</body>
</html>
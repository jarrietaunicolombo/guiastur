<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
SessionUtility::startSession();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php
    $error = @$_SESSION[ItemsInSessionEnum::ERROR_MESSAGE];
    if (isset($error)) {
        echo "<p style='color:red'>" . $error . "</p>";
       unset($_SESSION[ItemsInSessionEnum::ERROR_MESSAGE]);
    }
    ?>
    <form action="index.php" method="post">
        <input type="hidden"  name="action" value="login"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>

</html>
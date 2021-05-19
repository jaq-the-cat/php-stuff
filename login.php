
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include_once 'db.php';


$result = $db->login($_POST['username'], $_POST['password']);
if ($result == false) {
    header('location: login.php');
} else {
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['id'] = $result['id'];
    $_SESSION['username'] = $result['username'];
    header('location: index.php');
}
?>
<?php } else { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php-stuff</title>
</head>
<body>
    <header>
        <h1><a href="index.php">CSS is for losers</a></h1>
        <hr>
    </header>
    <form action="login.php" method="post">
        <input type="text" name="username" id="username" placeholder="Username">
        <input type="password" name="password" id="password" placeholder="Password"><br>
        <br>
        <button type="submit">Login</button>
    </form>
</body>

<?php } ?>

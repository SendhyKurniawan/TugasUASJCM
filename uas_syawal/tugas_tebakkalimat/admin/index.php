<?php
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "admin" && $password == "1234") {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body { font-family: Arial; background:#e9ecef; text-align:center; margin-top:100px; }
        form { background:#fff; display:inline-block; padding:30px; border-radius:10px; box-shadow:0 0 10px #ccc; }
        input { margin:10px; padding:10px; width:200px; }
        button { padding:10px 20px; }
        .error { color:red; }
    </style>
</head>
<body>
    <h2>🔐 Login Admin</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Masuk</button>
    </form>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
</body>
</html>
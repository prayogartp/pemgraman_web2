<?php
session_start();

if (isset($_POST['Login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Pemeriksaan login
    if ($user == "rahadian" && $pass == "123") {
        $_SESSION['login'] = $user;

        echo "<h1>Anda berhasil LOGIN</h1>";
        echo "<h2>Klik <a href='session2.php'>di sini</a> untuk menuju halaman pemeriksaan session.</h2>";
    } else {
        echo "<h3>Username atau password salah!</h3>";
    }
}
?>

<html>
<head>
    <title>Login Here</title>
</head>
<body>
    <form action="" method="post">
        <h2>Login Here...</h2>
        Username: <input type="text" name="user" required><br><br>
        Password: <input type="password" name="pass" required><br><br>
        <input type="submit" name="Login" value="Log In">
    </form>
</body>
</html>
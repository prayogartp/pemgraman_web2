<?php
session_start();

if (isset($_SESSION['login'])) {
    echo "<h1>Selamat Datang " . $_SESSION['login'] . "</h1>";
    echo "<h2>Halaman ini hanya bisa diakses jika Anda sudah login.</h2>";
    echo "<h2><a href='session3.php'>Logout</a></h2>";
} else {
    echo "Anda belum login! Silahkan <a href='session1.php'>login di sini</a>.";
}
?>
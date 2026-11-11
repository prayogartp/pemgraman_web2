<?php
session_start();

if (isset($_SESSION['login'])) {
    $_SESSION = array();
    session_destroy();

    echo "<h1>Anda sudah berhasil LOGOUT</h1>";
    echo "<h2><a href='session1.php'>Login kembali</a></h2>";
} else {
    echo "<h1>Anda belum login.</h1>";
    echo "<a href='session1.php'>Kembali ke halaman login</a>";
}
?>
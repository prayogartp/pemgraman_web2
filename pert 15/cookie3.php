<?php
setcookie("username", "", time() - 3600, "/");
setcookie("namalengkap", "", time() - 3600, "/");

echo "<h1>Cookie Berhasil dihapus.</h1>";
echo "<h2><a href='cookie1.php'>Pembuatan cookies</a></h2>";
echo "<h2><a href='cookie2.php'>Pemeriksaan cookies</a></h2>";
?>
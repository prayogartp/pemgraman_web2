<?php
$value = 'rahadian';
$value2 = 'rahadi ramelan';

setcookie("username", $value, time() + 3600, "/");
setcookie("namalengkap", $value2, time() + 3600, "/");

echo "<h1>Ini halaman pengesetan cookie</h1>";
echo "<h2><a href='cookie2.php'>Klik di sini untuk pemeriksaan cookies</a></h2>";
?>
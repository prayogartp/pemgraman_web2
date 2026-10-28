<?php
$link = mysqli_connect("localhost", "root", "");
$dbname = "lat_dbase";

$cek = mysqli_query($link, "CREATE DATABASE IF NOT EXISTS $dbname");
if ($cek) {
    echo "Database $dbname berhasil dibuat (atau sudah ada)";
} else {
    echo "Couldn't Create Database: $dbname";
}
?>
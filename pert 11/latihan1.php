<?php
// Hostname atau IP server
$servername = 'localhost'; 

// Username dan Password MySQL
$dbusername = 'root';
$dbpassword = '';
$link = mysqli_connect("$servername", "$dbusername", "$dbpassword") 
        or die("Not able to connect to server");
if ($link) 
{
    echo "ok....koneksi berhasil";
}
?>
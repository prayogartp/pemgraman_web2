<?php
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

mysqli_select_db($con, "lat_dbase");

$hasil = mysqli_query($con, "SELECT * FROM tbl_mhs");

while ($data = mysqli_fetch_row($hasil)) {
    echo "$data[0] $data[1] $data[2]<br>";
}
mysqli_close($con);
?>
<?php
$con = mysqli_connect("localhost", "root", "");
mysqli_select_db($con, "lat_dbase");

$hasil = mysqli_query($con, "SELECT * FROM tbl_mhs");
$hit = mysqli_num_rows($hasil);

echo "jumlah record $hit";
mysqli_close($con);
?>
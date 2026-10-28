<?php
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' .mysql_error($con));
}

mysqli_select_db($con, "lat_dbase");

mysqli_query($con, "UPDATE tbl_mhs SET Age = '36' WHERE FirstName = 'Karina' AND LastName = 'Suwandi'");

mysqli_close($con);
?>
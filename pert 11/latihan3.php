<?php
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, "lat_dbase");

// Buat tabel hanya jika belum ada
$sql = "CREATE TABLE IF NOT EXISTS tbl_mhs (
    mhsID int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(mhsID),
    FirstName varchar(15),
    LastName varchar(15),
    Age int
)";
mysqli_query($con, $sql);

// Input data pertama
mysqli_query($con, "INSERT INTO tbl_mhs(FirstName, LastName, Age) VALUES('Anjar', 'Prabowo', 25)");

echo "Tabel siap dan data berhasil dimasukkan";
?>
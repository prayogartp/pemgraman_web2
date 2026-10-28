<?php
// Kalau dibuka langsung (bukan dari form), arahkan ke form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

mysqli_select_db($con, "lat_dbase");

// Ambil data dengan aman, kosong kalau tidak ada
$firstname = $_POST['firstname'] ?? '';
$lastname  = $_POST['lastname'] ?? '';
$age       = (int) ($_POST['age'] ?? 0);

// Jangan simpan kalau kosong
if ($firstname === '' || $lastname === '') {
    die('Firstname dan Lastname wajib diisi. <a href="form.php">Kembali</a>');
}

$firstname = mysqli_real_escape_string($con, $firstname);
$lastname  = mysqli_real_escape_string($con, $lastname);

$sql = "INSERT INTO tbl_mhs (FirstName, LastName, Age)
        VALUES ('$firstname', '$lastname', $age)";

if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
}

echo "1 record added <br><a href='form.php'>Tambah lagi</a>";

mysqli_close($con);
?>
<?php
if (isset($_POST['upload'])) {

    $nama = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    if (move_uploaded_file($tmp, "uploads/" . $nama)) {
        echo "File berhasil diupload";
    } else {
        echo "File gagal diupload";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    Pilih File:
    <input type="file" name="file" required>
    <button type="submit" name="upload">Upload</button>
</form>
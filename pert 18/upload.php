
<?php
if (isset($_POST['upload'])) {

    $nama = $_FILES['file']['name'];
    $ukuran = $_FILES['file']['size'];
    $tmp = $_FILES['file']['tmp_name'];

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if ($ukuran <= 80 * 1024 * 1024) {

        if (move_uploaded_file($tmp, "uploads/" . basename($nama))) {
            echo "File berhasil diupload";
        } else {
            echo "File gagal diupload";
        }

    } else {
        echo "Ukuran file terlalu besar";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    Pilih File:
    <input type="file" name="file" required>
    <button type="submit" name="upload">Upload</button>
</form>
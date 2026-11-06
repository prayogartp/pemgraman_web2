<?php
if (isset($_POST['Submit']) && $_POST['Submit'] == "Submit") {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $nama         = $_POST['nama'];
    $jurusan      = $_POST['jurusan'];
    $alamat       = $_POST['alamat'];
    $telepon      = $_POST['telepon'];

    // Validasi data kosong
    if (empty($id_mahasiswa) || empty($nama) || empty($alamat) || empty($telepon)) {
        ?>
        <script language="JavaScript">
            alert('Data Harap Dilengkapi!');
            document.location='index.php';
        </script>
        <?php
    } else {
        // Koneksi ke database
        include "koneksi-tutor.php";
        /** @var mysqli $koneksi */

        // Cek NIM di database
        $cek_query = mysqli_query($koneksi, "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa='$id_mahasiswa'");
        $cek       = mysqli_num_rows($cek_query);

        if ($cek > 0) {
            ?>
            <script language="JavaScript">
                alert('NIM sudah dipakai!, silahkan ganti NIM yang lain');
                document.location='index.php';
            </script>
            <?php
        } else {
            // Masukkan data ke tabel
            $input = "INSERT INTO mahasiswa (id_mahasiswa, nama, jurusan, alamat, telepon) 
                      VALUES ('$id_mahasiswa', '$nama', '$jurusan', '$alamat', '$telepon')";
            
            $query_input = mysqli_query($koneksi, $input);

            if ($query_input) {
                ?>
                <script language="JavaScript">
                    alert('Input Data Mahasiswa Berhasil');
                    document.location='index.php';
                </script>
                <?php
            } else {
                echo "Input Data Mahasiswa Gagal!, Silahkan diulangi! " . mysqli_error($koneksi);
            }

            mysqli_close($koneksi);
        }
    }
}
?>
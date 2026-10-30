<?php
require_once __DIR__ . "/koneksi.php";

function hitungRata(int $mat, int $bing, int $umum): float{
    return ($mat + $bing + $umum) / 3;
}

function tentukanKeterangan(float $rata): string{
    if($rata >= 70){
        return "Lulus";
    }elseif($rata >= 60){
        return "Cadangan";
    }
    return "Tidak Lulus";
}

function tentukanTempatTes(string $kode): string{
    $kode_awal = substr(strtoupper($kode), 0, 1);
    if($kode_awal == "A"){
        return "Gedung A";
    }elseif($kode_awal == "B"){
        return "Gedung B";
    }elseif($kode_awal == "V"){
        return "Viktor";
    }
    return "Tidak Diketahui";
}

function e(?string $teks): string{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

if(isset($_POST['simpan'])){
    $stmt = mysqli_prepare($koneksi, "INSERT INTO pendaftar
        (tgl_input, kode, nama, jk, asal_sekolah, pekerjaan_ortu, tempat_lahir, tgl_lahir, mat, bing, umum)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)");

    $kode = strtoupper($_POST['kode']);
    $mat  = (int)$_POST['mat'];
    $bing = (int)$_POST['bing'];
    $umum = (int)$_POST['umum'];

    mysqli_stmt_bind_param($stmt, "ssssssssiii",
        $_POST['tgl_input'], $kode, $_POST['nama'], $_POST['jk'],
        $_POST['asal_sekolah'], $_POST['pekerjaan_ortu'], $_POST['tempat_lahir'],
        $_POST['tgl_lahir'], $mat, $bing, $umum);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?msg=tambah");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM pendaftar ORDER BY id DESC");

$jumlah_pendaftar = 0;
$jumlah_lulus = 0;
$jumlah_cadangan = 0;
$jumlah_tidak_lulus = 0;
$baris = [];

while($row = mysqli_fetch_assoc($data)){
    $row['rata'] = hitungRata($row['mat'], $row['bing'], $row['umum']);
    $row['keterangan'] = tentukanKeterangan($row['rata']);
    $row['tempat_tes'] = tentukanTempatTes($row['kode']);
    $baris[] = $row;

    $jumlah_pendaftar++;
    if($row['keterangan'] == "Lulus"){
        $jumlah_lulus++;
    }elseif($row['keterangan'] == "Cadangan"){
        $jumlah_cadangan++;
    }else{
        $jumlah_tidak_lulus++;
    }
}

$pesan = "";
if(isset($_GET['msg']) && $_GET['msg'] == "tambah"){
    $pesan = "Data berhasil disimpan.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS PHP - Pendaftaran Mahasiswa</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 30px;
            background: #f4f4f4;
        }

        .container{
            width: 1100px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2{
            text-align: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td{
            border: 1px solid black;
        }

        th, td{
            padding: 10px;
            text-align: center;
        }

        input[type=text],
        input[type=number],
        input[type=date]{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .btn{
            background: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover{
            background: darkblue;
        }

        .btn-tampil{
            background: green;
        }

        .btn-tampil:hover{
            background: darkgreen;
        }

        .info{
            margin-top: 20px;
            padding: 10px;
            background: #eef;
        }

        .pesan{
            margin-top: 15px;
            padding: 10px;
            background: #dfd;
            border: 1px solid green;
            transition: opacity 0.5s;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>FORM PENDAFTARAN MAHASISWA BARU</h2>

    <?php if($pesan != ""){ ?>
        <div class="pesan" id="pesan"><?= e($pesan) ?></div>
    <?php } ?>

    <form method="POST" action="index.php">

        <label>Tanggal Input</label>
        <input type="date" name="tgl_input" required>

        <label>Kode Pendaftaran</label>
        <input type="text" name="kode" placeholder="Contoh : A2" required>

        <label>Nama Pendaftar</label>
        <input type="text" name="nama" required>

        <label>Jenis Kelamin</label><br>
        <input type="radio" name="jk" value="Laki-Laki" required> Laki-Laki
        <input type="radio" name="jk" value="Perempuan"> Perempuan
        <br><br>

        <label>Asal Sekolah</label>
        <input type="text" name="asal_sekolah" required>

        <label>Pekerjaan Orang Tua</label>
        <input type="text" name="pekerjaan_ortu" required>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" required>

        <label>Matematika</label>
        <input type="number" name="mat" min="0" max="100" required>

        <label>Bahasa Inggris</label>
        <input type="number" name="bing" min="0" max="100" required>

        <label>Umum</label>
        <input type="number" name="umum" min="0" max="100" required>

        <button type="submit" name="simpan" class="btn">SIMPAN</button>
        <button type="button" id="btnTampil" class="btn btn-tampil" onclick="toggleData()">TAMPILKAN DATA</button>

    </form>

    <div id="areaData" style="display: none;">

        <h3>Data Pendaftar</h3>

        <table>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Tgl Lahir</th>
                <th>Asal Sekolah</th>
                <th>Pekerjaan Ortu</th>
                <th>Tempat Tes</th>
                <th>MAT</th>
                <th>B. Inggris</th>
                <th>Umum</th>
                <th>Rata-rata</th>
                <th>Keterangan</th>
            </tr>

            <?php if(count($baris) == 0){ ?>
                <tr>
                    <td colspan="13">Belum ada data pendaftar.</td>
                </tr>
            <?php } ?>

            <?php $no = 1; foreach($baris as $r){ ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= e($r['kode']) ?></td>
                    <td><?= e($r['nama']) ?></td>
                    <td><?= e($r['jk']) ?></td>
                    <td><?= e($r['tempat_lahir']) ?>, <?= e($r['tgl_lahir']) ?></td>
                    <td><?= e($r['asal_sekolah']) ?></td>
                    <td><?= e($r['pekerjaan_ortu']) ?></td>
                    <td><?= e($r['tempat_tes']) ?></td>
                    <td><?= (int)$r['mat'] ?></td>
                    <td><?= (int)$r['bing'] ?></td>
                    <td><?= (int)$r['umum'] ?></td>
                    <td><?= number_format($r['rata'], 2) ?></td>
                    <td><?= e($r['keterangan']) ?></td>
                </tr>
            <?php } ?>
        </table>

        <div class="info">
            <h3>Rekap Data:</h3>
            <p>Jumlah Pendaftar : <b><?= $jumlah_pendaftar ?></b></p>
            <p>Jumlah Peserta Lulus : <b><?= $jumlah_lulus ?></b></p>
            <p>Jumlah Cadangan : <b><?= $jumlah_cadangan ?></b></p>
            <p>Jumlah Tidak Lulus : <b><?= $jumlah_tidak_lulus ?></b></p>
        </div>

    </div>

    <div class="info">
        <h3>Keterangan:</h3>
        <p><b>Kode Tempat Tes:</b></p>
        <ul>
            <li>A = Gedung A</li>
            <li>B = Gedung B</li>
            <li>V = Viktor</li>
        </ul>

        <p><b>Hasil Seleksi:</b></p>
        <ul>
            <li>Rata-rata &ge; 70 = Lulus</li>
            <li>Rata-rata 60 - 69 = Cadangan</li>
            <li>Rata-rata &lt; 60 = Tidak Lulus</li>
        </ul>
    </div>

</div>

<script>
    var pesan = document.getElementById("pesan");
    if(pesan){
        setTimeout(function(){
            pesan.style.opacity = "0";
            setTimeout(function(){
                pesan.style.display = "none";
            }, 500);
        }, 3000);

        window.history.replaceState(null, "", "index.php");
    }

    function toggleData(){
        var area = document.getElementById("areaData");
        var btn = document.getElementById("btnTampil");
        if(area.style.display === "none"){
            area.style.display = "block";
            btn.textContent = "SEMBUNYIKAN DATA";
        }else{
            area.style.display = "none";
            btn.textContent = "TAMPILKAN DATA";
        }
    }
</script>
</body>
</html>
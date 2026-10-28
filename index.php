<?php
session_start();

$TEMPAT = ['A' => 'Gedung A', 'B' => 'Gedung B', 'V' => 'Viktor'];
$BULAN  = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni',
           '7'=>'Juli','8'=>'Agustus','9'=>'September','A'=>'Oktober','B'=>'November','C'=>'Desember'];

$ORTU = ['PNS', 'TNI/Polri', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Buruh', 'Lainnya'];

if (!isset($_SESSION['data'])) $_SESSION['data'] = [];
if (!isset($_SESSION['urut'])) $_SESSION['urut'] = 100;

$error = '';
$old = ['nama'=>'','jk'=>'','tmp'=>'','tgl'=>'','sek'=>'','ortu'=>'','tempat'=>'A','gel'=>'1','bulan'=>'9','mat'=>'','ing'=>'','umum'=>''];

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'hapus') {
        $_SESSION['data'] = [];
        $_SESSION['urut'] = 100;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($aksi === 'simpan') {
        foreach ($old as $k => $v) $old[$k] = trim($_POST[$k] ?? '');

        if ($old['nama']===''||$old['jk']===''||$old['tmp']===''||$old['tgl']===''||$old['sek']===''||$old['ortu']===''
            ||$old['mat']===''||$old['ing']===''||$old['umum']==='') {
            $error = 'Semua data wajib diisi';
        } elseif (!in_array($old['ortu'], $ORTU) || !isset($TEMPAT[$old['tempat']]) || !preg_match('/^[1-9]$/', $old['gel']) || !isset($BULAN[$old['bulan']])) {
            $error = 'Pilihan pekerjaan ortu, tempat tes, gelombang, atau bulan tes tidak valid';
        } elseif (!is_numeric($old['mat'])||!is_numeric($old['ing'])||!is_numeric($old['umum'])
                  ||$old['mat']<0||$old['mat']>100||$old['ing']<0||$old['ing']>100||$old['umum']<0||$old['umum']>100) {
            $error = 'Nilai harus 0 - 100';
        } else {
            $_SESSION['urut']++;
            $kode = $old['tempat'] . $old['gel'] . '-' . $_SESSION['urut'] . '-' . $old['bulan'];
            $mat = (float)$old['mat']; $ing = (float)$old['ing']; $um = (float)$old['umum'];
            $rata = ($mat + $ing + $um) / 3;
            $ket = $rata >= 70 ? 'Lulus' : ($rata >= 60 ? 'Cadangan' : 'Tidak Lulus');
            $_SESSION['data'][] = [
                'kode'   => $kode,
                'nama'   => $old['nama'],
                'jk'     => $old['jk'] === 'Perempuan' ? 'Perempuan' : 'Laki-Laki',
                'ttl'    => $old['tmp'] . ', ' . date('d-m-Y', strtotime($old['tgl'])),
                'sek'    => $old['sek'],
                'ortu'   => $old['ortu'],
                'tempat' => $TEMPAT[$old['tempat']] . ' – Gelombang ' . $old['gel'],
                'bulan'  => $BULAN[$old['bulan']],
                'mat'    => $mat, 'ing' => $ing, 'um' => $um,
                'rata'   => $rata, 'ket' => $ket,
            ];
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

$data  = $_SESSION['data'];
$nextNo = $_SESSION['urut'] + 1;
$jmlLulus = 0; $jmlTidak = 0;
foreach ($data as $d) {
    if ($d['ket'] === 'Lulus') $jmlLulus++;
    if ($d['ket'] === 'Tidak Lulus') $jmlTidak++;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Input Pendaftaran Mahasiswa Baru</title>
<style>
body{font-family:Arial,Helvetica,sans-serif;margin:0;padding:16px;font-size:14px}
h2{margin:0 0 12px}
.box{max-width:560px;margin-bottom:16px}
.row{display:flex;align-items:center;margin:6px 0;gap:6px}
.row .l{width:160px;flex:none}
input[type=text],input[type=number],input[type=date],select{flex:1;padding:5px;border:1px solid #999;min-width:0}
button{padding:6px 14px;border:1px solid #999;background:#e8e8e8;cursor:pointer}
button.p{background:#1a4d8f;color:#fff;border-color:#1a4d8f}
.err{color:#c0392b;min-height:18px;margin:6px 0}
.wrap{overflow-x:auto}
table{border-collapse:collapse;width:100%;min-width:900px}
th,td{border:1px solid #999;padding:5px 7px;text-align:left}
th{background:#e8e8e8}
.n{text-align:center}
tfoot td{font-weight:bold}
tfoot td.r{text-align:right}
</style>
</head>
<body>
<h2>INPUT PENDAFTARAN</h2>

<form method="post" class="box">
  <input type="hidden" name="aksi" value="simpan">
  <div class="row"><span class="l">KODE PENDAFTARAN</span><input type="text" id="kodePrev" readonly style="background:#f1f1f1;font-weight:bold"></div>
  <div class="row"><span class="l">TEMPAT TES</span>
    <select name="tempat" id="tempat">
      <?php foreach ($TEMPAT as $k => $v): ?><option value="<?= $k ?>" <?= $old['tempat']===$k?'selected':'' ?>><?= e($v) ?></option><?php endforeach; ?>
    </select></div>
  <div class="row"><span class="l">GELOMBANG</span>
    <select name="gel" id="gel">
      <?php for ($i = 1; $i <= 9; $i++): ?><option value="<?= $i ?>" <?= $old['gel']==(string)$i?'selected':'' ?>>Gelombang <?= $i ?></option><?php endfor; ?>
    </select></div>
  <div class="row"><span class="l">BULAN TES</span>
    <select name="bulan" id="bulan">
      <?php foreach ($BULAN as $k => $v): ?><option value="<?= $k ?>" <?= $old['bulan']===(string)$k?'selected':'' ?>><?= e($v) ?></option><?php endforeach; ?>
    </select></div>
  <div class="row"><span class="l">NAMA PENDAFTAR</span><input type="text" name="nama" value="<?= e($old['nama']) ?>"></div>
  <div class="row"><span class="l">JENIS KELAMIN</span>
    <label><input type="radio" name="jk" value="Laki-Laki" <?= $old['jk']==='Laki-Laki'?'checked':'' ?>> Laki-Laki</label>
    <label><input type="radio" name="jk" value="Perempuan" <?= $old['jk']==='Perempuan'?'checked':'' ?>> Perempuan</label></div>
  <div class="row"><span class="l">TTL</span>
    <input type="text" name="tmp" placeholder="Tempat" value="<?= e($old['tmp']) ?>">
    <input type="date" name="tgl" value="<?= e($old['tgl']) ?>"></div>
  <div class="row"><span class="l">ASAL SEKOLAH</span><input type="text" name="sek" value="<?= e($old['sek']) ?>"></div>
  <div class="row"><span class="l">PEKERJAAN ORTU</span>
    <select name="ortu">
      <option value="">-- Pilih --</option>
      <?php foreach ($ORTU as $v): ?><option value="<?= e($v) ?>" <?= $old['ortu']===$v?'selected':'' ?>><?= e($v) ?></option><?php endforeach; ?>
    </select></div>
  <div class="row"><span class="l">NILAI TES</span></div>
  <div class="row"><span class="l">&nbsp;&nbsp;MATEMATIKA</span><input type="number" name="mat" min="0" max="100" step="any" value="<?= e($old['mat']) ?>"></div>
  <div class="row"><span class="l">&nbsp;&nbsp;BHS. INGGRIS</span><input type="number" name="ing" min="0" max="100" step="any" value="<?= e($old['ing']) ?>"></div>
  <div class="row"><span class="l">&nbsp;&nbsp;P. UMUM</span><input type="number" name="umum" min="0" max="100" step="any" value="<?= e($old['umum']) ?>"></div>
  <div class="err"><?= e($error) ?></div>
  <div class="row"><span class="l"></span>
    <button class="p" type="submit">Simpan</button>
    <a href="<?= e($_SERVER['PHP_SELF']) ?>"><button type="button">Reset</button></a></div>
</form>

<?php if ($data): ?>
<form method="post" class="box">
  <input type="hidden" name="aksi" value="hapus">
  <button type="submit" onclick="return confirm('Hapus semua data?')">Hapus Semua Data</button>
</form>
<?php endif; ?>

<script>
var no = <?= (int)$nextNo ?>;
function prev(){
  document.getElementById('kodePrev').value =
    document.getElementById('tempat').value + document.getElementById('gel').value + '-' + no + '-' + document.getElementById('bulan').value;
}
['tempat','gel','bulan'].forEach(function(i){document.getElementById(i).addEventListener('change',prev)});
prev();
</script>

<h3>TABEL DATA</h3>
<div class="wrap">
<table>
<thead><tr>
<th>Kode Pendaftaran</th><th>Nama Pendaftar</th><th>JK</th><th>Tempat, Tgl Lahir</th><th>Asal Sekolah</th><th>Pek. Ortu</th>
<th>Tempat Tes</th><th>Bulan Tes</th><th class="n">MAT</th><th class="n">B.ING</th><th class="n">UMUM</th><th class="n">N. RATA</th><th>KETERANGAN</th>
</tr></thead>
<tbody>
<?php if (!$data): ?>
<tr><td colspan="13" class="n">Belum ada data</td></tr>
<?php else: foreach ($data as $d): ?>
<tr>
  <td><?= e($d['kode']) ?></td><td><?= e($d['nama']) ?></td><td><?= e($d['jk']) ?></td><td><?= e($d['ttl']) ?></td>
  <td><?= e($d['sek']) ?></td><td><?= e($d['ortu']) ?></td><td><?= e($d['tempat']) ?></td><td><?= e($d['bulan']) ?></td>
  <td class="n"><?= $d['mat'] ?></td><td class="n"><?= $d['ing'] ?></td><td class="n"><?= $d['um'] ?></td>
  <td class="n"><?= number_format($d['rata'], 2) ?></td><td><?= e($d['ket']) ?></td>
</tr>
<?php endforeach; endif; ?>
</tbody>
<tfoot>
<tr><td colspan="12" class="r">JUMLAH PENDAFTAR</td><td><?= count($data) ?></td></tr>
<tr><td colspan="12" class="r">JUMLAH PESERTA LULUS</td><td><?= $jmlLulus ?></td></tr>
<tr><td colspan="12" class="r">JUMLAH TIDAK PESERTA LULUS</td><td><?= $jmlTidak ?></td></tr>
</tfoot>
</table>
</div>

<div class="box" style="margin-top:16px;border:1px solid #999;padding:10px">
<b>Kode pendaftaran:</b>
<ul style="margin:6px 0">
<li>2 karakter awal untuk tempat tes dan gelombang: A = Gedung A, B = Gedung B, V = Viktor</li>
<li>1 karakter akhir bulan tes</li>
</ul>
Contoh: A2-101-9 &rarr; Gedung A – Gelombang 2, Bulan Tes: September
</div>
</body>
</html>
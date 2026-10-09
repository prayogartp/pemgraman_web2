<html>
<head>
    <title>Contoh Penggunaan UDF</title>
</head>
<body>
<form method="post">

    Masukkan Bilangan Pertama : <br>
    <input type="text" name="A" size="10"> <br>

    Masukkan Bilangan Kedua : <br>
    <input type="text" name="B" size="10"> <br>

    <input type="submit" value="hitung">

</form>
<?php

$a = $_POST["A"] ?? 0;
$b = $_POST["B"] ?? 0;

function jumlah($A, $B)
{
    $jumlahbil = $A + $B;
    return $jumlahbil;
}

function kurang($A, $B)
{
    $kurangbil = $A - $B;
    return $kurangbil;
}

function kali($A, $B)
{
    $kalibil = $A * $B;
    return $kalibil;
}

function bagi($A, $B)
{
    $bagibil = $A / $B;
    return $bagibil;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    echo "<br>";

    echo "Bilangan Pertama : ";
    echo $a;
    echo "<br>";

    echo "Bilangan Kedua : ";
    echo $b;
    echo "<br><br>";

    echo "Hasil Penjumlahan 2 buah bilangan";
    echo "<br>";

    $jumlahbil = jumlah($a, $b);

    printf(
        "Penjumlahan antara : %d + %d = %d",
        $a,
        $b,
        $jumlahbil
    );

    echo "<br><br>";
    echo "Hasil Pengurangan 2 buah bilangan";
    echo "<br>";

    $kurangbil = kurang($a, $b);

    printf(
        "Pengurangan antara : %d - %d = %d",
        $a,
        $b,
        $kurangbil
    );

    echo "<br><br>";
    echo "Hasil Perkalian 2 buah bilangan";
    echo "<br>";

    $kalibil = kali($a, $b);

    printf(
        "Perkalian antara : %d * %d = %d",
        $a,
        $b,
        $kalibil
    );

    echo "<br><br>";
    echo "Hasil Pembagian 2 buah bilangan";
    echo "<br>";

    if ($b != 0) {
        $bagibil = bagi($a, $b);

        printf(
            "Pembagian antara : %d / %d = %d",
            $a,
            $b,
            $bagibil
        );
    } else {
        echo "Pembagian dengan angka 0 tidak dapat dilakukan.";
    }
    echo "<br><br>";
}
?>
</body>
</html>
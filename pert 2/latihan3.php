<!DOCTYPE html>
<html>
<head>
    <title>Latihan 3</title>
    <style>
        body {
            margin-top: 50px;
        }
        .instruksi {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .label-merah {
            color: #cc0000;
            font-weight: bold;
        }
        table {
            margin: 0 auto;
        }
        td {
            text-align: center;
            padding: 2px 5px;
        }
    </style>
</head>
<body>
    <center>       
        <form method="POST" action="">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="label-merah">Nilai I</td>
                    <td></td>
                    <td class="label-merah">Nilai II</td>
                    <td></td>
                </tr>
                <tr>
                    <td><input type="number" name="nilai1" step="any" required></td>
                    <td>
                        <select name="operator">
                            <option value="+">+</option>
                            <option value="-">-</option>
                            <option value="*">*</option>
                            <option value="/">/</option>
                        </select>
                    </td>
                    <td><input type="number" name="nilai2" step="any" required></td>
                    <td><input type="submit" name="submit" value="submit"></td>
                </tr>
            </table>
        </form>

        <br><br>

        <?php
        if (isset($_POST['submit'])) {
            $nilai1 = $_POST['nilai1'];
            $nilai2 = $_POST['nilai2'];
            $operator = $_POST['operator'];
            $hasil = 0;

            switch ($operator) {
                case '+':
                    $hasil = $nilai1 + $nilai2;
                    break;
                case '-':
                    $hasil = $nilai1 - $nilai2;
                    break;
                case '*':
                    $hasil = $nilai1 * $nilai2;
                    break;
                case '/':
                    if ($nilai2 != 0) {
                        $hasil = $nilai1 / $nilai2;
                    } else {
                        $hasil = "Error (Tidak bisa dibagi 0)";
                    }
                    break;
            }

            echo "<h3>Hasil Perhitungan:</h3>";
            echo "<p style='font-size: 16px;'>$nilai1 $operator $nilai2 = <b>$hasil</b></p>";
        }
        ?>
    </center>
</body>
</html>
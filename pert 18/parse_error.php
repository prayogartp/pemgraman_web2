<?php
$a = 5;

if ($a > 0) {
    $status = "A lebih besar dari 0";
} else if ($a < 0) {
    $status = "A lebih kecil dari 0";
} else {
    $status = "A sama dengan 0";
}

echo $status;
?>
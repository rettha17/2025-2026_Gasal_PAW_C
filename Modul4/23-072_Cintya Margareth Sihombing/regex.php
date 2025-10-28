<?php
$nama = "Cintya Margareth";
if (preg_match("/^[a-zA-Z ]+$/", $nama)) {
    echo "Nama valid";
} else {
    echo "Nama tidak valid";
}
?>
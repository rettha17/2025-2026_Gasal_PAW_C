<?php
require 'validate.inc'; // panggil fungsi validasi

// Periksa input surname
if (validateName($_POST, 'surname'))
    echo 'Data OK!';
else
    echo 'Data invalid!';
?>

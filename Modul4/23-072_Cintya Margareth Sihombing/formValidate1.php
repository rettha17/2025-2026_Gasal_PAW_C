<?php
$errors = array();
$data = $_POST;

if (isset($_POST['surname'])) {
    require 'validate1.inc';
    validateName($errors, $_POST, 'surname');

    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error) {
            echo "$field $error<br>";
        }

        include 'form1.inc';
        show_form($errors, $data);
    } else {
        echo '<h1>Form submitted successfully with no errors</h1>';
    }
} else {
    include 'form1.inc';
    show_form(); // tampilkan form awal
}
?>

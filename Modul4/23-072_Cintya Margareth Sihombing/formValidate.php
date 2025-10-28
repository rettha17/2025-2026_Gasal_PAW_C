<?php
$errors = array();

if (isset($_POST['surname'])) 
{
    require 'validate1.inc';
    validateName($errors, $_POST, 'surname');

    if ($errors) 
    {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error)
            echo "$field $error<br>";

        include 'form.inc'; // tampilkan kembali form dengan pesan error
    } 
    else 
    {
        echo 'Form submitted successfully with no errors';
    }
} 
else 
    include 'form.inc'; // tampilkan form pertama kali
?>

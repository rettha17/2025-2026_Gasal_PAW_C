<?php
$email = "cintya@gmail.com";
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email valid";
} else {
    echo "Email tidak valid";
}

$url = "https://www.example.com";
if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo "URL valid";
}
?>
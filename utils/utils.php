<?php
function connect():PDO{
    $bdd=new PDO("mysql:host=localhost;dbname=chez_jeremy","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $bdd;
}

function sanitize($data):string{
    return $data=htmlentities(strip_tags(stripcslashes(trim($data))));
}

function formatPhoneNumber($phone) {
    // Supprimer les caractères non numériques, au cas où
    $phone = preg_replace('/\D/', '', $phone);

    if (strlen($phone) === 10) {
        return implode(' ', str_split($phone, 2)); // => "06 12 34 56 78"
    }

    return $phone;
}

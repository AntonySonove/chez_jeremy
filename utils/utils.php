<?php
function connect():PDO{
    $bdd=new PDO("mysql:host=localhost;dbname=chez_jeremy","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $bdd;
}
function sanitize($data):string{
    return $data=htmlentities(strip_tags(stripcslashes(trim($data))));
}
<?php
error_reporting(0);
try {
    $db = new PDO("mysql:host=localhost;dbname=secim;charset=utf8",'root','12345');
    //echo "Veritabanı bağlantısı başarılı";
}
catch (PDOExpception $e){
    echo $e->getMessage();
}
require_once 'class.phpmailer.php';

?>
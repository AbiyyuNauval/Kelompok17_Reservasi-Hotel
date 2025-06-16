<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "reservasi_hotel";

    $koneksi = new mysqli(hostname: $hostname, username: $username, password: $password, database: $database);

    if ($koneksi->connect_error){
        die("Failed");
    } else{
        
    }
?>
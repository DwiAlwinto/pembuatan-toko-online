<?php 
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "toko_azzahra";

    $koneksi = mysqli_connect($server, $user, $password, $database);
    
    //check koneksi
    if (mysqli_connect_errno()) {
        echo "Koneksi gagal to MySQL: " . mysqli_connect_error();
         exit();
    }
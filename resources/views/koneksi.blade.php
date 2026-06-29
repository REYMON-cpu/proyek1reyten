<?php
$conn = mysqli_connect("localhost", "root", "", "gopet");

if($conn){
    echo "Database terhubung";
} else {
    echo "Gagal koneksi";
}
?>
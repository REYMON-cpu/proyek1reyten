<?php
session_start();
include 'koneksi.php';

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "SELECT * FROM hewan WHERE id_user='$id_user'");

while($data = mysqli_fetch_array($query)){
    echo $data['nama_hewan'] . "<br>";
}
?>
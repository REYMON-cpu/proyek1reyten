<?php
include 'koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM user");

while($row = mysqli_fetch_array($data)){
    echo $row['nama'] . "<br>";
}
?>
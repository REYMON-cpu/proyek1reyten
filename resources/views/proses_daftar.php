<?php
session_start();
include 'koneksi.php';

// Mengambil data dari form pendaftaran (Register)
$nama     = $_POST['nama'];
$email    = $_POST['email'];
$password = $_POST['password'];
$role     = $_POST['role'];

// 1. Validasi: Cek dulu apakah email sudah pernah dipakai atau belum
$cek_email = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");

if (mysqli_num_rows($cek_email) > 0) {
    // Jika email sudah terdaftar di database
    echo "<script>
            alert('Email sudah terdaftar, Cees! Gunakan email lain.');
            window.location.href='register.php';
          </script>";
} else {
    // 2. Jika email aman, langsung masukkan data baru ke tabel 'user'
    $query = mysqli_query($conn, "INSERT INTO user (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");

    if ($query) {
        // Jika berhasil mendaftar, oper ke halaman login utama
        echo "<script>
                alert('Akun berhasil dibuat, Cees! Silakan login.');
                window.location.href='login.php'; 
              </script>";
    } else {
        // Jika terjadi kesalahan sistem database
        echo "Gagal mendaftarkan akun: " . mysqli_error($conn);
    }
}
?>
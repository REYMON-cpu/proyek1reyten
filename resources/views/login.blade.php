<?php
session_start();
include 'koneksi.php';

// --- LOGIKA PEMROSES LOGIN (DIJALANKAN JIKA TOMBOL MASUK DIKLIK) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Cari data user berdasarkan email
    $query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
    $data  = mysqli_fetch_array($query);

    if ($data) {
        // Cocokkan password teks biasa (Plaintext)
        if ($password == $data['password']) {

            // Simpan data ke session
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['nama']    = $data['nama'];
            $_SESSION['role']    = $data['role'];

            // Jika sukses, langsung dialihkan ke halaman dashboard
            header("Location: dashboard.php");
            exit();

        } else {
            echo "<script>alert('Password salah, Cees!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email tidak ditemukan, silakan daftar dulu!'); window.location.href='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoPet</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        h2 { color: #1e3a3a; margin: 10px 0; }
        p { color: #777; font-size: 14px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background-color: #1e3a3a; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: bold; margin-top: 10px; }
        .btn-submit:hover { background-color: #142828; }
        .register-link { margin-top: 20px; font-size: 14px; color: #555; }
        .register-link a { color: #1e3a3a; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <div class="login-container">
        <div style="font-size: 24px; font-weight: bold; color: #1e3a3a; margin-bottom: 5px;">🐾 GoPet</div>
        <h2>Selamat Datang, Cees!</h2>
        <p>Silakan masuk untuk mengelola anabul kesayanganmu.</p>

        <form action="login.php" method="POST">

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password kamu" required>
            </div>

            <div class="form-group">
                <label for="role">Masuk Sebagai</label>
                <select id="role" name="role" required>
                    <option value="Pemilik Hewan">Pemilik Hewan</option>
                    <option value="Penyedia Jasa">Penyedia Jasa</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar Sekarang</a>
        </div>
    </div>

</body>
</html>

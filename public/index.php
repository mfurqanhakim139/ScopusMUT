<?php
// TAMBAHKAN 3 BARIS INI SEMENTARA UNTUK DEBUGGING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Aktifkan laporan error agar jika ada salah nama folder, sistem langsung memberitahu
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Panggil file konfigurasi
require_once __DIR__ . '/../config/config.php';

// =========================================================================
// JURUS PAMUNGKAS: Custom Autoloader (Pengganti Composer)
// Sistem ini akan mencari file langsung secara otomatis dan kebal terhadap error cache
// =========================================================================
spl_autoload_register(function ($class) {
    // Prefix namespace yang kita gunakan
    $prefix = 'App\\';
    
    // Direktori folder aplikasi kita (harus 'app' huruf kecil)
    $base_dir = __DIR__ . '/../app/';

    // Cek apakah class yang dipanggil menggunakan namespace App\
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Ambil sisa nama class (contohnya menjadi: Core/App)
    $relative_class = substr($class, $len);

    // Buat path/alamat file fisik yang sebenarnya di server Linux
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Jika filenya ada, load file tersebut
    if (file_exists($file)) {
        require $file;
    } else {
        // JIKA MASIH ERROR, SISTEM AKAN MENCETAK ALAMAT YANG SALAH DI SINI:
        die("<div style='background:#fee2e2; padding:20px; border:1px solid red; font-family:sans-serif;'>
            <h3 style='color:red;'>🚨 Cek Nama Folder Anda!</h3>
            Sistem mencoba mencari file di alamat Linux ini:<br>
            <code style='background:#fff; padding:5px; font-size:16px; display:inline-block; margin-top:10px;'>" . realpath(__DIR__ . '/../') . "/app/" . str_replace('\\', '/', $relative_class) . ".php</code><br><br>
            <b>Solusi:</b> Buka File Manager cPanel, pastikan alamat di atas benar-benar ada dan <b>HURUF BESAR/KECILNYA</b> sama persis!
            </div>");
    }
});

// Menjalankan Aplikasi
$app = new App\Core\App();
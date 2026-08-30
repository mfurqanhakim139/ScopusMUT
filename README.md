# ScopusMUT: Stateless MVC Architecture 
 
## Deskripsi 
Aplikasi web berbasis PHP Native MVC yang ringan untuk mengekstrak metadata Scopus menggunakan sistem Bring-Your-Own-Key. 
 
## Persyaratan Sistem 
- PHP 8.1 atau lebih baru 
- Web Server 
- Ekstensi PHP cURL diaktifkan 
 
## Instalasi 
1. Clone repositori ini: git clone https://github.com/mfurqanhakim139/ScopusMUT.git 
2. Buat file .env dari template .env.example 
3. Masukkan API Key Scopus Anda di dalam file .env 
4. Jalankan aplikasi di local server Anda 
 
## Keamanan dan Privasi 
Repositori ini tidak menyimpan kredensial. API Key pengguna hanya dikirim via POST request dan disimpan sementara di memori, lalu langsung dihapus. 

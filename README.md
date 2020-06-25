# Sistem Informasi Notulen
Merupakan versi _rewrite_ dari aplikasi notulen sebelumnya yang bertujuan untuk mencatat hasil rapat, lampiran dan peserta hadir. Dibuat saat saya PKL di Universitas Muhammadiyah Yogyakarta.

## Instalasi & Setup
```bash
git clone https://github.com/mxsgx/si-notulen-umy
cd si-notulen-umy
composer install --no-dev --no-scripts
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate --ansi
```
Silahkan konfigurasi database pada file `.env` dan kebutuhannya kemudian:
```bash
php artisan migrate --seed
``` 

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Introduction

- Laravel 12 
- PHP 8.2 - 8.5
- DB PostgreSQL

## Installation

- composer install
- generate file .env atau copy from file .env.example dan comfiguration with database
- php artisan key:generate
- php artisan migrate
- php artisan db:seed

## Akun Dummy

- Requestor => username:requestor | password:requestorpass
- SPV Gudang => username:spv | password:spvpass
- Kepala Gudang => username:head | password:headpass
- Manager Operasional => username:manager | password:managerpass
- Direktur Operasional => username:coo | password:coopass
- Direktur Keuangan => username:cfo | password:cfopass

## Cara menjalankan aplikasi

Aplikasi Approval merupakan sistem pengajuan pembangunan gudang distribusi dengan proses approval berjenjang. dimulai dari :

- Login aplikasi menggunakan akun dummy yang telah disediakan diatas, aktifkan 2FA Google Authenticator
- Requestor mengajukan data berupa judul, lokasi, budget, keterangan dan dokumen yang diperlukan. Pada saat menambah data terdapat tombol untuk simpan data ke dalam draft atau melakukan pengiriman data. Data pengajuan baru akan bisa dilihat oleh approver ketika data dikirim.
- Data yang sudah di kirim oleh Requestor akan dilakukan approval dengan urutan sebagai berikut: SPV Gudang > Kepala Gudang > Manager Operasional > Direktur Operasional > Direktur Keuangan.
- Apabila dari approver terdapat reject maka proses pengajuan berhenti, dan pihak reject wajib memberikan alasan penolakan.
- Pengajuan dinyatakan disetujui jika semua pihak melakukan approve.

## Lokasi Dokumen

- /public/uploads/files
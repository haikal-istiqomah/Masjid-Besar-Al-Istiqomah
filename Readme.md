Readme Masjid Besar Al-istiqomah (draft)
Masjid Besar Al-Istiqomah — Sistem Informasi (Laravel)

Dokumen ini adalah draf README untuk memudahkan setup lokal, pengembangan fitur, dan pengujian pembayaran (Midtrans) serta kalkulator zakat.

Ringkas Proyek

Sistem Informasi untuk aktivitas Masjid Besar Al‑Istiqomah: donasi online, kalkulator zakat, manajemen jamaah/keluarga/kematian, dsb.

Fitur Utama (saat ini)

Donasi Online: Integrasi Midtrans (Sandbox) dengan notifikasi pembayaran.

Kalkulator Zakat: Perhitungan Fitrah & Fidyah berbasis parameter wilayah & tahun.

Data Jamaah: Struktur tabel keluarga/anggota & kejadian kematian (migrasi tersedia).

Teknologi

Laravel ^11, PHP ^8.2

PostgreSQL 14+

Laragon (Windows) / PHP Dev Server

Midtrans Snap (Sandbox)

Prasyarat

PHP 8.2+, Composer

PostgreSQL aktif & kredensial DB siap

Akun Midtrans Sandbox

(Opsional) Ngrok untuk publikasi URL callback

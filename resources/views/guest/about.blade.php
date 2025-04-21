@extends('layouts.guest.template')
@section('content')
    <!-- hero area for About -->
    <div class="breadcrumb-section hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Mengenal Lebih Dekat</p>
                        <h1>Tentang Kami</h1>
                        <div class="hero-btns">
                            <a href="{{ route('guest.kontak') }}" class="bordered-btn">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- featured section -->
    <div class="feature-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="featured-text">
                        <h2 class="pb-3">Mengapa <span class="orange-text">Eventway</span></h2>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb-4 mb-md-5">
                                <div class="list-box d-flex">
                                    <div class="list-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Manajemen Acara</h3>
                                        <p>Kelola acara kamu dengan mudah, mulai dari pembuatan hingga selesai, semuanya
                                            dalam satu platform.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-5 mb-md-5">
                                <div class="list-box d-flex">
                                    <div class="list-icon">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Sistem Tiket</h3>
                                        <p>Sistem tiket kami yang mulus memastikan proses pembelian tiket yang lancar bagi
                                            penyelenggara maupun peserta.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-5 mb-md-5">
                                <div class="list-box d-flex">
                                    <div class="list-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Keterlibatan Komunitas</h3>
                                        <p>Bangun komunitas yang kuat di sekitar acara kamu dengan fitur untuk interaksi dan
                                            umpan balik.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="list-box d-flex">
                                    <div class="list-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Analitik & Insight</h3>
                                        <p>Dapatkan wawasan berharga tentang kinerja acara dan perilaku audiens melalui
                                            analitik bawaan kami.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end featured section -->


    <!-- testimonail-section -->
    <div class="testimonail-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <h2 class="mb-5">Apa Kata Mereka tentang <span class="text-primary">EventWay</span>?</h2>
                    <div class="testimonial-sliders">

                        <div class="single-testimonial-slider">
                            <div class="client-avater">
                                <img src="{{ asset('assets/frontend/assets/img/avaters/avatar1.png') }}"
                                    alt="Pengunjung Event">
                            </div>
                            <div class="client-meta">
                                <h3>Rizky Amelia <span>Pengunjung Event</span></h3>
                                <p class="testimonial-body">
                                    "Aku baru pertama kali beli tiket konser online lewat EventWay, dan ternyata prosesnya
                                    cepat banget. Tiket langsung dikirim ke email lengkap sama QR Code. Gampang tinggal scan
                                    di venue!"
                                </p>
                                <div class="last-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </div>

                        <div class="single-testimonial-slider">
                            <div class="client-avater">
                                <img src="{{ asset('assets/frontend/assets/img/avaters/avatar2.png') }}" alt="EO">
                            </div>
                            <div class="client-meta">
                                <h3>Agung Prasetya <span>Event Organizer</span></h3>
                                <p class="testimonial-body">
                                    "Kami pakai EventWay buat jual tiket event komunitas, dan semuanya bisa dimonitor dari
                                    dashboard. Fitur notifikasi pembelian dan konfirmasi pembayaran sangat membantu banget!"
                                </p>
                                <div class="last-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </div>

                        <div class="single-testimonial-slider">
                            <div class="client-avater">
                                <img src="{{ asset('assets/frontend/assets/img/avaters/avatar3.png') }}" alt="Vendor">
                            </div>
                            <div class="client-meta">
                                <h3>Sinta Maharani <span>Vendor Makanan</span></h3>
                                <p class="testimonial-body">
                                    "Berpartisipasi di event yang diorganisir lewat EventWay itu beda banget. Informasi
                                    lengkap, terorganisir, dan jumlah pengunjung bisa diprediksi karena sistem tiket yang
                                    rapi!"
                                </p>
                                <div class="last-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end testimonail-section -->
@endsection

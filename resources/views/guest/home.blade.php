@extends('layouts.guest.template') {{-- Atau bikin layout khusus guest kalau mau beda gaya --}}

@section('content')
    <!-- hero area -->
    <div class="hero-area hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 offset-lg-2 text-center">
                    <div class="hero-text">
                        <div class="hero-text-tablecell">
                            <p class="subtitle">Setiap Momen Punya Cerita</p>
                            <p
                                style="color: white; font-size: 55px; font-weight: 700; line-height: 1.2; margin-bottom: 30px;">
                                EventWay - Wujudkan Acara yang Tak Terlupakan</p>
                            <div class="hero-btns">
                                <a href="{{ route('guest.event') }}" class="boxed-btn">Lihat Event</a>
                                <a href="{{ route('guest.kontak') }}" class="bordered-btn">Hubungi Kami</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end hero area -->

    <!-- features list section -->
    <div class="list-section pt-80 pb-80">
        <div class="container">

            <div class="row text-center">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="list-box d-flex flex-column align-items-center">
                        <div class="list-icon mb-3">
                            <i class="fas fa-ticket-alt fa-2x text-orange"></i>
                        </div>
                        <div class="content">
                            <h3 class="mb-2">E-Ticket Instan</h3>
                            <p>Tiket langsung dikirim setelah pembayaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="list-box d-flex flex-column align-items-center">
                        <div class="list-icon mb-3">
                            <i class="fas fa-headset fa-2x text-orange"></i>
                        </div>
                        <div class="content">
                            <h3 class="mb-2">Bantuan 24/7</h3>
                            <p>Tim kami siap bantu kapan pun dibutuhkan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="list-box d-flex flex-column align-items-center">
                        <div class="list-icon mb-3">
                            <i class="fas fa-shield-alt fa-2x text-orange"></i>
                        </div>
                        <div class="content">
                            <h3 class="mb-2">Pembayaran Aman</h3>
                            <p>Didukung oleh sistem Midtrans terpercaya</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end features list section -->

    <!-- event section -->
    <div class="product-section mt-100 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Upcoming</span> Events</h3>
                        <p>Temukan berbagai acara menarik yang akan datang!</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($events as $event)
                    <div class="col-lg-4 col-md-6 text-center mb-4">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('guest.detail', $event->slug) }}">
                                    <img src="{{ asset($event->image) }}" alt="{{ $event->title }}">
                                </a>
                            </div>
                            <h3>{{ $event->title }}</h3>
                            <p class="product-price">
                                <span>{{ $event->kota }}</span>
                                {{ \Carbon\Carbon::parse($event->tgl_mulai)->translatedFormat('d M Y') }} <br>
                                @if ($event->harga)
                                    <span>Rp {{ number_format($event->harga, 0, ',', '.') }}</span>
                                @else
                                    <span>Harga tidak tersedia</span>
                                @endif
                            </p>
                            <a href="{{ route('guest.detail', $event->slug) }}" class="cart-btn">
                                <i class="fas fa-calendar-check"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end event section -->

    <!-- event gratis terdekat section -->
    @if ($eventGratis)
        <section class="cart-banner pt-50 pb-100">
            <div class="container">
                <div class="row clearfix">
                    <!-- Image Column -->
                    <div class="image-column col-lg-6">
                        <div class="image">
                            <div class="price-box">
                                <div class="inner-price bg-basic text-white">
                                    <span class="price">
                                        <strong>GRATIS</strong><br> Tiket Masuk
                                    </span>
                                </div>
                            </div>
                            <img src="{{ asset($event->image) }}" alt="{{ $eventGratis->title }}">
                        </div>
                    </div>
                    <!-- Content Column -->
                    <div class="content-column col-lg-6">
                        <h3><span class="orange-text">Event</span> Gratis Terdekat</h3>
                        <h4>{{ $eventGratis->title }}</h4>
                        <div class="text">
                            {{ \Illuminate\Support\Str::limit(strip_tags($eventGratis->deskripsi), 150) }}
                        </div>
                        <!-- Countdown Timer -->
                        <div class="time-counter">
                            <div class="time-countdown clearfix" data-countdown="{{ $eventGratis->tgl_mulai }}">
                                <div class="counter-column">
                                    <div class="inner"><span class="count">00</span>Hari</div>
                                </div>
                                <div class="counter-column">
                                    <div class="inner"><span class="count">00</span>Jam</div>
                                </div>
                                <div class="counter-column">
                                    <div class="inner"><span class="count">00</span>Menit</div>
                                </div>
                                <div class="counter-column">
                                    <div class="inner"><span class="count">00</span>Detik</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('guest.detail', $eventGratis->slug) }}" class="cart-btn mt-3">
                            <i class="fas fa-ticket-alt"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <script>
        $('[data-countdown]').each(function() {
            var $this = $(this),
                finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('' +
                    '<div class="counter-column"><div class="inner"><span class="count">%D</span>Hari</div></div>' +
                    '<div class="counter-column"><div class="inner"><span class="count">%H</span>Jam</div></div>' +
                    '<div class="counter-column"><div class="inner"><span class="count">%M</span>Menit</div></div>' +
                    '<div class="counter-column"><div class="inner"><span class="count">%S</span>Detik</div></div>'
                ));
            });
        });
    </script>


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


    <!-- eventway advertisement section -->
    <div class="abt-section mb-150">
        <div class="container">
            <div class="row">
                <!-- Video Column -->
                <div class="col-lg-6 col-md-12">
                    <div class="abt-bg">
                        <a href="https://www.youtube.com/watch?v=W3qG1CuuC0g" class="video-play-btn popup-youtube">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                </div>
                <!-- Content Column -->
                <div class="col-lg-6 col-md-12">
                    <div class="abt-text">
                        <p class="top-sub">Sejak 2020</p>
                        <h2>Kami adalah <span class="orange-text">EventWay</span></h2>
                        <p>EventWay adalah platform yang menghubungkan Anda dengan berbagai event menarik di sekitar Anda.
                            Temukan, daftar, dan nikmati pengalaman tak terlupakan bersama kami.</p>
                        <p>Dengan jaringan event organizer profesional, kami memastikan setiap acara yang kami tampilkan
                            memiliki kualitas terbaik dan memberikan pengalaman yang berkesan.</p>
                        <a href="{{ route('guest.about') }}" class="boxed-btn mt-4">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end eventway advertisement section -->

    <style>
        .list-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .list-box:hover {
            transform: translateY(-5px);
        }

        .text-orange {
            color: #5da6ff;
        }
    </style>
@endsection

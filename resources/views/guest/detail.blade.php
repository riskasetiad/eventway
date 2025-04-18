@extends('layouts.guest.template')

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset($event->image) }}') center center / cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center text-white">
                    <div class="breadcrumb-text py-5">
                        <p>Detail Acara</p>
                        <h1>{{ $event->title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- single event -->
    <div class="single-product mt-80 mb-150">
        <div class="container">
            <!-- Judul & Kategori -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <p class="single-product-pricing">
                        <!-- Menampilkan kategori dengan menggunakan relasi many-to-many -->
                        {{ $event->kategoris->pluck('kategori')->implode(', ') }}
                    </p>
                    <h3>{{ $event->title }}</h3>
                </div>
            </div>

            <!-- Gambar dan Detail -->
            <div class="row">
                <!-- Kolom Gambar -->
                <div class="col-md-5">
                    <div class="single-product-img mb-3">
                        <img src="{{ asset($event->image) }}" alt="{{ $event->title }}"
                            style="width: 100%; border-radius: 10px; object-fit: cover;">
                    </div>
                </div>

                <!-- Kolom Detail -->
                <div class="col-md-7">
                    <div class="single-product-content">
                        @php
                            use Carbon\Carbon;
                            Carbon::setLocale('id');

                            $tglMulai = Carbon::parse($event->tgl_mulai);
                            $tglSelesai = Carbon::parse($event->tgl_selesai);
                        @endphp

                        <!-- Detail Event -->
                        <p>
                            <i class="fa-regular fa-calendar-days me-2"></i>
                            <strong>Tanggal:</strong>
                            @if ($tglMulai->toDateString() === $tglSelesai->toDateString())
                                {{ $tglMulai->translatedFormat('d F Y') }}
                            @else
                                {{ $tglMulai->translatedFormat('d F Y') }} -
                                {{ $tglSelesai->translatedFormat('d F Y') }}
                            @endif
                        </p>

                        <p>
                            <i class="fa-regular fa-clock me-2"></i>
                            <strong>Waktu:</strong> {{ $event->waktu_mulai }} - {{ $event->waktu_selesai }}
                        </p>

                        <p>
                            <i class="fa-solid fa-location-dot me-2"></i>
                            <strong>Lokasi:</strong>
                            @if ($event->url_lokasi)
                                <a href="{{ $event->url_lokasi }}" target="_blank">
                                    {{ $event->lokasi }}
                                </a>
                            @else
                                {{ $event->lokasi }}
                            @endif
                        </p>
                        <a href="{{ route('guest.checkout.form') }}" class="boxed-btn mt-3">Beli Tiket</a>
                    </div>
                </div>
            </div>

            <!-- Kolom Deskripsi di bawah gambar -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="event-description">
                        <div>{!! $event->deskripsi !!}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end single event -->

        <!-- more events -->
        <div class="more-products mt-100 mb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="section-title">
                            <h3><span class="orange-text">Event</span> Lainnya</h3>
                            <p>Beberapa event lain yang mungkin menarik untukmu.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($relatedEvents as $related)
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="{{ route('guest.detail', $related->slug) }}">
                                        <img src="{{ asset($related->image) }}" alt="{{ $related->title }}">
                                    </a>
                                </div>
                                <h3>{{ $related->title }}</h3>
                                <p class="product-price">
                                    <span>{{ $related->kategoris->pluck('kategori')->implode(', ') }}</span>
                                </p>
                                <a href="{{ route('guest.detail', $related->slug) }}" class="cart-btn"><i
                                        class="fas fa-eye"></i>
                                    Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

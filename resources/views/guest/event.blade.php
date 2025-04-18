@extends('layouts.guest.template')
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Shop</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- products -->
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <!-- Filter Kategori -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="category-filter text-center">
                        <li><button class="filter-btn active" data-filter="all">All</button></li>
                        @foreach ($categories as $category)
                            <li>
                                <button class="filter-btn" data-filter="{{ Str::slug($category->kategori) }}">
                                    {{ $category->kategori }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- List Event -->
            <div class="row product-lists">
                @foreach ($events as $event)
                    <div
                        class="col-lg-4 col-md-6 text-center event-item
                        {{ $event->kategoris->map(fn($k) => Str::slug($k->kategori))->implode(' ') }}">
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
                                    <span>Harga: Rp {{ number_format($event->harga, 0, ',', '.') }}</span>
                                @else
                                    <span>Harga tidak tersedia</span>
                                @endif
                            </p>
                            <a href="{{ route('guest.detail', $event->slug) }}" class="cart-btn">
                                <i class="fas fa-calendar-alt"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end products -->

    <!-- CSS -->
    <style>
        .category-filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            padding: 0;
            list-style: none;
            margin-bottom: 40px;
        }

        .category-filter li {
            margin: 0;
        }

        .filter-btn {
            border: none;
            padding: 12px 24px;
            border-radius: 999px;
            background-color: white;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background-color: #f2f2f2;
        }

        .filter-btn.active {
            background-color:#88bdff;
            color: white;
        }
    </style>

    <!-- JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.filter-btn');
            const items = document.querySelectorAll('.event-item');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ganti active button
                    buttons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.dataset.filter;

                    items.forEach(item => {
                        if (filter === 'all' || item.classList.contains(filter)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection

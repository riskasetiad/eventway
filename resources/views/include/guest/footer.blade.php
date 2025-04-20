<!-- footer -->
<div class="footer-area">
    <div class="container">
        <div class="row">
            <!-- About EventWay -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box about-widget">
                    <h2 class="widget-title">Tentang Kami</h2>
                    <p>EventWay adalah platform digital yang membantu Anda menemukan dan mengelola berbagai event menarik, baik lokal maupun nasional. Bergabunglah dan temukan pengalaman seru di sekitar Anda!</p>
                </div>
            </div>

            <!-- Contact -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box get-in-touch">
                    <h2 class="widget-title">Kontak Kami</h2>
                    <ul>
                        <li>Jl. Event Raya No.123, Jakarta</li>
                        <li>support@eventway.id</li>
                        <li>+62 812 3456 7890</li>
                    </ul>
                </div>
            </div>

            <!-- Navigasi -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box pages">
                    <h2 class="widget-title">Navigasi</h2>
                    <ul>
                        <li><a href="{{ route('guest.home') }}">Beranda</a></li>
                        <li><a href="{{ route('guest.about') }}">Tentang</a></li>
                        <li><a href="{{ route('guest.event') }}">Event</a></li>
                        <li><a href="{{ route('guest.kontak') }}">Kontak</a></li>
                    </ul>
                </div>
            </div>

            <!-- Subscribe -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box subscribe">
                    <h2 class="widget-title">Berlangganan</h2>
                    <p>Daftarkan email Anda untuk mendapatkan info event terbaru dari EventWay.</p>
                    <form action="#" method="POST">
                        @csrf
                        <input type="email" name="email" placeholder="Email Anda" required>
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end footer -->

<!-- copyright -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p>Hak Cipta &copy; {{ now()->year }} - EventWay. Seluruh hak dilindungi undang-undang.</p>
            </div>
            <div class="col-lg-6 text-right col-md-12">
                <div class="social-icons">
                    <ul>
                        <li><a href="https://facebook.com/eventway" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="https://twitter.com/eventway" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="https://instagram.com/eventway" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://linkedin.com/company/eventway" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end copyright -->

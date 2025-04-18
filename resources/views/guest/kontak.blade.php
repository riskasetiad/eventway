@extends('layouts.guest.template')
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Dukungan 24/7 Tersedia</p>
                        <h1>Hubungi Kami</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- contact form -->
    <div class="contact-from-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="form-title">
                        <h2>Ada pertanyaan?</h2>
                        <p>Silakan hubungi kami jika kamu memiliki pertanyaan, saran, atau butuh bantuan terkait platform
                            Eventway.</p>
                    </div>
                    <div id="form_status"></div>
                    <div class="contact-form">
                        <form type="POST" id="eventway-contact" onSubmit="return valid_datas( this );">
                            <p>
                                <input type="text" placeholder="Nama" name="name" id="name">
                                <input type="email" placeholder="Email" name="email" id="email">
                            </p>
                            <p>
                                <input type="tel" placeholder="Telepon" name="phone" id="phone">
                                <input type="text" placeholder="Subjek" name="subject" id="subject">
                            </p>
                            <p>
                                <textarea name="message" id="message" cols="30" rows="10" placeholder="Pesan Anda"></textarea>
                            </p>
                            <input type="hidden" name="token" value="FsWga4&@f6aw" />
                            <p><input type="submit" value="Kirim Pesan"></p>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-form-wrap">
                        <div class="contact-form-box">
                            <h4><i class="fas fa-map"></i> Alamat Kantor</h4>
                            <p>Jl. Contoh No. 123<br>Kota Eventway<br>Indonesia</p>
                        </div>
                        <div class="contact-form-box">
                            <h4><i class="far fa-clock"></i> Jam Operasional</h4>
                            <p>SENIN - JUMAT: 08.00 - 21.00 <br>SABTU - MINGGU: 10.00 - 20.00</p>
                        </div>
                        <div class="contact-form-box">
                            <h4><i class="fas fa-address-book"></i> Kontak</h4>
                            <p>Telepon: +62 812 3456 7890<br>Email: support@eventway.id</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end contact form -->

    <!-- find our location -->
    <div class="find-location blue-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p><i class="fas fa-map-marker-alt"></i> Temukan Lokasi Kami</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end find our location -->

    <!-- google map section -->
    <div class="embed-responsive embed-responsive-21by9">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26432.42324808999!2d-118.34398767954286!3d34.09378509738966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2bf07045279bf%3A0xf67a9a6797bdfae4!2sHollywood%2C%20Los%20Angeles%2C%20CA%2C%20USA!5e0!3m2!1sen!2sbd!4v1576846473265!5m2!1sen!2sbd"
            width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
            class="embed-responsive-item"></iframe>
    </div>
    <!-- end google map section -->
@endsection

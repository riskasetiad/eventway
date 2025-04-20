 <!--PreLoader-->
 <div class="loader">
     <div class="loader-inner">
         <div class="circle"></div>
     </div>
 </div>
 <!--PreLoader Ends-->
 <!-- header -->
 <div class="top-header-area" id="sticker">
     <div class="container">
         <div class="row">
             <div class="col-lg-12 col-sm-12 text-center">
                 <div class="main-menu-wrap">
                     <!-- logo -->
                     <div class="site-logo">
                         <a href="index.html">
                             <img src="{{ asset('assets/frontend/assets/img/logo.png') }}" alt="">
                         </a>
                     </div>
                     <!-- logo -->

                     <!-- menu start -->
                     <nav class="main-menu">
                         <ul>
                             <li class="current-list-item"><a href="{{ route('guest.home') }}">Beranda</a></li>
                             <li><a href="{{ route('guest.about') }}">Tentang</a></li>
                             <li><a href="{{ route('guest.event') }}">Event</a></li>
                             <li><a href="{{ route('guest.kontak') }}">Kontak</a></li>
                             <li>
                                 <div class="header-icons">
                                     <a class="mobile-hide search-bar-icon" href="#" onclick="toggleSearch()">
                                         <i class="fas fa-search"></i>
                                     </a>
                                     <a class="mobile-hide register-icon" href="{{route('register')}}">
                                         <i class="fas fa-user-plus"></i>
                                     </a>
                                 </div>
                             </li>
                         </ul>
                     </nav>

                     <!-- Search input (toggle by icon click) -->
                     <form action="{{ route('guest.event') }}" method="GET" id="search-form"
                         class="search-form d-none">
                         <input type="text" name="search" placeholder="Cari event..."
                             value="{{ request('search') }}" onkeydown="if(event.key === 'Enter') this.form.submit();">
                     </form>

                     <script>
                         function toggleSearch() {
                             const form = document.getElementById('search-form');
                             form.classList.toggle('d-none');
                             if (!form.classList.contains('d-none')) {
                                 form.querySelector('input').focus();
                             }
                         }
                     </script>

                     <style>
                         .search-form {
                             text-align: center;
                             margin-top: 10px;
                         }

                         .search-form input {
                             padding: 6px 15px;
                             border-radius: 20px;
                             border: 1px solid #ccc;
                             width: 250px;
                             max-width: 90%;
                         }

                         .d-none {
                             display: none !important;
                         }
                     </style>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- end header -->

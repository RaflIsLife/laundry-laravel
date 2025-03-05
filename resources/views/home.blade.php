@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="hero-section bg-light vh-100 d-flex align-items-center mb-0 pb-0"
            style="background-image: url('image/home/back.webp')">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="display-3 fw-bold mb-3 text-white">
                            Welcome to our<br>
                            <span class="text-white">Laundry Store
                            </span>
                        </h1>
                        <p class="lead text-white">Rasakan perawatan kain terbaik dengan layanan laundry modern kami</p>
                        <a class="btn btn-light btn-lg text-primary fw-bold" href="{{ route('login') }}">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border: 14px solid rgb(124, 159, 210); opacity: 1;" class="mt-0">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="font-size: 73px">Jelajahi Keunggulan Kami</h2>
                <p class="text-muted">Rasakan layanan laundry terbaik dengan solusi inovatif yang memudahkan Anda.</p>
            </div>
            <div class="row align-items-center mb-5 mt-5">
                <div class="col-md-6">
                    <h2 class="display-5 fw-bold mb-4">
                        Layanan<br>
                        <span class="text-primary"> Profesional</span>
                    </h2>
                    <p class="text-muted">
                        Kami menghadirkan layanan laundry berkualitas dengan pencucian higienis dan perawatan maksimal.
                        Pakaian Anda akan selalu bersih, segar, dan nyaman dikenakan setiap hari.
                    </p>
                </div>
                <div class="col-md-6">
                    <img src="image/home/c1.webp" alt="Laundry Service" class="img-fluid rounded">
                </div>
            </div>

            <div class="row align-items-center mb-5 mt-5">
                <div class="col-md-6 order-md-2">
                    <h2 class="display-5 fw-bold mb-4">
                        Proses<br>
                        <span class="text-primary">Cepat & Berkualitas</span>
                    </h2>
                    <p class="text-muted">
                        Hemat waktu dengan layanan laundry kilat dan antar-jemput. Kami memastikan pakaian bersih dan rapi
                        dalam waktu singkat tanpa mengurangi kualitas.
                    </p>
                </div>
                <div class="col-md-6 order-md-1" style="border-radius: 100px; display: flex; overflow: hidden;">
                    <img src="image/home/c2.webp" alt="Laundry Care" class="img-fluid rounded">
                </div>
            </div>

            <div class="row align-items-center mb-5 mt-5"
                style="background-image: url(image/home/c3.webp); background-position: right; background-size: cover; height: 560px;">
                <div class="col-md-6">
                    <h2 class="display-5 fw-bold mb-4">
                        Perawatan<br>
                        <span class="text-primary"> Khusus</span>
                    </h2>
                    <p class="text-muted">
                        Setiap jenis kain membutuhkan perawatan berbeda. Dari pakaian harian hingga bahan sensitif, kami
                        menggunakan metode terbaik.
                    </p>
                </div>
            </div>

            <div class="row align-items-center mb-5 mt-5">
                <div class="col-md-6 order-md-2">
                    <h2 class="display-5 fw-bold mb-4">
                        Harga<br>
                        <span class="text-primary">Terjangkau</span>
                    </h2>
                    <p class="text-muted">
                        Laundry berkualitas tak harus mahal. Dengan harga bersahabat, kami memastikan pakaian Anda tetap
                        bersih, wangi, dan siap pakai kapan saja.
                    </p>
                </div>
                <div class="col-md-6 order-md-1" style="border-radius: 100px; display: flex; overflow: hidden;">
                    <img src="image/home/c4.webp" alt="Laundry Care" class="img-fluid rounded">
                </div>
            </div>
        </div>

        <div class="text-white py-5">
            <div class="container">
                <div class="row g-4 align-content-between justify-content-between">
                    <div class="col-md-4 text-center text-black-50 card pb-5 hover-card-blue"
                        style="border-radius: 20px; background-color: rgba(195, 232, 250, 0.651); width: 31%;">
                        <img src="image/home/truck.png" alt="Service" class="card-img mb-4 mt-4 rounded align-self-center"
                            style="width: 148px; height: 148px">
                        <h4 class="mb-5">Kami Siap Antar-Jemput Cucianmu Kapan Saja, Di Mana Saja!</h4>
                    </div>
                    <div class="col-md-4 text-center text-black-50 card pb-5 hover-card-blue"
                        style="border-radius: 20px; background-color: rgba(195, 232, 250, 0.651); width: 31%;">
                        <img src="image/home/clock.png" alt="Service" class="card-img mb-4 mt-4 rounded align-self-center"
                            style="width: 148px; height: 148px">
                        <h4 class="mb-5">Layanan Pelanggan 24/7, Siap Membantu Tanpa Perlu Keluar Rumah!</h4>
                    </div>

                    <div class="col-md-4 text-center text-black-50 card pb-5 hover-card-blue"
                        style="border-radius: 20px; background-color: rgba(195, 232, 250, 0.651); width: 31%;">
                        <img src="image/home/dolar.png" alt="Service" class="card-img mb-4 mt-4 rounded align-self-center"
                            style="width: 148px; height: 148px">
                        <h4 class="mb-5">Nikmati Diskon Menarik pada Setiap Pemesanan Anda dan Hemat Lebih Banyak!</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-5 py-5 text-center">
            <h2 class="display-5 fw-bold mb-4" style="font-size: 77px; line-height: 70px;">
                Apa yang akan kami lakukan<br>
                Dengan pakaian anda
            </h2>
            <div class="row g-4 align-content-between justify-content-between mt-4">
                <div class="col-md-4 text-center text-black-50 card pb-5 hover-card-blue"
                    style="border-radius: 20px; background-color: rgba(195, 232, 250, 0.651); width: 23%; height: 300px;">
                    <img src="image/home/wash.png" alt="Service" class="card-img mb-3 mt-4 rounded align-self-center"
                        style="width: 60px; height: 60px">
                    <h4 class="mb-3 text-black">Mencuci</h4>
                    <p class="">Pakaian Anda dicuci dengan hati-hati menggunakan deterjen berkualitas, sehingga tetap
                        bersih, wangi, dan terjaga keawetannya.</p>
                </div>
                <div class="col-md-4 text-center text-black-50 card pb-5 hover-card-blue"
                    style="border-radius: 20px; background-color: rgba(195, 232, 250, 0.651); width: 23%; height: 300px;">
                    <img src="image/home/dry.png" alt="Service" class="card-img mb-3 mt-4 rounded align-self-center"
                        style="width: 60px; height: 60px">
                    <h4 class="mb-3 text-black">Mengeringkan</h4>
                    <p class="">Kami mengeringkan pakaian dengan metode yang aman, sehingga pakaian tetap lembut dan
                        tidak rusak.</p>
                </div>
                <div class="col-md-4 text-center text-black-50 card pb-5 hover-card-blue"
                    style="border-radius: 20px; background-color: rgba(195, 232, 250, 0.651); width: 23%; height: 300px;">
                    <img src="image/home/iron.png" alt="Service" class="card-img mb-3 mt-4 rounded align-self-center"
                        style="width: 60px; height: 60px">
                    <h4 class="mb-3 text-black">Menyetrika</h4>
                    <p class="">Kami menyetrika pakaian dengan rapi dan halus, siap digunakan untuk setiap kesempatan
                        tanpa kusut</p>
                </div>
                <div class="col-md-4 text-center text-black-50 card pb-5 hover-card-blue"
                    style="border-radius: 20px; background-color: rgba(195, 232, 250, 0.651); width: 23%; height: 300px;">
                    <img src="image/home/fold.png" alt="Service" class="card-img mb-3 mt-4 rounded align-self-center"
                        style="width: 60px; height: 60px">
                    <h4 class="mb-3 text-black">Melipat</h4>
                    <p class="">Pakaian yang telah dicuci dan disetrika kami lipat dengan rapi agar lebih praktis
                        saat disimpan</p>
                </div>
            </div>
        </div>
    </div>
@endsection

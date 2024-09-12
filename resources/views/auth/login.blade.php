<!DOCTYPE html>
<html>
<head>
    <title>Halaman Masuk</title>
    <!-- Vite CSS -->
    @vite('resources/css/app.css')
</head>
<body>
    <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase">Halaman Masuk</h2>
                <p class="text-white-50 mb-5">Silahkan Masukan Nama Pengguna dan Kata Sandi Anda!</p>

                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm" method="POST" action="login">
                @csrf
                    <div data-mdb-input-init class="form-outline form-white mb-4">
                        <input type="text" name="username" id="typeEmailX" class="form-control form-control-lg" />
                        <label class="form-label" for="typeEmailX">Nama Pengguna</label>
                    </div>

                    <div data-mdb-input-init class="form-outline form-white mb-4">
                        <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" />
                        <label class="form-label" for="typePasswordX">Kata Sandi</label>
                    </div>

                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Masuk</button>
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</body>
</html>

@extends('dashboard.index')
@section('content')

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Manajemen User</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <a href="#" id="tambahUser" class="btn btn-primary">Tambah User</a>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Refresh Count</th>
                        <th>Peran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Refresh Count</th>
                        <th>Peran</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Popup (Hidden by Default) -->
<div id="popup">
    <p><strong>Username:</strong> <span id="popupUsername"></span></p>
    <p><strong>Password:</strong> <span id="popupPassword"></span></p>
    <p><strong>Email:</strong> <span id="popupEmail"></span></p>
    <button id="closePopup">Close</button>
</div>
@endsection

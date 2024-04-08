@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data User</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>
                <i class="icon fas fa-check"></i> Success!
            </h5>
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data User</h3>
                <div class="float-right">
                    @if (auth()->check() && auth()->user()->fitur['user create'])
                    <a href="{{ url('admin/user/create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kode User</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Departemen</th>
                            <th class="text-center" width="20">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="dropdown">{{ $user->kode_user }}</td>
                            <td class="dropdown">{{ $user->karyawan->nama_lengkap }}</td>
                            <td class="dropdown">{{ $user->karyawan->telp }}</td>
                            <td class="dropdown">{{ $user->karyawan->departemen->nama }}</td>
                            <td class="text-center">
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    $('tbody tr.dropdown').click(function(e) {
        // Menghilangkan efek highlight seleksi yang dibuat secara otomatis oleh browser
        $('tr.dropdown').removeClass('selected');

        // Menambahkan kelas 'selected' ke baris yang dipilih
        $(this).addClass('selected');

        // Mendapatkan posisi td yang diklik
        var clickedTd = $(e.target).closest('td');
        var tdPosition = clickedTd.position();

        // Menampilkan dropdown pada posisi yang tepat
        $(this).find('.dropdown-menu').css({
            top: tdPosition.top + 30, // Sesuaikan offset dari posisi td
            left: tdPosition.left
        }).toggle();

        // Menyembunyikan dropdown pada baris lain yang tidak dipilih
        $('tbody tr.dropdown').not(this).find('.dropdown-menu').hide();

        // Mencegah event klik menyebar ke atas (misalnya, saat mengklik dropdown)
        e.stopPropagation();
    });

    // Menyembunyikan dropdown saat klik di tempat lain
    $(document).click(function() {
        $('.dropdown-menu').hide();
    });
});
</script>

@endsection
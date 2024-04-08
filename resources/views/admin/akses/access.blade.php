@extends('layouts.app')

@section('title', 'Hak Akses')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hak Akses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/akses') }}">Hak akses</a>
                        </li>
                        <li class="breadcrumb-item active">Lihat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambahkan</h3>
                    <div class="float-right">
                        {{-- <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Akses Menu
                        </a> --}}
                        <a href="{{ url('admin/akses/accessdetail/' . $akses->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Akses Menu
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5>
                            <i class="icon fas fa-check"></i> Success!
                        </h5>
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ url('admin/akses-access/' . $akses->id) }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <label style="margin-left: 22px; margin-top: 15px"
                        for="option-all">{{ $akses->karyawan->nama_lengkap }}</label>
                    <div class="card-body">
                        <input type="checkbox" id="option-all" onchange="checkAll(this)">
                        <label for="option-all">Select All</label>
                        <br>
                        @foreach ($menus as $menu)
                            @if ($loop->iteration === 1)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">MASTER</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 26)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">OPERASIONAL</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 34)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">TRANSAKSI</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 46)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">FINANCE</label>
                                <br>
                            @endif
                            @if ($loop->iteration === 66)
                                <label style="font-weight: bold; margin-bottom:20px; margin-top:20px"
                                    class="form-check-label">LAPORAN</label>
                                <br>
                            @endif

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="menu[]" value="{{ $menu }}"
                                    {{ $akses->menu[$menu] ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    @if ($loop->iteration === 18)
                                        Data Driver
                                    @elseif ($loop->iteration === 3)
                                        Hak Akses
                                    @elseif ($loop->iteration === 46)
                                        UJS
                                    @else
                                        {{ $loop->iteration <= 25 ? 'Data ' : '' }}{{ ucfirst($menu) }}
                                    @endif
                                </label>
                            </div>
                        @endforeach


                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        var checkboxes = document.querySelectorAll("input[type = 'checkbox']");

        function checkAll(myCheckbox) {
            if (myCheckbox.checked == true) {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                });
            } else {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }
        }
    </script>
@endsection

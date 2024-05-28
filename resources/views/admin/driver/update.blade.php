@extends('layouts.app')

@section('title', 'Perbarui Driver')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Driver</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/drivers') }}">Driver</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perbarui Driver</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/driver/' . $drivers->id) }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Deposit</label>
                            <input type="number" class="form-control" id="no_sim" name="deposit"
                                placeholder="Masukan deposit" value="{{ old('deposit', $drivers->deposit) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Kasbon</label>
                            <input type="number" class="form-control" id="kasbon" name="kasbon"
                                placeholder="Masukan kasbon" value="{{ old('kasbon', $drivers->kasbon) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Bayar Kasbon</label>
                            <input type="number" class="form-control" id="bayar_kasbon" name="bayar_kasbon"
                                placeholder="Masukan bayar" value="{{ old('bayar_kasbon', $drivers->bayar_kasbon) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Saldo Deposit</label>
                            <input type="number" class="form-control" id="no_sim" name="tabungan"
                                placeholder="Masukan deposit driver" value="{{ old('tabungan', $drivers->tabungan) }}">
                        </div>
                    </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Bank</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="nama_bank">Nama Bank</label>
                        <select class="form-control" id="nama_bank" name="nama_bank">
                            <option value="">- Pilih -</option>
                            <option value="BRI"
                                {{ old('nama_bank', $drivers->nama_bank) == 'BRI' ? 'selected' : null }}>
                                BRI</option>
                            <option value="MANDIRI"
                                {{ old('nama_bank', $drivers->nama_bank) == 'MANDIRI' ? 'selected' : null }}>
                                MANDIRI</option>
                            <option value="BNI"
                                {{ old('nama_bank', $drivers->nama_bank) == 'BNI' ? 'selected' : null }}>
                                BNI</option>
                            <option value="BTN"
                                {{ old('nama_bank', $drivers->nama_bank) == 'BTN' ? 'selected' : null }}>
                                BTN</option>
                            <option value="DANAMON"
                                {{ old('nama_bank', $drivers->nama_bank) == 'DANAMON' ? 'selected' : null }}>
                                DANAMON</option>
                            <option value="BCA"
                                {{ old('nama_bank', $drivers->nama_bank) == 'BCA' ? 'selected' : null }}>
                                BCA</option>
                            <option value="PERMATA"
                                {{ old('nama_bank', $drivers->nama_bank) == 'PERMATA' ? 'selected' : null }}>
                                PERMATA</option>
                            <option value="PAN"
                                {{ old('nama_bank', $drivers->nama_bank) == 'PAN' ? 'selected' : null }}>
                                PAN</option>
                            <option value="CIMB NIAGA"
                                {{ old('nama_bank', $drivers->nama_bank) == 'CIMB NIAGA' ? 'selected' : null }}>
                                CIMB NIAGA</option>
                            <option value="UOB"
                                {{ old('nama_bank', $drivers->nama_bank) == 'UOB' ? 'selected' : null }}>
                                UOB</option>
                            <option value="ARTHA GRAHA"
                                {{ old('nama_bank', $drivers->nama_bank) == 'ARTHA GRAHA' ? 'selected' : null }}>
                                ARTHA GRAHA</option>
                            <option value="BUMI ARTHA"
                                {{ old('nama_bank', $drivers->nama_bank) == 'BUMI ARTHA' ? 'selected' : null }}>
                                BUMI ARTHA</option>
                            <option value="MEGA"
                                {{ old('nama_bank', $drivers->nama_bank) == 'MEGA' ? 'selected' : null }}>
                                MEGA</option>
                            <option value="SYARIAH"
                                {{ old('nama_bank', $drivers->nama_bank) == 'SYARIAH' ? 'selected' : null }}>
                                SYARIAH</option>
                            <option value="MEGA SYARIAH"
                                {{ old('nama_bank', $drivers->nama_bank) == 'MEGA SYARIAH' ? 'selected' : null }}>
                                MEGA SYARIAH</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="atas_nama">Atas nama</label>
                        <input type="text" class="form-control" id="atas_nama" name="atas_nama"
                            placeholder="Masukan atas nama" value="{{ old('atas_nama', $drivers->atas_nama) }}">
                    </div>
                    <div class="form-group">
                        <label for="norek">No. Rekening</label>
                        <input type="number" class="form-control" id="norek" name="norek"
                            placeholder="Masukan no rekening" value="{{ old('norek', $drivers->norek) }}">
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </section>
@endsection

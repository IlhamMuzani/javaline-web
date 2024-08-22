@extends('layouts.app')

@section('title', 'Perbaru Rekanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rekanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/vendor') }}">Rekanan</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
            <form action="{{ url('admin/vendor/' . $vendor->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Rekanan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nama_vendor">Nama Rekanan</label>
                                    <input type="text" class="form-control" id="nama_vendor" name="nama_vendor"
                                        placeholder="Masukan nama vendor"
                                        value="{{ old('nama_vendor', $vendor->nama_vendor) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nama_alias">Nama Alias</label>
                                    <input type="text" class="form-control" id="nama_alias" name="nama_alias"
                                        placeholder="Masukan nama alias"
                                        value="{{ old('nama_alias', $vendor->nama_alias) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="npwp">No. NPWP</label>
                                    <input type="number" class="form-control" id="npwp" name="npwp"
                                        placeholder="Masukan no npwp" value="{{ old('npwp', $vendor->npwp) }}">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat" value="">{{ old('alamat', $vendor->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kotak Person</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama_person" name="nama_person"
                                placeholder="Masukan nama" value="{{ old('nama_person', $vendor->nama_person) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                placeholder="Masukan jabatan" value="{{ old('jabatan', $vendor->jabatan) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No. Telepon</label>
                            <input type="number" class="form-control" id="telp" name="telp"
                                placeholder="Masukan no telepon" value="{{ old('telp', $vendor->telp) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Fax</label>
                            <input type="number" class="form-control" id="fax" name="fax"
                                placeholder="Masukan no fax" value="{{ old('fax', $vendor->fax) }}">
                        </div>
                        <div class="form-group">
                            <label for="telp">Hp</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="number" id="hp" name="hp" class="form-control"
                                    placeholder="Masukan nomor hp" value="{{ old('hp', $vendor->hp) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Masukan email" value="{{ old('email', $vendor->email) }}">
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
                                    {{ old('nama_bank', $vendor->nama_bank) == 'BRI' ? 'selected' : null }}>
                                    BRI</option>
                                <option value="MANDIRI"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'MANDIRI' ? 'selected' : null }}>
                                    MANDIRI</option>
                                <option value="BNI"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'BNI' ? 'selected' : null }}>
                                    BNI</option>
                                <option value="BTN"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'BTN' ? 'selected' : null }}>
                                    BTN</option>
                                <option value="DANAMON"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'DANAMON' ? 'selected' : null }}>
                                    DANAMON</option>
                                <option value="BCA"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'BCA' ? 'selected' : null }}>
                                    BCA</option>
                                <option value="PERMATA"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'PERMATA' ? 'selected' : null }}>
                                    PERMATA</option>
                                <option value="PAN"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'PAN' ? 'selected' : null }}>
                                    PAN</option>
                                <option value="CIMB NIAGA"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'CIMB NIAGA' ? 'selected' : null }}>
                                    CIMB NIAGA</option>
                                <option value="UOB"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'UOB' ? 'selected' : null }}>
                                    UOB</option>
                                <option value="ARTHA GRAHA"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'ARTHA GRAHA' ? 'selected' : null }}>
                                    ARTHA GRAHA</option>
                                <option value="BUMI ARTHA"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'BUMI ARTHA' ? 'selected' : null }}>
                                    BUMI ARTHA</option>
                                <option value="MEGA"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'MEGA' ? 'selected' : null }}>
                                    MEGA</option>
                                <option value="SYARIAH"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'SYARIAH' ? 'selected' : null }}>
                                    SYARIAH</option>
                                <option value="MEGA SYARIAH"
                                    {{ old('nama_bank', $vendor->nama_bank) == 'MEGA SYARIAH' ? 'selected' : null }}>
                                    MEGA SYARIAH</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="atas_nama">Atas nama</label>
                            <input type="text" class="form-control" id="atas_nama" name="atas_nama"
                                placeholder="Masukan atas nama" value="{{ old('atas_nama', $vendor->atas_nama) }}">
                        </div>
                        <div class="form-group">
                            <label for="norek">No. Rekening</label>
                            <input type="number" class="form-control" id="norek" name="norek"
                                placeholder="Masukan no rekening" value="{{ old('norek', $vendor->norek) }}">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
            {{-- </div> --}}
        </div>
    </section>
@endsection

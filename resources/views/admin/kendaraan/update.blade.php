@extends('layouts.app')

@section('title', 'Perbarui Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/kendaraan') }}">Kendaraan</a></li>
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
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/kendaraan/' . $kendaraan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Kendaraan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="gpsid">ID GPS Mulia Track</label>
                                    <input type="text" class="form-control" id="gpsid" name="gpsid"
                                        placeholder="Masukan gpsid" value="{{ old('gpsid', $kendaraan->gpsid) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="list_vehicle_id">ID GPS Easygo</label>
                                    <input type="text" class="form-control" id="list_vehicle_id" name="list_vehicle_id"
                                        placeholder="Masukan list vehicle id" value="{{ old('list_vehicle_id', $kendaraan->list_vehicle_id) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="no_kabin">No Kabin</label>
                                    <input type="text" class="form-control" id="no_kabin" name="no_kabin"
                                        placeholder="Masukan no kabin" value="{{ old('no_kabin', $kendaraan->no_kabin) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="no_pol">No. Pol</label>
                                    <input type="text" class="form-control" id="no_pol" name="no_pol"
                                        placeholder="Masukan no pol" value="{{ old('no_pol', $kendaraan->no_pol) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="no_rangka">No. Rangka</label>
                                    <input type="text" class="form-control" id="no_rangka" name="no_rangka"
                                        placeholder="Masukan no rangka"
                                        value="{{ old('no_rangka', $kendaraan->no_rangka) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="no_mesin">No. Mesin</label>
                                    <input type="text" class="form-control" id="no_mesin" name="no_mesin"
                                        placeholder="Masukan no mesin" value="{{ old('no_mesin', $kendaraan->no_mesin) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="jenis_kendaraan_id">Jenis Kendaraan</label>
                                    <select class="form-control" id="jenis_kendaraan_id" name="jenis_kendaraan_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($jenis_kendaraans as $jenis_kendaraan)
                                            <option value="{{ $jenis_kendaraan->id }}"
                                                {{ old('jenis_kendaraan_id', $kendaraan->jenis_kendaraan_id) == $jenis_kendaraan->id ? 'selected' : '' }}>
                                                {{ $jenis_kendaraan->nama_jenis_kendaraan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="warna">Warna</label>
                                    <select class="form-control" id="warna" name="warna">
                                        <option value="">- Pilih -</option>
                                        <option value="Hitam"
                                            {{ old('warna', $kendaraan->warna) == 'Hitam' ? 'selected' : null }}>
                                            Hitam</option>
                                        <option value="Putih"
                                            {{ old('warna', $kendaraan->warna) == 'Putih' ? 'selected' : null }}>
                                            Putih</option>
                                        <option value="Cokelat"
                                            {{ old('warna', $kendaraan->warna) == 'Cokelat' ? 'selected' : null }}>
                                            Cokelat</option>
                                        <option value="Hijau"
                                            {{ old('warna', $kendaraan->warna) == 'Hijau' ? 'selected' : null }}>
                                            Hijau</option>
                                        <option value="Orange"
                                            {{ old('warna', $kendaraan->warna) == 'Orange' ? 'selected' : null }}>
                                            Orange</option>
                                        <option value="Merah"
                                            {{ old('warna', $kendaraan->warna) == 'Merah' ? 'selected' : null }}>
                                            Merah</option>
                                        <option value="Ungu"
                                            {{ old('warna', $kendaraan->warna) == 'Ungu' ? 'selected' : null }}>
                                            Ungu</option>
                                        <option value="Kuning"
                                            {{ old('warna', $kendaraan->warna) == 'Kuning' ? 'selected' : null }}>
                                            Kuning</option>
                                        <option value="Biru"
                                            {{ old('warna', $kendaraan->warna) == 'Biru' ? 'selected' : null }}>
                                            Biru</option>
                                        <option value="Silver"
                                            {{ old('warna', $kendaraan->warna) == 'Silver' ? 'selected' : null }}>
                                            Silver</option>
                                        <option value="Hitam"
                                            {{ old('warna', $kendaraan->warna) == 'Hitam' ? 'selected' : null }}>
                                            Hitam</option>
                                        <option value="Putih"
                                            {{ old('warna', $kendaraan->warna) == 'Putih' ? 'selected' : null }}>
                                            Putih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Expired Kir:</label>
                                    <div class="input-group date" id="reservationdatetime">
                                        <input type="date" id="expired_kir" name="expired_kir"
                                            placeholder="d M Y sampai d M Y"
                                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                            value="{{ old('expired_kir', $kendaraan->expired_kir) }}"
                                            class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Expired STNK:</label>
                                    <div class="input-group date" id="reservationdatetime">
                                        <input type="date" id="expired_stnk" name="expired_stnk"
                                            placeholder="d M Y sampai d M Y"
                                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                            value="{{ old('expired_stnk', $kendaraan->expired_stnk) }}"
                                            class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="golongan">Golongan</label>
                                    <select class="form-control" id="golongan_id" name="golongan_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($golongans as $golongan)
                                            <option value="{{ $golongan->id }}"
                                                {{ old('golongan_id', $kendaraan->golongan_id) == $golongan->id ? 'selected' : '' }}>
                                                {{ $golongan->nama_golongan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="divisi_id">Divisi Mobil</label>
                                    <select class="form-control" id="divisi_id" name="divisi_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($divisis as $divisi)
                                            <option value="{{ $divisi->id }}"
                                                {{ old('divisi_id', $kendaraan->divisi_id) == $divisi->id ? 'selected' : '' }}>
                                                {{ $divisi->nama_divisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="user_id">Driver</label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}"
                                                {{ old('user_id', $kendaraan->user_id) == $driver->id ? 'selected' : '' }}>
                                                {{ $driver->karyawan->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="km">KM Akhir</label>
                                    <input type="text" class="form-control" id="km" name="km"
                                        placeholder="Masukan km" value="{{ old('km', $kendaraan->km) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="gambar_barcodesolar">
                                        Gambar Barcode Solar
                                        <small>(kosongkan saja jika tidak ingin diubah)</small>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="gambar_barcodesolar"
                                            name="gambar_barcodesolar" accept="image/*">
                                        <label class="custom-file-label" for="gambar_barcodesolar">Pilih Gambar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="gambar_stnk">
                                        Gambar Stnk
                                        <small>(kosongkan saja jika tidak ingin diubah)</small>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="gambar_stnk"
                                            name="gambar_stnk" accept="image/*">
                                        <label class="custom-file-label" for="gambar_stnk">Pilih Gambar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            {{-- </div> --}}
        </div>
    </section>
@endsection

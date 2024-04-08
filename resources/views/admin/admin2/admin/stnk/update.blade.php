@extends('layouts.app')

@section('title', 'Perbarui No. Stnk')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">No. Stnk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/stnk') }}">No. Stnk</a></li>
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

            <form action="{{ url('admin/stnk/' . $stnk->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Stnk</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kendaraan_id">No. Kabin</label>
                            <select class="custom-select form-control" id="kendaraan_id" name="kendaraan_id"
                                onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($kendaraans as $kendaraan)
                                    <option value="{{ $kendaraan->id }}"
                                        {{ old('kendaraan_id', $stnk->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>
                                        {{ $kendaraan->no_kabin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nopol">No. Registrasi Kendaraan</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan"
                                value="{{ old('no_pol', $stnk->kendaraan->no_pol) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Pemilik</label>
                            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"
                                placeholder="Masukan nama pemilik" value="{{ old('nama_pemilik', $stnk->nama_pemilik) }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat', $stnk->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="merek">Merek</label>
                            <input type="text" class="form-control" id="merek" name="merek"
                                placeholder="Masukan merek" value="{{ old('merek', $stnk->merek) }}">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" id="type" name="type"
                                placeholder="Masukan type" value="{{ old('type', $stnk->type) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="jenis_kendaraan_id">Jenis Kendaraan</label>
                            <select class="form-control" id="jenis_kendaraan_id" name="jenis_kendaraan_id">
                                <option value="">- Pilih -</option>
                                @foreach ($jenis_kendaraans as $jenis_kendaraan)
                                    <option value="{{ $jenis_kendaraan->id }}"
                                        {{ old('jenis_kendaraan_id', $stnk->jenis_kendaraan_id) == $jenis_kendaraan->id ? 'selected' : '' }}>
                                        {{ $jenis_kendaraan->nama_jenis_kendaraan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" id="model" name="model"
                                placeholder="Masukan model" value="{{ old('model', $stnk->model) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tahun_pembuatan">Tahun Pembuatan</label>
                            <select class="form-control" id="tahun_pembuatan" name="tahun_pembuatan">
                                <option value="">- Pilih -</option>
                                <option value="2025" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2025' ? 'selected' : null }}>
                                    2025</option>
                                <option value="2024" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2024' ? 'selected' : null }}>
                                    2024</option>
                                <option value="2023" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2023' ? 'selected' : null }}>
                                    2023</option>
                                <option value="2022" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2022' ? 'selected' : null }}>
                                    2022</option>
                                <option value="2021" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2021' ? 'selected' : null }}>
                                    2021</option>
                                <option value="2020" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2020' ? 'selected' : null }}>
                                    2020</option>
                                <option value="2019" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2019' ? 'selected' : null }}>
                                    2019</option>
                                <option value="2018" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2018' ? 'selected' : null }}>
                                    2018</option>
                                <option value="2017" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2017' ? 'selected' : null }}>
                                    2017</option>
                                <option value="2016" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2016' ? 'selected' : null }}>
                                    2016</option>
                                <option value="2015" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2015' ? 'selected' : null }}>
                                    2015</option>
                                <option value="2014" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2014' ? 'selected' : null }}>
                                    2014</option>
                                <option value="2013" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2013' ? 'selected' : null }}>
                                    2013</option>
                                <option value="2012" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2012' ? 'selected' : null }}>
                                    2012</option>
                                <option value="2011" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2011' ? 'selected' : null }}>
                                    2011</option>
                                <option value="2010" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2010' ? 'selected' : null }}>
                                    2010</option>
                                <option value="2009" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2009' ? 'selected' : null }}>
                                    2009</option>
                                <option value="2008" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2008' ? 'selected' : null }}>
                                    2008</option>
                                <option value="2007" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2007' ? 'selected' : null }}>
                                    2007</option>
                                <option value="2006" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2006' ? 'selected' : null }}>
                                    2006</option>
                                <option value="2005" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2005' ? 'selected' : null }}>
                                    2005</option>
                                <option value="2004" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2004' ? 'selected' : null }}>
                                    2004</option>
                                <option value="2003" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2003' ? 'selected' : null }}>
                                    2003</option>
                                <option value="2002" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2002' ? 'selected' : null }}>
                                    2002</option>
                                <option value="2001" {{ old('tahun_pembuatan', $stnk->tahun_pembuatan) == '2001' ? 'selected' : null }}>
                                    2001</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_rangka">Nomor Rangka</label>
                            <input type="text" class="form-control" id="no_rangka" name="no_rangka" readonly
                                placeholder="Masukan no rangka" value="{{ old('no_rangka', $stnk->no_rangka) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nomor Mesin</label>
                            <input type="text" class="form-control" id="no_mesin" name="no_mesin" readonly
                                placeholder="Masukan no motor penggerak" value="{{ old('no_mesin', $stnk->no_mesin) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="warna">Warna</label>
                            <select class="form-control" id="warna" name="warna">
                                <option value="">- Pilih -</option>
                                <option value="Hitam" {{ old('warna', $stnk->warna) == 'Hitam' ? 'selected' : null }}>
                                    Hitam</option>
                                <option value="Putih" {{ old('warna', $stnk->warna) == 'Putih' ? 'selected' : null }}>
                                    Putih</option>
                                <option value="Cokelat" {{ old('warna', $stnk->warna) == 'Cokelat' ? 'selected' : null }}>
                                    Cokelat</option>
                                <option value="Hijau" {{ old('warna', $stnk->warna) == 'Hijau' ? 'selected' : null }}>
                                    Hijau</option>
                                <option value="Orange" {{ old('warna', $stnk->warna) == 'Orange' ? 'selected' : null }}>
                                    Orange</option>
                                <option value="Merah" {{ old('warna', $stnk->warna) == 'Merah' ? 'selected' : null }}>
                                    Merah</option>
                                <option value="Ungu" {{ old('warna', $stnk->warna) == 'Ungu' ? 'selected' : null }}>
                                    Ungu</option>
                                <option value="Kuning" {{ old('warna', $stnk->warna) == 'Kuning' ? 'selected' : null }}>
                                    Kuning</option>
                                <option value="Biru" {{ old('warna', $stnk->warna) == 'Biru' ? 'selected' : null }}>
                                    Biru</option>
                                <option value="Silver" {{ old('warna', $stnk->warna) == 'Silver' ? 'selected' : null }}>
                                    Silver</option>
                                <option value="Hitam" {{ old('warna', $stnk->warna) == 'Hitam' ? 'selected' : null }}>
                                    Hitam</option>
                                <option value="Putih" {{ old('warna', $stnk->warna) == 'Putih' ? 'selected' : null }}>
                                    Putih</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="warna">Warna TNKB</label>
                            <select class="form-control" id="warna_tnkb" name="warna_tnkb">
                                <option value="">- Pilih -</option>
                                <option value="Hitam" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Hitam' ? 'selected' : null }}>
                                    Hitam</option>
                                <option value="Putih" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Putih' ? 'selected' : null }}>
                                    Putih</option>
                                <option value="Cokelat" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Cokelat' ? 'selected' : null }}>
                                    Cokelat</option>
                                <option value="Hijau" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Hijau' ? 'selected' : null }}>
                                    Hijau</option>
                                <option value="Orange" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Orange' ? 'selected' : null }}>
                                    Orange</option>
                                <option value="Merah" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Merah' ? 'selected' : null }}>
                                    Merah</option>
                                <option value="Ungu" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Ungu' ? 'selected' : null }}>
                                    Ungu</option>
                                <option value="Kuning" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Kuning' ? 'selected' : null }}>
                                    Kuning</option>
                                <option value="Biru" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Biru' ? 'selected' : null }}>
                                    Biru</option>
                                <option value="Silver" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Silver' ? 'selected' : null }}>
                                    Silver</option>
                                <option value="Hitam" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Hitam' ? 'selected' : null }}>
                                    Hitam</option>
                                <option value="Putih" {{ old('warna_tnkb', $stnk->warna_tnkb) == 'Putih' ? 'selected' : null }}>
                                    Putih</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tahun_registrasi">Tahun Registrasi</label>
                            <select class="form-control" id="tahun_registrasi" name="tahun_registrasi">
                                <option value="">- Pilih -</option>
                                <option value="2025" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2025' ? 'selected' : null }}>
                                    2025</option>
                                <option value="2024" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2024' ? 'selected' : null }}>
                                    2024</option>
                                <option value="2023" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2023' ? 'selected' : null }}>
                                    2023</option>
                                <option value="2022" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2022' ? 'selected' : null }}>
                                    2022</option>
                                <option value="2021" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2021' ? 'selected' : null }}>
                                    2021</option>
                                <option value="2020" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2020' ? 'selected' : null }}>
                                    2020</option>
                                <option value="2019" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2019' ? 'selected' : null }}>
                                    2019</option>
                                <option value="2018" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2018' ? 'selected' : null }}>
                                    2018</option>
                                <option value="2017" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2017' ? 'selected' : null }}>
                                    2017</option>
                                <option value="2016" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2016' ? 'selected' : null }}>
                                    2016</option>
                                <option value="2015" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2015' ? 'selected' : null }}>
                                    2015</option>
                                <option value="2014" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2014' ? 'selected' : null }}>
                                    2014</option>
                                <option value="2013" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2013' ? 'selected' : null }}>
                                    2013</option>
                                <option value="2012" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2012' ? 'selected' : null }}>
                                    2012</option>
                                <option value="2011" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2011' ? 'selected' : null }}>
                                    2011</option>
                                <option value="2010" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2010' ? 'selected' : null }}>
                                    2010</option>
                                <option value="2009" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2009' ? 'selected' : null }}>
                                    2009</option>
                                <option value="2008" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2008' ? 'selected' : null }}>
                                    2008</option>
                                <option value="2007" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2007' ? 'selected' : null }}>
                                    2007</option>
                                <option value="2006" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2006' ? 'selected' : null }}>
                                    2006</option>
                                <option value="2005" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2005' ? 'selected' : null }}>
                                    2005</option>
                                <option value="2004" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2004' ? 'selected' : null }}>
                                    2004</option>
                                <option value="2003" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2003' ? 'selected' : null }}>
                                    2003</option>
                                <option value="2002" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2002' ? 'selected' : null }}>
                                    2002</option>
                                <option value="2001" {{ old('tahun_registrasi', $stnk->tahun_registrasi) == '2001' ? 'selected' : null }}>
                                    2001</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">No. BPKB</label>
                            <input type="text" class="form-control" id="nomor_bpkb" name="nomor_bpkb"
                                placeholder="Masukan isi no bpkb" value="{{ old('nomor_bpkb', $stnk->nomor_bpkb) }}">
                        </div>
                        <div class="form-group">
                            <label>Berlaku Sampai:</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="expired_stnk" name="expired_stnk"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('expired_stnk', $stnk->expired_stnk) }}" class="form-control datetimepicker-input"
                                    data-target="#reservationdatetime">
                            </div>
                        </div>
                    </div>
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
        function getData(id) {
            var kendaraan_id = document.getElementById('kendaraan_id');
            $.ajax({
                url: "{{ url('admin/stnk/kendaraan') }}" + "/" + kendaraan_id.value,
                type: "GET",
                dataType: "json",
                success: function(kendaraan_id) {
                    var no_pol = document.getElementById('no_pol');
                    no_pol.value = kendaraan_id.no_pol;

                    var no_rangka = document.getElementById('no_rangka');
                    no_rangka.value = kendaraan_id.no_rangka;

                    var no_mesin = document.getElementById('no_mesin');
                    no_mesin.value = kendaraan_id.no_mesin;
                },
            });
        }
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Tambah No. Kir')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">No. Kir</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/nokir') }}">No. Kir</a></li>
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

            <form action="{{ url('admin/nokir') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Identitas Pemilik Kendaraan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama Pemilik</label>
                            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"
                                placeholder="Masukan nama pemilik" value="{{ old('nama_pemilik') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- div diatas ini --}}

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Identitas Kendaraan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">No. Uji Kendaraan</label>
                            <input type="text" class="form-control" id="nomor_uji_kendaraan" name="nomor_uji_kendaraan"
                                placeholder="Masukan nomor uji kendaraan" value="{{ old('nomor_uji_kendaraan') }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_kabin">No. Sertifikat Kendaraan</label>
                            <input type="text" class="form-control" id="nomor_sertifikat_kendaraan"
                                name="nomor_sertifikat_kendaraan" placeholder="Masukan no sertifikat kendaraan"
                                value="{{ old('nomor_sertifikat_kendaraan') }}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Sertifikat Registrasi</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="tanggal_sertifikat" name="tanggal_sertifikat"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('tanggal_sertifikat') }}" class="form-control datetimepicker-input"
                                    data-target="#reservationdatetime">
                            </div>
                        </div>
                        <div class="form-group" style="flex: 8;"> <!-- Adjusted flex value -->
                            <label for="kendaraan_id">No. Kabin</label>
                            <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                data-placeholder="Cari Kabin.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="kendaraan_id" onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($kendaraans as $kendaraan)
                                    <option value="{{ $kendaraan->id }}"
                                        {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                        {{ $kendaraan->no_kabin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nopol">No. Registrasi Kendaraan</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan" value="{{ old('no_pol') }}">
                        </div>
                        <div class="form-group">
                            <label for="no_rangka">Nomor Rangka Kendaraan</label>
                            <input type="text" class="form-control" id="no_rangka" name="no_rangka" readonly
                                placeholder="Masukan no rangka" value="{{ old('no_rangka') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No. Motor Penggerak</label>
                            <input type="text" class="form-control" id="no_mesin" name="no_mesin" readonly
                                placeholder="Masukan no motor penggerak" value="{{ old('no_mesin') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Foto Berwarna 4 Sisi Kendaraan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="gambar">Foto Depan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_depan" name="gambar_depan"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_depan">Masukkan Foto Depan</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar_belakang">Foto Belakang</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_belakang"
                                    name="gambar_belakang" accept="image/*">
                                <label class="custom-file-label" for="gambar_belakang">Masukkan Foto Belakang</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar_kanan">Foto Kanan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_kanan" name="gambar_kanan"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_kanan">Masukkan Foto Kanan</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar_kiri">Foto Kiri</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_kiri" name="gambar_kiri"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_kiri">Masukkan Foto Kiri</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Spesifikasi Kendaraan Bermotor</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"
                                placeholder="Masukan jenis kendaraan" value="{{ old('jenis_kendaraan') }}">
                        </div>
                        <div class="form-group">
                            <label for="merek_kendaraan">Merek / Type</label>
                            <input type="text" class="form-control" id="merek_kendaraan" name="merek_kendaraan"
                                placeholder="Masukan merek" value="{{ old('merek_kendaraan') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tahun_kendaraan">Tahun Pembuatan</label>
                            <select class="form-control" id="tahun_kendaraan" name="tahun_kendaraan">
                                <option value="">- Pilih -</option>
                                <option value="2025" {{ old('tahun_kendaraan') == '2025' ? 'selected' : null }}>
                                    2025</option>
                                <option value="2024" {{ old('tahun_kendaraan') == '2024' ? 'selected' : null }}>
                                    2024</option>
                                <option value="2023" {{ old('tahun_kendaraan') == '2023' ? 'selected' : null }}>
                                    2023</option>
                                <option value="2022" {{ old('tahun_kendaraan') == '2022' ? 'selected' : null }}>
                                    2022</option>
                                <option value="2021" {{ old('tahun_kendaraan') == '2021' ? 'selected' : null }}>
                                    2021</option>
                                <option value="2020" {{ old('tahun_kendaraan') == '2020' ? 'selected' : null }}>
                                    2020</option>
                                <option value="2019" {{ old('tahun_kendaraan') == '2019' ? 'selected' : null }}>
                                    2019</option>
                                <option value="2018" {{ old('tahun_kendaraan') == '2018' ? 'selected' : null }}>
                                    2018</option>
                                <option value="2017" {{ old('tahun_kendaraan') == '2017' ? 'selected' : null }}>
                                    2017</option>
                                <option value="2016" {{ old('tahun_kendaraan') == '2016' ? 'selected' : null }}>
                                    2016</option>
                                <option value="2015" {{ old('tahun_kendaraan') == '2015' ? 'selected' : null }}>
                                    2015</option>
                                <option value="2014" {{ old('tahun_kendaraan') == '2014' ? 'selected' : null }}>
                                    2014</option>
                                <option value="2013" {{ old('tahun_kendaraan') == '2013' ? 'selected' : null }}>
                                    2013</option>
                                <option value="2012" {{ old('tahun_kendaraan') == '2012' ? 'selected' : null }}>
                                    2012</option>
                                <option value="2011" {{ old('tahun_kendaraan') == '2011' ? 'selected' : null }}>
                                    2011</option>
                                <option value="2010" {{ old('tahun_kendaraan') == '2010' ? 'selected' : null }}>
                                    2010</option>
                                <option value="2009" {{ old('tahun_kendaraan') == '2009' ? 'selected' : null }}>
                                    2009</option>
                                <option value="2008" {{ old('tahun_kendaraan') == '2008' ? 'selected' : null }}>
                                    2008</option>
                                <option value="2007" {{ old('tahun_kendaraan') == '2007' ? 'selected' : null }}>
                                    2007</option>
                                <option value="2006" {{ old('tahun_kendaraan') == '2006' ? 'selected' : null }}>
                                    2006</option>
                                <option value="2005" {{ old('tahun_kendaraan') == '2005' ? 'selected' : null }}>
                                    2005</option>
                                <option value="2004" {{ old('tahun_kendaraan') == '2004' ? 'selected' : null }}>
                                    2004</option>
                                <option value="2003" {{ old('tahun_kendaraan') == '2003' ? 'selected' : null }}>
                                    2003</option>
                                <option value="2002" {{ old('tahun_kendaraan') == '2002' ? 'selected' : null }}>
                                    2002</option>
                                <option value="2001" {{ old('tahun_kendaraan') == '2001' ? 'selected' : null }}>
                                    2001</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="bahan_bakar">Bahan Bakar</label>
                            <select class="form-control" id="bahan_bakar" name="bahan_bakar">
                                <option value="">- Pilih -</option>
                                <option value="Solar" {{ old('bahan_bakar') == 'Solar' ? 'selected' : null }}>
                                    Solar</option>
                                <option value="Bensin" {{ old('bahan_bakar') == 'Bensin' ? 'selected' : null }}>
                                    Bensin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Isi Silinder</label>
                            <input type="text" class="form-control" id="isi_silinder" name="isi_silinder"
                                placeholder="Masukan isi silinder" value="{{ old('isi_silinder') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Daya Motor</label>
                            <input type="text" class="form-control" id="daya_motor" name="daya_motor"
                                placeholder="Masukan daya motor" value="{{ old('daya_motor') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Ukuran Ban</label>
                            <input type="text" class="form-control" id="ukuran_ban" name="ukuran_ban"
                                placeholder="Masukan ukuran ban" value="{{ old('ukuran_ban') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Konfigurasi Sumbu</label>
                            <input type="text" class="form-control" id="konfigurasi_sumbu" name="konfigurasi_sumbu"
                                placeholder="Masukan konfigurasi sumbu" value="{{ old('konfigurasi_sumbu') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Berat Kosong Kendaraan</label>
                            <input type="text" class="form-control" id="berat_kosongkendaraan"
                                name="berat_kosongkendaraan" placeholder="Masukan berat kosong kendaraan"
                                value="{{ old('berat_kosongkendaraan') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dimensi Utama Kendaraan Bermotor</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="panjang">Panjang</label>
                                    <input type="text" class="form-control" id="panjang" name="panjang"
                                        placeholder="Masukan panjang" value="{{ old('panjang') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="lebar">Lebar</label>
                                    <input type="text" class="form-control" id="lebar" name="lebar"
                                        placeholder="Masukan lebar" value="{{ old('lebar') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="tinggi">Tinggi</label>
                                    <input type="text" class="form-control" id="tinggi" name="tinggi"
                                        placeholder="Masukan tinggi" value="{{ old('tinggi') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="julur_depan">Julur Depan</label>
                                    <input type="text" class="form-control" id="julur_depan" name="julur_depan"
                                        placeholder="Masukan julu depan" value="{{ old('julur_depan') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="julur_belakang">Julur Belakang</label>
                                    <input type="text" class="form-control" id="julur_belakang" name="julur_belakang"
                                        placeholder="Masukan julur belakang" value="{{ old('julur_belakang') }}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jarak Sumbu</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sumbu_1_2">Sumbu I - II</label>
                            <input type="text" class="form-control" id="sumbu_1_2" name="sumbu_1_2"
                                placeholder="Masukan sumbu" value="{{ old('sumbu_1_2') }}">
                        </div>
                        <div class="form-group">
                            <label for="sumbu_2_3">Sumbu II - III</label>
                            <input type="text" class="form-control" id="sumbu_2_3" name="sumbu_2_3"
                                placeholder="Masukan sumbu" value="{{ old('sumbu_2_3') }}">
                        </div>
                        <div class="form-group">
                            <label for="sumbu_3_4">Sumbu III - IV</label>
                            <input type="text" class="form-control" id="sumbu_3_4" name="sumbu_3_4"
                                placeholder="Masukan sumbu" value="{{ old('sumbu_3_4') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Identitas Kendaraan</h3>
                    </div> --}}
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="dimensi_bakmuatan">Dimensi Bak Muatan/Tangki</label>
                            <input type="text" class="form-control" id="dimensi_bakmuatan" name="dimensi_bakmuatan"
                                placeholder="Panjang x Lebar x Tinggi" value="{{ old('dimensi_bakmuatan') }}">
                        </div>
                        <div class="form-group">
                            <label for="jbb">JBB/JBKB</label>
                            <input type="text" class="form-control" id="jbb" name="jbb"
                                placeholder="Masukan jbb" value="{{ old('jbb') }}">
                        </div>
                        <div class="form-group">
                            <label for="jbi">JBI/JBKI</label>
                            <input type="text" class="form-control" id="jbi" name="jbi"
                                placeholder="Masukan no jbi" value="{{ old('jbi') }}">
                        </div>
                        <div class="form-group">
                            <label for="no_rangka">Daya angkut orang(orang/kg)</label>
                            <input type="text" class="form-control" id="daya_angkutorang" name="daya_angkutorang"
                                placeholder="Masukan daya angkut orang" value="{{ old('daya_angkutorang') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Kelas jalan terendah yang boleh dilalui</label>
                            <input type="text" class="form-control" id="kelas_jalan" name="kelas_jalan"
                                placeholder="Masukan kelas jalan" value="{{ old('kelas_jalan') }}">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Keterangan Hasil Uji</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <select class="form-control" id="keterangan" name="keterangan">
                                <option value="">- Pilih -</option>
                                <option value="LULUS UJI BERKALA"
                                    {{ old('keterangan') == 'LULUS UJI BERKALA' ? 'selected' : null }}>
                                    LULUS UJI BERKALA</option>
                                <option value="TIDAK LULUS UJI BERKALA"
                                    {{ old('keterangan') == 'TIDAK LULUS UJI BERKALA' ? 'selected' : null }}>
                                    TIDAK LULUS UJI BERKALA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Masa Berlaku Uji Berkala</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="masa_berlaku" name="masa_berlaku"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('masa_berlaku') }}" class="form-control datetimepicker-input"
                                    data-target="#reservationdatetime">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="norek">Nama Petugas Penguji</label>
                            <input type="text" class="form-control" id="nama_petugas_penguji"
                                name="nama_petugas_penguji" placeholder="Masukan nama petugas"
                                value="{{ old('nama_petugas_penguji') }}">
                        </div>
                        <div class="form-group">
                            <label for="norek">NRP Petugas Penguji</label>
                            <input type="text" class="form-control" id="nrp_petugas_penguji"
                                name="nrp_petugas_penguji" placeholder="Masukan nrp petugas penguji"
                                value="{{ old('nrp_petugas_penguji') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_kepala_dinas">Nama Kepala Dinas</label>
                            <input type="text" class="form-control" id="nama_kepala_dinas" name="nama_kepala_dinas"
                                placeholder="Masukan nama kepala dinas" value="{{ old('nama_kepala_dinas') }}">
                        </div>
                        <div class="form-group">
                            <label for="norek">Pangkat Kepala Dinas</label>
                            <input type="text" class="form-control" id="pangkat_kepala_dinas"
                                name="pangkat_kepala_dinas" placeholder="Masukan pangkat kepala dinas"
                                value="{{ old('pangkat_kepala_dinas') }}">
                        </div>
                        <div class="form-group">
                            <label for="nip_kepala_dinas">NIP Kepala Dinas</label>
                            <input type="text" class="form-control" id="nip_kepala_dinas" name="nip_kepala_dinas"
                                placeholder="Masukan nip kepala dinas" value="{{ old('nip_kepala_dinas') }}">
                        </div>
                        <div class="form-group">
                            <label for="unit_pelaksanaan_teknis">Unit Pelaksanaan Teknis Daerah Pengujian</label>
                            <input type="text" class="form-control" id="unit_pelaksanaan_teknis"
                                name="unit_pelaksanaan_teknis" placeholder="Masukan unit pelaksaan"
                                value="{{ old('unit_pelaksanaan_teknis') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_direktur">Nama Direktur</label>
                            <input type="text" class="form-control" id="nama_direktur" name="nama_direktur"
                                placeholder="Masukan nama direktur" value="{{ old('nama_direktur') }}">
                        </div>
                        <div class="form-group">
                            <label for="nip_kepala_dinas">Pangkat Direktur</label>
                            <input type="text" class="form-control" id="pangkat_direktur" name="pangkat_direktur"
                                placeholder="Masukan pangkat direktur" value="{{ old('pangkat_direktur') }}">
                        </div>
                        <div class="form-group">
                            <label for="nip_kepala_dinas">NIP Direktur</label>
                            <input type="text" class="form-control" id="nip_direktur" name="nip_direktur"
                                placeholder="Masukan pangkat nip direktur" value="{{ old('nip_direktur') }}">
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

    <script>
        function getData(id) {
            var kendaraan_id = document.getElementById('kendaraan_id');
            $.ajax({
                url: "{{ url('admin/nokir/kendaraan') }}" + "/" + kendaraan_id.value,
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

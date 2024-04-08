@extends('layouts.app')

@section('title', 'Tambah Pelepasan')

@section('content')

    <div class="modal fade" id="modal-pilihkabin">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Kabin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <form action="{{ url('admin/pelepasan_ban') }}" enctype="multipart/form-data" autocomplete="off"
                            method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pelepasan Ban</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group" style="flex: 8;"> <!-- Adjusted flex value -->
                                        <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                            data-placeholder="Cari Kabin.." style="width: 100%;" data-select2-id="23"
                                            tabindex="-1" aria-hidden="true" id="kendaraan_id" onchange="getData(0)">
                                            <option value="">- Pilih -</option>
                                            @foreach ($kendaraans as $kendaraan)
                                                <option value="{{ $kendaraan->id }}"
                                                    {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                                    {{ $kendaraan->no_kabin }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" hidden>
                                        <label for="nopol">id kendaraan</label>
                                        <input type="text" class="form-control" id="id" name="id_kendaraan"
                                            readonly placeholder="Masukan id" value="{{ old('id') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nopol">No. Registrasi Kendaraan</label>
                                        <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                            placeholder="Masukan no registrasi kendaraan" value="{{ old('no_pol') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Jumlah Ban</label>
                                        <input type="text" class="form-control" id="jumlah_ban" name="jumlah_ban"
                                            readonly placeholder="Masukan jumlah ban" value="{{ old('jumlah_ban') }}">
                                    </div>
                                    <div class="form-group" id="layoutjenis">
                                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                        <input type="text" class="form-control" id="jenis_kendaraan"
                                            name="jenis_kendaraan" readonly placeholder="Masukan jenis kendaraan"
                                            value="{{ old('jenis_kendaraan') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Lanjutkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#modal-pilihkabin').modal('show');
        });

        function getData(id) {
            var kendaraan_id = document.getElementById('kendaraan_id');
            $.ajax({
                url: "{{ url('admin/pelepasan_ban/kendaraan') }}" + "/" + kendaraan_id.value,
                type: "GET",
                dataType: "json",
                success: function(kendaraan_id) {
                    var no_pol = document.getElementById('no_pol');
                    no_pol.value = kendaraan_id.no_pol;

                    var no_pol = document.getElementById('id');
                    no_pol.value = kendaraan_id.id;

                    var jenis_kendaraan = document.getElementById('jenis_kendaraan');
                    jenis_kendaraan.value = kendaraan_id.jenis_kendaraan.nama_jenis_kendaraan;

                    var jumlah_ban = document.getElementById('jumlah_ban');
                    jumlah_ban.value = kendaraan_id.jenis_kendaraan.total_ban;

                    //modal kendaraan id exle 1

                    var kendaraan_x1a = document.getElementById('kendaraan_x1a');
                    kendaraan_x1a.value = kendaraan_id.id;

                    var kendaraan_x1b = document.getElementById('kendaraan_x1b');
                    kendaraan_x1b.value = kendaraan_id.id;

                    //modal kendaraan id exle 2

                    var kendaraan_x2a = document.getElementById('kendaraan_x2a');
                    kendaraan_x2a.value = kendaraan_id.id;

                    var kendaraan_x2b = document.getElementById('kendaraan_x2b');
                    kendaraan_x2b.value = kendaraan_id.id;

                    var kendaraan_x2c = document.getElementById('kendaraan_x2c');
                    kendaraan_x2c.value = kendaraan_id.id;

                    var kendaraan_x2d = document.getElementById('kendaraan_x2d');
                    kendaraan_x2d.value = kendaraan_id.id;

                    //modal kendaraan id exle 3

                    var kendaraan_x3a = document.getElementById('kendaraan_x3a');
                    kendaraan_x3a.value = kendaraan_id.id;

                    var kendaraan_x3b = document.getElementById('kendaraan_x3b');
                    kendaraan_x3b.value = kendaraan_id.id;

                    var kendaraan_x3c = document.getElementById('kendaraan_x3c');
                    kendaraan_x3c.value = kendaraan_id.id;

                    var kendaraan_x3d = document.getElementById('kendaraan_x3d');
                    kendaraan_x3d.value = kendaraan_id.id;

                    //modal kendaraan id exle 4

                    var kendaraan_x4a = document.getElementById('kendaraan_x4a');
                    kendaraan_x4a.value = kendaraan_id.id;

                    var kendaraan_x4b = document.getElementById('kendaraan_x4b');
                    kendaraan_x4b.value = kendaraan_id.id;

                    var kendaraan_x4c = document.getElementById('kendaraan_x4c');
                    kendaraan_x4c.value = kendaraan_id.id;

                    var kendaraan_x4d = document.getElementById('kendaraan_x4d');
                    kendaraan_x4d.value = kendaraan_id.id;

                    //modal kendaraan id exle 5

                    var kendaraan_x5a = document.getElementById('kendaraan_x5a');
                    kendaraan_x5a.value = kendaraan_id.id;

                    var kendaraan_x5b = document.getElementById('kendaraan_x5b');
                    kendaraan_x5b.value = kendaraan_id.id;

                    var kendaraan_x5c = document.getElementById('kendaraan_x5c');
                    kendaraan_x5c.value = kendaraan_id.id;

                    var kendaraan_x5d = document.getElementById('kendaraan_x5d');
                    kendaraan_x5d.value = kendaraan_id.id;

                    //modal kendaraan id exle 6

                    var kendaraan_x6a = document.getElementById('kendaraan_x6a');
                    kendaraan_x6a.value = kendaraan_id.id;

                    var kendaraan_x6b = document.getElementById('kendaraan_x6b');
                    kendaraan_x6b.value = kendaraan_id.id;

                    var kendaraan_x6c = document.getElementById('kendaraan_x6c');
                    kendaraan_x6c.value = kendaraan_id.id;

                    var kendaraan_x6d = document.getElementById('kendaraan_x6d');
                    kendaraan_x6d.value = kendaraan_id.id;


                    // var km_kendaraan = document.getElementById('km_kendaraan');
                    // km_kendaraan.value = kendaraan_id.km;

                },
            });
        }
    </script>
@endsection

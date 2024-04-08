@extends('layouts.app')

@section('title', 'Pilih Laporan Return')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="modal fade" id="modal-pilihreturn">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Laporan Return Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="text-align: left;">
                        <form id="memoForm" enctype="multipart/form-data" autocomplete="off" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pilih Laporan Return Barang</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="memo_type" id="memoPerjalanan"
                                            value="perjalanan" checked>
                                        <label class="form-check-label" for="memoPerjalanan">
                                            Laporan Surat Penerimaan Return Barang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="memo_type" id="memoBorong"
                                            value="borong">
                                        <label class="form-check-label" for="memoBorong">
                                            Laporan Nota Return Barang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="memo_type" id="penjualan"
                                            value="penjualan">
                                        <label class="form-check-label" for="penjualan">
                                            Laporan Penjualan Return Barang
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="button" id="lanjutkanBtn" class="btn btn-primary">Lanjutkan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#modal-pilihreturn').modal('show');
        });
    </script>

    <script>
        document.getElementById('lanjutkanBtn').addEventListener('click', function() {
            var memoType = document.querySelector('input[name="memo_type"]:checked').value;

            // Redirect based on the selected memo type
            switch (memoType) {
                case 'perjalanan':
                    window.location.href = "{{ url('admin/laporan_return') }}";
                    break;
                case 'borong':
                    window.location.href = "{{ url('admin/laporan_notareturn') }}";
                    break;
                case 'penjualan':
                    window.location.href = "{{ url('admin/laporan_penjualanreturn') }}";
                    break;
                default:
                    // Handle default case or do nothing
                    break;
            }
        });
    </script>
@endsection

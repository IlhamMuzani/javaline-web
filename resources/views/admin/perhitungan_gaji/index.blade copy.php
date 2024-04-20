@extends('layouts.app')

@section('title', 'Perhitungan Gaji Karyawan')

@section('content')
 Content Header (Page header) -->
 class="content-header">
<div class="container-fluid">
      <d class="row mb-2">
          <d class="col-sm-6">
               <class="m-0">Perhitungan Gaji Karyawan</h1>
        </div><!-- /.col -->
             class="col-sm-6">
             <olclass="breadcrumb float-sm-right">
                 <liclass="breadcrumb-item"><a href="{{ url('admin/perhitungan_gaji') }}">Perhitungan Gaji
                          Kaawan</a></li>
                  <lclass="breadcrumb-item active">Tambah</li>
               <>
         </dv>
        v>
    v>
v>


tion class="content">
<div class="container-fluid">
    @if (session('error'))
      <dss="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            
           <i cl="icon fas fa-ban"></i> Error!
        </h5
         @fo (session('error') as $error)
   - {{ $err}} <br>
        @endach
     </d
      @eif
    @if (session('erorrss'))
        ss="alert alert-danger alert-dismissible">
      <buttotype="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <h5>
             <i ="icon fas fa-ban"></i> Error!
          </
           {on('erorrss') }}
  </div>
      @eif

       @(session('error_pelanggans') || session('error_pesanans'))
    <divss="alert alert-danger alert-dismissible">
         <butype="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h
        <i class="icon fas fa-ban"></i> Error!
            
       @if (sion('error_pelanggans'))
 @foreach (sssion('error_pelanggans') as $error)
- {{ $error br>
  @endforeac
       @endi
         @ifsion('error_pesanans'))
   @foreach ssion('error_pesanans') as $error)
  - {{ $errobr>
    @endfore
         @en
       <
        if
 </dv>
 <fom action="{{ url('admin/perhitungan_gaji') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
      @cf
    <div class="card">
             class="card-header">
             <h3class="card-title">Perhitungan Gaji Karyawan Mingguan</h3>
         </dv>
          <d class="card-body">
              <d class="form-group" style="flex: 8;">
                   < class="row">
                     <di class="col-lg-6">
                        <label>Periode:</label>
                          <d class="input-group date" id="reservationdatetime">
                            <input type="date" id="periode_awal" name="periode_awal"
                                placeholder="d M Y sampai d M Y"
                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                value="{{ old('periode_awal') }}" class="form-control datetimepicker-input"
                                data-target="#reservationdatetime">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label style="color:white">.</label>
                        <div class="input-group date" id="reservationdatetime">
                            <input type="date" id="periode_akhir" name="periode_akhir"
                                placeholder="d M Y sampai d M Y"
                                data-options='{"mode":"range","dateFormat":"d M Y","disa e="{{ old('periode_akhir') }}" c -target="#reservationdatetime"> i
                  </div>
              </div>
           </div>
        <!-- /.card-header -->
            <div class="cardy">
                <div class="floaght mb-3"> " class="btn btn-primary btn-sm"s-plus"></i>  
            <div class="table-responsive">
                <!-- Hapus class "overflow-x-auto" -->
                <table class="table table-bordered table-striped">
                    <!-- Tambahkan class "table-responsive" -->
                    <thead>
                        <tr>
                            <!-- Tambahkan style untuk lebar kolom -->
                            <th style="font-size:14px; width: 50px;" class="text-center">No</th>
                            <th style="font-size:14px; min-width: 150px;">Nama</th>
                            <th style="font-size:14px; min-width: 150px;">Gapok</th>
                            <th style="font-size:14px; min-width: 150px;">UM</th>
                            <th style="font-size:14px; min-width: 150px;">UH</th>
                            <th style="font-size:14px; min-width: 150px;">HK</th>
                            <th style="font-size:14px; min-width: 150px;">Lembur</th>
                                <th style="font-size:14px; min-width: 150px;">HL</th>
                                <th style="font-size:14px; min-width: 150px;">Storing</th>
                                <th style="font-size:14px; min-width: 150px;">Storing Hasil</th>
                            <th style="font-size:14px; min-width: 150px;">Gaji Kotor</th>
                            <th style="font-size:14px; min-width: 150px;">keterlambatan</th>
                            <th style="font-size:14px; min-width: 150px;">Absen</th>
                            <th style="font-size:14px; min-width: 150px;">Pelunasan</th>
                            <th style="font-size:14px; min-width: 150px;">Gaji Bersih</th>
                            <th style="font-size:14px; text-align:center; min-width: 100px;">Opsi</th>
                         </tr>
                      </thead>
                      <tbody id=abel-pembelian">
                           <tr ipembelian-0">
                             <tdstyle="width: 70px; font-size:14px" class="text-center" id="urutan">1
                             </t>
                              <thidden>
                                <div class="form-group">
                                       <ut type="text" class="form-control" id="karyawan_id-0" name="karyawan_id[]">
                                </div>
                                >
                              <thidden>
                                <div class="form-group">
                                       <ut onclick="Karyawan(0)" style="font-size:14px" type="text" readonly
                                        class="form-control" id="kode_karyawan-0" name="kode_karyawan[]">
                                </div>
                             </t>
                              <tstyle="width: 150px;">
                                <div class="form-group">
                                    <input onclick="Karyawan(0)" style="font-size:14px" type="text" readonly
                                        class="form-control" id="nama_lengkap-0" name="nama_lengkap[]">
                                 </dv>
                             </t>
                              <tstyle="width: 150px;">
                                <div class="form-group">
                                        ut type="number" onclick="Karyawan(0)" style="font-size:14px" readonly
                                        class="form-control gaji" id="gaji-0" name="gaji[]" data-row-id="0">
                                </div>
                              </>
                              <tstyle="width: 150px;">
                                <div class="form-group">
                                    <input type="number" onclick="Karyawan(0)" style="font-size:14px" readonly
                                        class="form-control uang_makan" id="uang_makan-0" name="uang_makan[]">
                                </div>
                                </td>
                              <tstyle="width: 150px;">
                                <div class="form-group">
                                    <input onclick="Karyawan(0)" onclick="Karyawan(0)" style="font-size:14px"
                                        readonly type="number" class="form-control uang_hadir" id="uang_hadir-0"
                                        name="uang_hadir[]" data-row-id="0">
                                </div>
                                >
                                style="width: 150px;">
                                <div class="form-group">
                                    <input type="number" style="font-size:14px" class="form-control hari_kerja"
                                        id="hari_kerja-0" name="hari_kerja[]" data-row-id="0"> 
                            </td style="width: 150px;">
                             <td
                                <div class="form-group">
                                    <input style="font-size:14px" type="number" class="form-control lembur"
                                        id="lembur-0" name="lembur[]" data-row-id="0"> 
                            </td>
                            <td style="width: 150px;">
                                <div class="form-group">
                                    <input style="font-size:14px" readonly type="number"
                                        class="form-control hasil_lembur" id="hasil_lembur-0" name="hasil_lembur -row-id="0">
                                </div>
                                >
                                style="width: 150px;">
                                     class="form-group">
                                        ut style="font-size:14px" type="number" class="form-control storing" storing-0" name="storing[]" data-row-id="0">
                                </div>
                                >
                             <tdstyle="width: 150px;">
                                  <d class="form-group">
                                       <ut style="font-size:14px" readonly type="number" s="form-control hasil_storing" id="hasil_storing-0"
                                        name="hasil_storing[]" data-row-id="0">
                                </div>
                               <>
                            <td style="width: 150px;">
                                    <divss="form-group"> tyle="font-size:14px" onclick="Karyawan(0)" readonly type="number" s="form-control gaji_kotor" id="gaji_kotor-0" name="gaji_kotor[]">
                                </div>
                            </td>
                            <td style="width: 150px;">
                                <div class="form-group">
                                    <input style="font-size:14px" type="number" class="form-control keterlambatan keterlambatan-0" name="keterlambatan[]"> 
                            </td>
                            <td style="width: 150px;">
                                <div class="form-group">
                                    <input style="font-size:14px" type="number" class="form-control absen"
                                        id="absen-0" name="absen[]"> 
                               <td se="width: 150px;">
                                <div class="form-group">
                                    <input style="font-size:14px" type="number"
                                        class="form-control pelunasan_kasbon" id="pelunasan_kasbon-0"
                                        name="pelunasan_kasbon[]"> 
                            <td style="width: 150px;">
                                <div class="form-group">
                                    <input style="font-size:14px" onclick="Karyawan(0)" readonly type="number"
                                        class="form-control gaji_bersih" id="gaji_bersih-0" name="gaji_bersih[]">
                                 </div>  : 100px">
                                <button type="button" class="btn btn-primary btn-sm" onclick="Karyawan(0)">
                                    <i class="fas fa-plus"></i>
                                </button>
                                    ton style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                        ick="removeBan(0)"> ="fas fa-trash"></i> 
                                </td
                         </tr>
                     </tbody>
                  </table>
                </div> 

        <div style="margin-right: 20px; margin-left:20px" class="form-group">
            <label for="alamat">Keterangan</label>
               <textarea type="text"ass="form-control" id="keterangan" name="keterangan"
                    placeholder="Masukanerangan">{{ old('keterangan') }}</textarea>
            </div>
            <div style="margin-right: 20px; margeft:20px" class="form-group">z3" for="nopol">Grand Total</label>-" class="form-control text-right" id="grand_total"
                name="grand_total" readonly placeholder="" value="{{ old('grand_total') }}">
          </div>
          <div class="card-footer text-rht">
               <button type="reset" class="bbtn-secondary" id="btnReset">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button> > i> Sedang Menyimpan...
            </div>
        </div>
        </div>

        <div class="modal fade" id="tableMemo" data-backdrop="static">
         <div class="modal-dialo modal-lg">
              <div class="modal-contt">
                  <div class="modal-head">
                       <h4 class="modal-titlData Gaji Karyawan</h4>
                     <button type="button" class"close" data-dismiss="modal" aria-label="Close"> mes;</span> 
                    </div>
                    <div class="modal-bo
                        <div class="m-2"
                            <input type="texd="searchInput" class="form-control" placeholder="Search...">
                        </div>ltable-bordered table-striped">
                              <tr>
                                  <th cls="text-center">No</th>
                                   <Kode Karyawan</th>
                                <th>Nama Karyawan</th>
                                <th>Gapok</th>
                                  <tOpsi</th>
                                </tr>  
                            @foreach ($karyawans as $karyawan)
                               <onclick="getMemos({{ $loop->index }})" data-id="{{ $karyawan->id }}"
                                data-kode_karyawan="{{ $karyawan->kode_karyawan }}"
                                    -nama_lengkap="{{ $karyawan->nama_lengkap }}" data-gaji="{{ $karyawan->gaji }}"
                                 data-paam="{{ $loop->index }}"> ext-center">{{ $loop->iteration }}</td> awan->kode_karyawan }}</td>
                                <td>{{ $karyawan->nama_lengkap }}</td>
                                <td>{{ number_format($karyawan->gaji, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                        onclick="getMemos({{ $loop->index }})"> lass="fas fa-plus"></i> >
                                </td>
                            </tr>
                            @endforeach
                           </tbody>
                        </table>
         </div>
        </div>
</section>
<script>
// filter rute te;u");
    filter = input.value.toUpperCase
    table = document.getElementB"tables");
    tr = table.getElementsByTagN"tr");

    for (i = 0; i < tr.length; i++) {
    // Loop through columns (td 1, 2, and 3)
        for (j = 1; j <= 3; j++)
         td = tr[i].getElementsBTagName("td")[j];
          if (td) {
               txtValue = td.textContent td.innerText;tOf(filter) > -1) {
                    displayRow = tru
                    break; // Brthe loop if a match is found in any column
                }
            }
        }

        // Set the display style basn whether a match is found in any column"" : "none";
}

ument.getElementById("searchInpu").addEventListener("input", filterMemo);
cript>

cript>
ar data_pembelia @json(session('data_pembelians'));
jumlah_ban = 1;

(data_pembelian != null){
 jumlah_ban = data_pmbelian.length;
  $('#tabel-pembian').empty();
  var urutan 0;
    $.each(data_pembelian, function(key, value) {
       uruta urutan + 1;
    itemPembelian(urutan, key, value);
    });


unction addPesan) {
jumlah_ban = jumlah_ban + 1;
  if (jumlahan === 1) {
      $('#tal-pembelian').empty();
   }
b_ban, jumlah_ban - 1);


function reman(params) {
 jumlah_ban = julah_ban - 1;
rdocument.getElementById('tabel-pembelian');
var pembelian = document.getElementById('pembelian-' + params);

  tabel_pesanan.moveChild(pembelian);

   if (jumlah_ba== 0) {
    var item_pembelian = '<tr>';
        item_peman += '<td class="text-center" colspan="5">- Memo belum ditambahkan -</td>';
     item_pebelian += '</tr>';
      $(tabel-pembelian').html(item_pembelian);
    } else {
       vurutan = document.querySelectorAll('#urutan');
    for (let i = 0; i < urutan.length; i++) {
            urut].innerText = i + 1;
     }
 }
  updateGrandTotal();


tion itemPembelian(urutan, key, value = null) {
    var karyawan_id ;
 var kode_karyawan = '';
 var nama_lengkap = '';
  var gaji = '';
var uang_makan = '';
    var uang_hadir = '';
 var hari_kerja = '';
 var lembur = '';
  var hasil_lembur = '';
  var storing = '';
   var hasil_storing = '';
 var gaji_kotor = '';
 var keterlambatan = '';
  var pelunasan_kasbon = '';
  var absen = '';
   var gaji_bersih = '';

 (value !== null) {a ei
        uang_makan = value.uang_makan;
        uang_hadir = value.uang_hadir;
        hari_kerja = value.hari_kerja;
        lembur = value.lembur;
        hasil_lembur = value.hasil_lembur;
        storing = value.storing;
        hasil_storing = value.hasil_storing;
        gaji_kotor = value.gaji_kotor;e
    pelunasan_kasbon = value.pelunasasbon;
     absen = value.absen;
       gaji_bersih = value.gaji_bers


// urutan 
r item_pembelian = '<tr id="pembelian-'  '">';
 item_pembelian += '<td style="width: 70:14px" class="text-center" id="urutan-' + urutan + '">' +
 + '</td>';

    // karyawan_id 
item_pembelian += '<td hidden>';
embelian += '<div class="form-group">'
tem_pembelian += '<input type="text" cla"form-control" id="karyawan_id-' + urutan +
    '" name="karyawan_id[]" value="' + kid + '" ';
tem_pembelian += '</div>';
item_pembelian += '</td>';

 // kode_karyawan 
_pembelian += '<td hidden onclick="Karyawan(' + urutan +
        ')">';n
_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_karyawan-' +
urutan +
    '" name="kode_karyawan[]" value= kode_karyawan + '" ';
 item_pembelian += '</div>';
  item_pembelian += '</td>';

   // nama_lengkap 
 item_pembelian += 'td onclick="Karyawan(' + urutan +
        ')">';
    item_peman += '<div class="form-group">'
    itembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="nama_lengkap-' +
    urutan +
    '" name="nama_lengkap[]" value="' + nama_lengkap + '" ';
item_pembelian += '</div>';
  it_pembelian += '</td>';

   // ga
item_pembelian += '<td onclick="Karyawan(' + urutan +
        ';
 item_pebelian += '<div class="form-group">'
    item_pembelian += '<input type="number" class="form-control gaji" style="font-size:14px" readonly id="gaji-' +
     uruan +
      '" nam"gaji[]" value="' + gaji + '" ';
    item_pembelian += '</div>';
  item_pembean += '</td>';

// uang_makan 
    item_pembeli= '<td onclick="Karyawan(' + urutan +
     ')">';
  item_pembelian += div class="form-group">'
   item_pembelian +=
    '<input type="number" class="form-control uang_makan" style="font-size:14px" readonly id="uang_makan-' +
        urutan +
     '" name="uag_makan[]" value="' + uang_makan + '" ';
 item_pembelan += '</div>';
    item_pembelian += '</td>';

// uang_hadir
    itembelian += '<td onclick="Karyawan(' + urutan +
    ')">';
    _pembelian += '<div class="form-group">'
item_pembelian +=
        '<input type="number" class="form-control uang_hadir" readonly style="font-size:14px" id="uang_hadir-' +
    urutan +
    '" name="uang_hadir[]" value="' + uang_hadir + '" ';
 ite_pembelian += '</div>';
    item_pembelian += '</td>';

  // harkerja 
  item_pbelian += '<td>';
   item_belian += '<div class="form-group">'
item_pembelian +=
        '<intype="number" class="form-control hari_kerja" style="font-size:14px" id="hari_kerja-' +
      urutan
      '"ame="hari_kerja[]" value="' + hari_kerja + '" ';
   i_pembelian += '</div>';
    item_pembelian += '</td>';

    // lr 
    item_pembelian += '<td>';
 item_pebelian += '<div class="form-group">'
  item_pembean +=
       'put type="number" class="form-control lembur" style="font-size:14px" id="lembur-' +
        urutan +
    '" name="lembur[]" value="' + lembur + '" ';
    _pembelian += '</div>';
    item_pembelian += '</td>';

 // hasi_lembur 
    item_pembelian += '<td onclick="Karyawan(' + urutan +
      ')';
item_pembelian += '<div class="form-group">'
    item_pembelian +=
        put type="number" class="form-control hasil_lembur" style="font-size:14px" readonly id="hasil_lembur-' +
        urutan +
     '" ame="hasil_lembur[]" value="' + hasil_lembur + '" ';
 item_pembelan += '</div>';
  item_pembean += '</td>';

   // storin
 item_pebelian += '<td>';
 item_pembelan += '<div class="form-group">'
  item_pembean +=
      '<input ty="number" class="form-control storing" style="font-size:14px" id="storing-' +
       uruta
    '" name="storing[]" value="' + storing + '" ';
    itembelian += '</div>';
 ite_pembelian += '</td>';

 // asil_storing 
  item_pbelian += '<td onclick="Karyawan(' + urutan +
      ')';
   item_belian += '<div class="form-group">'
item_pembelian +=
        put type="number" class="form-control hasil_storing" style="font-size:14px" readonly id="hasil_storing-' +
      uran +
      '"ame="hasil_storing[]" value="' + hasil_storing + '" ';
   item_belian += '</div>';
item_pembelian += '</td>';

 // gajikotor 
  item_pbelian += '<td onclick="Karyawan(' + urutan +
       '';
item_pembelian += '<div class="form-group">'
    itembelian +=
     '<iput type="number" class="form-control gaji_kotor" style="font-size:14px" readonly id="gaji_kotor-' +
     uruan +
      '"ame="gaji_kotor[]" value="' + gaji_kotor + '" ';
item_pembelian += '</div>';
    itembelian += '</td>';

 // ketelambatan 
  item_pbelian += '<td>';
    item_pembelian += '<div class="form-group">'
  item_pbelian +=
       '<inptype="number" class="form-control keterlambatan" style="font-size:14px" id="keterlambatan-' +
     urutan 
     '" name"keterlambatan[]" value="' + keterlambatan + '" ';
  item_pembean += '</div>';
  item_pembean += '</td>';

// absen 
    item_peman += '<td>';
  item_pembean += '<div class="form-group">'
  item_pembean +=
       '<inptype="number" class="form-control absen" style="font-size:14px" id="absen-' +
    urutan +
        '" n"absen[]" value="' + absen + '" ';
 item_pembelan += '</div>';
  item_pembean += '</td>';

// pelunasan_kasbon 
    item_peman += '<td>';
 item_pembelan += '<div class="form-group">'
 item_pembelan +=
      '<inputype="number" class="form-control pelunasan_kasbon" style="font-size:14px" id="pelunasan_kasbon-' +
    urutan +
        '" n"pelunasan_kasbon[]" value="' + pelunasan_kasbon + '" ';
 item_pebelian += '</div>';
    item_pembelian += '</td>';

  // gajbersih 
  item_pbelian += '<td onclick="Karyawan(' + urutan +
       ')">'
    item_pembelian += '<div class="form-group">'
item_pembelian +=
        put type="number" class="form-control gaji_bersih" style="font-size:14px" readonly id="gaji_bersih-' +
     uruan +
     '" ame="gaji_bersih[]" value="' + gaji_bersih + '" ';
  item_pembean += '</div>';
  item_pbelian += '</td>';
   item_belian += '<td style="width: 100px">';
    item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="Karyawan(' + urutan +
     ')"';
 item_pebelian += '<i class="fas fa-plus"></i>';
  item_pembean += '</button>';
  item_pbelian +=
       'tton style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
    urutan + ')">';
    item_peman += '<i class="fas fa-trash"></i>';
  item_pbelian += '</button>';
  item_pbelian += '</td>';
    item_pembelian += '</tr>';

$('#tabel-pembelian').append(item_pembelian);
}
cript>

script>
activeSpecificationIndex = 0;

ction Kayawan(param) {
    activeSpecificationIndex = param;
 // Showthe modal and filter rows if necessary
  $('#taeMemo').modal('show');


ction geMemos(rowIndex) {
 var selecteRow = $('#tables tbody tr:eq(' + rowIndex + ')');
  var karyaw_id = selectedRow.data('id');
  var ko_karyawan = selectedRow.data('kode_karyawan');
   var n_lengkap = selectedRow.data('nama_lengkap');
    var gaji = selectedRow.data('gaji');

 // Updae the form fields for the active specification
  $('#kaawan_id-' + activeSpecificationIndex).val(karyawan_id);
  $('#ko_karyawan-' + activeSpecificationIndex).val(kode_karyawan);
   $('#nama_gkap-' + activeSpecificationIndex).val(nama_lengkap);
$('#gaji-' + activeSpecificationIndex).val(gaji);

  // Hidthe modal after updating the form fields
  $('#taeMemo').modal('hide');
}
/script>

{{-- has-}}
ript>
document).oninput", ".gaji, .lembur, .storing, .keterlambatan, .pelunasan_kasbon, .absen, .hari_kerja",
   function(
    // Ambil baris saat ini
        currentRow = $(this).closest('tr');

        // Ambil nilai dari input
     vargaji = parseFloat(currentRow.find(".gaji").val()) || 0;
      vahari_kerja = parseFloat(currentRow.find(".hari_kerja").val()) || 0;
      valembur = parseFloat(currentRow.find(".lembur").val()) || 0;
       vstoring = parseFloat(currentRow.find(".storing").val()) || 0;
    var keterlambatan = parseFloat(currentRow.find(".keterlambatan").val()) || 0;
        var nasan_kasbon = parseFloat(currentRow.find(".pelunasan_kasbon").val()) || 0;
     var absn = parseFloat(currentRow.find(".absen").val()) || 0;

      //itung uang makan dan uang hadir
        var uang_makan = hari_kerja * 10000;
    var uang_hadir = hari_kerja * 5000;

     // itung hasil lembur dan storing
     varhasil_lembur = lembur * 10000;
      var gaperjam = gaji / 12;
      var hal_storing = Math.round(gajiperjam * storing); // Menggunakan Math.round() untuk membulatkan

     // itung gaji kotor dan gaji bersih
     vargaji_kotor = (gaji + 10000 + 5000) * hari_kerja + hasil_lembur + hasil_storing;
        // var gaji_bersih = gaji_kotor - keterlambatan - pelunasan_kasbon - absen;
      vagaji_bersih = gaji_kotor - keterlambatan - absen;

       /asukkan hasil perhitungan ke dalam input yang sesuai
    currentRow.find(".uang_makan").val(uang_makan);
        currow.find(".uang_hadir").val(uang_hadir);
      currenow.find(".hasil_lembur").val(hasil_lembur);
      currenow.find(".hasil_storing").val(hasil_storing);
       centRow.find(".gaji_kotor").val(gaji_kotor);
    currentRow.find(".gaji_bersih").val(gaji_bersih);
        updateGrandTotal();

 });
cript>

-- grand_tot --}}
script>
tion updateGrandTotal() {
    var dTotal = 0;

    // Loop through all elements with name "nominal_tambahan[]"
  $('inp[name^="gaji_bersih"]').each(function() {
       vnominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0; // Remove dots
    grandTotal += nominalValue;
    });

 $('#grand_ttal').val(formatRupiah(grandTotal));



$('body').on('input', 'input[name^="gaji_bersih"]', function() {
 updateGandTotal();


 Panggilungsi saat halaman dimuat untuk menginisialisasi grand total
(document).ry(function() {
 updateGrandotal();


nction fmatRupiah(number) {
    var formatted = new Intl.NumberFormat('id-ID', {
       mmumFractionDigits: 2,
    maximumFractionDigits: 2
    }).ft(number);
 return ' + formatted;

script>

script>
cument).ready(function() {
    // Thkan event listener pada tombol "Simpan"
  $('#btimpan').click(function() {
      //embunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
       $is).hide();
    $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
        $('#ing').show();

      //akukan pengiriman formulir
       $orm').submit();
});
});
</script


cript>
tanggalAwal = document.getElementById('periode_awal');
var tangkhir = document.getElementById('periode_akhir');
(tanggalAwalvalue == "") {
 tanggalAkhi.readOnly = true;

nggalAwaaddEventListener('change', function() {
   if (t.value == "") {
     tangalAkhir.readOnly = true;
 } else 
      tagalAkhir.readOnly = false;
  };
   tanggalAk.value = "";
var today = new Date().toISOString().split('T')[0];
    tangkhir.value = today;
  tanggakhir.setAttribute('min', this.value);
;
/script>

@endsection
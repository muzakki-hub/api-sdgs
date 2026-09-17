 <form action="{{ route('desa-p2.store') }}" method="POST">
     @csrf
     <div class="row col-sm">
         <!-- ID Desa -->
         {{-- <div class="mb-3">
             <label>ID Desa</label>
             <input type="text" name="id" class="form-control" required maxlength="25">
         </div> --}}
     </div>
     <!-- ID Survey -->
     <div class="mb-3">
         <label>ID Survey</label>
         <select name="id_survey" class="form-control shadow-sm">
             @foreach ($survey as $item)
                 {{-- <p>{{ $item->nama_survey }} (aktif dari {{ $item->tanggal_mulai }} sampai {{ $item->tanggal_selesai }})
                 </p> --}}
                 <option value="{{ $item->id }}">(aktif dari {{ $item->tgl_mulai }} sampai {{ $item->tgl_akhir }})
                 </option>
             @endforeach
         </select>
     </div>

     <!-- Lokasi -->
     <div class="row">
         <div class="col-sm">
             <div class="mb-3">
                 <label>Kode Provinsi</label>
                 <select id="provinsi" class="select2 form-control" name="kode_provinsi">
                     <option value="">-- Pilih Provinsi --</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Kode Kabupaten</label>
                 <select id="kabupaten" class="select2 form-control" name="kode_kabupaten">
                     <option value="">-- Pilih Kabupaten --</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Kode Kecamatan</label>
                 <select id="kecamatan" class="select2 form-control" name="kode_kecamatan">
                     <option value="">-- Pilih Kecamatan --</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Kode Desa</label>
                 <select id="desa" class="select2 form-control" name="kode_desa">
                     <option value="">-- Pilih Desa --</option>
                 </select>
             </div>
         </div>
     </div>

     <!-- Info Desa -->
     <div class="mb-3">
         <label>Nama Desa</label>
         <input type="text" name="nama_desa" class="form-control" maxlength="100">
     </div>
     <div class="row">
         <div class="col-sm">
             <div class="mb-3">
                 <label>Email Desa</label>
                 <input type="email" name="email" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>URL Web</label>
                 <input type="url" name="url_web" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Facebook</label>
                 <input type="url" name="url_facebook" class="form-control">
             </div>
         </div>

     </div>
     <div class="row">
         <div class="col-sm">
             <div class="mb-3">
                 <label>Twitter</label>
                 <input type="url" name="url_twitter" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Instagram</label>
                 <input type="url" name="url_instagram" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Youtube</label>
                 <input type="url" name="url_youtube" class="form-control">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-sm">
             <!-- Status Pemerintahan -->
             <div class="mb-3">
                 <label>Status Pemerintahan</label>
                 <select name="status_pemerintahan" class="form-control shadow-sm">
                     <option value="1">Desa</option>
                     <option value="2">Nagari</option>
                     <option value="3">Gampong</option>
                     <option value="4">Kampung</option>
                     <option value="5">Kelurahan</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <!-- Jumlah RW/RT -->
             <div class="mb-3">
                 <label>Jumlah RW</label>
                 <input type="number" name="jml_rw" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Jumlah RT</label>
                 <input type="number" name="jml_rt" class="form-control">
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-sm">
             <!-- SK Pendirian Desa -->
             <div class="mb-3">
                 <label>No SK Pendirian Desa</label>
                 <input type="text" name="no_sk_pendirian_desa" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Tgl SK Pendirian Desa</label>
                 <input type="date" name="tgl_sk_pendirian_desa" class="form-control">
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-sm">
             <!-- SK Peta Desa -->
             <div class="mb-3">
                 <label>No SK Peta Desa</label>
                 <input type="text" name="no_sk_peta_desa" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Tgl SK Peta Desa</label>
                 <input type="date" name="tgl_sk_peta_desa" class="form-control">
             </div>
         </div>
     </div>


     <div class="row">
         <div class="col-sm">
             <!-- Informasi Wilayah -->
             <div class="mb-3">
                 <label>Luas Wilayah (Ha)</label>
                 <input type="number" step="0.01" name="luas_wilayah" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Lokasi Desa</label>
                 <input type="text" name="lokasi_desa" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Topografi</label>
                 <select name="topografi" class="form-control shadow-sm">
                     <option value="1">Lereng/Puncak</option>
                     <option value="2">Lembah</option>
                     <option value="3">Dataran</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Jumlah Warga di Lereng/Puncak</label>
                 <input type="number" name="jml_warga" class="form-control">
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-sm">
             <!-- Fasilitas Desa -->
             <div class="mb-3">
                 <label>Balai Desa</label>
                 <select name="balai_desa" class="form-control shadow-sm">
                     <option value="1">Ada Layak</option>
                     <option value="2">Ada Tidak Layak</option>
                     <option value="3">Tidak Ada</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Kepemilikan</label>
                 <select name="kepemilikan" class="form-control shadow-sm">
                     <option value="1">Aset Desa</option>
                     <option value="2">Bukan Aset Desa</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Lokasi Balai Desa</label>
                 <select name="lokasi_balai_desa" class="form-control shadow-sm">
                     <option value="1">Di Dalam Desa</option>
                     <option value="2">Di Luar Desa</option>
                 </select>
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-sm">
             <div class="mb-3">
                 <label>Tempat Pemerintah Desa</label>
                 <select name="tempat_pemerintah_desa" class="form-control shadow-sm">
                     <option value="1">Kantor kepala desa/balai desa</option>
                     <option value="2">Bukan Kantor kepala desa/balai desa</option>
                 </select>
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Jam Kerja</label>
                 <select name="jam_kerja" class="form-control shadow-sm">
                     <option value="1">Tidak Menentu</option>
                     <option value="2">Ada Jadwal</option>
                 </select>
             </div>
         </div>

         <div class="col-sm mb-3">
             <label>Mulai Pukul</label>
             <input type="time" name="mulai_pukul" class="form-control">
         </div>
         <div class="col-sm mb-3">
             <label>Akhir Pukul</label>
             <input type="time" name="akhir_pukul" class="form-control">
         </div>

     </div>

     <div class="row">
         <div class="col-sm">
             <!-- Koordinat -->
             <div class="mb-3">
                 <label>Lintang</label>
                 <input type="number" step="0.0000001" name="lintang" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Bujur</label>
                 <input type="number" step="0.0000001" name="bujur" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Jenis Koordinat</label>
                 <select name="jenis_koordinat" class="form-control shadow-sm">
                     <option value="1">Utara</option>
                     <option value="2">Selatan</option>
                 </select>
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-sm">
             <div class="mb-3">
                 <label>Ketinggian Lokasi (m DPAL)</label>
                 <input type="number" step="0.01" name="ketinggian_lok" class="form-control">
             </div>
         </div>
         <div class="col-sm">
             <div class="mb-3">
                 <label>Panjang Garis Pantai (Km)</label>
                 <input type="number" step="0.01" name="pjg_garis_pantai" class="form-control">
             </div>
         </div>
     </div>

     <!-- Tombol Simpan -->
     <button type="submit" class="btn btn-primary w-100">Simpan Desa</button>
 </form>

    <!-- Modal Tambah Desa -->
    {{-- <div class="modal fade" id="modalTambahDesa" aria-labelledby="modalTambahDesaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDesaLabel">Tambah Data Desa P2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('desa-p2.store') }}" method="POST">
                                @csrf
                                <!-- Lokasi -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Kode Provinsi<span class="text-danger">*</span></label>
                                            <select id="cboprovinsi" class="form-control select2" onchange="ambilKab()" name="kode_provinsi"
                                                required>
                                                <option value="">-- Pilih Provinsi --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Kode Kabupaten<span class="text-danger">*</span></label>
                                            <select id="cbokabupaten" class="form-control select2" onchange="ambilKec()" name="kode_kabupaten"
                                                required>
                                                <option value="">-- Pilih Kabupaten --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Kode Kecamatan<span class="text-danger">*</span></label>
                                            <select id="cbokecamatan" class="form-control select2" onchange="ambilDesa()" name="kode_kecamatan"
                                                required>
                                                <option value="">-- Pilih Kecamatan --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Kode Desa<span class="text-danger">*</span></label>
                                            <select id="cbodesa" class="form-control select2" name="kode_desa"
                                                required>
                                                <option value="">-- Pilih Desa --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Email Desa</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>URL Web</label>
                                            <input type="url" name="url_web" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Facebook</label>
                                            <input type="url" name="url_facebook" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Twitter</label>
                                            <input type="url" name="url_twitter" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Instagram</label>
                                            <input type="url" name="url_instagram" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Youtube</label>
                                            <input type="url" name="url_youtube" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <!-- Status Pemerintahan -->
                                        <div class="mb-3">
                                            <label>Status Pemerintahan <span class="text-danger">*</span></label>
                                            <select name="status_pemerintahan" class="form-control shadow-sm" required>
                                                <option value="1">Desa</option>
                                                <option value="2">Nagari</option>
                                                <option value="3">Gampong</option>
                                                <option value="4">Kampung</option>
                                                <option value="5">Kelurahan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <!-- Jumlah RW/RT -->
                                        <div class="mb-3">
                                            <label>Jumlah RW<span class="text-danger">*</span></label>
                                            <input type="number" name="jml_rw" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Jumlah RT<span class="text-danger">*</span></label>
                                            <input type="number" name="jml_rt" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <!-- SK Pendirian Desa -->
                                        <div class="mb-3">
                                            <label>No SK Pendirian Desa</label>
                                            <input type="text" name="no_sk_pendirian_desa" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Tgl SK Pendirian Desa<span class="text-danger">*</span></label>
                                            <input type="date" name="tgl_sk_pendirian_desa" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <!-- SK Peta Desa -->
                                        <div class="mb-3">
                                            <label>No SK Peta Desa</label>
                                            <input type="text" name="no_sk_peta_desa" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Tgl SK Peta Desa<span class="text-danger">*</span></label>
                                            <input type="date" name="tgl_sk_peta_desa" class="form-control" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm">
                                        <!-- Informasi Wilayah -->
                                        <div class="mb-3">
                                            <label>Luas Wilayah (Ha)<span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="luas_wilayah"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Lokasi Desa<span class="text-danger">*</span></label>
                                            <input type="text" name="lokasi_desa" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Topografi</label>
                                            <select name="topografi" class="form-control shadow-sm">
                                                <option value="1">Lereng/Puncak</option>
                                                <option value="2">Lembah</option>
                                                <option value="3">Dataran</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Jumlah Warga di Lereng/Puncak<span class="text-danger">*</span></label>
                                            <input type="number" name="jml_warga" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <!-- Fasilitas Desa -->
                                        <div class="mb-3">
                                            <label>Balai Desa<span class="text-danger">*</span></label>
                                            <select name="balai_desa" class="form-control shadow-sm" required>
                                                <option value="1">Ada Layak</option>
                                                <option value="2">Ada Tidak Layak</option>
                                                <option value="3">Tidak Ada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Kepemilikan<span class="text-danger">*</span></label>
                                            <select name="kepemilikan" class="form-control shadow-sm" required>
                                                <option value="1">Aset Desa</option>
                                                <option value="2">Bukan Aset Desa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Lokasi Balai Desa<span class="text-danger">*</span></label>
                                            <select name="lokasi_balai_desa" class="form-control shadow-sm" required>
                                                <option value="1">Di Dalam Desa</option>
                                                <option value="2">Di Luar Desa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Tempat Pemerintah Desa<span class="text-danger">*</span></label>
                                            <select name="tempat_pemerintah_desa" class="form-control shadow-sm" required>
                                                <option value="1">Kantor kepala desa/balai desa</option>
                                                <option value="2">Bukan Kantor kepala desa/balai desa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Jam Kerja</label>
                                            <select name="jam_kerja" class="form-control shadow-sm">
                                                <option value="1">Tidak Menentu</option>
                                                <option value="2">Ada Jadwal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm mb-3">
                                        <label>Mulai Pukul <span class="text-danger">*</span></label>
                                        <input type="time" name="mulai_pukul" class="form-control" required>
                                    </div>
                                    <div class="col-sm mb-3">
                                        <label>Akhir Pukul<span class="text-danger">*</span></label>
                                        <input type="time" name="akhir_pukul" class="form-control" required>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <!-- Koordinat -->
                                        <div class="mb-3">
                                            <label>Lintang<span class="text-danger">*</span></label>
                                            <input type="number" step="0.0000001" name="lintang" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Bujur<span class="text-danger">*</span></label>
                                            <input type="number" step="0.0000001" name="bujur" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Ketinggian Lokasi (m DPAL)<span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="ketinggian_lok"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="mb-3">
                                            <label>Panjang Garis Pantai (Km)</label>
                                            <input type="number" step="0.01" name="pjg_garis_pantai"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Simpan -->
                                <button type="submit" class="btn btn-primary w-100">Simpan Desa</button>
                            </form>
                </div>
            </div>
        </div>
    </div> --}}

    
        <!-- Modal -->
        {{-- <div class="modal fade" id="modalFormDesa" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" aria-labelledby="modalLabel">hola</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body-desa">
                        <!-- Isi form akan dimuat lewat AJAX -->
                    </div>
                </div>
            </div>
        </div> --}}

 {{-- <script>
     $(document).ready(function() {
         console.log("Script wilayah dijalankan");

         $(".select2").select2({
             width: '100%'
         });

         $.getJSON("/provinces", function(response) {
             console.log("Data provinsi diterima:", response);
             $.each(response.data, function(i, prov) {
                 $("#provinsi").append(`<option value="${prov.kode}">${prov.nama}</option>`);
             });
         });

         $("#provinsi").change(function() {
             let provinceCode = $(this).val();
             $("#kabupaten").empty().append('<option value="">-- Pilih Kabupaten --</option>');
             $("#kecamatan").empty().append('<option value="">-- Pilih Kecamatan --</option>');
             $("#desa").empty().append('<option value="">-- Pilih Desa --</option>');

             if (provinceCode) {
                 $.getJSON(`/kabupaten/${provinceCode}`, function(response) {
                     $.each(response.data, function(i, kab) {
                         $("#kabupaten").append(
                             `<option value="${kab.kode}">${kab.nama}</option>`);
                     });
                 });
             }
         });

         $("#kabupaten").change(function() {
             let regencyCode = $(this).val();
             $("#kecamatan").empty().append('<option value="">-- Pilih Kecamatan --</option>');
             $("#desa").empty().append('<option value="">-- Pilih Desa --</option>');

             if (regencyCode) {
                 $.getJSON(`/kecamatan/${regencyCode}`, function(response) {
                     $.each(response.data, function(i, kec) {
                         $("#kecamatan").append(
                             `<option value="${kec.kode}">${kec.nama}</option>`);
                     });
                 });
             }
         });

         $("#kecamatan").change(function() {
             let districtCode = $(this).val();
             $("#desa").empty().append('<option value="">-- Pilih Desa --</option>');

             if (districtCode) {
                 $.getJSON(`/desa/${districtCode}`, function(response) {
                     $.each(response.data, function(i, des) {
                         $("#desa").append(
                             `<option value="${des.kode}">${des.nama}</option>`);
                     });
                 });
             }
         });
     });
 </script> --}}
 {{-- <script>
     $(document).ready(function() {
         // aktifkan select2
         $(".select2").select2({
             width: '100%',
             dropdownParent: $('#modalTambahDesa') // penting saat select2 di dalam modal
         });


         // Load Provinsi
         $.getJSON("/provinces", function(response) {
             console.log("Response full:", response);
             if (response && response.data && Array.isArray(response.data)) {
                 $.each(response.data, function(i, prov) {
                     $("#provinsi").append(`<option value="${prov.kode}">${prov.nama}</option>`);
                 });
                 $("#provinsi").trigger('change'); // refresh tampilan select2
             }
         });

         // Load Kabupaten sesuai Provinsi
         $("#provinsi").change(function() {
             let provinceCode = $(this).val();
             $("#kabupaten").empty().append('<option value="">-- Pilih Kabupaten --</option>');
             $("#kecamatan").empty().append('<option value="">-- Pilih Kecamatan --</option>');
             $("#desa").empty().append('<option value="">-- Pilih Desa --</option>');

             if (provinceCode) {
                 $.getJSON(`/kabupaten/${provinceCode}`, function(response) {
                     if (response && response.data) {
                         $.each(response.data, function(i, kab) {
                             $("#kabupaten").append(
                                 `<option value="${kab.kode}">${kab.nama}</option>`);
                         });
                         $("#kabupaten").trigger('change');
                     }
                 });
             }
         });

         // Load Kecamatan
         $("#kabupaten").change(function() {
             let regencyCode = $(this).val();
             $("#kecamatan").empty().append('<option value="">-- Pilih Kecamatan --</option>');
             $("#desa").empty().append('<option value="">-- Pilih Desa --</option>');

             if (regencyCode) {
                 $.getJSON(`/kecamatan/${regencyCode}`, function(response) {
                     if (response && response.data) {
                         $.each(response.data, function(i, kec) {
                             $("#kecamatan").append(
                                 `<option value="${kec.kode}">${kec.nama}</option>`);
                         });
                         $("#kecamatan").trigger('change');
                     }
                 });
             }
         });

         // Load Desa
         $("#kecamatan").change(function() {
             let districtCode = $(this).val();
             $("#desa").empty().append('<option value="">-- Pilih Desa --</option>');

             if (districtCode) {
                 $.getJSON(`/desa/${districtCode}`, function(response) {
                     if (response && response.data) {
                         $.each(response.data, function(i, des) {
                             $("#desa").append(
                                 `<option value="${des.kode}">${des.nama}</option>`);
                         });
                         $("#desa").trigger('change');
                     }
                 });
             }
         });
     });
 </script> --}}

 {{-- Script untuk Tambah Desa --}}
 {{-- <script>
     $(document).ready(function() {
         // Inisialisasi hanya sekali saat modal terbuka
         $(document).on('shown.bs.modal', '#modalTambahDesa', function() {
             const modal = $(this);
             const prov = modal.find('#provinsi');
             const kab = modal.find('#kabupaten');
             const kec = modal.find('#kecamatan');
             const des = modal.find('#desa');

             // Re-init Select2 setiap kali modal dibuka agar tidak rusak
             modal.find('.select2').select2({
                 dropdownParent: modal,
                 width: '100%'
             });

             // Load data provinsi
             $.getJSON("/provinces", function(response) {
                 prov.empty().append('<option value="">-- Pilih Provinsi --</option>');
                 if (response?.data) {
                     $.each(response.data, function(i, p) {
                         prov.append(`<option value="${p.kode}">${p.nama}</option>`);
                     });
                 }
                 prov.trigger('change.select2');
             });

             // Event Provinsi
             prov.off().on('select2:select', function(e) {
                 const kodeProv = $(this).val();
                 console.log("Provinsi dipilih:", kodeProv);

                 kab.empty().append('<option value="">-- Pilih Kabupaten --</option>');
                 kec.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                 des.empty().append('<option value="">-- Pilih Desa --</option>');
                 kab.trigger('change.select2');
                 kec.trigger('change.select2');
                 des.trigger('change.select2');

                 if (kodeProv) {
                     $.getJSON(`/kabupaten/${kodeProv}`, function(response) {
                         if (response?.data) {
                             $.each(response.data, function(i, k) {
                                 kab.append(
                                     `<option value="${k.kode}">${k.nama}</option>`
                                     );
                             });
                         }
                         kab.trigger('change.select2');
                     });
                 }
             });

             // Event Kabupaten
             kab.off().on('select2:select', function(e) {
                 const kodeKab = $(this).val();
                 console.log("Kabupaten dipilih:", kodeKab);

                 kec.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                 des.empty().append('<option value="">-- Pilih Desa --</option>');
                 kec.trigger('change.select2');
                 des.trigger('change.select2');

                 if (kodeKab) {
                     $.getJSON(`/kecamatan/${kodeKab}`, function(response) {
                         if (response?.data) {
                             $.each(response.data, function(i, kc) {
                                 kec.append(
                                     `<option value="${kc.kode}">${kc.nama}</option>`
                                     );
                             });
                         }
                         kec.trigger('change.select2');
                     });
                 }
             });

             // Event Kecamatan
             kec.off().on('select2:select', function(e) {
                 const kodeKec = $(this).val();
                 console.log("Kecamatan dipilih:", kodeKec);

                 des.empty().append('<option value="">-- Pilih Desa --</option>');
                 des.trigger('change.select2');

                 if (kodeKec) {
                     $.getJSON(`/desa/${kodeKec}`, function(response) {
                         if (response?.data) {
                             $.each(response.data, function(i, d) {
                                 des.append(
                                     `<option value="${d.kode}">${d.nama}</option>`
                                     );
                             });
                         }
                         des.trigger('change.select2');
                     });
                 }
             });
         });
     });
 </script> --}}
{{-- <script>
        $(document).ready(function() {
            const prov = $('#provinsi');
            const kab = $('#kabupaten');
            const kec = $('#kecamatan');
            const des = $('#desa');
            const namaDesa = $('input[name="nama_desa"]');

            // === Inisialisasi Select2 ===
            $('.select2').each(function() {
                const $this = $(this);
                const $modalParent = $this.closest('.modal'); // cek apakah select ini ada di modal
                $this.select2({
                    width: '100%',
                    theme: 'classic',
                    dropdownParent: $modalParent.length ? $modalParent : $(document.body)
                });
            });

            // === Load Provinsi ===
            $.getJSON("/provinces", function(response) {
                prov.empty().append('<option value="">-- Pilih Provinsi --</option>');
                if (response?.data) {
                    $.each(response.data, function(i, p) {
                        prov.append(`<option value="${p.kode}">${p.nama}</option>`);
                    });
                }
            });

            // === Event Provinsi ===
            prov.on('change', function() {
                const kodeProv = $(this).val();
                kab.html('<option value="">-- Pilih Kabupaten --</option>');
                kec.html('<option value="">-- Pilih Kecamatan --</option>');
                des.html('<option value="">-- Pilih Desa --</option>');
                namaDesa.val('');

                if (kodeProv) {
                    $.getJSON(`/kabupaten/${kodeProv}`, function(response) {
                        if (response?.data) {
                            $.each(response.data, function(i, k) {
                                kab.append(`<option value="${k.kode}">${k.nama}</option>`);
                            });
                        }
                    });
                }
            });

            // === Event Kabupaten ===
            kab.on('change', function() {
                const kodeKab = $(this).val();
                kec.html('<option value="">-- Pilih Kecamatan --</option>');
                des.html('<option value="">-- Pilih Desa --</option>');
                namaDesa.val('');

                if (kodeKab) {
                    $.getJSON(`/kecamatan/${kodeKab}`, function(response) {
                        if (response?.data) {
                            $.each(response.data, function(i, kc) {
                                kec.append(
                                    `<option value="${kc.kode}">${kc.nama}</option>`);
                            });
                        }
                    });
                }
            });

            // === Event Kecamatan ===
            kec.on('change', function() {
                const kodeKec = $(this).val();
                des.html('<option value="">-- Pilih Desa --</option>');
                namaDesa.val('');

                if (kodeKec) {
                    $.getJSON(`/desa/${kodeKec}`, function(response) {
                        if (response?.data) {
                            $.each(response.data, function(i, d) {
                                des.append(
                                    `<option value="${d.kode}" data-nama="${d.nama}">${d.nama}</option>`
                                );
                            });
                        }
                    });
                }
            });

            // === Event Desa: otomatis isi nama desa ===
            des.on('change', function() {
                const nama = $(this).find(':selected').data('nama') || '';
                namaDesa.val(nama);
            });

            // === Auto pilih id_survey aktif (berdasarkan tanggal hari ini) ===
            $.getJSON('/survey/aktif', function(res) {
                if (res.success && res.data) {
                    $('select[name="id_survey"]').val(res.data.id);
                }
            });

            // === Validasi Dinamis ===
            function toggleRequired(condition, selector) {
                $(selector).prop('required', condition);
                if (condition) $(selector).closest('.mb-3').show();
                else $(selector).closest('.mb-3').hide();
            }

            // No SK Pendirian Desa → Tgl wajib diisi
            $('input[name="no_sk_pendirian_desa"]').on('input', function() {
                const hasValue = $(this).val().trim() !== '';
                toggleRequired(hasValue, 'input[name="tgl_sk_pendirian_desa"]');
            });

            // No SK Peta Desa → Tgl wajib diisi
            $('input[name="no_sk_peta_desa"]').on('input', function() {
                const hasValue = $(this).val().trim() !== '';
                toggleRequired(hasValue, 'input[name="tgl_sk_peta_desa"]');
            });

            // Topografi Lereng/Puncak → wajib isi Jumlah Warga
            $('select[name="topografi"]').on('change', function() {
                const isLereng = $(this).val() === '1';
                toggleRequired(isLereng, 'input[name="jml_warga"]');
            });

            // Jam kerja Ada Jadwal → wajib isi waktu mulai dan akhir
            $('select[name="jam_kerja"]').on('change', function() {
                const adaJadwal = $(this).val() === '2';
                toggleRequired(adaJadwal, 'input[name="mulai_pukul"]');
                toggleRequired(adaJadwal, 'input[name="akhir_pukul"]');
            });

            // === Trigger awal untuk sembunyikan field opsional ===
            toggleRequired(false, 'input[name="tgl_sk_pendirian_desa"]');
            toggleRequired(false, 'input[name="tgl_sk_peta_desa"]');
            toggleRequired(false, 'input[name="jml_warga"]');
            toggleRequired(false, 'input[name="mulai_pukul"]');
            toggleRequired(false, 'input[name="akhir_pukul"]');
        });
    </script> --}

    <script>
        $(document).ready(function() {
            const prov = $('#provinsi');
            const kab = $('#kabupaten');
            const kec = $('#kecamatan');
            const des = $('#desa');
            const namaDesa = $('input[name="nama_desa"]');

            // === Inisialisasi Select2 ===
            $('.select2').each(function() {
                const $this = $(this);
                const $modalParent = $this.closest('.modal'); // cek apakah select ini ada di modal
                $this.select2({
                    width: '100%',
                    theme: 'classic',
                    dropdownParent: $modalParent.length ? $modalParent : $(document.body)
                });
            });

            // === Load Provinsi ===
            $.getJSON("/provinces", function(response) {
                prov.empty().append('<option value="">-- Pilih Provinsi --</option>');
                if (response?.data) {
                    $.each(response.data, function(i, p) {
                        prov.append(`<option value="${p.kode}">${p.nama}</option>`);
                    });
                }
            });

            // === Event Provinsi ===
            prov.on('change', function() {
                const kodeProv = $(this).val();
                kab.html('<option value="">-- Pilih Kabupaten --</option>');
                kec.html('<option value="">-- Pilih Kecamatan --</option>');
                des.html('<option value="">-- Pilih Desa --</option>');
                namaDesa.val('');

                if (kodeProv) {
                    $.getJSON(`/kabupaten/${kodeProv}`, function(response) {
                        if (response?.data) {
                            $.each(response.data, function(i, k) {
                                kab.append(`<option value="${k.kode}">${k.nama}</option>`);
                            });
                        }
                    });
                }
            });

            // === Event Kabupaten ===
            kab.on('change', function() {
                const kodeKab = $(this).val();
                kec.html('<option value="">-- Pilih Kecamatan --</option>');
                des.html('<option value="">-- Pilih Desa --</option>');
                namaDesa.val('');

                if (kodeKab) {
                    $.getJSON(`/kecamatan/${kodeKab}`, function(response) {
                        if (response?.data) {
                            $.each(response.data, function(i, kc) {
                                kec.append(
                                    `<option value="${kc.kode}">${kc.nama}</option>`);
                            });
                        }
                    });
                }
            });

            // === Event Kecamatan ===
            kec.on('change', function() {
                const kodeKec = $(this).val();
                des.html('<option value="">-- Pilih Desa --</option>');
                namaDesa.val('');

                if (kodeKec) {
                    $.getJSON(`/desa/${kodeKec}`, function(response) {
                        if (response?.data) {
                            $.each(response.data, function(i, d) {
                                des.append(
                                    `<option value="${d.kode}" data-nama="${d.nama}">${d.nama}</option>`
                                );
                            });
                        }
                    });
                }
            });

            // === Event Desa: otomatis isi nama desa ===
            des.on('change', function() {
                const nama = $(this).find(':selected').data('nama') || '';
                namaDesa.val(nama);
            });

            // === Auto pilih id_survey aktif (berdasarkan tanggal hari ini) ===
            $.getJSON('/survey/aktif', function(res) {
                if (res.success && res.data) {
                    $('select[name="id_survey"]').val(res.data.id);
                }
            });

            // === Validasi Dinamis ===
            function toggleRequired(condition, selector) {
                $(selector).prop('required', condition);
                if (condition) $(selector).closest('.mb-3').show();
                else $(selector).closest('.mb-3').hide();
            }

            // No SK Pendirian Desa → Tgl wajib diisi
            $('input[name="no_sk_pendirian_desa"]').on('input', function() {
                const hasValue = $(this).val().trim() !== '';
                toggleRequired(hasValue, 'input[name="tgl_sk_pendirian_desa"]');
            });

            // No SK Peta Desa → Tgl wajib diisi
            $('input[name="no_sk_peta_desa"]').on('input', function() {
                const hasValue = $(this).val().trim() !== '';
                toggleRequired(hasValue, 'input[name="tgl_sk_peta_desa"]');
            });

            // Topografi Lereng/Puncak → wajib isi Jumlah Warga
            $('select[name="topografi"]').on('change', function() {
                const isLereng = $(this).val() === '1';
                toggleRequired(isLereng, 'input[name="jml_warga"]');
            });

            // Jam kerja Ada Jadwal → wajib isi waktu mulai dan akhir
            $('select[name="jam_kerja"]').on('change', function() {
                const adaJadwal = $(this).val() === '2';
                toggleRequired(adaJadwal, 'input[name="mulai_pukul"]');
                toggleRequired(adaJadwal, 'input[name="akhir_pukul"]');
            });

            // === Trigger awal untuk sembunyikan field opsional ===
            toggleRequired(false, 'input[name="tgl_sk_pendirian_desa"]');
            toggleRequired(false, 'input[name="tgl_sk_peta_desa"]');
            toggleRequired(false, 'input[name="jml_warga"]');
            toggleRequired(false, 'input[name="mulai_pukul"]');
            toggleRequired(false, 'input[name="akhir_pukul"]');
        });
    </script>

        {{-- Script untuk menampilkan form --}}
    {{-- <script>
        $(document).on('click', '.btn-open-form', function(e) {
            e.preventDefault();

            let px = $(this).data('px'); // contoh: 'p3'
            let id = $(this).data('id'); // contoh: '01'

            let url = `/desa/${px}/modal/${id}`;

            // Optional: Loading teks sebelum isi dimuat
            $('#modal-body-desa').html('<p class="text-muted">Memuat form...</p>');

            $.get(url, function(response) {
                $('#modal-body-desa').html(response);
                $('#modalFormDesa').modal('show');
            }).fail(function(xhr) {
                $('#modal-body-desa').html('<p class="text-danger">Gagal memuat form.</p>');
                console.error(xhr.responseText);
            });
        });
    </script> --}}
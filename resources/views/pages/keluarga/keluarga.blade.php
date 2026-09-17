@extends('layouts.app')

@section('content')
    <div class="container">


        <!-- Data Keluarga -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Keluarga</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal Survey</th>
                                <th>Nama Kepala Keluarga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        @if ($item->survey)
                                            {{ \Carbon\Carbon::parse($item->survey->tgl_mulai)->format('d M Y') }}
                                            s/d
                                            {{ \Carbon\Carbon::parse($item->survey->tgl_akhir)->format('d M Y') }}
                                        @else
                                            <em>Tidak ada survey aktif</em>
                                        @endif
                                        {{-- kjhshdjkshd --}}
                                    </td>
                                    <td>{{ $item->nama_kpl_keluarga }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <!-- <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditKeluarga{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button> -->

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('kg-p2.destroy', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modaltambahkeluarga" aria-labelledby="modaltambahkeluargaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaltambahkeluargaLabel">Tambah Data Keluarga P2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kg-p2.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Provinsi<span class="text-danger">*</span></label>
                                    <select id="cboprovinsi" class="form-control select2" onchange="ambilKab()"
                                        name="kode_provinsi" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Kabupaten<span class="text-danger">*</span></label>
                                    <select id="cbokabupaten" class="form-control select2" onchange="ambilKec()"
                                        name="kode_kabupaten" required>
                                        <option value="">-- Pilih Kabupaten --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Kecamatan<span class="text-danger">*</span></label>
                                    <select id="cbokecamatan" class="form-control select2" onchange="ambilDesa()"
                                        name="kode_kecamatan" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Desa<span class="text-danger">*</span></label>
                                    <select id="cbodesa" class="form-control select2" name="kode_desa" required>
                                        <option value="">-- Pilih Desa --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>RT</label>
                                    <input type="number" name="rt" class="form-control" placeholder="Contoh: 005"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>RW</label>
                                    <input type="number" name="rw" class="form-control" placeholder="Contoh: 005"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Nama Kepala Keluarga<span class="text-danger">*</span></label>
                                    <input type="text" name="nama_kpl_keluarga" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Nomer Kartu Keluarga<span class="text-danger">*</span></label>
                                    <input type="number" min="0" name="no_kk" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Nomer HP</label>
                                    <input type="number" name="no_hp" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Nomer Telepon Rumah</label>
                                    <input type="number" name="telp_rumah" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" cols="50" rows="7"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Meteran Rumah</label>
                                    <select id="meteran_rumah" class="form-control" name="meteran_rumah">
                                        <option value="" selected disabled>-- Pilih Opsi --</option>
                                        <option value="1">Punya Sendiri</option>
                                        <option value="2">Menumpang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Nomer Meteran Rumah<span class="text-danger">*</span></label>
                                    <input type="number" name="no_meteran" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Daya Meteran Rumah<span class="text-danger">*</span></label>
                                    <select id="daya_meteran_rumah" class="form-control" name="daya_meteran_rumah">
                                        <option value="" selected disabled>-- Pilih Opsi --</option>
                                        <option value="450">450 VA</option>
                                        <option value="900">900</option>
                                        <option value="1.300">1.300 VA</option>
                                        <option value="2.200">2.200 VA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Keluarga</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    @foreach ($data as $item)
        <div class="modal fade" id="modalEditKeluarga{{ $item->id }}"
            aria-labelledby="modalEditKeluarga{{ $item->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKeluarga{{ $item->id }}Label">Tambah Data Keluarga P2
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kg-p2.update', $item->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Provinsi<span class="text-danger">*</span></label>
                                        <select id="cboprovinsi-edit" class="form-control select2" onchange="ambilKab()"
                                            name="kode_provinsi" required>
                                            <option value="">-- Pilih Provinsi --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Kabupaten<span class="text-danger">*</span></label>
                                        <select id="cbokabupaten-edit" class="form-control select2" onchange="ambilKec()"
                                            name="kode_kabupaten" required>
                                            <option value="">-- Pilih Kabupaten --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Kecamatan<span class="text-danger">*</span></label>
                                        <select id="cbokecamatan-edit" class="form-control select2"
                                            onchange="ambilDesa()" name="kode_kecamatan" required>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Desa<span class="text-danger">*</span></label>
                                        <select id="cbodesa-edit" class="form-control select2" name="kode_desa" required>
                                            <option value="">-- Pilih Desa --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>RT</label>
                                        <input type="number" name="rt" class="form-control"
                                            value="{{ $item->rt }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>RW</label>
                                        <input type="number" name="rw" class="form-control"
                                            value="{{ $item->rw }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Nama Kepala Keluarga<span class="text-danger">*</span></label>
                                        <input type="text" name="nama_kpl_keluarga"
                                            value="{{ $item->nama_kpl_keluarga }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Nomer Kartu Keluarga<span class="text-danger">*</span></label>
                                        <input type="number" min="0" name="no_kk" value="{{ $item->no_kk }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Nomer HP</label>
                                        <input type="number" name="no_hp" value="{{ $item->no_hp }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Nomer Telepon Rumah</label>
                                        <input type="number" name="telp_rumah" value="{{ $item->telp_rumah }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label>Alamat</label>
                                        <textarea name="alamat" id="alamat" value="{{ $item->alamat }}" class="form-control" cols="50"
                                            rows="7"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Meteran Rumah</label>
                                        <select id="meteran_rumah" class="form-control" name="meteran_rumah">
                                            <option value="" selected disabled>-- Pilih Opsi --</option>
                                            <option value="1" {{ $item->meteran_rumah == 1 ? 'selected' : '' }}>Punya
                                                Sendiri</option>
                                            <option value="2"{{ $item->meteran_rumah == 2 ? 'selected' : '' }}>
                                                Menumpang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Nomer Meteran Rumah<span class="text-danger">*</span></label>
                                        <input type="number" name="no_meteran" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Daya Meteran Rumah<span class="text-danger">*</span></label>
                                        <select id="daya_meteran_rumah" class="form-control" name="daya_meteran_rumah">
                                            <option value="" selected disabled>-- Pilih Opsi --</option>
                                            <option value="450">450 VA</option>
                                            <option value="900">900</option>
                                            <option value="1.300">1.300 VA</option>
                                            <option value="2.200">2.200 VA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan Keluarga</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    {{-- Script untuk Wilayah --}}
    <script>
        function toggleRequired(condition, selector) {
            $(selector).prop('required', condition);
            if (condition) $(selector).closest('.mb-3').show();
            else $(selector).closest('.mb-3').hide();
        }

        $(document).ready(function() {
            $(".select2").select2({
                width: '100%',
                dropdownParent: $('#modaltambahkeluarga')
            });
            // Trigger ketika select berubah
            $('select[name="meteran_rumah"]').on('change', function() {
                const hasValue = $(this).val() === '1';

                toggleRequired(hasValue, 'input[name="no_meteran"]');
                toggleRequired(hasValue, 'select[name="daya_meteran_rumah"]');
            });

            // Kondisi awal: hidden
            toggleRequired(false, 'input[name="no_meteran"]');
            toggleRequired(false, 'select[name="daya_meteran_rumah"]');
        });
    </script>

    {{-- Script untuk Wilayah --}}
    <script>
        function ambilProvinsi() {
            $.ajax({
                url: "{{ URL::to('provinces') }}",
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cboprovinsi").html(`<option value="">-- Pilih Salah Satu --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }

        function ambilKab() {
            let kodeProv = $("#cboprovinsi").val();
            if (kodeProv == "") {
                $("#cbokabupaten").html(`<option value="">-- Pilih Salah Satu --</option>`);
                return;
            }
            $.ajax({
                url: `{{ URL::to('kabupaten') }}/${kodeProv}`,
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cbokabupaten").html(`<option value="">-- Pilih Kabupaten --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }

        function ambilKec() {
            let kodeKab = $("#cbokabupaten").val();
            if (kodeKab == "") {
                $("#cbokabupaten").html(`<option value="">-- Pilih Salah Satu --</option>`);
                return;
            }
            $.ajax({
                url: `{{ URL::to('kecamatan') }}/${kodeKab}`,
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cbokecamatan").html(`<option value="">-- Pilih Kecamatan --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }

        function ambilDesa() {
            let kodeKec = $("#cbokecamatan").val();
            if (kodeKec == "") {
                $("#cbokecamatan").html(`<option value="">-- Pilih Salah Satu --</option>`);
                return;
            }
            $.ajax({
                url: `{{ URL::to('desa') }}/${kodeKec}`,
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cbodesa").html(`<option value="">-- Pilih Desa --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }
    </script>
@endpush

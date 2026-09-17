@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P3 - Data Pemerintahan Desa </h5>
        <form action="{{ route('desa-p3.store') }}" method="POST" class="mb-5">
            @csrf
            <div class="mb-3">
                <!-- Kepala Desa -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kepala Desa</label><input type="text" name="nik_kades"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kepala Desa</label><input type="text" name="nama_kades"
                                class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>HP Kepala Desa</label><input type="text" name="hp_kades"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kepala Desa</label><input type="date"
                                name="awal_jabatan_kades" class="form-control"></div>
                    </div>
                </div>
                <!-- Sekretaris Desa -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Sekdes</label><input type="text" name="nik_sekdes"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Sekdes</label><input type="text" name="nama_sekdes"
                                class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Sekdes</label><input type="text" name="hp_sekdes"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Sekdes</label><input type="date"
                                name="awal_jabatan_sekdes" class="form-control"></div>
                    </div>
                </div>
                <!-- Bendahara Desa -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Bendahara Desa</label><input type="text" name="nik_bendes"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Bendahara Desa</label><input type="text" name="nama_bendes"
                                class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Bendahara Desa</label><input type="text" name="hp_bendes"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Bendahara Desa</label><input type="date"
                                name="awal_jabatan_bendes" class="form-control"></div>
                    </div>
                </div>
                <!-- Kepala Urusan Tata Usaha -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kepala Tata Usaha</label><input type="text" name="nik_kpl_tu"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kepala Tata Usaha</label><input type="text" name="nama_kpl_tu"
                                class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Kepala Tata Usaha</label><input type="text" name="hp_kpl_tu"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kepala Tata Usaha</label><input type="date"
                                name="awal_jabatan_kpl_tu" class="form-control"></div>
                    </div>
                </div>
                <!-- Kepala Urusan Keuangan -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kep.Urusan Keuangan</label><input type="text"
                                name="nik_kpl_uang" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kep.Urusan Keuangan</label><input type="text"
                                name="nama_kpl_uang" class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Kep.Urusan Keuangan</label><input type="text"
                                name="hp_kpl_uang" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kep. Keuangan</label><input type="date"
                                name="awal_jabatan_kpl_uang" class="form-control"></div>
                    </div>
                </div>
                <!-- Kepala Urusan Perencanaan -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kep. Perencanaan</label><input type="text"
                                name="nik_kpl_rencana" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kep. Perencanaan</label><input type="text"
                                name="nama_kpl_rencana" class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Kep. Perencanaan</label><input type="text"
                                name="hp_kpl_rencana" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kep. Perencanaan</label><input type="date"
                                name="awal_jabatan_kpl_rencana" class="form-control"></div>
                    </div>
                </div>
                <!-- Kepala Seksi Pemerintahan -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kep.Sek.Pemerintahan</label><input type="text"
                                name="nik_kepsek_pemerintahan" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kep.Sek.Pemerintahan</label><input type="text"
                                name="nama_kepsek_pemerintahan" class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Kep.Sek.Pemerintahan</label><input type="text"
                                name="hp_kepsek_pemerintahan" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kep.Pemerintahan</label><input type="date"
                                name="awal_jabatan_kepsek_pemerintahan" class="form-control"></div>
                    </div>
                </div>
                <!-- Kepala Seksi Kesejahteraan -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kep.Sek.Kesejahteraan</label><input type="text"
                                name="nik_kepsek_kesejahteraan" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kep.Sek.Kesejahteraan</label><input type="text"
                                name="nama_kepsek_kesejahteraan" class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Kep.Sek.Kesejahteraan</label><input type="text"
                                name="hp_kepsek_kesejahteraan" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kep.Kesejahteraan</label><input type="date"
                                name="awal_jabatan_kepsek_kesejahteraan" class="form-control"></div>
                    </div>
                </div>
                <!-- Kepala Seksi Pelayanan -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kepala Seksi Pelayanan</label><input type="text"
                                name="nik_kepsek_pelayanan" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kepala Seksi Pelayanan</label><input type="text"
                                name="nama_kepsek_pelayanan" class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Kepala Pelayanan</label><input type="text"
                                name="hp_kepsek_pelayanan" class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kepala Seksi Pelayanan</label><input type="date"
                                name="awal_jabatan_kepsek_pelayanan" class="form-control"></div>
                    </div>
                </div>
                <!-- Kepala BPD -->
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3"><label>NIK Kepala BPD</label><input type="text" name="nik_kpl_bpd"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nama Kepala BPD</label><input type="text" name="nama_kpl_bpd"
                                class="form-control" maxlength="100"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Nomer HP Kepala BPD</label><input type="text" name="hp_kpl_bpd"
                                class="form-control" maxlength="20"></div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3"><label>Awal Jabatan Kepala BPD</label><input type="date"
                                name="awal_jabatan_kpl_bpd" class="form-control"></div>
                    </div>
                </div>

                {{-- ====== Tombol Aksi ====== --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/desa') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Data
                    </button>
                </div>
        </form>

        <div class="card shadow mb-4 mt-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pemerintahan Desa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable">
                        <thead>
                            <tr>
                                <th style="width: 90%">Data</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Kepala desa</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_kades }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Sekretaris desa</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_sekdes }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Bendahara desa</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_bendes }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Kepala Tata Usaha</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_kpl_tu }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Kepala Keuangan</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_kpl_uang }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Kepala Perencanaan</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_kpl_rencana }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Seksi Pemerintahan</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_kepsek_pemerintahan }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Seksi Kesejahteraan</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_kepsek_kesejahteraan }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div
                                                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Kepala BPD</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    {{ $item->nama_kepsek_pelayanan }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="text-align: center;">
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-user mb-3"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p3.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus Data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit Data --}}
                                <div class="modal fade" id="modalEditData{{ $item->id }}"
                                    aria-labelledby="modalEditDataLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditDataLabel{{ $item->id }}">Edit
                                                    Data P4</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p3.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')

                                                    <!-- Kepala Desa -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Kepala Desa</label>
                                                                <input type="text" name="nik_kades"
                                                                    value="{{ $item->nik_kades }}" class="form-control"
                                                                    maxlength="20">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Kepala Desa</label><input
                                                                    type="text" name="nama_kades"
                                                                    value="{{ $item->nama_kades }}" class="form-control"
                                                                    maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>HP Kepala Desa</label><input
                                                                    type="text" name="hp_kades"
                                                                    value="{{ $item->hp_kades }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Kepala
                                                                    Desa</label><input type="date"
                                                                    name="awal_jabatan_kades"
                                                                    value="{{ $item->awal_jabatan_kades }}"
                                                                    class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Sekretaris Desa -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Sekdes</label><input
                                                                    type="text" name="nik_sekdes"
                                                                    value="{{ $item->nik_sekdes }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Sekdes</label><input
                                                                    type="text" name="nama_sekdes"
                                                                    value="{{ $item->nama_sekdes }}" class="form-control"
                                                                    maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP Sekdes</label><input
                                                                    type="text" name="hp_sekdes"
                                                                    value="{{ $item->hp_sekdes }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Sekdes</label><input
                                                                    type="date" name="awal_jabatan_sekdes"
                                                                    value="{{ $item->awal_jabatan_sekdes }}"
                                                                    class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Bendahara Desa -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Bendahara Desa</label><input
                                                                    type="text" name="nik_bendes"
                                                                    value="{{ $item->nik_bendes }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Bendahara Desa</label><input
                                                                    type="text" name="nama_bendes"
                                                                    value="{{ $item->nama_bendes }}" class="form-control"
                                                                    maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP Bendahara
                                                                    Desa</label><input type="text" name="hp_bendes"
                                                                    value="{{ $item->hp_bendes }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Bendahara
                                                                    Desa</label><input type="date"
                                                                    name="awal_jabatan_bendes"
                                                                    value="{{ $item->awal_jabatan_bendes }}"
                                                                    class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Kepala Urusan Tata Usaha -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Kepala Tata Usaha</label><input
                                                                    type="text" name="nik_kpl_tu"
                                                                    value="{{ $item->nik_kpl_tu }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Kepala Tata Usaha</label><input
                                                                    type="text" name="nama_kpl_tu"
                                                                    value="{{ $item->nama_kpl_tu }}" class="form-control"
                                                                    maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP Kepala Tata
                                                                    Usaha</label><input type="text" name="hp_kpl_tu"
                                                                    value="{{ $item->hp_kpl_tu }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Kepala Tata
                                                                    Usaha</label><input type="date"
                                                                    name="awal_jabatan_kpl_tu"
                                                                    value="{{ $item->awal_jabatan_kpl_tu }}"
                                                                    class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Kepala Urusan Keuangan -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Kep.Urusan
                                                                    Keuangan</label><input type="text"
                                                                    name="nik_kpl_uang" value="{{ $item->nik_kpl_uang }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Kep.Urusan
                                                                    Keuangan</label><input type="text"
                                                                    name="nama_kpl_uang"
                                                                    value="{{ $item->nama_kpl_uang }}"
                                                                    class="form-control" maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP Kep.Urusan
                                                                    Keuangan</label><input type="text"
                                                                    name="hp_kpl_uang" value="{{ $item->hp_kpl_uang }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Kep.
                                                                    Keuangan</label><input type="date"
                                                                    name="awal_jabatan_kpl_uang"
                                                                    value="{{ $item->awal_jabatan_kpl_uang }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Kepala Urusan Perencanaan -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Kep. Perencanaan</label><input
                                                                    type="text" name="nik_kpl_rencana"
                                                                    value="{{ $item->nik_kpl_rencana }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Kep. Perencanaan</label><input
                                                                    type="text" name="nama_kpl_rencana"
                                                                    value="{{ $item->nama_kpl_rencana }}"
                                                                    class="form-control" maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP Kep.
                                                                    Perencanaan</label><input type="text"
                                                                    name="hp_kpl_rencana"
                                                                    value="{{ $item->hp_kpl_rencana }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Kep.
                                                                    Perencanaan</label><input type="date"
                                                                    name="awal_jabatan_kpl_rencana"
                                                                    value="{{ $item->awal_jabatan_kpl_rencana }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Kepala Seksi Pemerintahan -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK
                                                                    Kep.Sek.Pemerintahan</label><input type="text"
                                                                    name="nik_kepsek_pemerintahan"
                                                                    value="{{ $item->nik_kepsek_pemerintahan }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama
                                                                    Kep.Sek.Pemerintahan</label><input type="text"
                                                                    name="nama_kepsek_pemerintahan"
                                                                    value="{{ $item->nama_kepsek_pemerintahan }}"
                                                                    class="form-control" maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP
                                                                    Kep.Sek.Pemerintahan</label><input type="text"
                                                                    name="hp_kepsek_pemerintahan"
                                                                    value="{{ $item->hp_kepsek_pemerintahan }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan
                                                                    Kep.Pemerintahan</label><input type="date"
                                                                    name="awal_jabatan_kepsek_pemerintahan"
                                                                    value="{{ $item->awal_jabatan_kepsek_pemerintahan }}"
                                                                    class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Kepala Seksi Kesejahteraan -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK
                                                                    Kep.Sek.Kesejahteraan</label><input type="text"
                                                                    name="nik_kepsek_kesejahteraan"
                                                                    value="{{ $item->nik_kepsek_kesejahteraan }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama
                                                                    Kep.Sek.Kesejahteraan</label><input type="text"
                                                                    name="nama_kepsek_kesejahteraan"
                                                                    value="{{ $item->nama_kepsek_kesejahteraan }}"
                                                                    class="form-control" maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP
                                                                    Kep.Sek.Kesejahteraan</label><input type="text"
                                                                    name="hp_kepsek_kesejahteraan"
                                                                    value="{{ $item->hp_kepsek_kesejahteraan }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan
                                                                    Kep.Kesejahteraan</label><input type="date"
                                                                    name="awal_jabatan_kepsek_kesejahteraan"
                                                                    value="{{ $item->awal_jabatan_kepsek_kesejahteraan }}"
                                                                    class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Kepala Seksi Pelayanan -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Kepala Seksi
                                                                    Pelayanan</label><input type="text"
                                                                    name="nik_kepsek_pelayanan"
                                                                    value="{{ $item->nik_kepsek_pelayanan }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Kepala Seksi
                                                                    Pelayanan</label><input type="text"
                                                                    name="nama_kepsek_pelayanan"
                                                                    value="{{ $item->nama_kepsek_pelayanan }}"
                                                                    class="form-control" maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP Kepala
                                                                    Pelayanan</label><input type="text"
                                                                    name="hp_kepsek_pelayanan"
                                                                    value="{{ $item->hp_kepsek_pelayanan }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Kepala
                                                                    BPD</label><input type="date"
                                                                    name="awal_jabatan_kepsek_pelayanan"
                                                                    value="{{ $item->awal_jabatan_kepsek_pelayanan }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Kepala BPD -->
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>NIK Kepala BPD</label><input
                                                                    type="text" name="nik_kpl_bpd" value="{{ $item->nik_kpl_bpd }}"
                                                                    class="form-control" maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nama Kepala BPD</label><input
                                                                    type="text" name="nama_kpl_bpd" value="{{ $item->nama_kpl_bpd }}"
                                                                    class="form-control" maxlength="100"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Nomer HP Kepala BPD</label><input
                                                                    type="text" name="hp_kpl_bpd" value="{{ $item->hp_kpl_bpd }}" class="form-control"
                                                                    maxlength="20"></div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3"><label>Awal Jabatan Kepala
                                                                    BPD</label><input type="date"
                                                                    name="awal_jabatan_kpl_bpd" value="{{ $item->awal_jabatan_kpl_bpd }}" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- @empty
                                <tr>
                                    <td colspan="6">Belum ada Data Pemerintahan Desa.</td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush

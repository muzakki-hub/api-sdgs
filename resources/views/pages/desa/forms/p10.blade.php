@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P10 - Transportasi Desa</h5>


        <form action="{{ route('desa-p10.store') }}" method="POST" class="mb-5">
            @csrf
            <div class="form-group">
                <label for="sarana_yg_digunakan">Sarana Transportasi yang Digunakan Menuju Kantor Desa Ke</label>
                <select name="sarana_yg_digunakan" class="form-control" required>
                    <option value="">- Pilih -</option>
                    <option value="kantor camat">kantor camat</option>
                    <option value="kantor bupati">kantor bupati</option>
                    <option value="kantor camat lain terdekat">kantor camat lain terdekat</option>
                    <option value="kantor bupati lain terdekat">kantor bupati lain terdekat</option>
                </select>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="sarana_transportasi">Jenis Sarana Transportasi</label>
                    <select name="sarana_transportasi" class="form-control" required>
                        <option value="">- Pilih -</option>
                        <option value="1">Angkutan umum</option>
                        <option value="2">Kendaraan pribadi</option>
                        <option value="3">Sepeda, becak, bentor, delman</option>
                        <option value="4">Jalan kaki, lainnya</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label for="angkutan_umum">Jenis Angkutan Umum (jika dipilih)</label>
                    <select name="angkutan_umum" class="form-control" required>
                        <option value="">- Pilih -</option>
                        <option value="1">Angkot</option>
                        <option value="2">Bus</option>
                        <option value="3">Ojek</option>
                        <option value="4">Lainnya</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label for="angkutan_umum_utama">Nama Angkutan Umum Utama</label>
                    <select name="angkutan_umum_utama" class="form-control" required>
                        <option value="">- Pilih -</option>
                        <option value="1">Angkot</option>
                        <option value="2">Bus</option>
                        <option value="3">Ojek</option>
                        <option value="4">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="jarak_tempuh">Jarak Tempuh (km)</label>
                    <input type="number" step="0.01" name="jarak_tempuh" class="form-control" required>
                </div>

                <div class="col-sm">
                    <label for="waktu_tempuh">Waktu Tempuh (menit)</label>
                    <input type="number" name="waktu_tempuh" class="form-control" required>
                </div>

                <div class="col-sm">
                    <label for="biaya">Biaya Transportasi (Rp)</label>
                    <input type="number" step="1000" name="biaya" class="form-control" required>
                </div>
            </div>
            {{-- ====== Tombol Aksi ====== --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/desa') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data P10 Transportasi Desa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sarana Yang Digunakan</th>
                                <th>Jarak Tempuh</th>
                                <th>Waktu Tempuh</th>
                                <th>Biaya</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->sarana_yg_digunakan }}</td>
                                    <td>{{ $item->jarak_tempuh }} KM</td>
                                    <td>{{ $item->waktu_tempuh }} Menit</td>
                                    <td>Rp.{{ number_format($item->biaya, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p10.destroy', $item->id) }}" method="POST"
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
                                                    Data P941</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p10.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="sarana_yg_digunakan">Sarana Transportasi yang
                                                                    Digunakan Menuju Kantor Desa Ke</label>
                                                                <select name="sarana_yg_digunakan" class="form-control"
                                                                    required>
                                                                    <option
                                                                        value="kantor camat"{{ $item->sarana_yg_digunakan == 'kantor camat' ? 'selected' : '' }}>
                                                                        kantor camat</option>
                                                                    <option
                                                                        value="kantor bupati"{{ $item->sarana_yg_digunakan == 'kantor bupati' ? 'selected' : '' }}>
                                                                        kantor bupati</option>
                                                                    <option
                                                                        value="kantor camat lain terdekat"{{ $item->sarana_yg_digunakan == 'kantor camat lain terdekat' ? 'selected' : '' }}>
                                                                        kantor camat
                                                                        lain terdekat</option>
                                                                    <option value="kantor bupati lain terdekat"
                                                                        {{ $item->sarana_yg_digunakan == 'kantor bupati lain terdekat' ? 'selected' : '' }}>
                                                                        kantor
                                                                        bupati lain terdekat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="sarana_transportasi">Jenis Sarana
                                                                Transportasi</label>
                                                            <select name="sarana_transportasi" class="form-control"
                                                                required>
                                                                <option
                                                                    value="1"{{ $item->sarana_transportasi == '1' ? 'selected' : '' }}>
                                                                    Angkutan umum</option>
                                                                <option
                                                                    value="2"{{ $item->sarana_transportasi == '2' ? 'selected' : '' }}>
                                                                    Kendaraan pribadi</option>
                                                                <option
                                                                    value="3"{{ $item->sarana_transportasi == '3' ? 'selected' : '' }}>
                                                                    Sepeda, becak, bentor, delman
                                                                </option>
                                                                <option
                                                                    value="4"{{ $item->sarana_transportasi == '4' ? 'selected' : '' }}>
                                                                    Jalan kaki, lainnya</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="angkutan_umum">Jenis Angkutan Umum (jika
                                                                dipilih)</label>
                                                            <select name="angkutan_umum" class="form-control" required>
                                                                <option
                                                                    value="1"{{ $item->angkutan_umum == '1' ? 'selected' : '' }}>
                                                                    Angkot</option>
                                                                <option
                                                                    value="2"{{ $item->angkutan_umum == '2' ? 'selected' : '' }}>
                                                                    Bus</option>
                                                                <option
                                                                    value="3"{{ $item->angkutan_umum == '3' ? 'selected' : '' }}>
                                                                    Ojek</option>
                                                                <option
                                                                    value="4"{{ $item->angkutan_umum == '4' ? 'selected' : '' }}>
                                                                    Lainnya</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="angkutan_umum_utama">Nama Angkutan Umum
                                                                Utama</label>
                                                            <select name="angkutan_umum_utama" class="form-control"
                                                                required>
                                                                <option
                                                                    value="1"{{ $item->angkutan_umum_utama == '1' ? 'selected' : '' }}>
                                                                    Angkot</option>
                                                                <option
                                                                    value="2"{{ $item->angkutan_umum_utama == '2' ? 'selected' : '' }}>
                                                                    Bus</option>
                                                                <option
                                                                    value="3"{{ $item->angkutan_umum_utama == '3' ? 'selected' : '' }}>
                                                                    Ojek</option>
                                                                <option
                                                                    value="4"{{ $item->angkutan_umum_utama == '4' ? 'selected' : '' }}>
                                                                    Lainnya</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="jarak_tempuh">Jarak Tempuh (km)</label>
                                                            <input type="number" step="0.01" name="jarak_tempuh"
                                                                value="{{ $item->jarak_tempuh }}" class="form-control"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label for="waktu_tempuh">Waktu Tempuh (menit)</label>
                                                            <input type="number" name="waktu_tempuh"
                                                                value="{{ $item->waktu_tempuh }}" class="form-control"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label for="biaya">Biaya Transportasi (Rp)</label>
                                                            <input type="number" step="1000" name="biaya"
                                                                value="{{ $item->biaya }}" class="form-control"
                                                                required>
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
                                    <td colspan="5">Belum ada Data Transportasi Desa.</td>
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

@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P3 - Pegawai Desa Lainnya </h5>
        <form action="{{ route('desa-p3Pegawai.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_desa_p3" value="{{ $p3->id ?? '' }}">
            <div id="pegawai-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Pegawai ke-</label>
                            <input type="number" name="pegawai_ke" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>NIK Pegawai</label>
                            <input type="text" name="nik_pegawai_desa" class="form-control" maxlength="20" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Nama Pegawai</label>
                            <input type="text" name="nama_pegawai_desa" class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>No HP Pegawai</label>
                            <input type="text" name="hp_pegawai_desa" class="form-control" maxlength="20" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Awal Jabatan</label>
                            <input type="date" name="awal_jabatan_pegawai_desa" class="form-control" required>
                        </div>
                    </div>
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
                <h6 class="m-0 font-weight-bold text-primary">Data Pegawai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Pegawai Ke</th>
                                <th>NIK Pegawai</th>
                                <th>Nama Pegawai</th>
                                <th>Nomer Hp Pegawai</th>
                                {{-- <th>Awal Jabatan Pegawai Desa</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($data as $p)
                                <tr>
                                    <td>{{ $p->pegawai_ke }}</td>
                                    <td>{{ $p->nik_pegawai_desa }}</td>
                                    <td>{{ $p->nama_pegawai_desa }}</td>
                                    <td>{{ $p->hp_pegawai_desa }}</td>
                                    {{-- <td>{{$p->awal_jabatan_pegawai_desa}}</td> --}}
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditData{{ $p->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p3Pegawai.destroy', $p->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus Data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit Data --}}
                                <div class="modal fade" id="modalEditData{{ $p->id }}"
                                    aria-labelledby="modalEditDataLabel{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditDataLabel{{ $p->id }}">Edit
                                                    Data P4</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p3Pegawai.update', $p->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')

                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>Pegawai ke-</label>
                                                                <input type="number" name="pegawai_ke"
                                                                    value="{{ $p->pegawai_ke }}" class="form-control"
                                                                    required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>NIK Pegawai</label>
                                                                <input type="text" name="nik_pegawai_desa"
                                                                    value="{{ $p->nik_pegawai_desa }}" class="form-control"
                                                                    maxlength="20" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>Nama Pegawai</label>
                                                                <input type="text" name="nama_pegawai_desa"
                                                                    value="{{ $p->nama_pegawai_desa }}"
                                                                    class="form-control" maxlength="100" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>No HP Pegawai</label>
                                                                <input type="text" name="hp_pegawai_desa"
                                                                    value="{{ $p->hp_pegawai_desa }}"
                                                                    class="form-control" maxlength="20" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>Awal Jabatan</label>
                                                                <input type="date" name="awal_jabatan_pegawai_desa"
                                                                    value="{{ $p->awal_jabatan_pegawai_desa }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
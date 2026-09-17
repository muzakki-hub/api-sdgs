@extends('layouts.app')

@section('content')
    <div class="container">

        <h5 class="mb-3">Form P932 - Direksi </h5>
        <form action="{{ route('desa-p932.store') }}" method="POST" class="mb-5">
            @csrf
            <input type="hidden" name="id_desa_p9" value="{{ $p9->id }}">
            <div id="direksi-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>direksi ke-</label>
                            <input type="number" name="direksi_ke" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Nama direksi Desa</label>
                            <input type="text" name="nama_direksi" class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>NIK direksi Desa</label>
                            <input type="text" name="nik_direksi" class="form-control" maxlength="20" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>HP direksi Desa</label>
                            <input type="text" name="hp_direksi" class="form-control" maxlength="20" required>
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


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengawas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable">
                        <thead>
                            <tr>
                                <th>direksi Ke</th>
                                <th>Nama direksi</th>
                                <th>NIK direksi</th>
                                <th>Nomer Hp direksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->direksi_ke }}</td>
                                    <td>{{ $item->nama_direksi }}</td>
                                    <td>{{ $item->nik_direksi }}</td>
                                    <td>{{ $item->hp_direksi }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p932.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus Direksi ini?')">
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
                                                    Data P932</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p932.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>direksi ke-</label>
                                                                <input type="number" name="direksi_ke"
                                                                    value="{{ $item->direksi_ke }}" class="form-control"
                                                                    required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>Nama direksi Desa</label>
                                                                <input type="text" name="nama_direksi"
                                                                    value="{{ $item->nama_direksi }}" class="form-control"
                                                                    maxlength="100" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>NIK direksi Desa</label>
                                                                <input type="text" name="nik_direksi"
                                                                    value="{{ $item->nik_direksi }}" class="form-control"
                                                                    maxlength="20" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>HP direksi Desa</label>
                                                                <input type="text" name="hp_direksi"
                                                                    value="{{ $item->hp_direksi }}" class="form-control"
                                                                    maxlength="20" required>
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
                                    <td colspan="5">Belum ada Data Direksi.</td>
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

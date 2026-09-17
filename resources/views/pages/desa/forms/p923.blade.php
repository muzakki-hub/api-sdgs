@extends('layouts.app')

@section('content')
    <div class="container">

        <h5 class="mb-3">Form P923 - Pengawas </h5>
        <form action="{{ route('desa-p923.store') }}" method="POST" class="mb-5">
            @csrf
            <input type="hidden" name="id_desa_p9" value="{{ $p9->id }}">
            <div id="pengawas-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Pengawas Ke-</label>
                            <input type="number" name="pengawas_ke" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Nama Pengawas Desa</label>
                            <input type="text" name="nama_pengawas" class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>NIK Pengawas Desa</label>
                            <input type="text" name="nik_pengawas" class="form-control" maxlength="20" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>HP Pengawas Desa</label>
                            <input type="text" name="hp_pengawas" class="form-control" maxlength="20" required>
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
                                <th>pengawas Ke</th>
                                <th>Nama pengawas</th>
                                <th>NIK pengawas</th>
                                <th>Nomer Hp pengawas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->pengawas_ke }}</td>
                                    <td>{{ $item->nama_pengawas }}</td>
                                    <td>{{ $item->nik_pengawas }}</td>
                                    <td>{{ $item->hp_pengawas }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p923.destroy', $item->id) }} " method="POST"
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
                                                    Data P923</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p923.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>Pengawas Ke-</label>
                                                                <input type="number" name="pengawas_ke"
                                                                    value="{{ $item->pengawas_ke }}" class="form-control"
                                                                    required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>Nama Pengawas Desa</label>
                                                                <input type="text" name="nama_pengawas"
                                                                    value="{{ $item->nama_pengawas }}" class="form-control"
                                                                    maxlength="100" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>NIK Pengawas Desa</label>
                                                                <input type="text" name="nik_pengawas"
                                                                    value="{{ $item->nik_pengawas }}" class="form-control"
                                                                    maxlength="20" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="mb-3">
                                                                <label>HP Pengawas Desa</label>
                                                                <input type="text" name="hp_pengawas"
                                                                    value="{{ $item->hp_pengawas }}" class="form-control"
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
                                    <td colspan="5">Belum ada Data Pengawas.</td>
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

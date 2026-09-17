@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Tombol Tambah Survey --}}
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahSurvey">
            + Tambah Survey
        </button>

        {{-- Tabel Survey --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Survey</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($survey as $j)
                                <tr>
                                    <td>{{ $j->id }}</td>
                                    <td>{{ $j->tgl_mulai }}</td>
                                    <td>{{ $j->tgl_akhir }}</td>
                                    <td>{{ $j->deskripsi }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-survey"
                                            data-id="{{ $j->id }}" data-tgl_mulai="{{ $j->tgl_mulai }}"
                                            data-tgl_akhir="{{ $j->tgl_akhir }}" data-deskripsi="{{ $j->deskripsi }}"
                                            data-toggle="modal" data-target="#modalEditSurvey{{ $j->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('survey.destroy', $j->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus Survey ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
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

    {{-- Modal Tambah Survey --}}
    <div class="modal fade" id="modalTambahSurvey" tabindex="-1" aria-labelledby="modalTambahSurveyLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSurveyLabel">Tambah Survey</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('survey.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <input type="text" name="deskripsi" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Survey</button>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-2">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Survey --}}
    @foreach ($survey as $j)
        <div class="modal fade" id="modalEditSurvey{{ $j->id }}" tabindex="-1"
            aria-labelledby="modalEditSurveyLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditSurveyLabel">Edit Survey</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditSurvey" method="POST" action="{{ route('survey.update', $j->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label>Tanggal Mulai</label>
                                <input type="date" value="{{ $j->tgl_mulai }}" name="tgl_mulai" id="edit_tgl_mulai"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Akhir</label>
                                <input type="date" value="{{ $j->tgl_akhir }}" name="tgl_akhir" id="edit_tgl_akhir"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <input type="text" value="{{ $j->deskripsi }}" name="deskripsi" id="edit_deskripsi"
                                    class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
@push('scripts')
@endpush

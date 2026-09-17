@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- Tombol Tambah Data --}}
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahFaskes">
            + Tambah Fasilitas Kesehatan
        </button>

        {{-- Tabel Data --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Fasilitas Kesehatan untuk pendataan Keluarga</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Fasilitas Kesehatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faskes as $j)
                                <tr>
                                    <td>{{ $j->id }}</td>
                                    <td>{{ $j->jenjang_kesehatan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditFaskes{{ $j->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('faskes.destroy', $j->id) }}" method="POST"
                                            {{--  --}} class="d-inline"
                                            onsubmit="return confirm('Hapus Data ini?')">
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

    {{-- Modal Tambah  --}}
    <div class="modal fade" id="modalTambahFaskes" tabindex="-1" aria-labelledby="modalTambahFaskesLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahFaskesLabel">Tambah Fasilitas Kesehatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('faskes.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>ID Fasilitas Kesehatan</label>
                            <input type="text" name="id" readonly class="form-control"
                                placeholder="ID akan terisi OTOMATIS">
                        </div>
                        <div class="mb-3">
                            <label>Nama Fasilitas Kesehatan</label>
                            <input type="text" name="jenjang_kesehatan" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Data</button>

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

    {{-- Modal Edit  --}}
    @foreach ($faskes as $j)
        <div class="modal fade" id="modalEditFaskes{{ $j->id }}" tabindex="-1"
            aria-labelledby="modalEditFaskesLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditFaskesLabel">Edit Fasilitas Kesehatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form id="formEditFaskes" action="{{ route('faskes.update', $j->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>ID Fasilitas Kesehatan</label>
                                    <input type="text" value="{{ $j->id }}" name="id" id="edit_id"
                                        class="form-control" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Fasilitas Kesehatan</label>
                                    <input type="text" value="{{ $j->jenjang_kesehatan }}" name="jenjang_kesehatan"
                                        class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

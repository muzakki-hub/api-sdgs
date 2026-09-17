@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- Tombol Tambah Data --}}
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahPenyakit">
            + Tambah Penyakit
        </button>

        {{-- Tabel Data --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Penyakit untuk pendataan Individu</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Penyakit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataP as $j)
                                <tr>
                                    <td>{{ $j->id }}</td>
                                    <td>{{ $j->jenis_penyakit }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditPenyakit{{ $j->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('penyakit.destroy', $j->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus Data ini?')">
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
    <div class="modal fade" id="modalTambahPenyakit" tabindex="-1" aria-labelledby="modalTambahPenyakitLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPenyakitLabel">Tambah Penyakit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penyakit.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>ID Penyakit</label>
                            <input type="text" name="id" readonly class="form-control"
                                placeholder="ID akan terisi OTOMATIS">
                        </div>
                        <div class="mb-3">
                            <label>Nama Penyakit</label>
                            <input type="text" name="jenis_penyakit" class="form-control" required>
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
    @foreach ($dataP as $j)
        <div class="modal fade" id="modalEditPenyakit{{ $j->id }}" tabindex="-1"
            aria-labelledby="modalEditPenyakitLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPenyakitLabel">Edit Penyakit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form id="formEditPenyakit" action="{{ route('penyakit.update', $j->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>ID Penyakit</label>
                                    <input type="text" value="{{ $j->id }}" name="id" id="edit_id"
                                        class="form-control" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Penyakit</label>
                                    <input type="text" value="{{ $j->jenis_penyakit }}" name="jenis_penyakit"
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

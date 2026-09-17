@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- Tombol Tambah Data --}}
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahApst">
            + Tambah Akses Sarpras
        </button>

        {{-- Tabel Data --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Akses Sarpras untuk pendataan Keluarga</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Akses Sarpras</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apst as $j)
                                <tr>
                                    <td>{{ $j->id }}</td>
                                    <td>{{ $j->nama_akses }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"
                                            data-toggle="modal" data-target="#modalEditApst{{ $j->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('apst.destroy', $j->id) }}" method="POST"
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
    <div class="modal fade" id="modalTambahApst" tabindex="-1" aria-labelledby="modalTambahApstLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahApstLabel">Tambah Akses Sarpras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('apst.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>ID Akses Sarpras</label>
                            <input type="text" name="id" readonly class="form-control" placeholder="ID akan terisi OTOMATIS">
                        </div>
                        <div class="mb-3">
                            <label>Nama Akses Sarpras</label>
                            <input type="text" name="nama_akses" class="form-control" required>
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
    @foreach ($apst as $j)
        <div class="modal fade" id="modalEditApst{{ $j->id }}" tabindex="-1"
            aria-labelledby="modalEditApstLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditApstLabel">Edit Akses Sarpras</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form id="formEditApst" action="{{ route('apst.update', $j->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>ID Akses Sarpras</label>
                                    <input type="text" value="{{ $j->id }}" name="id" id="edit_id"
                                        class="form-control" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Akses Sarpras</label>
                                    <input type="text" value="{{ $j->nama_akses }}" name="nama_akses"
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

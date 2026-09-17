@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- Tombol Tambah Lembaga --}}
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahLembaga">
            + Tambah Lembaga
        </button>

        {{-- Tabel Lembaga --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Lembaga untuk pendataan Desa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Lembaga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lembaga as $j)
                                <tr>
                                    <td>{{ $j->id_lembaga }}</td>
                                    <td>{{ $j->nama_lembaga }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-Lembaga"
                                            data-id="{{ $j->id }}" data-nama_Lembaga="{{ $j->nama_lembaga }}"
                                            data-toggle="modal" data-target="#modalEditLembaga{{ $j->id_lembaga }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('lembaga.destroy', $j->id_lembaga) }}" method="POST"
                                            {{--  --}} class="d-inline"
                                            onsubmit="return confirm('Hapus Lembaga ini?')">
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

    {{-- Modal Tambah Lembaga --}}
    <div class="modal fade" id="modalTambahLembaga" tabindex="-1" aria-labelledby="modalTambahLembagaLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLembagaLabel">Tambah Lembaga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lembaga.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>ID Lembaga</label>
                            <input type="text" name="id_lembaga" readonly class="form-control" placeholder="ID akan terisi OTOMATIS">
                        </div>
                        <div class="mb-3">
                            <label>Nama Lembaga</label>
                            <input type="text" name="nama_lembaga" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Lembaga</button>

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

    {{-- Modal Edit Lembaga --}}
    @foreach ($lembaga as $j)
        <div class="modal fade" id="modalEditLembaga{{ $j->id_lembaga }}" tabindex="-1"
            aria-labelledby="modalEditLembagaLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLembagaLabel">Edit Lembaga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form id="formEditLembaga" action="{{ route('lembaga.update', $j->id_lembaga) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>ID Lembaga</label>
                                    <input type="text" value="{{ $j->id_lembaga }}" name="id_lembaga" id="edit_id"
                                        class="form-control" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Lembaga</label>
                                    <input type="text" value="{{ $j->nama_lembaga }}" name="nama_lembaga"
                                        id="edit_nama_Lembaga" class="form-control" required>
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

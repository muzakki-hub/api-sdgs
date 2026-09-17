@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- Tombol Tambah Data --}}
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahPendidikan">
            + Tambah Pendidikan
        </button>

        {{-- Tabel Data --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pendidikan untuk pendataan Keluarga</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pendidikan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikan as $j)
                                <tr>
                                    <td>{{ $j->id }}</td>
                                    <td>{{ $j->jenjang_pendidikan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalEditPendidikan{{ $j->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('pendidikan.destroy', $j->id) }}" method="POST"
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
    <div class="modal fade" id="modalTambahPendidikan" tabindex="-1" aria-labelledby="modalTambahPendidikanLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPendidikanLabel">Tambah Pendidikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pendidikan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>ID Pendidikan</label>
                            <input type="text" name="id" readonly class="form-control"
                                placeholder="ID akan terisi OTOMATIS">
                        </div>
                        <div class="mb-3">
                            <label>Nama Pendidikan</label>
                            <input type="text" name="jenjang_pendidikan" class="form-control" required>
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
    @foreach ($pendidikan as $j)
        <div class="modal fade" id="modalEditPendidikan{{ $j->id }}" tabindex="-1"
            aria-labelledby="modalEditPendidikanLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPendidikanLabel">Edit Pendidikan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form id="formEditPendidikan" action="{{ route('pendidikan.update', $j->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>ID Pendidikan</label>
                                    <input type="text" value="{{ $j->id }}" name="id" id="edit_id"
                                        class="form-control" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Pendidikan</label>
                                    <input type="text" value="{{ $j->jenjang_pendidikan }}" name="jenjang_pendidikan"
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

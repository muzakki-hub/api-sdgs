@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Tombol Tambah Jabatan --}}
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahJabatan">
            + Tambah Jabatan
        </button>

        {{-- Tabel Jabatan --}}
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
                                <th>Nama Jabatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jabatan as $j)
                                <tr>
                                    <td>{{ $j->id }}</td>
                                    <td>{{ $j->nama_jabatan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-jabatan"
                                            data-id="{{ $j->id }}" data-nama_jabatan="{{ $j->nama_jabatan }}"
                                            data-toggle="modal" data-target="#modalEditJabatan{{ $j->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('jabatan.destroy', $j->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus Jabatan ini?')">
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

    {{-- Modal Tambah Jabatan --}}
    <div class="modal fade" id="modalTambahJabatan" tabindex="-1" aria-labelledby="modalTambahJabatanLabel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahJabatanLabel">Tambah Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('jabatan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>ID Jabatan</label>
                            <input type="text" name="id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Jabatan</button>

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

    {{-- Modal Edit Jabatan --}}
    @foreach ($jabatan as $j)
        <div class="modal fade" id="modalEditJabatan{{ $j->id }}" tabindex="-1"
            aria-labelledby="modalEditJabatanLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditJabatanLabel">Edit Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form id="formEditJabatan{{ $j->id }}" action="{{ route('jabatan.update', $j->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>ID Jabatan</label>
        <input type="text" name="id" value="{{ $j->id }}" class="form-control" required readonly>
    </div>

    <div class="mb-3">
        <label>Nama Jabatan</label>
        <input type="text" name="nama_jabatan" value="{{ $j->nama_jabatan }}" class="form-control" required>
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
@push('scripts')
//     <script>
//         $(document).ready(function() {
//             $('#modalEditJabatan').on('show.bs.modal', function(event) {
//                 var button = $(event.relatedTarget);
//                 var id = button.data('id');
//                 var namaJabatan = button.data('nama_jabatan');
//                 console.log('ID:', id, 'Nama:', namaJabatan); // harus keluar saat klik edit
//                 $('#formEditJabatan').attr('action', '/jabatan/' + id);
//                 $('#edit_id').val(id); // <-- TAMBAHKAN INI
//                 $('#edit_nama_jabatan').val(namaJabatan);

//             });
//         });
//     </script>
    @endpush

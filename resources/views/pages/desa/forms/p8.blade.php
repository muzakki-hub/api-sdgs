@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P8 - Kelembagaan Desa</h5>

        <form action="{{ route('desa-p8.store') }}" class="mb-5" method="POST">
            @csrf
            <h5>Daftar Lembaga</h5>
            <div id="lembaga-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Lembaga</label>
                            <select name="id_lembaga" class="form-control" required>
                                <option value="">-- Pilih Lembaga --</option>
                                @foreach ($lembaga ?? [] as $item)
                                    <option value="{{ $item->id_lembaga }}">{{ $item->nama_lembaga }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Jumlah Pengurus</label>
                            <input type="number" name="jml_pengurus" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="mb-3">
                            <label>Jumlah Anggota</label>
                            <input type="number" name="jml_anggota" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ====== Tombol Aksi ====== --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/desa') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lembaga</th>
                        <th>Jumlah Pengurus</th>
                        <th>Jumlah Anggota</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_lembaga }}</td>
                            <td>{{ $item->jml_pengurus }}</td>
                            <td>{{ $item->jml_anggota }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning btn-edit-user" data-toggle="modal"
                                    data-target="#modalEditData{{ $item->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('desa-p8.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus Data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        {{-- @empty
                        <tr>
                            <td colspan="5">Belum ada user.</td>
                        </tr> --}}
                        <!-- Modal Edit Data -->
                        <div class="modal fade" id="modalEditData{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">Edit Data Lembaga
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('desa-p8.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-sm">
                                                    <div class="mb-3">
                                                        <label>Lembaga</label>
                                                        <select name="id_lembaga" class="form-control" required>
                                                            <option value="">-- Pilih Lembaga --</option>
                                                            @foreach ($lembaga as $lb)
                                                                <option value="{{ $lb->id_lembaga }}"
                                                                    {{ $lb->id_lembaga == $item->id_lembaga ? 'selected' : '' }}>
                                                                    {{ $lb->nama_lembaga }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm">
                                                    <div class="mb-3">
                                                        <label>Jumlah Pengurus</label>
                                                        <input type="number" name="jml_pengurus" class="form-control"
                                                            value="{{ $item->jml_pengurus }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm">
                                                    <div class="mb-3">
                                                        <label>Jumlah Anggota</label>
                                                        <input type="number" name="jml_anggota" class="form-control"
                                                            value="{{ $item->jml_anggota }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
@endpush

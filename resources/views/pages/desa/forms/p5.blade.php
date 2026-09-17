@extends('layouts.app')

@section('content')
    <div class="container">
        <h5>Form P5 - Regulasi Desa</h5>

        <form action="{{ route('desa-p5.store') }}" method="POST" class="mb-5">
            @csrf

            {{-- ====== Data Utama P5 ====== --}}
            <div class="form-group">
                <label>RPJM Desa Berlaku Sampai Tahun</label>
                <input type="date" name="rpjm_berlaku" class="form-control" required>
            </div>

            <div class="form-group">
                <label>RKP Desa</label>
                <select name="rkp_desa" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="1">Ada</option>
                    <option value="2">Tidak Ada</option>
                </select>
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
                <h6 class="m-0 font-weight-bold text-primary">Data Regulasi Desa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>RPJM Berlaku Sampai Tahun</th>
                                <th>RKP Desa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @php
                            $rkpDesa = [
                                '1' => 'Ada',
                                '2' => 'Tidak ada',
                            ];

                        @endphp
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->rpjm_berlaku }}</td>
                                    <td>{{ $rkpDesa[$item->rkp_desa] ?? '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p5.destroy', $item->id) }}" method="POST"
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
                                                    Data P5 Regulasi Data</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p5.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')

                                                    <div class="form-group">
                                                        <label>RPJM Desa Berlaku Sampai Tahun</label>
                                                        <input type="date" name="rpjm_berlaku"
                                                            value="{{ $item->rpjm_berlaku }}" class="form-control" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>RKP Desa</label>
                                                        <select name="rkp_desa" class="form-control" required>
                                                            <option
                                                                value="1"{{ $item->rkp_desa == '1' ? 'selected' : '' }}>
                                                                Ada</option>
                                                            <option
                                                                value="2"{{ $item->rkp_desa == '2' ? 'selected' : '' }}>
                                                                Tidak Ada</option>
                                                        </select>
                                                    </div>
                                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- @empty
                                <tr>
                                    <td colspan="6">Belum ada Data Regulasi Desa.</td>
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

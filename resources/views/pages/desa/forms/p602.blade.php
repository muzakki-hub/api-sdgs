@extends('layouts.app')

@section('content')
    <div class="container">


        <h5 class="mb-3">Form P602 - Anggaran pembelanjaan desa tahun sebelumnya </h5>


        <form action="{{ route('desa-p602.store') }}" method="POST" class="mb-5">
            @csrf

            @php
                $pengeluaranFields = [
                    'anggaran_pengeluaran' => 'Total Anggaran Pengeluaran Desa',
                    'penyelenggaraan_desa' => 'Pemerintahan Desa',
                    'pembangunan_desa' => 'Pelaksanaan Pembangunan',
                    'pemberdayaan_desa' => 'Pemberdayaan Masyarakat',
                    'bina_masyarakat' => 'Pembinaan Kemasyarakatan',
                    'belanja_modal' => 'Belanja Modal',
                    'bumdes' => 'Penyertaan Modal BUMDes',
                    'lainnya' => 'Lainnya (Tak Terduga, Konsumsi Rapat, dll)',
                ];
            @endphp

            <div class="row">
                @foreach ($pengeluaranFields as $name => $label)
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{ $label }} (Rp)</label>
                            <input type="number" step="any" name="{{ $name }}" class="form-control" required>
                        </div>
                    </div>
                @endforeach
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
                <h6 class="m-0 font-weight-bold text-primary">Data Anggaran pembelanjaan desa tahun sebelumnya</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>anggaran pengeluaran</th>
                                <th>bina masyarakat</th>
                                <th>belanja modal</th>
                                <th>lainnya</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>Rp.{{ number_format($item->anggaran_pengeluaran, 0, ',', '.') }}</td>
                                    <td>Rp.{{ number_format($item->bina_masyarakat, 0, ',', '.') }}</td>
                                    <td>Rp.{{ number_format($item->belanja_modal, 0, ',', '.') }}</td>
                                    <td>Rp.{{ number_format($item->lainnya, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p602.destroy', $item->id) }}" method="POST"
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
                                                    Data P602</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p602.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    @php
                                                        $pengeluaranFields = [
                                                            'anggaran_pengeluaran' => 'Total Anggaran Pengeluaran Desa',
                                                            'penyelenggaraan_desa' => 'Pemerintahan Desa',
                                                            'pembangunan_desa' => 'Pelaksanaan Pembangunan',
                                                            'pemberdayaan_desa' => 'Pemberdayaan Masyarakat',
                                                            'bina_masyarakat' => 'Pembinaan Kemasyarakatan',
                                                            'belanja_modal' => 'Belanja Modal',
                                                            'bumdes' => 'Penyertaan Modal BUMDes',
                                                            'lainnya' => 'Lainnya (Tak Terduga, Konsumsi Rapat, dll)',
                                                        ];
                                                    @endphp
                                                    <div class="row">
                                                        @foreach ($pengeluaranFields as $name => $label)
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>{{ $label }} (Rp)</label>
                                                                    <input type="number" step="any"
                                                                        name="{{ $name }}"
                                                                        value="{{ $item->$name }}" class="form-control"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- @empty
                                <tr>
                                    <td colspan="6">Belum ada Data.</td>
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

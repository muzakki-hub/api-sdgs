@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P603 - Nilai Aset Desa </h5>
        <form action="{{ route('desa-p603.store') }}" method="POST" class="mb-5">
            @csrf

            <div id="aset-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <input type="text" name="aset" class="form-control mb-2" placeholder="Nama Aset" required>
                    </div>
                    <div class="col-sm">
                        <input type="number" step="any" name="volume" class="form-control mb-2" placeholder="Volume"
                            required>
                    </div>
                    <div class="col-sm">
                        <select name="satuan_volume" class="form-control mb-2" required>
                            <option value="1">Unit</option>
                            <option value="2">Hektar</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <input type="number" step="any" name="nilai" class="form-control mb-2"
                            placeholder="Nilai (Rp)" required>
                    </div>
                </div>
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

        <div class="table-responsive">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aset</th>
                        <th>Volume</th>
                        <th>Satuan Volume</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @php
                    $satuanVolume = [
                        '1' => 'Unit',
                        '2' => 'Hektar',
                    ];
                @endphp
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->aset }}</td>
                            <td>{{ $item->volume }}</td>
                            <td>{{ $satuanVolume[$item->satuan_volume] ?? '-' }}</td>
                            <td>Rp.{{ number_format($item->nilai, 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning btn-edit-data" data-toggle="modal"
                                    data-target="#modalEditData{{ $item->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('desa-p603.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus Data ini?')">
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
                                            Data P603</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('desa-p603.update', $item->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            <div class="row">
                                                <div class="col-sm">
                                                    <input type="text" name="aset" value="{{ $item->aset }}"
                                                        class="form-control mb-2" placeholder="Nama Aset" required>
                                                </div>
                                                <div class="col-sm">
                                                    <input type="number" step="any" name="volume"
                                                        value="{{ $item->volume }}" class="form-control mb-2"
                                                        placeholder="Volume" required>
                                                </div>
                                                <div class="col-sm">
                                                    <select name="satuan_volume" class="form-control mb-2" required>
                                                        <option value="1"
                                                            {{ $item->satuan_volume == '1' ? 'selected' : '' }}>Unit
                                                        </option>
                                                        <option value="2"
                                                            {{ $item->satuan_volume == '2' ? 'selected' : '' }}>Hektar
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm">
                                                    <input type="number" step="any" name="nilai"
                                                        value="{{ $item->nilai }}" class="form-control mb-2"
                                                        placeholder="Nilai (Rp)" required>
                                                </div>
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
@endsection
@push('scripts')
@endpush

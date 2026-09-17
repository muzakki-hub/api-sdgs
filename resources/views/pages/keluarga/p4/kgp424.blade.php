@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P424 Keluarga</h5>
        <form action="{{ route('kg-p424.store') }}" method="post" class="mb-5">
            @csrf
            <div class="row">
                {{-- Master APST --}}
                <div class="col-sm-4 mb-3">
                    <label>Akses Sarana/Prasarana Transportasi<span class="text-danger">*</span></label>
                    <select name="id_master_akses_sarpras" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Akses Transportasi --</option>
                        @foreach ($masterapst as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_akses }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Transportasi --}}
                <div class="col-sm-4 mb-3">
                    <label>Jenis Transportasi<span class="text-danger">*</span></label>
                    <select name="jenis_transportasi" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Jenis --</option>
                        <option value="1">Darat</option>
                        <option value="2">Air</option>
                        <option value="3">Laut</option>
                    </select>
                </div>

                {{-- Penggunaan Transportasi --}}
                <div class="col-sm-4 mb-3">
                    <label>Apakah Digunakan?<span class="text-danger">*</span></label>
                    <select name="penggunaan_transportasi" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Jawaban --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                {{-- Kemudahan --}}
                <div class="col-sm-4 mb-3">
                    <label>Kemudahan Akses<span class="text-danger">*</span></label>
                    <select name="kemudahan" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Kemudahan --</option>
                        <option value="1">Mudah</option>
                        <option value="2">Sulit</option>
                    </select>
                </div>

                {{-- Waktu Tempuh --}}
                <div class="col-sm-4">
                    <label>Waktu Tempuh (jam)</label>
                    <input type="number" step="0.1" name="waktu_tempuh" class="form-control">
                </div>

                {{-- Biaya Sekali Perjalanan --}}
                <div class="col-sm-4">
                    <label>Biaya Sekali Perjalanan (Rp)</label>
                    <input type="number" name="biaya_sekali" class="form-control">
                </div>
            </div>

            {{-- === TOMBOL AKSI === --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/kg-p2') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan Keluarga
                </button>
            </div>
        </form>




        <!-- Data Keluarga -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Keluarga P424</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Akses SarPras</th>
                                <th>Jenis Transportasi</th>
                                <th>Waktu Tempuh (jam)</th>
                                <th>Biaya</th>
                                <th>Kemudahan Akses</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $jenis = [
                                    1 => 'Darat',
                                    2 => 'Air',
                                    3 => 'Laut',
                                ];
                                $akses = [
                                    1 => 'Mudah',
                                    2 => 'Sulit',
                                ];
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->masterApst->nama_akses }}</td>
                                    <td>
                                        {{ $jenis[$item->jenis_transportasi] }}
                                    </td>
                                    <td>
                                        {{ $item->waktu_tempuh }} Jam
                                    </td>
                                    <td>
                                        Rp.{{ number_format($item->biaya_sekali, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        {{ $akses[$item->kemudahan] ?? '-' }}
                                    </td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditKeluargaP424">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('kg-p424.destroy', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Modal Edit Keluarga P424 --}}
        <div class="modal fade" id="modalEditKeluargaP424" aria-labelledby="modalEditKeluargaLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKeluargaLabel">Edit Data Transportasi Keluarga:
                            {{ $datap2->nama_kpl_keluarga }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($data as $item)
                            <form action="{{ route('kg-p424.update', $item->id) }}" method="POST" class="mb-4">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    {{-- Akses Sarana/Prasarana Transportasi --}}
                                    <div class="col-sm-4 mb-3">
                                        <label>Akses Sarana/Prasarana Transportasi<span class="text-danger">*</span></label>
                                        <select name="id_master_akses_sarpras" class="form-control" required>
                                            <option value="" disabled>-- Pilih Akses Transportasi --</option>
                                            @foreach ($masterapst as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ $p->id == $item->id_master_akses_sarpras ? 'selected' : '' }}>
                                                    {{ $p->nama_akses }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Jenis Transportasi --}}
                                    <div class="col-sm-4 mb-3">
                                        <label>Jenis Transportasi<span class="text-danger">*</span></label>
                                        <select name="jenis_transportasi" class="form-control" required>
                                            <option value="" disabled>-- Pilih Jenis --</option>
                                            <option value="1"
                                                {{ $item->jenis_transportasi == '1' ? 'selected' : '' }}>Darat</option>
                                            <option value="2"
                                                {{ $item->jenis_transportasi == '2' ? 'selected' : '' }}>Air</option>
                                            <option value="3"
                                                {{ $item->jenis_transportasi == '3' ? 'selected' : '' }}>Laut</option>
                                        </select>
                                    </div>

                                    {{-- Penggunaan Transportasi --}}
                                    <div class="col-sm-4 mb-3">
                                        <label>Apakah Digunakan?<span class="text-danger">*</span></label>
                                        <select name="penggunaan_transportasi" class="form-control" required>
                                            <option value="" disabled>-- Pilih Jawaban --</option>
                                            <option value="1"
                                                {{ $item->penggunaan_transportasi == '1' ? 'selected' : '' }}>Ya</option>
                                            <option value="2"
                                                {{ $item->penggunaan_transportasi == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Kemudahan --}}
                                    <div class="col-sm-4 mb-3">
                                        <label>Kemudahan Akses<span class="text-danger">*</span></label>
                                        <select name="kemudahan" class="form-control" required>
                                            <option value="" disabled>-- Pilih Kemudahan --</option>
                                            <option value="1" {{ $item->kemudahan == '1' ? 'selected' : '' }}>Mudah
                                            </option>
                                            <option value="2" {{ $item->kemudahan == '2' ? 'selected' : '' }}>Sulit
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Waktu Tempuh --}}
                                    <div class="col-sm-4 mb-3">
                                        <label>Waktu Tempuh (jam)</label>
                                        <input type="number" step="0.1" name="waktu_tempuh" class="form-control"
                                            value="{{ $item->waktu_tempuh }}">
                                    </div>

                                    {{-- Biaya Sekali Perjalanan --}}
                                    <div class="col-sm-4 mb-3">
                                        <label>Biaya Sekali Perjalanan (Rp)</label>
                                        <input type="number" name="biaya_sekali" class="form-control"
                                            value="{{ $item->biaya_sekali }}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
@endpush

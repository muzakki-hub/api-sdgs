@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P421 Keluarga</h5>
        <form action="{{ route('kg-p421.store') }}" method="post" class="mb-5">
            @csrf
            <div class="row">
                {{-- ID Master Pendidikan --}}
                <div class="col-sm-3 mb-3">
                    <label>Jenjang Pendidikan Terdekat<span class="text-danger">*</span></label>
                    <select name="id_master_pendidikan" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Pendidikan --</option>
                        @foreach ($masterPendidikan as $p)
                            <option value="{{ $p->id }}">{{ $p->jenjang_pendidikan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <div class="mb-3">
                        <label>Jarak ke Pendidikan Terdekat (km)<span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="jarak" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-3">
                        <label>Waktu Tempuh (jam)<span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="waktu_tempuh" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-3 mb-3">
                    <label>Kemudahan Akses<span class="text-danger">*</span></label>
                    <select name="kemudahan" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Kemudahan --</option>
                        <option value="1">Mudah</option>
                        <option value="2">Sulit</option>
                    </select>
                </div>
            </div>
            {{-- ====== Tombol Aksi ====== --}}
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
                <h6 class="m-0 font-weight-bold text-primary">Data Keluarga P421</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Jenjang Pendidikan Terdekat</th>
                                <th>Jarak ke Pendidikan Terdekat (km)</th>
                                <th>Waktu Tempuh (jam)</th>
                                <th>Kemudahan Akses</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $akses = [
                                    1 => 'Mudah',
                                    2 => 'Sulit',
                                ];
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->pendidikan->jenjang_pendidikan ?? '-' }}</td>
                                    <td>
                                        {{ $item->jarak }}
                                    </td>
                                    <td>
                                        {{ $item->waktu_tempuh }}
                                    </td>
                                    <td>
                                        {{ $akses[$item->kemudahan] ?? '-' }}
                                    </td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditKeluargaP421">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('kg-p421.destroy', $item->id) }}" method="POST"
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


        {{-- Modal Edit Keluarga P421 --}}
        <div class="modal fade" id="modalEditKeluargaP421" aria-labelledby="modalEditKeluargaLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKeluargaLabel">Edit
                            Data Keluarga:
                            {{ $datap2->nama_kpl_keluarga }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($data as $item)
                            <form action="{{ route('kg-p421.update', $item->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="row">
                                    {{-- ID Master Pendidikan --}}
                                    <div class="col-sm-3 mb-3">
                                        <label>Jenjang Pendidikan Terdekat<span class="text-danger">*</span></label>
                                        <select name="id_master_pendidikan" class="form-control" required>
                                            @foreach ($masterPendidikan as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ $p->id == $item->id_master_pendidikan ? 'selected' : '' }}>
                                                    {{ $p->jenjang_pendidikan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label>Jarak ke Pendidikan Terdekat (km)<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.1" value="{{ $item->jarak }}" name="jarak"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label>Waktu Tempuh (jam)<span class="text-danger">*</span></label>
                                            <input type="number" step="0.1" name="waktu_tempuh"
                                                value="{{ $item->waktu_tempuh }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <label>Kemudahan Akses<span class="text-danger">*</span></label>
                                        <select name="kemudahan" class="form-control" required>
                                            <option value="1" {{ $item->kemudahan == '1' ? 'selected' : '' }}>Mudah
                                            </option>
                                            <option value="2" {{ $item->kemudahan == '2' ? 'selected' : '' }}>Sulit
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary">Simpan Perubahan</button>
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

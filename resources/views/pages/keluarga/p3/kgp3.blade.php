@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P3 Keluarga </h5>
        <form action="{{ route('kg-p3.store') }}" method="post" class="mb-5">
            {{-- {{ route('kg-p2.store') }} --}}
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Nik Kepala Keluarga<span class="text-danger">*</span></label>
                        <input type="number" name="nik_kk" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Nomer Kartu Keluarga<span class="text-danger">*</span></label>
                        <input type="number" min="0" name="no_kk" value="{{ $datap2->no_kk ?? '' }}" readonly
                            class="form-control" required>
                    </div>
                </div>
            </div>
            {{-- ====== Tombol Aksi ====== --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/kg-p2') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                @if ($data->isNotEmpty())
                    <button type="submit" class="btn btn-primary" disabled>
                        Sudah Terisi
                    </button>
                @else
                    <button type="submit" class="btn btn-primary">
                        Simpan Keluarga
                    </button>
                @endif

            </div>
        </form>


        <!-- Data Keluarga -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Keluarga P3</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nomer Kartu Keluarga</th>
                                <th>Nik Kepala Keluarga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $item->no_kk }}
                                    </td>
                                    <td>
                                        {{ $item->nik_kk }}
                                    </td>

                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditKeluargaP3">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('kg-p3.destroy', $item->id) }}" method="POST"
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


        {{-- Modal Edit Keluarga P3 --}}
        <div class="modal fade" id="modalEditKeluargaP3" aria-labelledby="modalEditKeluargaLabel" aria-hidden="true">
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
                            <form action="{{ route('kg-p3.update', $item->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Nik Kepala Keluarga<span class="text-danger">*</span></label>
                                            <input type="number" value="{{ $item->nik_kk }}" name="nik_kk"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Nomer Kartu Keluarga<span class="text-danger">*</span></label>
                                            <input type="number" min="0" name="no_kk"
                                                value="{{ $item->no_kk ?? '' }}" readonly class="form-control" required>
                                        </div>
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

@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P503 - SK Kepala Desa tahun sebelumnya </h5>


        <form action="{{ route('desa-p503.store') }}" method="POST" class="mb-5" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_desa_p5" value="{{ $p5->id }}">
            <div id="p503-wrapper">
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" name="no_dokumen" class="form-control mb-2" placeholder="No Dokumen" required>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="bulan" class="form-control mb-2" placeholder="Bulan (Angka)"
                            maxlength="5" required>
                    </div>
                    <div class="col-sm-4">
                        {{-- <label for="fileUpload" class="font-weight-bold">Unggah Dokumen</label> --}}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileUpload" name="dokumen_sk_kepdes">
                            <label class="custom-file-label" for="dokumen_sk_kepdes">Upload Dokumen PDF</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <input type="text" name="tentang" class="form-control mb-2" placeholder="Tentang" required>
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data SK Kepala Desa </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Dokumen</th>
                                <th>Bulan</th>
                                <th>Tentang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->no_dokumen }}</td>
                                    <td>{{ $item->bulan }}</td>
                                    <td>{{ $item->tentang }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p503.destroy', $item->id) }}" method="POST"
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
                                                    Data P503</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- === PREVIEW PDF (jika file ada) === --}}
                                               @php
                                                    $filePath = public_path('dokumen/p5/sk_kepdes/' . $item->id . '.pdf');
                                                @endphp

                                                @if (file_exists($filePath))
                                                    <div class="mb-3">
                                                        <h6>Dokumen Saat Ini:</h6>

                                                        <a href="{{ asset('dokumen/p5/sk_kepdes/' . $item->id . '.pdf'). '?v=' . time() }}"
                                                            target="_blank" class="btn btn-sm btn-info mt-2">
                                                            Lihat / Download Dokumen
                                                        </a>
                                                    </div>
                                                @else
                                                    <p class="text-danger">Dokumen belum diunggah.</p>
                                                @endif
                                                {{-- === END PREVIEW === --}}
                                                <form action="{{ route('desa-p503.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <input type="text" name="no_dokumen"
                                                                value="{{ $item->no_dokumen }}" class="form-control mb-2"
                                                                required>
                                                        </div>
                                                        <div class="col-sm">
                                                            <input type="text" name="bulan"
                                                                value="{{ $item->bulan }}" class="form-control mb-2"
                                                                maxlength="5" required>
                                                        </div>
                                                        <div class="col-sm">
                                                            <input type="text" name="tentang"
                                                                value="{{ $item->tentang }}" class="form-control mb-2"
                                                                required>
                                                        </div>
                                                        <div class="col-sm">
                                                            {{-- <label for="fileUpload" class="font-weight-bold">Unggah Dokumen</label> --}}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="fileUpload" name="dokumen_sk_kepdes">
                                                                <label class="custom-file-label"
                                                                    for="dokumen_sk_kepdes">Upload
                                                                    Dokumen PDF</label>
                                                            </div>
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
                                    <td colspan="6">Belum ada Data SK Kepala Desa.</td>
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

@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P7 - Direksi </h5>

        <form action="{{ route('desa-p705.store') }}" method="POST" class="mb-5">
            @csrf
            <input type="hidden" name="id_desa_p7" value="{{ $p7->id }}">
            <div id="kerjasama-wrapper">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" name="pihak_kerjasama" class="form-control mb-2"
                            placeholder="Pihak yang diajak kerja sama" required>
                    </div>
                    <div class="col-sm">
                        <select name="lingkup_kerjasama" class="form-control mb-2" required>
                            <option value="1">Antardesa</option>
                            <option value="2">Pemerintah Daerah</option>
                            <option value="3">Pemerintah Pusat</option>
                            <option value="4">Swasta</option>
                            <option value="5">Lembaga Internasional</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <input type="text" name="akhir_kerjasama" class="form-control mb-2"
                            placeholder="Tahun Berakhir (YYYY)" maxlength="4" required>
                    </div>
                    <div class="col-sm">
                        <input type="number" name="jml_jiwa" class="form-control mb-2" placeholder="Jumlah Pemanfaat"
                            required>
                    </div>
                    <div class="col-sm">
                        <input type="number" step="any" name="nilai_kerjasama" class="form-control mb-2"
                            placeholder="Nilai Kerja Sama (Rp)" required>
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
                <h6 class="m-0 font-weight-bold text-primary">Data Peraturan Desa Tahun Sebelumnya</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pihak Yang Kerja Sama</th>
                                <th>Lingkup Kerjasama</th>
                                <th>Akhir Kerjasama</th>
                                <th>Jumlah Jiwa</th>
                                <th>Nilai Kerjasama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->pihak_kerjasama }}</td>
                                    <td>{{ $item->lingkup_kerjasama }}</td>
                                    <td>{{ $item->akhir_kerjasama }}</td>
                                    <td>{{ $item->jml_jiwa }}</td>
                                    <td>Rp.{{ number_format($item->nilai_kerjasama, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p705.destroy', $item->id) }}" method="POST"
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
                                                    Data P705</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p705.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="text" name="pihak_kerjasama"
                                                                value="{{ $item->pihak_kerjasama }}"
                                                                class="form-control mb-2" required>
                                                        </div>
                                                        <div class="col-sm">
                                                            <select name="lingkup_kerjasama" class="form-control mb-2"
                                                                required>
                                                                <option
                                                                    value="1"{{ $item->lingkup_kerjasama == '1' ? 'selected' : '' }}>
                                                                    Antardesa</option>
                                                                <option
                                                                    value="2"{{ $item->lingkup_kerjasama == '2' ? 'selected' : '' }}>
                                                                    Pemerintah Daerah</option>
                                                                <option
                                                                    value="3"{{ $item->lingkup_kerjasama == '3' ? 'selected' : '' }}>
                                                                    Pemerintah Pusat</option>
                                                                <option
                                                                    value="4"{{ $item->lingkup_kerjasama == '4' ? 'selected' : '' }}>
                                                                    Swasta</option>
                                                                <option
                                                                    value="5"{{ $item->lingkup_kerjasama == '5' ? 'selected' : '' }}>
                                                                    Lembaga Internasional</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm">
                                                            <input type="text" name="akhir_kerjasama"
                                                                value="{{ $item->akhir_kerjasama }}"
                                                                class="form-control mb-2" maxlength="4" required>
                                                        </div>
                                                        <div class="col-sm">
                                                            <input type="number" name="jml_jiwa"
                                                                value="{{ $item->jml_jiwa }}" class="form-control mb-2"
                                                                required>
                                                        </div>
                                                        <div class="col-sm">
                                                            <input type="number" step="any" name="nilai_kerjasama"
                                                                value="{{ $item->nilai_kerjasama }}"
                                                                class="form-control mb-2" required>
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
        </div>
    </div>
@endsection
@push('scripts')
@endpush

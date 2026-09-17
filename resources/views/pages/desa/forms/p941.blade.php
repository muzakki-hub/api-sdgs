@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P941 - Unit Usaha Bumdes </h5>
        <form action="{{ route('desa-p941.store') }}" method="POST" class="mb-5">
            @csrf
            <input type="hidden" name="id_desa_p9" value="{{ $p9->id }}">
            <div id="unitusaha-wrapper" class="mb-3">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Unit Usaha Bumdes</label>
                        <input type="text" name="unit_usaha_bumdes" class="form-control mb-2" placeholder="Nama Unit"
                            required>
                    </div>
                    <div class="col-sm-4">
                        <label>Jumlah Unit Usaha</label>
                        <input type="number" name="jml_unit_usaha" class="form-control mb-2" placeholder="Jumlah Unit"
                            required>
                    </div>
                    <div class="col-sm-4">
                        <label>Jumlah Pekerja</label>
                        <input type="number" name="jml_pekerja" class="form-control mb-2" placeholder="Jumlah Pekerja"
                            required>
                    </div>
                    <div class="col-sm-4">
                        <label>Keuntungan Bersih</label>
                        <input type="number" name="keuntungan_bersih" class="form-control mb-2"
                            placeholder="Keuntungan Bersih" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Omset Tahun Lalu</label>
                        <input type="number" name="omset_thn_lalu" class="form-control mb-2" placeholder="Omset" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Aset Tahun Lalu</label>
                        <input type="number" name="aset_thn_lalu" class="form-control mb-2" placeholder="Aset" required>
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
                <h6 class="m-0 font-weight-bold text-primary">Data Pengawas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Unit</th>
                                <th>Jumlah Unit</th>
                                <th>Jumlah Pekerja</th>
                                <th>Keuntungan Bersih</th>
                                <th>Omset Tahun Lalu</th>
                                {{-- <th>Aset Tahun Lalu</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->unit_usaha_bumdes }}</td>
                                    <td>{{ $item->jml_unit_usaha }}</td>
                                    <td>{{ $item->jml_pekerja }}</td>
                                    <td>Rp.{{ number_format($item->keuntungan_bersih, 0, ',', '.') }}</td>
                                    <td>Rp.{{ number_format($item->omset_thn_lalu, 0, ',', '.') }}</td>
                                    {{-- <td>{{ $item->aset_thn_lalu }}</td> --}}
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p941.destroy', $item->id) }}" method="POST"
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
                                                    Data P941</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p941.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Unit Usaha Bumdes</label>
                                                            <input type="text" name="unit_usaha_bumdes"
                                                                value="{{ $item->unit_usaha_bumdes }}"
                                                                class="form-control mb-2" placeholder="Nama Unit" required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Jumlah Unit Usaha</label>
                                                            <input type="number" name="jml_unit_usaha"
                                                                value="{{ $item->jml_unit_usaha }}"
                                                                class="form-control mb-2" placeholder="Jumlah Unit"
                                                                required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Jumlah Pekerja</label>
                                                            <input type="number" name="jml_pekerja"
                                                                value="{{ $item->jml_pekerja }}" class="form-control mb-2"
                                                                placeholder="Jumlah Pekerja" required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Keuntungan Bersih</label>
                                                            <input type="number" name="keuntungan_bersih"
                                                                value="{{ $item->keuntungan_bersih }}"
                                                                class="form-control mb-2" placeholder="Keuntungan Bersih"
                                                                required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Omset Tahun Lalu</label>
                                                            <input type="number" name="omset_thn_lalu"
                                                                value="{{ $item->omset_thn_lalu }}"
                                                                class="form-control mb-2" placeholder="Omset" required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Aset Tahun Lalu</label>
                                                            <input type="number" name="aset_thn_lalu"
                                                                value="{{ $item->aset_thn_lalu }}"
                                                                class="form-control mb-2" placeholder="Aset" required>
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
                                    <td colspan="6">Belum ada Data Unit Usaha Bumdes.</td>
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

@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P204 Individu</h5>
        <form action="{{ route('idv-p204.store') }}" class="mb-5" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Jenis Penghasilan</label>
                <select name="id_master_penghasilan" class="form-control select2" required>
                    <option value="" selected disabled>-- Pilih Penghasilan --</option>
                    @foreach ($masterPenghasilan as $row)
                        <option value="{{ $row->id }}">
                            {{ $row->nama_komoditas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="jumlah" placeholder="Contoh: 50" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" class="form-control" name="satuan" placeholder="Kg, Ekor, Liter, dll" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Penghasilan / Bulan (Rp)</label>
                <input type="number" class="form-control" name="penghasilan" placeholder="Contoh: 2500000" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Diekspor</label>
                <select name="diekspor" class="form-control" required>
                    <option value="" selected disabled>-- Pilih --</option>
                    <option value="1">Semua</option>
                    <option value="2">Sebagian Besar</option>
                    <option value="3">Tidak</option>
                </select>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/idv-p1') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>


        <!-- Data Individu -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Individu P2</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sumber Penghasilan</th>
                                <th>Jumlah / Satuan </th>
                                <th>Penghasilan Setahun (Rp) </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $item->masterPenghasilan->nama_komoditas }}
                                    </td>
                                    <td>
                                        {{ $item->jumlah }} /
                                        {{ $item->satuan }}
                                    </td>
                                    <td>
                                        Rp{{ number_format($item->penghasilan, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditP204{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('idv-p204.destroy', $item->id) }}" method="POST"
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


        {{-- Modal Edit Individu P2 --}}
        @foreach ($data as $item)
            <div class="modal fade modal-edit" id="modalEditP204{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Data Penghasilan</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form id="formEditP204" action="{{ route('idv-p204.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Penghasilan</label>
                                    <select name="id_master_penghasilan" class="form-control select2" required>
                                        @foreach ($masterPenghasilan as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $item->id_master_penghasilan == $row->id ? 'selected' : '' }}>
                                                {{ $row->nama_komoditas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" value="{{ $item->jumlah }}" class="form-control" name="jumlah"
                                        id="edit_jumlah" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" class="form-control" value="{{ $item->satuan }}" name="satuan"
                                        id="edit_satuan" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penghasilan / Bulan (Rp)</label>
                                    <input type="number" class="form-control" name="penghasilan"
                                        value="{{ $item->penghasilan }}" id="edit_penghasilan_bulan" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diekspor</label>
                                    <select name="diekspor" class="form-control" id="edit_diekspor" required>
                                        <option value="1" {{ $item->diekspor == '1' ? 'selected' : '' }}>Semua
                                        </option>
                                        <option value="2" {{ $item->diekspor == '2' ? 'selected' : '' }}>Sebagian
                                            Besar</option>
                                        <option value="3" {{ $item->diekspor == '3' ? 'selected' : '' }}>Tidak
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
@push('scripts')
    <script>
        $('.modal-edit').on('shown.bs.modal', function() {
            $(this).find('.select2').select2({
                width: '100%',
                dropdownParent: $(this)
            });
        });
    </script>
@endpush

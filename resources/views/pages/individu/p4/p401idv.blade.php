@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P401 Individu</h5>
        <form action="{{ route('idv-p401.store') }}" class="mb-5" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Jenis Penyakit</label>
                <select name="id_master_penyakit" class="form-control select2" required>
                    <option value="" selected disabled>-- Pilih Penyakit --</option>
                    @foreach ($masterPenyakit as $row)
                        <option value="{{ $row->id }}">
                            {{ $row->jenis_penyakit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="" selected disabled>-- Pilih --</option>
                    <option value="1">Ya</option>
                    <option value="2">Tidak</option>
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
                <h6 class="m-0 font-weight-bold text-primary">Data Individu P401</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Jenis Penyakit</th>
                                <th>Status </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $status = [
                                    1 => 'Ya',
                                    2 => 'Tidak',
                                ];
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $item->masterPenyakit->jenis_penyakit }}
                                    </td>
                                    <td>
                                        {{ $status[$item->status] }}
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditP401{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('idv-p401.destroy', $item->id) }}" method="POST"
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


        {{-- Modal Edit Individu P401 --}}
        @foreach ($data as $item)
            <div class="modal fade modal-edit" id="modalEditP401{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Data Penghasilan</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form id="formEditP401" action="{{ route('idv-p401.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Penyakit</label>
                                    <select name="id_master_penyakit" class="form-control select2" required>
                                        @foreach ($masterPenyakit as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $item->id_master_penyakit == $row->id ? 'selected' : '' }}>
                                                {{ $row->jenis_penyakit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ $item->status == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="2" {{ $item->status == '2' ? 'selected' : '' }}>Tidak</option>
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

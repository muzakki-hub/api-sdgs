 @extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P402 Individu</h5>
        <form action="{{ route('idv-p402.store') }}" class="mb-5" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Sarana Kesehatan</label>
                <select name="id_master_sarkes" class="form-control select2" required>
                    <option value="" selected disabled>-- Pilih Sarkes --</option>
                    @foreach ($masterSarkes as $row)
                        <option value="{{ $row->id }}">
                            {{ $row->nama_sarkes }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Berkunjung</label>
                <input type="number" name="jml_berkunjung" class="form-control">
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
                <h6 class="m-0 font-weight-bold text-primary">Data Individu P402</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Jenis Sarkes</th>
                                <th>Jumlah Berkunjung </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $item->masterSarkes->nama_sarkes }}
                                    </td>
                                    <td>
                                        {{ $item->jml_berkunjung}} Kali
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditP402{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('idv-p402.destroy', $item->id) }}" method="POST"
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


        {{-- Modal Edit Individu P402 --}}
        @foreach ($data as $item)
            <div class="modal fade modal-edit" id="modalEditP402{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Data Individu P402</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form id="formEditP402" action="{{ route('idv-p402.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Sarana Kesehatan</label>
                                    <select name="id_master_sarkes" class="form-control select2" required>
                                        @foreach ($masterSarkes as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $item->id_master_sarkes == $row->id ? 'selected' : '' }}>
                                                {{ $row->nama_sarkes }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Berkunjung</label>
                                    <input type="number" name="jml_berkunjung" value="{{$item->jml_berkunjung}}" class="form-control">
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

@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P4 Individu</h5>
        <form action="{{ route('idv-p4.store') }}" class="mb-5" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tunanetra</label>
                    <select name="tunanetra" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tunarungu</label>
                    <select name="tunarungu" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tunawicara</label>
                    <select name="tunawicara" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tunadaksa</label>
                    <select name="tunadaksa" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tunagrahita</label>
                    <select name="tunagrahita" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tunalaras</label>
                    <select name="tunalaras" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Cacat Eks Sakit Kusta</label>
                    <select name="cacat_eks_sakitkusta" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Cacat Ganda</label>
                    <select name="cacat_ganda" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Dip ASUNG</label>
                    <select name="dipasung" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/idv-p1') }}" class="btn btn-secondary">← Kembali</a>

                @if ($data->isNotEmpty())
                    <button type="submit" class="btn btn-primary" disabled>
                        Sudah Terisi
                    </button>
                @else
                    <button type="submit" class="btn btn-primary">
                        Simpan Data
                    </button>
                @endif
            </div>
        </form>



        <!-- Data Individu -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Individu P4</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                {{-- <th>Sumber Penghasilan</th> --}}
                                <th>Tunanetra</th>
                                <th>Tunarungu </th>
                                <th>Tunawicara </th>
                                <th>Tunadaksa </th>
                                <th>Tunagrahita </th>
                                <th>Tunalaras </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $value = [
                                    1 => 'Ya',
                                    2 => 'Tidak',
                                ];
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $value[$item->tunanetra] }}</td>
                                    <td>{{ $value[$item->tunarungu] }}</td>
                                    <td>{{ $value[$item->tunawicara] }}</td>
                                    <td>{{ $value[$item->tunadaksa] }}</td>
                                    <td>{{ $value[$item->tunagrahita] }}</td>
                                    <td>{{ $value[$item->tunalaras] }}</td>

                                    <td>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditP4{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('idv-p4.destroy', $item->id) }}" method="POST"
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


        {{-- Modal Edit Individu P4 --}}
        @foreach ($data as $item)
            <div class="modal fade modal-edit" id="modalEditP4{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Data Penghasilan</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form id="formEditP4" action="{{ route('idv-p4.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tunanetra</label>
                                        <select name="tunanetra" class="form-control" required>
                                            <option value="1" {{ $item->tunanetra == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2" {{ $item->tunanetra == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tunarungu</label>
                                        <select name="tunarungu" class="form-control" required>
                                            <option value="1" {{ $item->tunarungu == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2" {{ $item->tunarungu == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tunawicara</label>
                                        <select name="tunawicara" class="form-control" required>
                                            <option value="1" {{ $item->tunawicara == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2"{{ $item->tunawicara == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tunadaksa</label>
                                        <select name="tunadaksa" class="form-control" required>
                                            <option value="1"{{ $item->tunadaksa == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2"{{ $item->tunadaksa == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tunagrahita</label>
                                        <select name="tunagrahita" class="form-control" required>
                                            <option value="1"{{ $item->tunagrahita == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2"{{ $item->tunagrahita == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tunalaras</label>
                                        <select name="tunalaras" class="form-control" required>
                                            <option value="1"{{ $item->tunalaras == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2"{{ $item->tunalaras == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Cacat Eks Sakit Kusta</label>
                                        <select name="cacat_eks_sakitkusta" class="form-control" required>
                                            <option
                                                value="1"{{ $item->cacat_eks_sakitkusta == '1' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option
                                                value="2"{{ $item->cacat_eks_sakitkusta == '2' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Cacat Ganda</label>
                                        <select name="cacat_ganda" class="form-control" required>
                                            <option value="1"{{ $item->cacat_ganda == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2"{{ $item->cacat_ganda == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Dip ASUNG</label>
                                        <select name="dipasung" class="form-control" required>
                                            <option value="1"{{ $item->dipasung == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2"{{ $item->dipasung == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>
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
@endpush

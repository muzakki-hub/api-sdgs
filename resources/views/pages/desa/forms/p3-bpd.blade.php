@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P3 - Anggota BPD </h5>

        <form action="{{ route('desa-p3Bpd.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_desa_p3" value="{{ $p3->id ?? '' }}">
            <h4>Anggota BPD</h4>
            <div id="bpd-wrapper">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label>Anggota ke-</label>
                            <input type="number" name="anggota_ke" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label>NIK Anggota BPD</label>
                            <input type="text" name="nik_anggota_bpd" class="form-control" maxlength="20" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label>Nama Anggota BPD</label>
                            <input type="text" name="nama_anggota_bpd" class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label>HP Anggota BPD</label>
                            <input type="text" name="hp_anggota_bpd" class="form-control" maxlength="20" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label>Awal Jabatan Anggota BPD</label>
                            <input type="date" name="awal_jabatan_anggota_bpd" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/desa') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan Data
                </button>
            </div>
        </form>
        {{-- <div class="card shadow mb-4 mt-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Anggota BPD</h6>
            </div>
            <div class="card-body">
                
            </div>
        </div> --}}

        <table class="table display" id="tableBPD">
            <thead>
                <tr>
                    <th>Anggota BPD Ke</th>
                    <th>NIK Anggota BPD</th>
                    <th>Nama Anggota BPD</th>
                    <th>Nomer Hp Anggota BPD</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $p)
                    <tr>
                        <td>{{ $p->anggota_ke }}</td>
                        <td>{{ $p->nik_anggota_bpd }}</td>
                        <td>{{ $p->nama_anggota_bpd }}</td>
                        <td>{{ $p->hp_anggota_bpd }}</td>
                        {{-- <td>{{$p->awal_jabatan_anggota_bpd}}</td> --}}
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#modalEditData{{ $p->id }}">
                                Edit
                            </button>
                            <form action="{{ route('desa-p3Bpd.destroy', $p->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus Data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    {{-- Modal Edit Data --}}
                    <div class="modal fade" id="modalEditData{{ $p->id }}"
                        aria-labelledby="modalEditDataLabel{{ $p->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditDataLabel{{ $p->id }}">Edit
                                        Data P4</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('desa-p3Bpd.update', $p->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf @method('PUT')

                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="mb-3">
                                                    <label>Anggota ke-</label>
                                                    <input type="number" name="anggota_ke" value="{{ $p->anggota_ke }}"
                                                        class="form-control" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="mb-3">
                                                    <label>NIK Anggota BPD</label>
                                                    <input type="text" name="nik_anggota_bpd"
                                                        value="{{ $p->nik_anggota_bpd }}" class="form-control"
                                                        maxlength="20" required>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="mb-3">
                                                    <label>Nama Anggota</label>
                                                    <input type="text" name="nama_anggota_bpd"
                                                        value="{{ $p->nama_anggota_bpd }}" class="form-control"
                                                        maxlength="100" required>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="mb-3">
                                                    <label>No HP Anggota</label>
                                                    <input type="text" name="hp_anggota_bpd"
                                                        value="{{ $p->hp_anggota_bpd }}" class="form-control"
                                                        maxlength="20" required>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="mb-3">
                                                    <label>Awal Jabatan</label>
                                                    <input type="date" name="awal_jabatan_anggota_bpd"
                                                        value="{{ $p->awal_jabatan_anggota_bpd }}" class="form-control"
                                                        required>
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
                        <td colspan="5" class="text-center text-muted">Belum ada Data Anggota BPD.</td>
                    </tr> --}}
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
@push('scripts')

@endpush

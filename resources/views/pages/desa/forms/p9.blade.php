@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P9 - Bumdes</h5>
        <form action="{{ route('desa-p9.store') }}" method="POST" class="mb-5">
            @csrf

            {{-- <h5>Profil Bumdes</h5> --}}
            <div class="row mb-3">
                <div class="col-sm"><input type="text" name="nama_bumdes" class="form-control mb-2" placeholder="Nama Bumdes"
                        required></div>
                <div class="col-sm"><input type="email" name="email" class="form-control mb-2" placeholder="Email"
                        required>
                </div>
                <div class="col-sm"><input type="text" name="alamat_desa" class="form-control mb-2"
                        placeholder="Alamat Desa" required></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm"><input type="text" name="web_bumdes" class="form-control mb-2" placeholder="Website">
                </div>
                <div class="col-sm"><input type="text" name="fb_bumdes" class="form-control mb-2" placeholder="Facebook">
                </div>
                <div class="col-sm"><input type="text" name="twitter_bumdes" class="form-control mb-2"
                        placeholder="Twitter">
                </div>
                <div class="col-sm"><input type="text" name="yt_bumdes" class="form-control mb-2" placeholder="YouTube">
                </div>
            </div>

            <h5>Modal Awal</h5>
            <div class="row mb-3">
                <div class="col-sm">
                    <input type="number" name="modal_awal[]" class="form-control mb-2" placeholder="Modal Awal Dari Pemdes"
                        required>
                </div>
                <div class="col-sm">
                    <input type="number" name="modal_awal[]" class="form-control mb-2"
                        placeholder="Modal Awal Dari Warga Desa" required>
                </div>
                <div class="col-sm">
                    <input type="number" name="modal_awal[]" class="form-control mb-2"
                        placeholder="Modal Awal Dari Pihak Lain" required>
                </div>
            </div>

            <h5>Keuangan Bumdes</h5>
            <div class="row mb-3">
                <div class="col-sm"><input type="number" name="omset_setahun" class="form-control mb-2"
                        placeholder="Omset Tahun Lalu" required></div>
                <div class="col-sm"><input type="number" name="keuntungan_kotor" class="form-control mb-2"
                        placeholder="Keuntungan Kotor" required></div>
                <div class="col-sm"><input type="number" name="keuntungan_bersih" class="form-control mb-2"
                        placeholder="Keuntungan Bersih" required></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm"><input type="number" name="aset_bumdes" class="form-control mb-2"
                        placeholder="Nilai Aset" required></div>
                <div class="col-sm"><input type="number" name="sumbangan_padesa" class="form-control mb-2"
                        placeholder="Sumbangan ke PADesa" required></div>
            </div>

            {{-- ====== Tombol Aksi ====== --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/desa') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data P9 Bumdes</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bumdes</th>
                                <th>Omset Setahun</th>
                                <th>Aset Bumdes</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_bumdes }}</td>
                                    <td>Rp.{{ number_format($item->omset_setahun, 0, ',', '.') }}</td>
                                    <td>Rp.{{ number_format($item->aset_bumdes, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p9.destroy', $item->id) }}" method="POST"
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
                                                    Data P9</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p9.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Nama Bumdes</label>
                                                            <input type="text" name="nama_bumdes"
                                                                value="{{ $item->nama_bumdes }}"
                                                                class="form-control mb-2" required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Email Bumdes</label>
                                                            <input type="email" name="email"
                                                                value="{{ $item->email }}" class="form-control mb-2"
                                                                required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Alamat Bumdes</label>
                                                            <input type="text" name="alamat_desa"
                                                                value="{{ $item->alamat_desa }}"
                                                                class="form-control mb-2" required>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label>Web Bumdes</label>
                                                            <input type="text" name="web_bumdes"
                                                                value="{{ $item->web_bumdes }}"
                                                                class="form-control mb-2">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label>Facebook Bumdes</label>
                                                            <input type="text" name="fb_bumdes"
                                                                value="{{ $item->fb_bumdes }}" class="form-control mb-2">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label>Twitter Bumdes</label>
                                                            <input type="text" name="twitter_bumdes"
                                                                value="{{ $item->twitter_bumdes }}"
                                                                class="form-control mb-2">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label>YouTube Bumdes</label>
                                                            <input type="text" name="yt_bumdes"
                                                                value="{{ $item->yt_bumdes }}" class="form-control mb-2">
                                                        </div>
                                                        {{-- <div class="col-sm-3">
                                                            <label>Modal Awal</label>
                                                            <input type="number" name="modal_awal"
                                                                value="{{ $item->modal_awal }}" class="form-control mb-2"
                                                                required>
                                                        </div> --}}
                                                        @php
                                                            $modal = explode(',', $item->modal_awal);
                                                        @endphp

                                                        <div class="col-sm-4">
                                                            <label>Modal Awal Dari Pemdes</label>
                                                            <input type="number" name="modal_awal[]"
                                                                value="{{ $modal[0] ?? '' }}" class="form-control mb-2"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label>Modal Awal Dari Warga Desa</label>
                                                            <input type="number" name="modal_awal[]"
                                                                value="{{ $modal[1] ?? '' }}" class="form-control mb-2"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label>Modal Awal Dari Pihak Lain</label>
                                                            <input type="number" name="modal_awal[]"
                                                                value="{{ $modal[2] ?? '' }}" class="form-control mb-2"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label>Omset Setahun</label>
                                                            <input type="number" name="omset_setahun"
                                                                value="{{ $item->omset_setahun }}"
                                                                class="form-control mb-2" required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Keuntungan Kotor</label>
                                                            <input type="number" name="keuntungan_kotor"
                                                                value="{{ $item->keuntungan_kotor }}"
                                                                class="form-control mb-2" required>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label>Keuntungan Bersih</label>
                                                            <input type="number" name="keuntungan_bersih"
                                                                value="{{ $item->keuntungan_bersih }}"
                                                                class="form-control mb-2" required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label>Aset Bumdes</label>
                                                            <input type="number" name="aset_bumdes"
                                                                value="{{ $item->aset_bumdes }}"
                                                                class="form-control mb-2" required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label>Sumbangan Padesa</label>
                                                            <input type="number" name="sumbangan_padesa"
                                                                value="{{ $item->sumbangan_padesa }}"
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
                                    <td colspan="5">Belum ada Data Bumdes.</td>
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

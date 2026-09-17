@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P7 - Layanan dan Kerja Sama Desa</h5>

        <form action="{{ route('desa-p7.store') }}" method="POST" class="mb-5">
            @csrf

            <h5>Layanan dan Teknologi Desa</h5>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Penggunaan Teknologi Informasi</label>
                        <select name="teknologi" class="form-control" required>
                            <option value="1">Digunakan</option>
                            <option value="2">Jarang digunakan</option>
                            <option value="3">Tidak digunakan</option>
                            <option value="4">Tidak ada</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Kondisi Internet</label>
                        <select name="internet" class="form-control" required>
                            <option value="1">Berfungsi</option>
                            <option value="2">Jarang berfungsi</option>
                            <option value="3">Tidak berfungsi</option>
                            <option value="4">Tidak ada</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Informasi Desa</label>
                        <select name="info_desa" class="form-control" required>
                            <option value="1">Ada, diperbaharui</option>
                            <option value="2">Ada, tidak diperbaharui</option>
                            <option value="3">Tidak ada</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Informasi Keuangan Desa</label>
                        <select name="keuangan_desa" class="form-control" required>
                            <option value="1">Ada, diperbaharui</option>
                            <option value="2">Ada, tidak diperbaharui</option>
                            <option value="3">Tidak ada</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Surat Keterangan Tidak Mampu (setahun terakhir)</label>
                        <input type="number" name="srt_tidak_mampu" class="form-control" required>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Penduduk Belum Rekam eKTP</label>
                        <input type="number" name="blm_ektp" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Penduduk Belum Tercatat di KK</label>
                        <input type="number" name="blm_kk" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Pendamping Desa</label>
                        <input type="text" name="nama_pdesa" class="form-control" maxlength="100" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Jenis Kelamin Pendamping Desa</label>
                        <select name="jk_pdesa" class="form-control" required>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nomer HP Pendamping Desa</label>
                        <input type="number" name="hp_pdesa" class="form-control"
                            maxlength="15" required>
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
                <h6 class="m-0 font-weight-bold text-primary">Data Layanan dan Kerja Sama Desa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Penggunaan Teknologi Informasi</th>
                                <th>Kondisi Internet</th>
                                <th>Informasi Desa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @php
                            $teknologiOptions = [
                                '1' => 'Digunakan',
                                '2' => 'Jarang digunakan',
                                '3' => 'Tidak digunakan',
                                '4' => 'Tidak ada',
                            ];

                            $internetOptions = [
                                '1' => 'Berfungsi',
                                '2' => 'Jarang berfungsi',
                                '3' => 'Tidak berfungsi',
                                '4' => 'Tidak ada',
                            ];

                            $infoDesaOptions = [
                                '1' => 'Ada, diperbaharui',
                                '2' => 'Ada, tidak diperbaharui',
                                '3' => 'Tidak ada',
                            ];
                        @endphp
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $teknologiOptions[$item->teknologi] ?? '-' }}</td>
                                    <td>{{ $internetOptions[$item->internet] ?? '-' }}</td>
                                    <td>{{ $infoDesaOptions[$item->info_desa] ?? '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p7.destroy', $item->id) }}" method="POST"
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
                                                    Data P7</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p7.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Penggunaan Teknologi Informasi</label>
                                                                <select name="teknologi" class="form-control" required>
                                                                    <option
                                                                        value="1"{{ $item->teknologi == '1' ? 'selected' : '' }}>
                                                                        Digunakan</option>
                                                                    <option
                                                                        value="2"{{ $item->teknologi == '2' ? 'selected' : '' }}>
                                                                        Jarang digunakan</option>
                                                                    <option
                                                                        value="3"{{ $item->teknologi == '3' ? 'selected' : '' }}>
                                                                        Tidak digunakan</option>
                                                                    <option
                                                                        value="4"{{ $item->teknologi == '4' ? 'selected' : '' }}>
                                                                        Tidak ada</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Kondisi Internet</label>
                                                                <select name="internet" class="form-control" required>
                                                                    <option
                                                                        value="1"{{ $item->internet == '1' ? 'selected' : '' }}>
                                                                        Berfungsi</option>
                                                                    <option
                                                                        value="2"{{ $item->internet == '2' ? 'selected' : '' }}>
                                                                        Jarang berfungsi</option>
                                                                    <option
                                                                        value="3"{{ $item->internet == '3' ? 'selected' : '' }}>
                                                                        Tidak berfungsi</option>
                                                                    <option
                                                                        value="4"{{ $item->internet == '4' ? 'selected' : '' }}>
                                                                        Tidak ada</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Informasi Desa</label>
                                                                <select name="info_desa" class="form-control" required>
                                                                    <option
                                                                        value="1"{{ $item->info_desa == '1' ? 'selected' : '' }}>
                                                                        Ada, diperbaharui</option>
                                                                    <option
                                                                        value="2"{{ $item->info_desa == '2' ? 'selected' : '' }}>
                                                                        Ada, tidak diperbaharui</option>
                                                                    <option
                                                                        value="3"{{ $item->info_desa == '3' ? 'selected' : '' }}>
                                                                        Tidak ada</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Informasi Keuangan Desa</label>
                                                                <select name="keuangan_desa" class="form-control"
                                                                    required>
                                                                    <option
                                                                        value="1"{{ $item->keuangan_desa == '1' ? 'selected' : '' }}>
                                                                        Ada, diperbaharui</option>
                                                                    <option
                                                                        value="2"{{ $item->keuangan_desa == '2' ? 'selected' : '' }}>
                                                                        Ada, tidak diperbaharui</option>
                                                                    <option
                                                                        value="3"{{ $item->keuangan_desa == '3' ? 'selected' : '' }}>
                                                                        Tidak ada</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Jumlah Surat Keterangan Tidak Mampu (setahun
                                                                    terakhir)</label>
                                                                <input type="number" name="srt_tidak_mampu"
                                                                    value="{{ $item->srt_tidak_mampu }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Jumlah Penduduk Belum Rekam eKTP</label>
                                                                <input type="number" name="blm_ektp"
                                                                    value="{{ $item->blm_ektp }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Jumlah Penduduk Belum Tercatat di KK</label>
                                                                <input type="number" name="blm_kk"
                                                                    value="{{ $item->blm_kk }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Nama Pendamping Desa</label>
                                                                <input type="text" name="nama_pdesa"
                                                                    value="{{ $item->nama_pdesa }}" class="form-control"
                                                                    maxlength="100" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Jenis Kelamin Pendamping Desa</label>
                                                                <select name="jk_pdesa" class="form-control" required>
                                                                    <option
                                                                        value="1"{{ $item->jk_pdesa == '1' ? 'selected' : '' }}>
                                                                        Laki-laki</option>
                                                                    <option
                                                                        value="2"{{ $item->jk_pdesa == '2' ? 'selected' : '' }}>
                                                                        Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Nomer HP Pendamping Desa</label>
                                                                <input type="number" name="hp_pdesa"
                                                                    value="{{ $item->hp_pdesa }}" class="form-control"
                                                                    maxlength="15" required>
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
                                    <td colspan="6">Belum ada Data Layanan dan Kerja Sama Desa.</td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Tambah kolom dinamis --}}
    {{-- <script>
        let kerjasamaIndex = 1;

        function tambahKerjasama() {
            $('#kerjasama-wrapper').append(`
            <div class="row">
                <div class="col-sm">
                    <input type="text" name="kerjasama[${kerjasamaIndex}][pihak_kerjasama]" class="form-control mb-2" placeholder="Pihak Kerja Sama" required>
                </div>
                <div class="col-sm">
                    <select name="kerjasama[${kerjasamaIndex}][lingkup_kerjasama]" class="form-control mb-2" required>
                        <option value="1">Antardesa</option>
                        <option value="2">Pemerintah Daerah</option>
                        <option value="3">Pemerintah Pusat</option>
                        <option value="4">Swasta</option>
                        <option value="5">Lembaga Internasional</option>
                    </select>
                </div>
                <div class="col-sm">
                    <input type="text" name="kerjasama[${kerjasamaIndex}][akhir_kerjasama]" class="form-control mb-2" placeholder="Tahun Berakhir (YYYY)" maxlength="4" required>
                </div>
                <div class="col-sm">
                    <input type="number" name="kerjasama[${kerjasamaIndex}][jml_jiwa]" class="form-control mb-2" placeholder="Jumlah Pemanfaat" required>
                </div>
                <div class="col-sm">
                    <input type="number" step="any" name="kerjasama[${kerjasamaIndex}][nilai_kerjasama]" class="form-control mb-2" placeholder="Nilai Kerja Sama (Rp)" required>
                </div>
            </div>
        `);
            kerjasamaIndex++;
        }
    </script> --}}
@endsection
@push('scripts')
@endpush

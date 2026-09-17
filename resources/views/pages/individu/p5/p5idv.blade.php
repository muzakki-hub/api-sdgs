@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P5 Individu</h5>
        <form action="{{ route('idv-p5.store') }}" class="mb-5" method="POST">
            @csrf
            <div class="row">

                {{-- Pendidikan Terakhir --}}
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" class="form-control" id="pendidikan_terakhir" required>
                            <option value="" selected disabled>-- Pilih Pendidikan --</option>
                            <option value="1">Tidak Sekolah</option>
                            <option value="2">SD/Sederajat</option>
                            <option value="3">SMP/Sederajat</option>
                            <option value="4">SMA/Sederajat</option>
                            <option value="5">Diploma 1–3</option>
                            <option value="6">S1/Sederajat</option>
                            <option value="7">S2/Sederajat</option>
                            <option value="8">S3/Sederajat</option>
                            <option value="9">Pesantren</option>
                            <option value="10">Lainnya</option>
                        </select>
                    </div>
                </div>

                {{-- Pendidikan lainnya --}}
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Pendidikan Lainnya (Jika memilih "Lainnya")</label>
                        <input type="text" class="form-control" name="pendidikan_terakhir_lainnya"
                            placeholder="Isi jika memilih lainnya">
                    </div>
                </div>

                {{-- Bahasa di Rumah --}}
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Bahasa yang digunakan di Rumah</label>
                        <input type="text" class="form-control" name="bahasa_rumah" required>
                    </div>
                </div>

                {{-- Bahasa formal --}}
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Bahasa Formal (Sekolah/Tempat Kerja)</label>
                        <input type="text" class="form-control" name="bahasa_formal" required>
                    </div>
                </div>

                {{-- Aktivitas Sosial --}}
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Kerja Bakti (Kali/Tahun)</label>
                        <input type="number" min="0" name="kerja_bakti" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Siskamling (Kali/Tahun)</label>
                        <input type="number" min="0" name="siskampling" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Pesta Rakyat (Kali/Tahun)</label>
                        <input type="number" min="0" name="pesta_rakyat" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Menolong Kematian (Kali/Tahun)</label>
                        <input type="number" min="0" name="menolong_kematian" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Menolong Sakit (Kali/Tahun)</label>
                        <input type="number" min="0" name="menolong_sakit" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Menolong Kecelakaan (Kali/Tahun)</label>
                        <input type="number" min="0" name="menolong_kecelakaan" class="form-control" required>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/idv-p1') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan Individu
                </button>
            </div>
        </form>


        <!-- Data Individu -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Individu P5</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Pendidikan Terakhir</th>
                                <th>Bahasa Rumah</th>
                                <th> Kerja bakti setahun terakhir (jumlah)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $item->pendidikan_terakhir_text }}
                                    </td>
                                    <td>
                                        {{ $item->bahasa_rumah }}
                                    </td>
                                    <td>
                                        {{ $item->kerja_bakti }} Kali
                                    </td>

                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditIndividuP5{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('idv-p5.destroy', $item->id) }}" method="POST"
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


        {{-- Modal Edit Individu P5 --}}

        @foreach ($data as $item)
            <div class="modal fade modal-edit" id="modalEditIndividuP5{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Data Individu P5</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('idv-p5.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    {{-- Pendidikan Terakhir --}}
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Pendidikan Terakhir</label>
                                            <select name="pendidikan_terakhir" class="form-control"
                                                id="pendidikan_terakhir" required>
                                                <option value="" disabled>-- Pilih Pendidikan --</option>
                                                <option value="1"
                                                    {{ $item->pendidikan_terakhir == '1' ? 'selected' : '' }}>Tidak Sekolah
                                                </option>
                                                <option value="2"
                                                    {{ $item->pendidikan_terakhir == '2' ? 'selected' : '' }}>SD/Sederajat
                                                </option>
                                                <option value="3"
                                                    {{ $item->pendidikan_terakhir == '3' ? 'selected' : '' }}>SMP/Sederajat
                                                </option>
                                                <option value="4"
                                                    {{ $item->pendidikan_terakhir == '4' ? 'selected' : '' }}>SMA/Sederajat
                                                </option>
                                                <option value="5"
                                                    {{ $item->pendidikan_terakhir == '5' ? 'selected' : '' }}>Diploma 1–3
                                                </option>
                                                <option value="6"
                                                    {{ $item->pendidikan_terakhir == '6' ? 'selected' : '' }}>S1/Sederajat
                                                </option>
                                                <option value="7"
                                                    {{ $item->pendidikan_terakhir == '7' ? 'selected' : '' }}>S2/Sederajat
                                                </option>
                                                <option value="8"
                                                    {{ $item->pendidikan_terakhir == '8' ? 'selected' : '' }}>S3/Sederajat
                                                </option>
                                                <option value="9"
                                                    {{ $item->pendidikan_terakhir == '9' ? 'selected' : '' }}>Pesantren
                                                </option>
                                                <option value="10"
                                                    {{ $item->pendidikan_terakhir == '10' ? 'selected' : '' }}>Lainnya
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Pendidikan lainnya --}}
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Pendidikan Lainnya (Jika memilih "Lainnya")</label>
                                            <input type="text" class="form-control" name="pendidikan_terakhir_lainnya"
                                                value="{{ $item->pendidikan_terakhir_lainnya }}">
                                        </div>
                                    </div>

                                    {{-- Bahasa rumah --}}
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Bahasa di Rumah</label>
                                            <input type="text" class="form-control" name="bahasa_rumah"
                                                value="{{ $item->bahasa_rumah }}" required>
                                        </div>
                                    </div>

                                    {{-- Bahasa formal --}}
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Bahasa Formal (Sekolah/Tempat Kerja)</label>
                                            <input type="text" class="form-control" name="bahasa_formal"
                                                value="{{ $item->bahasa_formal }}" required>
                                        </div>
                                    </div>

                                    {{-- Aktivitas sosial --}}
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label>Kerja Bakti (Kali/Tahun)</label>
                                            <input type="number" min="0" class="form-control" name="kerja_bakti"
                                                value="{{ $item->kerja_bakti }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label>Siskamling (Kali/Tahun)</label>
                                            <input type="number" min="0" class="form-control" name="siskampling"
                                                value="{{ $item->siskampling }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label>Pesta Rakyat (Kali/Tahun)</label>
                                            <input type="number" min="0" class="form-control"
                                                name="pesta_rakyat" value="{{ $item->pesta_rakyat }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Menolong Kematian (Kali/Tahun)</label>
                                            <input type="number" min="0" class="form-control"
                                                name="menolong_kematian" value="{{ $item->menolong_kematian }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Menolong Sakit (Kali/Tahun)</label>
                                            <input type="number" min="0" class="form-control"
                                                name="menolong_sakit" value="{{ $item->menolong_sakit }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label>Menolong Kecelakaan (Kali/Tahun)</label>
                                            <input type="number" min="0" class="form-control"
                                                name="menolong_kecelakaan" value="{{ $item->menolong_kecelakaan }}"
                                                required>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary mt-3 w-100">
                                    <i class="bi bi-save"></i> Update Data
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach



    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Untuk form tambah
            const pekerjaanUtama = document.getElementById('pekerjaan_utama');
            const pekerjaanLainnyaContainer = document.getElementById('pekerjaan_lainnya_container');
            const pekerjaanLainnyaTextarea = document.getElementById('pekerjaan_lainnya');

            pekerjaanUtama.addEventListener('change', function() {
                if (this.value === '16') {
                    pekerjaanLainnyaContainer.style.display = 'block';
                    pekerjaanLainnyaTextarea.required = true;
                } else {
                    pekerjaanLainnyaContainer.style.display = 'none';
                    pekerjaanLainnyaTextarea.required = false;
                    pekerjaanLainnyaTextarea.value = '';
                }
            });

            // Untuk semua modal edit (loop semua dropdown dengan id yang mirip)
            document.querySelectorAll('[id^="pekerjaan_utama_"]').forEach(function(select) {
                const id = select.id.split('_').pop();
                const container = document.getElementById('pekerjaan_lainnya_container_' + id);
                const textarea = document.getElementById('pekerjaan_lainnya_' + id);

                // Saat dropdown berubah di modal edit
                select.addEventListener('change', function() {
                    if (this.value === '16') {
                        container.style.display = 'block';
                        textarea.required = true;
                    } else {
                        container.style.display = 'none';
                        textarea.required = false;
                        textarea.value = '';
                    }
                });

                // Pastikan juga tampil sesuai data saat modal dibuka
                const modal = select.closest('.modal');
                if (modal) {
                    modal.addEventListener('shown.bs.modal', function() {
                        if (select.value === '16') {
                            container.style.display = 'block';
                        } else {
                            container.style.display = 'none';
                        }
                    });
                }
            });
        });
    </script>
@endpush

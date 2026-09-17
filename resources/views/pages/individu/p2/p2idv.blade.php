@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P2 Individu</h5>
        <form action="{{ route('idv-p2.store') }}" method="POST" class="mb-5">
            @csrf
            <div class="row">
                {{-- Kondisi Pekerjaan --}}
                <div class="col-md-6 mb-3">
                    <label for="kondisi_pekerjaan" class="form-label">
                        Kondisi Pekerjaan <span class="text-danger">*</span>
                    </label>
                    <select name="kondisi_pekerjaan" id="kondisi_pekerjaan" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Kondisi --</option>
                        <option value="1">Bersekolah</option>
                        <option value="2">Ibu Rumah Tangga</option>
                        <option value="3">Tidak Bekerja</option>
                        <option value="4">Sedang Mencari Pekerjaan</option>
                        <option value="5">Bekerja</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jsk" class="form-label">
                        Kepesertaan JSK <span class="text-danger">*</span>
                    </label>
                    <select name="jsk" id="jsk" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Status --</option>
                        <option value="1">Peserta</option>
                        <option value="2">Bukan Peserta</option>
                    </select>
                </div>

                {{-- Pekerjaan Utama --}}
                <div class="col-md-6 mb-3">
                    <label for="pekerjaan_utama" class="form-label">
                        Pekerjaan Utama <span class="text-danger">*</span>
                    </label>
                    <select name="pekerjaan_utama" id="pekerjaan_utama" class="form-control" required>
                        <option value="" selected disabled>-- Pilih Pekerjaan --</option>
                        <option value="1">Petani Pemilik Lahan</option>
                        <option value="2">Petani Penyewa</option>
                        <option value="3">Buruh Tani</option>
                        <option value="4">Nelayan Pemilik Kapal/Perahu</option>
                        <option value="5">Nelayan Penyewa Kapal/Perahu</option>
                        <option value="6">Buruh Nelayan</option>
                        <option value="7">Guru</option>
                        <option value="8">Guru Agama</option>
                        <option value="9">Pedagang</option>
                        <option value="10">Pengolahan/Industri</option>
                        <option value="11">PNS</option>
                        <option value="12">TNI</option>
                        <option value="13">Perangkat Desa</option>
                        <option value="14">Pegawai Kantor Desa</option>
                        <option value="15">TKI</option>
                        <option value="16">Lainnya</option>
                    </select>
                </div>

                {{-- Pekerjaan Lainnya (jika "Lainnya" dipilih) --}}
                <div class="col-md-6 mb-3" id="pekerjaan_lainnya_container" style="display:none;">
                    <label for="pekerjaan_lainnya" class="form-label">
                        Pekerjaan Lainnya
                    </label>
                    <textarea name="pekerjaan_lainnya" id="pekerjaan_lainnya" class="form-control" rows="2"></textarea>
                </div>

                {{-- JSK --}}

            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/idv-p1') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                {{-- <button type="submit" class="btn btn-primary">
                    Simpan Data
                </button> --}}
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
                <h6 class="m-0 font-weight-bold text-primary">Data Individu P2</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kondisi Pekerjaan</th>
                                <th>Pekerjaan Utama</th>
                                <th>Kepesertaan JSK </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $item->kondisi_pekerjaan_text }}
                                    </td>
                                    <td>
                                        {{ $item->pekerjaan_utama_text }}
                                    </td>
                                    <td>
                                        {{ $item->jsk_text }}
                                    </td>

                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditIndividuP2{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('idv-p2.destroy', $item->id) }}" method="POST"
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
            <div class="modal fade" id="modalEditIndividuP2{{ $item->id }}" aria-labelledby="modalEditP2Label"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data Individu P2</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ route('idv-p2.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    {{-- Kondisi Pekerjaan --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="kondisi_pekerjaan_{{ $item->id }}">Kondisi Pekerjaan <span
                                                class="text-danger">*</span></label>
                                        <select name="kondisi_pekerjaan" id="kondisi_pekerjaan_{{ $item->id }}"
                                            class="form-control" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="1"
                                                {{ $item->kondisi_pekerjaan == '1' ? 'selected' : '' }}>Bersekolah</option>
                                            <option value="2"
                                                {{ $item->kondisi_pekerjaan == '2' ? 'selected' : '' }}>Ibu Rumah Tangga
                                            </option>
                                            <option value="3"
                                                {{ $item->kondisi_pekerjaan == '3' ? 'selected' : '' }}>Tidak Bekerja
                                            </option>
                                            <option value="4"
                                                {{ $item->kondisi_pekerjaan == '4' ? 'selected' : '' }}>Sedang Mencari
                                                Pekerjaan</option>
                                            <option value="5"
                                                {{ $item->kondisi_pekerjaan == '5' ? 'selected' : '' }}>Bekerja</option>
                                        </select>
                                    </div>

                                    {{-- JSK --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="jsk_{{ $item->id }}">Kepesertaan JSK <span
                                                class="text-danger">*</span></label>
                                        <select name="jsk" id="jsk_{{ $item->id }}" class="form-control"
                                            required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="1" {{ $item->jsk == '1' ? 'selected' : '' }}>Peserta
                                            </option>
                                            <option value="2" {{ $item->jsk == '2' ? 'selected' : '' }}>Bukan Peserta
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Pekerjaan Utama --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="pekerjaan_utama_{{ $item->id }}">Pekerjaan Utama <span
                                                class="text-danger">*</span></label>
                                        <select name="pekerjaan_utama" id="pekerjaan_utama_{{ $item->id }}"
                                            class="form-control" required>
                                            <option value="">-- Pilih Pekerjaan --</option>
                                            <option value="1" {{ $item->pekerjaan_utama == '1' ? 'selected' : '' }}>
                                                Petani Pemilik Lahan</option>
                                            <option value="2" {{ $item->pekerjaan_utama == '2' ? 'selected' : '' }}>
                                                Petani Penyewa</option>
                                            <option value="3" {{ $item->pekerjaan_utama == '3' ? 'selected' : '' }}>
                                                Buruh Tani</option>
                                            <option value="4" {{ $item->pekerjaan_utama == '4' ? 'selected' : '' }}>
                                                Nelayan Pemilik Kapal/Perahu</option>
                                            <option value="5" {{ $item->pekerjaan_utama == '5' ? 'selected' : '' }}>
                                                Nelayan Penyewa Kapal/Perahu</option>
                                            <option value="6" {{ $item->pekerjaan_utama == '6' ? 'selected' : '' }}>
                                                Buruh Nelayan</option>
                                            <option value="7" {{ $item->pekerjaan_utama == '7' ? 'selected' : '' }}>
                                                Guru</option>
                                            <option value="8" {{ $item->pekerjaan_utama == '8' ? 'selected' : '' }}>
                                                Guru Agama</option>
                                            <option value="9" {{ $item->pekerjaan_utama == '9' ? 'selected' : '' }}>
                                                Pedagang</option>
                                            <option value="10" {{ $item->pekerjaan_utama == '10' ? 'selected' : '' }}>
                                                Pengolahan/Industri</option>
                                            <option value="11" {{ $item->pekerjaan_utama == '11' ? 'selected' : '' }}>
                                                PNS</option>
                                            <option value="12" {{ $item->pekerjaan_utama == '12' ? 'selected' : '' }}>
                                                TNI</option>
                                            <option value="13" {{ $item->pekerjaan_utama == '13' ? 'selected' : '' }}>
                                                Perangkat Desa</option>
                                            <option value="14" {{ $item->pekerjaan_utama == '14' ? 'selected' : '' }}>
                                                Pegawai Kantor Desa</option>
                                            <option value="15" {{ $item->pekerjaan_utama == '15' ? 'selected' : '' }}>
                                                TKI</option>
                                            <option value="16" {{ $item->pekerjaan_utama == '16' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                    </div>

                                    {{-- Pekerjaan Lainnya --}}
                                    <div class="col-md-6 mb-3" id="pekerjaan_lainnya_container_{{ $item->id }}"
                                        style="{{ $item->pekerjaan_utama == '16' ? '' : 'display:none;' }}">
                                        <label for="pekerjaan_lainnya_{{ $item->id }}">Pekerjaan Lainnya</label>
                                        <textarea name="pekerjaan_lainnya" id="pekerjaan_lainnya_{{ $item->id }}" class="form-control" rows="2">{{ $item->pekerjaan_lainnya }}</textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

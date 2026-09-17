@extends('layouts.app')

@section('content')
    <div class="container">
        <h5 class="mb-3">Form P4 Keluarga </h5>
        <form action="{{ route('kg-p4.store') }}" method="post" class="mb-5">
            @csrf
            <div class="row">
                {{-- Tempat tinggal --}}
                <div class="col-md-3 mb-3">
                    <label>Tempat Tinggal yang Ditempati<span class="text-danger">*</span></label>
                    <select name="tempat_tinggal_yg_ditempati" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Milik Sendiri</option>
                        <option value="2">Kontrak/Sewa</option>
                        <option value="3">Bebas Sewa</option>
                        <option value="4">Dipinjami</option>
                        <option value="5">Dinas</option>
                        <option value="6">Lainnya</option>
                    </select>
                </div>

                {{-- Status lahan --}}
                <div class="col-md-3 mb-3">
                    <label>Status Lahan Tempat Tinggal<span class="text-danger">*</span></label>
                    <select name="status_lahan_tempat_tinggal_yg_ditempati" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Milik Sendiri</option>
                        <option value="2">Milik Orang lain</option>
                        <option value="3">Tanah Negara</option>
                        <option value="4">Lainnya</option>
                    </select>
                </div>

                {{-- Luas lantai --}}
                <div class="col-md-3 mb-3">
                    <label>Luas Lantai Tempat Tinggal (m²)<span class="text-danger">*</span></label>
                    <input type="number" step="0.1" name="luas_lantai_ttl_terluas" class="form-control" required>
                </div>

                {{-- Luas lahan --}}
                <div class="col-md-3 mb-3">
                    <label>Luas Lahan Tempat Tinggal (m²)<span class="text-danger">*</span></label>
                    <input type="number" step="0.1" name="luas_lahan_ttl_terluas" class="form-control" required>
                </div>

                {{-- Jenis lantai --}}
                <div class="col-md-3 mb-3">
                    <label>Jenis Lantai<span class="text-danger">*</span></label>
                    <select name="jns_lantai_ttl_terluas" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Marmer/Granit</option>
                        <option value="2">Keramik</option>
                        <option value="3">Parket/Vinil/Permadani</option>
                        <option value="4">Ubin/Tegel/Teraso</option>
                        <option value="5">Kayu/Papan Kualitas Tinggi</option>
                        <option value="6">Semen/Bata Merah</option>
                        <option value="7">Bambu</option>
                        <option value="8">Kayu/Papan Kualitas Rendah</option>
                        <option value="9">Bambu</option>
                        <option value="10">Lainnya</option>
                    </select>
                </div>

                {{-- Dinding --}}
                <div class="col-md-3 mb-3">
                    <label>Dinding Sebagian Besar Rumah<span class="text-danger">*</span></label>
                    <select name="dinding_sebagian_besar_rumah" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Semen/Beton/Kayu Berkualitas Tinggi</option>
                        <option value="2">Kayu Berkualitas Rendah/Bambu</option>
                        <option value="3">Lainnya</option>
                    </select>
                </div>

                {{-- Jendela --}}
                <div class="col-md-3 mb-3">
                    <label>Kondisi Jendela<span class="text-danger">*</span></label>
                    <select name="jendela" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Ada - Berfungsi</option>
                        <option value="2">Ada - Tidak berfungsi</option>
                        <option value="3">Tidak ada</option>
                    </select>
                </div>

                {{-- Atap --}}
                <div class="col-md-3 mb-3">
                    <label>Atap<span class="text-danger">*</span></label>
                    <select name="atap" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Genteng</option>
                        <option value="2">Kayu/Jerami</option>
                        <option value="3">Lainnya</option>
                    </select>
                </div>

                {{-- Penerangan --}}
                <div class="col-md-3 mb-3">
                    <label>Penerangan Rumah<span class="text-danger">*</span></label>
                    <select name="penerangan_rumah" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Listrik PLN</option>
                        <option value="2">Listrik non PLN</option>
                        <option value="3">Lampu minyak/lilin</option>
                        <option value="4">Sumber Lain</option>
                        <option value="5">Tidak ada</option>
                    </select>
                </div>

                {{-- Energi Memasak --}}
                <div class="col-md-3 mb-3">
                    <label>Energi Untuk Memasak<span class="text-danger">*</span></label>
                    <select name="energi_untuk_memasak" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Gas Kota / LPG / Biogas</option>
                        <option value="2">Minyak Tanah / Batu Bara</option>
                        <option value="3">Kayu Bakar</option>
                        <option value="4">Lainnya</option>
                    </select>
                </div>

                {{-- Sumber Kayu Bakar --}}
                <div class="col-md-3 mb-3">
                    <label>Sumber Kayu Bakar<span class="text-danger">*</span></label>
                    <select name="sumber_kayu_bakar" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">Membeli</option>
                        <option value="2">Mencari di hutan</option>
                        <option value="3">Mencari di kebun</option>
                        <option value="4">Menerima bantuan</option>
                        <option value="5">Sisa industri</option>
                        <option value="6">Lainnya</option>
                    </select>
                </div>

                {{-- Tempat Pembuangan Sampah --}}
                <div class="col-md-3 mb-3">
                    <label>Tempat Pembuangan Sampah<span class="text-danger">*</span></label>
                    <select name="tempat_pembuangan_sampah" class="form-control" required>
                        <option value="" selected disabled>-- Pilih --</option>
                        <option value="1">TPS Desa</option>
                        <option value="2">Diangkut Petugas</option>
                        <option value="3">Dibakar</option>
                        <option value="4">Dibuang ke sungai</option>
                        <option value="5">Ditanam</option>
                        <option value="6">Lainnya</option>
                    </select>
                </div>

                {{-- Fasilitas MCK --}}
                <div class="col-md-3 mb-3">
                    <label>Fasilitas MCK<span class="text-danger">*</span></label>
                    <select name="fasilitas_mck" class="form-control" required>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">Pilihan {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Sumber Air Mandi --}}
                <div class="col-md-3 mb-3">
                    <label>Sumber Air Mandi<span class="text-danger">*</span></label>
                    <select name="sumber_air_mandi" class="form-control" required>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">Pilihan {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Fasilitas BAB --}}
                <div class="col-md-3 mb-3">
                    <label>Fasilitas BAB<span class="text-danger">*</span></label>
                    <select name="fasilitas_bab" class="form-control" required>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">Pilihan {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Sumber Air Minum --}}
                <div class="col-md-3 mb-3">
                    <label>Sumber Air Minum<span class="text-danger">*</span></label>
                    <select name="sumber_air_minum" class="form-control" required>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">Pilihan {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Limbah Cair --}}
                <div class="col-md-3 mb-3">
                    <label>Tempat Pembuangan Limbah Cair<span class="text-danger">*</span></label>
                    <select name="tmpt_pembuangan_limbah_cair" class="form-control" required>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">Pilihan {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Lokasi berbahaya --}}
                <div class="col-md-3 mb-3">
                    <label>Rumah Berada di Bawah SUTET?<span class="text-danger">*</span></label>
                    <select name="rumah_berada_dibawah" class="form-control" required>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Rumah di Bantaran Sungai?<span class="text-danger">*</span></label>
                    <select name="rumah_di_bantaran_sungai" class="form-control" required>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Rumah di Lereng Gunung?<span class="text-danger">*</span></label>
                    <select name="rumah_dilereng_bukit_gunung" class="form-control" required>
                        <option value="1">Ya</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>

                {{-- Kondisi rumah --}}
                <div class="col-md-12 mb-3">
                    <label>Secara Keseluruhan, Kondisi Rumah<span class="text-danger">*</span></label>
                    <textarea name="secara_keseluruhan_kondisi_rumah" class="form-control" rows="3" required></textarea>
                </div>

                {{-- Bantuan --}}
                {{-- <h5><b>Bantuan yang Pernah Diterima</b></h5> --}}

                @php
                    $bantuan = [
                        'blt_dana_desa' => 'BLT Dana Desa',
                        'pkh' => 'PKH',
                        'bst' => 'BST',
                        'banpres' => 'Banpres',
                        'bantuan_umkm' => 'UMKM',
                        'bantuan_pekerja' => 'Bantuan Pekerja',
                        'bantuan_anak' => 'Bantuan Anak',
                        'lainnya' => 'Lainnya',
                    ];
                @endphp

                @foreach ($bantuan as $field => $label)
                    <div class="col-md-3 mb-3">
                        <label>{{ $label }}<span class="text-danger">*</span></label>
                        <select name="{{ $field }}" class="form-control" required>
                            <option value="1">Ya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                @endforeach

            </div> <!-- row -->

            {{-- Tombol --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/kg-p2') }}" class="btn btn-secondary">← Kembali</a>

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

        <!-- Data Keluarga -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Keluarga P4</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tempat Tinggal Yang Di Tempati</th>
                                <th>Status Lahan Tempat Tinggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tmpt = [
                                    1 => 'Rumah Sendiri',
                                    2 => 'Kontrak/Sewa',
                                    3 => 'Bebas Sewa',
                                    4 => 'Dipinjami',
                                    5 => 'Rumah Dinas',
                                    6 => 'Lainnya',
                                ];

                                $statusLahan = [
                                    1 => 'Milik Sendiri',
                                    2 => 'Milik Orang Lain',
                                    3 => 'Tanah Negara',
                                    4 => 'Lainnya',
                                ];
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $tmpt[$item->tempat_tinggal_yg_ditempati] ?? '-' }}</td>
                                    <td>{{ $statusLahan[$item->status_lahan_tempat_tinggal_yg_ditempati] ?? '-' }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditKeluargaP4">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('kg-p4.destroy', $item->id) }}" method="POST"
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

        {{-- Modal Edit Keluarga P4 --}}
        <div class="modal fade" id="modalEditKeluargaP4" aria-labelledby="modalEditKeluargaLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKeluargaLabel">Edit Data Keluarga:
                            {{ $datap2->nama_kpl_keluarga }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($data as $item)
                            <form action="{{ route('kg-p4.update', $item->id) }}" method="POST">
                                @csrf @method('PUT')

                                <div class="row">
                                    {{-- Tempat Tinggal --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Tempat Tinggal yang Ditempati</label>
                                        <select name="tempat_tinggal_yg_ditempati" class="form-control" required>
                                            @foreach (['1' => 'Milik Sendiri', '2' => 'Kontrak/Sewa', '3' => 'Bebas Sewa', '4' => 'Dipinjami', '5' => 'Dinas', '6' => 'Lainnya'] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->tempat_tinggal_yg_ditempati == $key ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Status Lahan --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Status Lahan Tempat Tinggal</label>
                                        <select name="status_lahan_tempat_tinggal_yg_ditempati" class="form-control"
                                            required>
                                            @foreach (['1' => 'Milik Sendiri', '2' => 'Milik Orang lain', '3' => 'Tanah Negara', '4' => 'Lainnya'] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->status_lahan_tempat_tinggal_yg_ditempati == $key ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Luas Lantai --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Luas Lantai (m²)</label>
                                        <input type="number" step="0.1" name="luas_lantai_ttl_terluas"
                                            value="{{ $item->luas_lantai_ttl_terluas }}" class="form-control" required>
                                    </div>

                                    {{-- Luas Lahan --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Luas Lahan (m²)</label>
                                        <input type="number" step="0.1" name="luas_lahan_ttl_terluas"
                                            value="{{ $item->luas_lahan_ttl_terluas }}" class="form-control" required>
                                    </div>

                                    {{-- Jenis Lantai --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Jenis Lantai</label>
                                        <select name="jns_lantai_ttl_terluas" class="form-control" required>
                                            @foreach ([
                                                        '1' => 'Marmer/Granit',
                                                        '2' => 'Keramik',
                                                        '3' => 'Parket/Vinil/Permadani',
                                                        '4' => 'Ubin/Tegel/Teraso',
                                                        '5' => 'Kayu/Papan Kualitas Tinggi',
                                                        '6' => 'Semen/Bata Merah',
                                                        '7' => 'Bambu',
                                                        '8' => 'Kayu/Papan Kualitas Rendah',
                                                        '9' => 'Bambu',
                                                        '10' => 'Lainnya',
                                                    ] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->jns_lantai_ttl_terluas == $key ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Dinding --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Dinding Sebagian Besar Rumah</label>
                                        <select name="dinding_sebagian_besar_rumah" class="form-control" required>
                                            @foreach (['1' => 'Semen/Beton/Kayu Berkualitas Tinggi', '2' => 'Kayu Rendah/Bambu', '3' => 'Lainnya'] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->dinding_sebagian_besar_rumah == $key ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Jendela --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Kondisi Jendela</label>
                                        <select name="jendela" class="form-control" required>
                                            @foreach (['1' => 'Ada-Berfungsi', '2' => 'Ada-Tidak', '3' => 'Tidak Ada'] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->jendela == $key ? 'selected' : '' }}>{{ $val }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Atap --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Atap</label>
                                        <select name="atap" class="form-control" required>
                                            @foreach (['1' => 'Genteng', '2' => 'Kayu/Jerami', '3' => 'Lainnya'] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->atap == $key ? 'selected' : '' }}>{{ $val }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Penerangan --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Penerangan Rumah</label>
                                        <select name="penerangan_rumah" class="form-control" required>
                                            @foreach (['1' => 'Listrik PLN', '2' => 'Non PLN', '3' => 'Lampu minyak/lilin', '4' => 'Lainnya', '5' => 'Tidak ada'] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->penerangan_rumah == $key ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Energi Memasak --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Energi Masak</label>
                                        <select name="energi_untuk_memasak" class="form-control" required>
                                            @foreach (['1' => 'Gas/LPG', '2' => 'Minyak/Batubara', '3' => 'Kayu', '4' => 'Lainnya'] as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $item->energi_untuk_memasak == $key ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Sumber Kayu --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Sumber Kayu Bakar</label>
                                        <select name="sumber_kayu_bakar" class="form-control" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->sumber_kayu_bakar == $i ? 'selected' : '' }}>Pilihan
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- Tempat Sampah --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Tempat Pembuangan Sampah</label>
                                        <select name="tempat_pembuangan_sampah" class="form-control" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->tempat_pembuangan_sampah == $i ? 'selected' : '' }}>Pilihan
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- MCK --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Fasilitas MCK</label>
                                        <select name="fasilitas_mck" class="form-control" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->fasilitas_mck == $i ? 'selected' : '' }}>Pilihan
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- Air Mandi --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Sumber Air Mandi</label>
                                        <select name="sumber_air_mandi" class="form-control" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->sumber_air_mandi == $i ? 'selected' : '' }}>Pilihan
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- BAB --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Fasilitas BAB</label>
                                        <select name="fasilitas_bab" class="form-control" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->fasilitas_bab == $i ? 'selected' : '' }}>Pilihan
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- Air Minum --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Sumber Air Minum</label>
                                        <select name="sumber_air_minum" class="form-control" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->sumber_air_minum == $i ? 'selected' : '' }}>Pilihan
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- Limbah Cair --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Pembuangan Limbah Cair</label>
                                        <select name="tmpt_pembuangan_limbah_cair" class="form-control" required>
                                            @for ($i = 1; $i <= 6; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->tmpt_pembuangan_limbah_cair == $i ? 'selected' : '' }}>
                                                    Pilihan {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- Lokasi Berbahaya --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Rumah di bawah SUTET?</label>
                                        <select name="rumah_berada_dibawah" class="form-control" required>
                                            <option value="Ya"
                                                {{ $item->rumah_berada_dibawah == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak"
                                                {{ $item->rumah_berada_dibawah == 'Tidak' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Bantaran --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Rumah di bantaran sungai?</label>
                                        <select name="rumah_di_bantaran_sungai" class="form-control" required>
                                            <option value="1"
                                                {{ $item->rumah_di_bantaran_sungai == '1' ? 'selected' : '' }}>Ya</option>
                                            <option value="2"
                                                {{ $item->rumah_di_bantaran_sungai == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Lereng --}}
                                    <div class="col-md-3 mb-3">
                                        <label>Rumah di lereng bukit/gunung?</label>
                                        <select name="rumah_dilereng_bukit_gunung" class="form-control" required>
                                            <option value="1"
                                                {{ $item->rumah_dilereng_bukit_gunung == '1' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="2"
                                                {{ $item->rumah_dilereng_bukit_gunung == '2' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Kondisi Rumah --}}
                                    <div class="col-md-12 mb-3">
                                        <label>Kondisi Rumah Secara Keseluruhan</label>
                                        <textarea name="secara_keseluruhan_kondisi_rumah" class="form-control" rows="3" required>{{ $item->secara_keseluruhan_kondisi_rumah }}</textarea>
                                    </div>

                                    {{-- Bantuan --}}
                                    @php
                                        $bantuan = [
                                            'blt_dana_desa' => 'BLT Dana Desa',
                                            'pkh' => 'PKH',
                                            'bst' => 'BST',
                                            'banpres' => 'Banpres',
                                            'bantuan_umkm' => 'UMKM',
                                            'bantuan_pekerja' => 'Bantuan Pekerja',
                                            'bantuan_anak' => 'Bantuan Anak',
                                            'lainnya' => 'Lainnya',
                                        ];
                                    @endphp

                                    @foreach ($bantuan as $field => $label)
                                        <div class="col-md-3 mb-3">
                                            <label>{{ $label }}</label>
                                            <select name="{{ $field }}" class="form-control" required>
                                                <option value="1" {{ $item->$field == '1' ? 'selected' : '' }}>Ya
                                                </option>
                                                <option value="2" {{ $item->$field == '2' ? 'selected' : '' }}>Tidak
                                                </option>
                                            </select>
                                        </div>
                                    @endforeach

                                </div> {{-- row --}}

                                <button class="btn btn-primary mt-3">Simpan Perubahan</button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush

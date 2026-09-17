@extends('layouts.app')

@section('content')
    <div class="container">

        @if (!$surveyAktif || !$desaAktif->isEmpty())
            <button class="btn btn-primary mb-3" disabled>
                + Tambah Desa
            </button>
        @else
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalcoba">
                + Tambah Desa
            </button>
        @endif


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Desa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal Survey</th>
                                <th>Nama Desa</th>
                                <th>Tambah Data</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($desa as $d)
                                @php
                                    $disabled = !$surveyAktif || $d->id_survey != $surveyAktif->id;
                                @endphp

                                <tr>
                                    <td>
                                        @if ($d->survey)
                                            {{ \Carbon\Carbon::parse($d->survey->tgl_mulai)->format('d M Y') }}
                                            s/d
                                            {{ \Carbon\Carbon::parse($d->survey->tgl_akhir)->format('d M Y') }}
                                        @else
                                            <em>Tidak ada survey aktif</em>
                                        @endif
                                    </td>
                                    <td>{{ $d->nama_desa }}</td>
                                    <td>
                                        {{-- P3-P502 --}}
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    P3-P502
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p3') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P3
                                                        @if (\App\Models\Desa\P3\P3::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p3Pegawai') }}">
                                                        Pegawai
                                                        @if (
                                                            \App\Models\Desa\P3\PegawaiLainnya::whereHas('p3', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p3Bpd') }}">
                                                        BPD
                                                        @if (
                                                            \App\Models\Desa\P3\AnggotaBpd::whereHas('p3', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p4') }}">P4
                                                        @if (\App\Models\Desa\P4\P4::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p5') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P5
                                                        @if (\App\Models\Desa\P5\P5::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p501') }}">
                                                        Peraturan Desa
                                                        @if (
                                                            \App\Models\Desa\P5\P501::whereHas('p5', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p502') }}">
                                                        Peraturan KepDes
                                                        @if (
                                                            \App\Models\Desa\P5\P502::whereHas('p5', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- P503-P8 --}}
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    P503-P8
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p503') }}">
                                                        SK KepDes
                                                        @if (
                                                            \App\Models\Desa\P5\P503::whereHas('p5', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p601') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P601
                                                        @if (\App\Models\Desa\P6\P601::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p602') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P602
                                                        @if (\App\Models\Desa\P6\P602::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p603') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P603
                                                        @if (\App\Models\Desa\P6\P603::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p7') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P7
                                                        @if (\App\Models\Desa\P7\P7::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p705') }}">
                                                        P705
                                                        @if (
                                                            \App\Models\Desa\P7\P705::whereHas('p7', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p8') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P8
                                                        @if (\App\Models\Desa\P8\P8::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- P9-P10 --}}
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    P9-P10
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p9') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P9
                                                        @if (\App\Models\Desa\P9\P9::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p914') }}">
                                                        P914
                                                        @if (
                                                            \App\Models\Desa\P9\P914::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p923') }}">
                                                        P923
                                                        @if (
                                                            \App\Models\Desa\P9\P923::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p932') }}">
                                                        P932
                                                        @if (
                                                            \App\Models\Desa\P9\P932::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p941') }}">
                                                        P941
                                                        @if (
                                                            \App\Models\Desa\P9\P941::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ $disabled ? 'disabled-item' : '' }}"
                                                        style="{{ $disabled ? 'pointer-events:none; opacity:0.6;' : '' }}"
                                                        href="{{ url('/set-session/' . $d->id . '/p10') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P10
                                                        @if (\App\Models\Desa\P10\P10::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditDesa{{ $d->id }}" @disabled($disabled)>
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('desa-p2.destroy', $d->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm"@disabled($disabled)
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                        <a href="{{ url('/desa/export/pdf/' . $d->id_survey) }}"
                                            class="btn btn-danger btn-sm">
                                            <i class="fas fa-file-pdf"></i> Download PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalcoba" aria-labelledby="modalcobaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcobaLabel">Tambah Data Desa P2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('desa-p2.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Provinsi<span class="text-danger">*</span></label>
                                    <select id="cboprovinsi" class="form-control select2" onchange="ambilKab()"
                                        name="kode_provinsi" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Kabupaten<span class="text-danger">*</span></label>
                                    <select id="cbokabupaten" class="form-control select2" onchange="ambilKec()"
                                        name="kode_kabupaten" required>
                                        <option value="">-- Pilih Kabupaten --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Kecamatan<span class="text-danger">*</span></label>
                                    <select id="cbokecamatan" class="form-control select2" onchange="ambilDesa()"
                                        name="kode_kecamatan" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Kode Desa<span class="text-danger">*</span></label>
                                    <select id="cbodesa" class="form-control select2" name="kode_desa" required>
                                        <option value="">-- Pilih Desa --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Email Desa</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>URL Web</label>
                                    <input type="url" name="url_web" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Facebook</label>
                                    <input type="url" name="url_facebook" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Twitter</label>
                                    <input type="url" name="url_twitter" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Instagram</label>
                                    <input type="url" name="url_instagram" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Youtube</label>
                                    <input type="url" name="url_youtube" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Balai Desa<span class="text-danger">*</span></label>
                                    <select name="balai_desa" class="form-control shadow-sm" required>
                                        <option value="1">Ada Layak</option>
                                        <option value="2">Ada Tidak Layak</option>
                                        <option value="3">Tidak Ada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Kepemilikan<span class="text-danger">*</span></label>
                                    <select name="kepemilikan" class="form-control shadow-sm" required>
                                        <option value="1">Aset Desa</option>
                                        <option value="2">Bukan Aset Desa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Lokasi Balai Desa<span class="text-danger">*</span></label>
                                    <select name="lokasi_balai_desa" class="form-control shadow-sm" required>
                                        <option value="1">Di Dalam Desa</option>
                                        <option value="2">Di Luar Desa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Status Pemerintahan <span class="text-danger">*</span></label>
                                    <select name="status_pemerintahan" class="form-control shadow-sm" required>
                                        <option value="1">Desa</option>
                                        <option value="2">Nagari</option>
                                        <option value="3">Gampong</option>
                                        <option value="4">Kampung</option>
                                        <option value="5">Kelurahan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Jumlah RW<span class="text-danger">*</span></label>
                                    <input type="number" name="jml_rw" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Jumlah RT<span class="text-danger">*</span></label>
                                    <input type="number" name="jml_rt" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>No SK Pendirian Desa</label>
                                    <input type="text" name="no_sk_pendirian_desa" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Tgl SK Pendirian Desa<span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_sk_pendirian_desa" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>No SK Peta Desa</label>
                                    <input type="text" name="no_sk_peta_desa" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Tgl SK Peta Desa<span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_sk_peta_desa" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Luas Wilayah (Ha)<span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="luas_wilayah" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Lokasi Desa<span class="text-danger">*</span></label>
                                    <input type="text" name="lokasi_desa" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Topografi<span class="text-danger">*</span></label>
                                    <select name="topografi" class="form-control shadow-sm" required>
                                        <option value="" selected disabled>-- Pilih Topografi --</option>
                                        <option value="1">Lereng/Puncak</option>
                                        <option value="2">Lembah</option>
                                        <option value="3">Dataran</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Jumlah Warga di Lereng/Puncak<span class="text-danger">*</span></label>
                                    <input type="number" name="jml_warga" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Tempat Pemerintah Desa<span class="text-danger">*</span></label>
                                    <select name="tempat_pemerintah_desa" class="form-control shadow-sm" required>
                                        <option value="1">Kantor kepala desa/balai desa</option>
                                        <option value="2">Bukan Kantor kepala desa/balai desa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Jam Kerja</label>
                                    <select name="jam_kerja" class="form-control shadow-sm">
                                        <option value="1">Tidak Menentu</option>
                                        <option value="2">Ada Jadwal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label>Mulai Pukul <span class="text-danger">*</span></label>
                                <input type="time" name="mulai_pukul" class="form-control" required>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label>Akhir Pukul<span class="text-danger">*</span></label>
                                <input type="time" name="akhir_pukul" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Lintang<span class="text-danger">*</span></label>
                                    <input type="number" step="0.0000001" name="lintang" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Bujur<span class="text-danger">*</span></label>
                                    <input type="number" step="0.0000001" name="bujur" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Ketinggian Lokasi (m DPAL)</label>
                                    <input type="number" step="0.01" name="ketinggian_lok" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Panjang Garis Pantai (Km)</label>
                                    <input type="number" step="0.01" name="pjg_garis_pantai" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal Edit Desa --}}
    @foreach ($desa as $d)
        <div class="modal fade modal-edit" id="modalEditDesa{{ $d->id }}"
            aria-labelledby="modalEditDesaLabel{{ $d->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditDesaLabel{{ $d->id }}">Edit
                            Data Desa:
                            {{ $d->nama_desa }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('desa-p2.update', $d->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Provinsi</label>
                                        <select id="provinsi" class="select2 provinsi form-control" name="kode_provinsi"
                                            data-value="{{ $d->kode_provinsi }}">
                                            <option value="">-- Pilih Provinsi --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Kabupaten</label>
                                        <select id="kabupaten" class="form-control select2 kabupaten"
                                            name="kode_kabupaten" data-value="{{ $d->kode_kabupaten }}">
                                            <option value="">-- Pilih Kabupaten --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Kecamatan</label>
                                        <select id="kecamatan" class="form-control select2 kecamatan"
                                            name="kode_kecamatan" data-value="{{ $d->kode_kecamatan }}">
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Kode Desa</label>
                                        <select id="desa" class="form-control select2 desa" name="kode_desa"
                                            data-value="{{ $d->kode_desa }}">
                                            <option value="">-- Pilih Desa --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Email Desa</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $d->email }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>URL Web</label>
                                        <input type="url" name="url_web" class="form-control"
                                            value="{{ $d->url_web }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Facebook</label>
                                        <input type="url" name="url_facebook" class="form-control"
                                            value="{{ $d->url_facebook }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Twitter</label>
                                        <input type="url" name="url_twitter" class="form-control"
                                            value="{{ $d->url_twitter }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Instagram</label>
                                        <input type="url" name="url_instagram" class="form-control"
                                            value="{{ $d->url_instagram }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Youtube</label>
                                        <input type="url" name="url_youtube" class="form-control"
                                            value="{{ $d->url_youtube }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <!-- Status Pemerintahan -->
                                    <div class="mb-3">
                                        <label>Status Pemerintahan</label>
                                        <select name="status_pemerintahan" class="form-control shadow-sm">
                                            <option value="1"
                                                {{ $d->status_pemerintahan == '1' ? 'selected' : '' }}>
                                                Desa
                                            </option>
                                            <option value="2"
                                                {{ $d->status_pemerintahan == '2' ? 'selected' : '' }}>
                                                Nagari</option>
                                            <option value="3"
                                                {{ $d->status_pemerintahan == '3' ? 'selected' : '' }}>
                                                Gampong</option>
                                            <option value="4"
                                                {{ $d->status_pemerintahan == '4' ? 'selected' : '' }}>
                                                Kampung</option>
                                            <option value="5"
                                                {{ $d->status_pemerintahan == '5' ? 'selected' : '' }}>
                                                Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- Jumlah RW/RT -->
                                    <div class="mb-3">
                                        <label>Jumlah RW</label>
                                        <input type="number" name="jml_rw" class="form-control"
                                            value="{{ $d->jml_rw }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Jumlah RT</label>
                                        <input type="number" name="jml_rt" class="form-control"
                                            value="{{ $d->jml_rt }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- SK Pendirian Desa -->
                                    <div class="mb-3">
                                        <label>No SK Pendirian Desa</label>
                                        <input type="text" name="no_sk_pendirian_desa" class="form-control"
                                            value="{{ $d->no_sk_pendirian_desa }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Tgl SK Pendirian Desa</label>
                                        <input type="date" name="tgl_sk_pendirian_desa" class="form-control"
                                            value="{{ $d->tgl_sk_pendirian_desa }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <!-- SK Peta Desa -->
                                    <div class="mb-3">
                                        <label>No SK Peta Desa</label>
                                        <input type="text" name="no_sk_peta_desa" class="form-control"
                                            value="{{ $d->no_sk_peta_desa }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Tgl SK Peta Desa</label>
                                        <input type="date" name="tgl_sk_peta_desa" class="form-control"
                                            value="{{ $d->tgl_sk_peta_desa }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <!-- Informasi Wilayah -->
                                    <div class="mb-3">
                                        <label>Luas Wilayah (Ha)</label>
                                        <input type="number" step="0.01" name="luas_wilayah" class="form-control"
                                            value="{{ $d->luas_wilayah }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Lokasi Desa</label>
                                        <input type="text" name="lokasi_desa" class="form-control"
                                            value="{{ $d->lokasi_desa }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Topografi</label>
                                        <select name="topografi" class="form-control shadow-sm">
                                            <option value="1" {{ $d->topografi == '1' ? 'selected' : '' }}>
                                                Lereng/Puncak
                                            </option>
                                            <option value="2" {{ $d->topografi == '2' ? 'selected' : '' }}>Lembah
                                            </option>
                                            <option value="3" {{ $d->topografi == '3' ? 'selected' : '' }}>
                                                Dataran
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Jumlah Warga di Lereng/Puncak</label>
                                        <input type="number" name="jml_warga" class="form-control"
                                            value="{{ $d->jml_warga }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <!-- Fasilitas Desa -->
                                    <div class="mb-3">
                                        <label>Balai Desa</label>
                                        <select name="balai_desa" class="form-control shadow-sm">
                                            <option value="1" {{ $d->balai_desa == '1' ? 'selected' : '' }}>Ada
                                                Layak
                                            </option>
                                            <option value="2" {{ $d->balai_desa == '2' ? 'selected' : '' }}>Ada
                                                Tidak
                                                Layak</option>
                                            <option value="3" {{ $d->balai_desa == '3' ? 'selected' : '' }}>Tidak
                                                Ada
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Kepemilikan</label>
                                        <select name="kepemilikan" class="form-control shadow-sm">
                                            <option value="1" {{ $d->kepemilikan == '1' ? 'selected' : '' }}>Aset
                                                Desa
                                            </option>
                                            <option value="2" {{ $d->kepemilikan == '2' ? 'selected' : '' }}>
                                                Bukan Aset
                                                Desa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Lokasi Balai Desa</label>
                                        <select name="lokasi_balai_desa" class="form-control shadow-sm">
                                            <option value="1" {{ $d->lokasi_balai_desa == '1' ? 'selected' : '' }}>
                                                Di
                                                Dalam Desa</option>
                                            <option value="2" {{ $d->lokasi_balai_desa == '2' ? 'selected' : '' }}>
                                                Di
                                                Luar Desa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Tempat Pemerintah Desa</label>
                                        <select name="tempat_pemerintah_desa" class="form-control shadow-sm">
                                            <option value="1"
                                                {{ $d->tempat_pemerintah_desa == '1' ? 'selected' : '' }}>
                                                Kantor kepala desa/balai desa</option>
                                            <option value="2"
                                                {{ $d->tempat_pemerintah_desa == '2' ? 'selected' : '' }}>
                                                Bukan Kantor kepala desa/balai desa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Jam Kerja</label>
                                        <select name="jam_kerja" class="form-control shadow-sm">
                                            <option value="1" {{ $d->jam_kerja == '1' ? 'selected' : '' }}>Tidak
                                                Menentu
                                            </option>
                                            <option value="2" {{ $d->jam_kerja == '2' ? 'selected' : '' }}>Ada
                                                Jadwal
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label>Mulai Pukul<span class="text-danger">*</span></label>
                                    <input type="time" name="mulai_pukul" class="form-control"
                                        value="{{ $d->mulai_pukul }}">
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label>Akhir Pukul<span class="text-danger">*</span></label>
                                    <input type="time" name="akhir_pukul" class="form-control"
                                        value="{{ $d->akhir_pukul }}">
                                </div>

                                <div class="col-sm-6">
                                    <!-- Koordinat -->
                                    <div class="mb-3">
                                        <label>Lintang</label>
                                        <input type="number" step="0.0000001" name="lintang" class="form-control"
                                            value="{{ $d->lintang }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Bujur</label>
                                        <input type="number" step="0.0000001" name="bujur" class="form-control"
                                            value="{{ $d->bujur }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Ketinggian Lokasi (m DPAL)</label>
                                        <input type="number" step="0.01" name="ketinggian_lok" class="form-control"
                                            value="{{ $d->ketinggian_lok }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Panjang Garis Pantai (Km)</label>
                                        <input type="number" step="0.01" name="pjg_garis_pantai"
                                            class="form-control" value="{{ $d->pjg_garis_pantai }}">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        // === Validasi Dinamis ===
        function toggleRequired(condition, selector) {
            $(selector).prop('required', condition);
            if (condition) $(selector).closest('.mb-3').show();
            else $(selector).closest('.mb-3').hide();
        }

        // No SK Pendirian Desa → Tgl wajib diisi
        $('input[name="no_sk_pendirian_desa"]').on('input', function() {
            const hasValue = $(this).val().trim() !== '';
            toggleRequired(hasValue, 'input[name="tgl_sk_pendirian_desa"]');
        });

        // No SK Peta Desa → Tgl wajib diisi
        $('input[name="no_sk_peta_desa"]').on('input', function() {
            const hasValue = $(this).val().trim() !== '';
            toggleRequired(hasValue, 'input[name="tgl_sk_peta_desa"]');
        });

        // Topografi Lereng/Puncak → wajib isi Jumlah Warga
        $('select[name="topografi"]').on('change', function() {
            const isLereng = $(this).val() === '1';
            toggleRequired(isLereng, 'input[name="jml_warga"]');
        });

        // Jam kerja Ada Jadwal → wajib isi waktu mulai dan akhir
        $('select[name="jam_kerja"]').on('change', function() {
            const adaJadwal = $(this).val() === '2';
            toggleRequired(adaJadwal, 'input[name="mulai_pukul"]');
            toggleRequired(adaJadwal, 'input[name="akhir_pukul"]');
        });

        // === Trigger awal untuk sembunyikan field opsional ===
        toggleRequired(false, 'input[name="tgl_sk_pendirian_desa"]');
        toggleRequired(false, 'input[name="tgl_sk_peta_desa"]');
        toggleRequired(false, 'input[name="jml_warga"]');
        toggleRequired(false, 'input[name="mulai_pukul"]');
        toggleRequired(false, 'input[name="akhir_pukul"]');

        // {{-- Script untuk form tambah --}}
        $('#modalcoba').on('shown.bs.modal', function() {
            $(".select2").select2({
                width: '100%',
                dropdownParent: $('#modalcoba')
            });
            ambilProvinsi(); // load provinsi pertama kali
        });

        function ambilProvinsi() {
            //   $(".select2").select2({
            //     width: '100%',
            //     dropdownParent: $('#modalcoba')
            // });
            $.ajax({
                url: "{{ URL::to('provinces') }}",
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cboprovinsi").html(`<option value="">-- Pilih Salah Satu --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }

        function ambilKab() {
            let kodeProv = $("#cboprovinsi").val();
            if (kodeProv == "") {
                $("#cbokabupaten").html(`<option value="">-- Pilih Salah Satu --</option>`);
                return;
            }
            $.ajax({
                url: `{{ URL::to('kabupaten') }}/${kodeProv}`,
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cbokabupaten").html(`<option value="">-- Pilih Kabupaten --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }

        function ambilKec() {
            let kodeKab = $("#cbokabupaten").val();
            if (kodeKab == "") {
                $("#cbokabupaten").html(`<option value="">-- Pilih Salah Satu --</option>`);
                return;
            }
            $.ajax({
                url: `{{ URL::to('kecamatan') }}/${kodeKab}`,
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cbokecamatan").html(`<option value="">-- Pilih Kecamatan --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }

        function ambilDesa() {
            let kodeKec = $("#cbokecamatan").val();
            if (kodeKec == "") {
                $("#cbokecamatan").html(`<option value="">-- Pilih Salah Satu --</option>`);
                return;
            }
            $.ajax({
                url: `{{ URL::to('desa') }}/${kodeKec}`,
                method: "get",
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    let dt = "";
                    $.each(response, function(i, kolom) {
                        let kode = kolom.kode;
                        let nama = kolom.nama;
                        dt += `<option value="${kode}">${nama}</option>`;
                    });
                    $("#cbodesa").html(`<option value="">-- Pilih Desa --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }


        // {{-- Script untuk form edit --}}

        $(document).ready(function() {

            // Saat modal edit dibuka
            $('.modal-edit').on('shown.bs.modal', function() {
                let modal = $(this);
                modal.find(".select2").select2({
                    width: '100%',
                    dropdownParent: modal
                });
                let prov = modal.find('.provinsi');
                let kab = modal.find('.kabupaten');
                let kec = modal.find('.kecamatan');
                let des = modal.find('.desa');

                // Ambil kode yang tersimpan sebelumnya
                let valProv = prov.data('value');
                let valKab = kab.data('value');
                let valKec = kec.data('value');
                let valDes = des.data('value');

                // 1️⃣ Load Provinsi
                $.getJSON("/provinces", function(resProv) {
                    prov.empty().append('<option value="">-- Pilih Provinsi --</option>');
                    $.each(resProv, function(i, p) {
                        let selected = (p.kode == valProv) ? 'selected' : '';
                        prov.append(
                            `<option value="${p.kode}" ${selected}>${p.nama}</option>`
                        );
                    });

                    // Jika sudah ada provinsi lama → lanjut load kabupaten
                    if (valProv) {
                        loadKabupaten(valProv);
                    }
                });

                // 2️⃣ Fungsi load kabupaten
                function loadKabupaten(kodeProv) {
                    $.getJSON(`/kabupaten/${kodeProv}`, function(resKab) {
                        kab.empty().append(
                            '<option value="">-- Pilih Kabupaten --</option>');
                        $.each(resKab, function(i, k) {
                            let selected = (k.kode == valKab) ? 'selected' : '';
                            kab.append(
                                `<option value="${k.kode}" ${selected}>${k.nama}</option>`
                            );
                        });

                        if (valKab) {
                            loadKecamatan(valKab);
                        }
                    });
                }

                // 3️⃣ Fungsi load kecamatan
                function loadKecamatan(kodeKab) {
                    $.getJSON(`/kecamatan/${kodeKab}`, function(resKec) {
                        kec.empty().append(
                            '<option value="">-- Pilih Kecamatan --</option>');
                        $.each(resKec, function(i, kc) {
                            let selected = (kc.kode == valKec) ? 'selected' :
                                '';
                            kec.append(
                                `<option value="${kc.kode}" ${selected}>${kc.nama}</option>`
                            );
                        });

                        if (valKec) {
                            loadDesa(valKec);
                        }
                    });
                }

                // 4️⃣ Fungsi load desa
                function loadDesa(kodeKec) {
                    $.getJSON(`/desa/${kodeKec}`, function(resDes) {
                        des.empty().append(
                            '<option value="">-- Pilih Desa --</option>');
                        $.each(resDes, function(i, d) {
                            let selected = (d.kode == valDes) ? 'selected' : '';
                            des.append(
                                `<option value="${d.kode}" ${selected}>${d.nama}</option>`
                            );
                        });
                    });
                }

                // 5️⃣ Event jika user ubah pilihan
                prov.off().on('change', function() {
                    let kodeProv = $(this).val();
                    kab.empty().append('<option value="">-- Pilih Kabupaten --</option>');
                    kec.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                    des.empty().append('<option value="">-- Pilih Desa --</option>');
                    if (kodeProv) loadKabupaten(kodeProv);
                });

                kab.off().on('change', function() {
                    let kodeKab = $(this).val();
                    kec.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                    des.empty().append('<option value="">-- Pilih Desa --</option>');
                    if (kodeKab) loadKecamatan(kodeKab);
                });

                kec.off().on('change', function() {
                    let kodeKec = $(this).val();
                    des.empty().append('<option value="">-- Pilih Desa --</option>');
                    if (kodeKec) loadDesa(kodeKec);
                });
            });
        });
    </script>
@endpush

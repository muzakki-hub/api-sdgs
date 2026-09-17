@extends('layouts.app')

@section('content')
    <div class="container">


        <!-- Data individu -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Individu P1</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal Survey</th>
                                <th>Nama </th>
                                <th>NIK </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        @if ($item->survey)
                                            {{ \Carbon\Carbon::parse($item->survey->tgl_mulai)->format('d M Y') }}
                                            s/d
                                            {{ \Carbon\Carbon::parse($item->survey->tgl_akhir)->format('d M Y') }}
                                        @else
                                            <em>Tidak ada survey aktif</em>
                                        @endif
                                    </td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('idv-p1.destroy', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf @method('DELETE') <button type="submit" class="btn btn-danger btn-sm"
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
    </div>



    <div class="modal fade" id="modaltambahindividu" aria-labelledby="modaltambahindividuLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaltambahindividuLabel">Tambah Data individu P1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('idv-p1.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>No KK<span class="text-danger">*</span></label>
                                    <input type="number" name="no_kk" class="form-control"
                                        placeholder="Masukkan Nomer KK" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>NIK<span class="text-danger">*</span></label>
                                    <input type="number" name="nik" class="form-control"
                                        placeholder="Masukkan Nomer Induk Kependudukan" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Nama Lengkap<span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select id="jenis_kelamin" class="form-control" name="jenis_kelamin">
                                        <option value="" selected disabled>-- Pilih Opsi --</option>
                                        <option value="1">Laki Laki</option>
                                        <option value="2">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Status Pernikahan</label>
                                    <select id="status_pernikahan" class="form-control" name="status_pernikahan">
                                        <option value="" selected disabled>-- Pilih Opsi --</option>
                                        <option value="1">Kawin</option>
                                        <option value="2">Belum Kawin</option>
                                        <option value="3">Duda/Janda</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Agama</label>
                                    <select id="status_pernikahan" class="form-control" name="agama">
                                        <option value="" selected disabled>-- Pilih Opsi --</option>
                                        <option value="1">Islam</option>
                                        <option value="2">Kristen</option>
                                        <option value="3">Katholik</option>
                                        <option value="4">Hindu</option>
                                        <option value="5">Budha</option>
                                        <option value="6">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Suku Bangsa</label>
                                    <input type="text" name="suku_bangsa" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Warganegara</label>
                                    <select id="status_pernikahan" class="form-control" name="warganegara">
                                        <option value="" selected disabled>-- Pilih Opsi --</option>
                                        <option value="1">WNI</option>
                                        <option value="2">WNA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Nomer HP</label>
                                    <input type="number" name="no_hp" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Nomer Whatsapp</label>
                                    <input type="number" name="no_wa" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="url" name="url_email_pribadi" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Facebook</label>
                                    <input type="url" name="url_facebook_pribadi" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Twitter</label>
                                    <input type="url" name="url_twitter_pribadi" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label>Instagram</label>
                                    <input type="url" name="url_instagram_pribadi" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan individu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Individu P1 --}}
    @foreach ($data as $item)
        <div class="modal fade" id="modalEditindividu{{ $item->id }}" aria-labelledby="modalEditindividuLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditindividuLabel">
                            Edit Data Individu: {{ $item->nama }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <form action="{{ route('idv-p1.update', $item->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>No KK<span class="text-danger">*</span></label>
                                        <input type="number" name="no_kk" class="form-control"
                                            value="{{ $item->no_kk ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>NIK<span class="text-danger">*</span></label>
                                        <input type="number" name="nik" class="form-control"
                                            value="{{ $item->nik ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Nama Lengkap<span class="text-danger">*</span></label>
                                        <input type="text" name="nama" class="form-control"
                                            value="{{ $item->nama ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Jenis Kelamin</label>
                                        <select id="jenis_kelamin" class="form-control" name="jenis_kelamin">
                                            <option value="" disabled>-- Pilih Opsi --</option>
                                            <option value="1" {{ $item->jenis_kelamin == 1 ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="2" {{ $item->jenis_kelamin == 2 ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control"
                                            value="{{ $item->tempat_lahir ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" class="form-control"
                                            value="{{ $item->tgl_lahir ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Status Pernikahan</label>
                                        <select class="form-control" name="status_pernikahan">
                                            <option value="" disabled>-- Pilih Opsi --</option>
                                            <option value="1" {{ $item->status_pernikahan == 1 ? 'selected' : '' }}>
                                                Kawin</option>
                                            <option value="2" {{ $item->status_pernikahan == 2 ? 'selected' : '' }}>
                                                Belum Kawin</option>
                                            <option value="3" {{ $item->status_pernikahan == 3 ? 'selected' : '' }}>
                                                Janda/Duda</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Agama</label>
                                        <select class="form-control" name="agama">
                                            <option value="" disabled>-- Pilih Opsi --</option>
                                            <option value="1" {{ $item->agama == 1 ? 'selected' : '' }}>Islam
                                            </option>
                                            <option value="2" {{ $item->agama == 2 ? 'selected' : '' }}>Kristen
                                            </option>
                                            <option value="3" {{ $item->agama == 3 ? 'selected' : '' }}>Katholik
                                            </option>
                                            <option value="4" {{ $item->agama == 4 ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="5" {{ $item->agama == 5 ? 'selected' : '' }}>Budha
                                            </option>
                                            <option value="6" {{ $item->agama == 6 ? 'selected' : '' }}>Konghucu
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Suku Bangsa</label>
                                        <input type="text" name="suku_bangsa" class="form-control"
                                            value="{{ $item->suku_bangsa ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Warganegara</label>
                                        <select class="form-control" name="warganegara">
                                            <option value="" disabled>-- Pilih Opsi --</option>
                                            <option value="1" {{ $item->warganegara == 1 ? 'selected' : '' }}>WNI
                                            </option>
                                            <option value="2" {{ $item->warganegara == 2 ? 'selected' : '' }}>WNA
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Nomer HP</label>
                                        <input type="number" name="no_hp" class="form-control"
                                            value="{{ $item->no_hp ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Nomer Whatsapp</label>
                                        <input type="number" name="no_wa" class="form-control"
                                            value="{{ $item->no_wa ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="url" name="url_email_pribadi" class="form-control"
                                            value="{{ $item->url_email_pribadi ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Facebook</label>
                                        <input type="url" name="url_facebook_pribadi" class="form-control"
                                            value="{{ $item->url_facebook_pribadi ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Twitter</label>
                                        <input type="url" name="url_twitter_pribadi" class="form-control"
                                            value="{{ $item->url_twitter_pribadi ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Instagram</label>
                                        <input type="url" name="url_instagram_pribadi" class="form-control"
                                            value="{{ $item->url_instagram_pribadi ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">
                                Simpan Perubahan
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
@endpush

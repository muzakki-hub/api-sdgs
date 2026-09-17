@extends('layouts.app')

@section('content')

    <div class="container">
        <h5>Form P4 - Musyawarah Desa </h5>
        <form action="{{ route('desa-p4.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
            @csrf
            <!-- Bulan ke -->
            <div class="mb-3">
                <label>Bulan ke (Musyawarah Desa Tahun Sebelumnya)</label>
                <input type="text" name="bulan_ke" class="form-control" required maxlength="5" placeholder="Contoh: 03">
            </div>

            <!-- Agenda Musyawarah -->
            <div class="mb-3">
                <label>Agenda Musyawarah</label>
                <textarea id="agendaMus" name="agenda_musyawarah" class="form-control" required
                    placeholder="Jelaskan agenda musyawarah..."></textarea>
            </div>

            <div class="mb-3">
                <label>Tanggal Pelaksanaan Musyawarah</label>
                <input type="datetime-local" name="tgl_musyawarah" class="form-control" id="">
            </div>

            <!-- Dokumen/Foto Musyawarah Desa -->
            {{-- Foto --}}
            <div class="mb-3">
                <label for="fileUpload" class="font-weight-bold">Dokumen Musyawarah Desa (Foto)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="fileUpload" name="dokumen_musyawarah">
                    <label class="custom-file-label" for="fileUpload">Pilih file</label>
                </div>
            </div>

            {{-- ====== Tombol Aksi ====== --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/desa') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-primary">Simpan Musyawarah Desa</button>
            </div>


            <!-- Error validation jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Musyawarah Desa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Bulan Ke</th>
                                <th>Tanggal Pelaksanaan Musyawarah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->bulan_ke }}</td>
                                    <td>{{ $item->tgl_musyawarah }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-data"
                                            data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('desa-p4.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus Data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                        <button class="btn btn-sm btn-secondary" data-toggle="modal"
                                            data-id="{{ $item->id }}" data-target="#modalViewP4">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                {{-- Modal Edit Data --}}
                                <div class="modal fade" id="modalEditData{{ $item->id }}"
                                    aria-labelledby="modalEditDataLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditDataLabel{{ $item->id }}">Edit
                                                    Data P4</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('desa-p4.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')

                                                    <!-- Bulan ke -->
                                                    <div class="mb-3">
                                                        <label>Bulan ke (Musyawarah Desa Tahun Sebelumnya)</label>
                                                        <input type="text" name="bulan_ke" class="form-control" required
                                                            value="{{ $item->bulan_ke }}">
                                                    </div>

                                                    <!-- Agenda Musyawarah -->
                                                    <div class="mb-3">
                                                        <label>Agenda Musyawarah</label>
                                                        <textarea id="agendaMus" name="agenda_musyawarah" class="form-control" required>{{ base64_decode($item->agenda_musyawarah) }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Tanggal Pelaksanaan Musyawarah</label>
                                                        <input type="datetime-local" name="tgl_musyawarah"
                                                            class="form-control" value="{{ $item->tgl_musyawarah }}"
                                                            id="">
                                                    </div>

                                                    <!-- Dokumen/Foto Musyawarah Desa -->
                                                    <div class="mb-3">
                                                        <label for="fileUpload" class="font-weight-bold">Dokumen Musyawarah
                                                            Desa (Foto)</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="fileUpload"
                                                                name="dokumen_musyawarah"
                                                                value="{{ $item->dokumen_musyawarah }}">
                                                            <label class="custom-file-label" for="fileUpload">Pilih
                                                                file</label>
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
                                    <td colspan="6">Belum ada Data Musyawarah.</td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalViewP4" aria-labelledby="modalViewP4Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewP4Label">View Data P4</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="viewP4Content">
                        <p class="text-center text-muted">Memuat data...</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- STYLE INPUT FILE --}}
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("fileUpload").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })
    </script>
    <script>
        tinymce.init({
            selector: '#agendaMus',
            license_key: 'gpl',
            plugins: [
                'accordion', 'advlist', 'anchor', 'autolink', 'autosave',
                'charmap', 'code', 'codesample', 'directionality', 'emoticons',
                'fullscreen', 'help', 'image', 'importcss',
                'insertdatetime', 'link', 'lists', 'media', 'nonbreaking',
                'pagebreak', 'preview', 'quickbars', 'save', 'searchreplace', 'table',
                'visualblocks', 'visualchars', 'wordcount'
            ],
            toolbar: 'undo redo | accordion accordionremove | importword exportword exportpdf | math | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent | forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl',
            menubar: 'file edit view insert format tools table help',

            setup: function(editor) {
                // pastikan textarea terupdate saat form submit
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
    </script>
    {{-- Modal View --}}
    <script>
        $(document).on('click', '[data-target="#modalViewP4"]', function() {
            const id = $(this).data('id');
            $('#viewP4Content').html('<p class="text-center text-muted">Memuat data...</p>');
            // <h5> Dokumen Musyawarah </h5>
            // <img src="${data.dokumen_musyawarah}" alt="Foto Rusak" srcset="">
            $.ajax({
                url: `/desa-p4/${id}`,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    let fileInfo = data.file_exists ?
                        `<a href="${data.file_url}" target="_blank" class="btn btn-sm btn-success">
                      <i class="fas fa-file-pdf"></i> Lihat Dokumen Musyawarah
                   </a>` :
                        `<p class="text-danger">Dokumen musyawarah belum diunggah.</p>`;
                    $('#viewP4Content').html(`
                                <h5>Dokumen Musyawarah</h5>
                                ${fileInfo}
                                <br><br>
                                <h5>Agenda Musyawarah</h5>
                                ${atob(data.agenda_musyawarah)}      
                    `);
                },
                error: function() {
                    $('#viewP4Content').html(
                        '<p class="text-danger text-center">Gagal memuat data.</p>');
                }
            });
        });
    </script>
@endpush

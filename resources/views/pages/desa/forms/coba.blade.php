@extends('layouts.app')

@section('content')
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalcoba">
        + modal coba
    </button>

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
                                <label>Twitter</label>
                                <input type="url" name="url_twitter" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm">
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".select2").select2({
            width: '100%',
            theme: 'classic',
        });

        ambilProvinsi();

        function ambilProvinsi() {
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
                    $("#cbokabupaten").html(`<option value="">-- Pilih Salah Satu --</option>${dt}`);
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
                    $("#cbokecamatan").html(`<option value="">-- Pilih Salah Satu --</option>${dt}`);
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
                    $("#cbodesa").html(`<option value="">-- Pilih Salah Satu --</option>${dt}`);
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }
    </script>
@endsection

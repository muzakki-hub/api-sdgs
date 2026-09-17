<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Export Data SDGs Desa - RT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10.8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000 ;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        th {
            width: 10%;
            font-weight: normal;
        }

        td {
            width: 90%;
        }

        .box {
            border: 1px solid #000;
            padding: 6px;
            margin-top: 5px;
            min-height: 20px;
        }

        .empty-row th,
        .empty-row td {
            padding: 10px !important;
        }
    </style>
</head>

<body>

    @php

        class SafeData
        {
            private $data;

            public function __construct($data = [])
            {
                $this->data = is_object($data) ? (array) $data : (array) $data;
            }

            public function __get($name)
            {
                return $this->data[$name] ?? null;
            }
        }

        // Single object
        $p2 = new SafeData($data['p2'] ?? null);
        $p3 = new SafeData($data['p3'] ?? null);
        $p4 = new SafeData($data['p4'] ?? null);
        $p5 = new SafeData($data['p5'] ?? null);
        $p6 = new SafeData($data['p6'] ?? null);
        $p7 = new SafeData($data['p7'] ?? null);
        $p8 = new SafeData($data['p8'] ?? null);
        $p10 = new SafeData($data['p10'] ?? null);
        $p11 = new SafeData($data['p11'] ?? null);


        // Collection / array
        $p502 = $data['p502'] ?? [];
        $master_p502 = $data['master_p502'] ?? [];

        $p508 = $data['p508'] ?? [];
        $master_p508 = $data['master_p508'] ?? [];

        $p607 = $data['p607'] ?? [];
        $master_p607 = $data['master_p607'] ?? [];

        $p609 = $data['p609'] ?? [];
        $master_p609 = $data['master_p609'] ?? [];

        $p706 = $data['p706'] ?? [];
        $master_p706 = $data['master_p706'] ?? [];

        $p709 = $data['p709'] ?? [];
        $master_p709 = $data['master_p709'] ?? [];

        $p713 = $data['p713'] ?? [];
        $master_p713 = $data['master_p713'] ?? [];

        $p801 = $data['p801'] ?? [];
        $master_p801 = $data['master_p801'] ?? [];

        $p901 = $data['p901'] ?? [];
        $master_p901 = $data['master_p901'] ?? [];

        $p902 = $data['p902'] ?? [];
        $master_p902 = $data['master_p902'] ?? [];

        $p1004 = $data['p1004'] ?? [];

        $p1009 = $data['p1009'] ?? [];
        $master_p1009 = $data['master_p1009'] ?? [];

        $p1101 = $data['p1101'] ?? [];
        $master_p1101 = $data['master_p1101'] ?? [];

        $p1102 = $data['p1102'] ?? [];
        $master_p1102 = $data['master_p1102'] ?? [];

        $lokasi = json_decode($p2->lokasi_rt ?? '[]', true);

        $topografi_opt = [
            '1' => '1. lereng/puncak',
            '2' => '2. Lembah',
            '3' => '3. Dataran',
        ];

        $tanam_opt = [
            '1' => '1. Ada, sebagian warga terlibat',
            '2' => '2. Ada, warga tidak terlibat',
            '3' => '3. Tidak ada kegiatan',
        ];

        $ada_opt = ['1' => '1. Ada', '2' => '2. Tidak ada'];

        $kondisi_mangrove_opt = [
            '1' => '1. Seluruhnya baik',
            '2' => '2. Sebagian besar baik',
            '3' => '3. Sebagian besar buruk',
            '4' => '4. Seluruhnya buruk',
            '5' => '5. Tidak ada',
        ];

        $ketergantungan_opt = [
            '1' => '1. Tinggi',
            '2' => '2. Sedang',
            '3' => '3. Rendah',
            '4' => '4. Tidak tergantung',
        ];
    @endphp

    <table class="table table-bordered table-sm">
        <tr>
            <th><b>P1</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI ENUMERATOR</b></td>
        </tr>
        <tr>
            <th>P101</th>
            <td>Nama: {{ $user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>P102</th>
            <td>Alamat: {{ $user->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <th>P103</th>
            <td>HP/telepon: {{ $user->hp ?? '-' }}</td>
        </tr>
        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>

        {{-- DESKRIPSI LOKASI P2 --}}
        <tr>
            <th><b>P2</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI LOKASI</b></td>
        </tr>
        <tr>
            <th>P201</th>
            <td>Provinsi: {{ $p3->nama_provinsi ?? '-' }}</td>
        </tr>
        <tr>
            <th>P202</th>
            <td>Kabupaten/kota: {{ $p3->nama_kabupaten ?? '-' }}</td>
        </tr>
        <tr>
            <th>P203</th>
            <td>Kecamatan: {{ $p3->nama_kecamatan ?? '-' }}</td>
        </tr>
        <tr>
            <th>P204</th>
            <td>Desa: {{ $p3->nama_desa ?? '-' }}</td>
        </tr>
        <tr>
            <th>P205</th>
            <td>RT/RW: {{ $p2->rt ?? '-' }}/{{ $p2->rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P206</th>
            <td>Nama ketua RT: {{ $p4->nama_ket_rt ?? '-' ?? '-' }}</td>
        </tr>
        <tr>
            <th>P207</th>
            <td>Alamat: {{ $p4->alamat_ket_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P208</th>
            <td>HP/telepon: {{ $p4->hp_ket_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P209</th>
            <td>
                Lokasi RT terletak di pulau (sebutkan nama pulau):
                <div style="margin-top: 5px">
                    @foreach ($lokasi as $idx => $item)
                        <div>{{ $idx + 1 }}. {{ $item }}</div>
                    @endforeach
                </div>
            </td>
        </tr>
        <tr>
            <th>P210</th>
            <td>Topografi terluas wilayah RT: {{ $topografi_opt[$p2->topografi] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P211</th>
            <td>Jumlah warga di lereng/puncak (jiwa): {{ $p2->jlm_warga_puncak ?? '-' }}</td>
        </tr>
        <tr>
            <th></th>
            <td>Penanaman/pemeliharaan pepohonan di lahan kritis:
                {{ $tanam_opt[$p2->tanam_pohon_lahan_kritis] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P212</th>
            <td>Panjang garis pantai (km): {{ $p2->panjang_garis_pantai ?? '-' }}</td>
        </tr>
        <tr>
            <th>P213</th>
            <td>Pemanfaatan laut: <br /> <br /> 1. Perikanan tangkap: {{ $ada_opt[$p2->perikanan_tangkap] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P214</th>
            <td>2. perikanan budidaya: {{ $ada_opt[$p2->perikanan_budidaya] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P215</th>
            <td>3. tambak garam: {{ $ada_opt[$p2->tambak_garam] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P216</th>
            <td>4. wisata bahari: {{ $ada_opt[$p2->wisata_bahari] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P217</th>
            <td>5. transportasi umum: {{ $ada_opt[$p2->transportasi_umum] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P218</th>
            <td>Kondisi mangrove: {{ $kondisi_mangrove_opt[$p2->kondisi_mangrove] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P219</th>
            <td>Penanaman mangrove: {{ $tanam_opt[$p2->penanaman_mangrove] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P220</th>
            <td>Jumlah warga di wilayah pesisir (jiwa): {{ $p2->jlm_warga_pesisir ?? '-' }}</td>
        </tr>
        <tr>
            <th>P221</th>
            <td>Jumlah warga yang tinggal di atas air (jiwa): {{ $p2->jlm_warga_diatas_air ?? '-' }}</td>
        </tr>
        <tr>
            <th>P222</th>
            <td>Wilayah desa di dalam hutan (Ha): {{ $p2->wilayah_desa_dlm_hutan ?? '-' }}</td>
        </tr>
        <tr>
            <th>P223</th>
            <td>Wilayah desa di tepi hutan (Ha): {{ $p2->wilayah_desa_tepi_hutan ?? '-' }}</td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P224</th>
            <td>
                Fungsi hutan:<br>
                <table style="margin: 5px 0; border: none !important;">
                    <tr>
                        <td style="width: 100%; border: none; padding: 2px;">
                            1. konservasi (Ha): {{ $p2->fungsi_hutan_konservasi ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: none; padding: 2px;">
                            2. lindung (Ha): {{ $p2->fungsi_hutan_lindung ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: none; padding: 2px;">
                            3. produksi (Ha): {{ $p2->fungsi_hutan_produksi ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="border: none; padding: 2px;">
                            4. hutan desa (Ha): {{ $p2->fungsi_hutan_desa ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>P225</th>
            <td>Jumlah warga yang tinggal di dalam hutan (jiwa): {{ $p2->jlm_warga_dlm_hutan ?? '-' }}</td>
        </tr>
        <tr>
            <th>P226</th>
            <td>Jumlah warga yang tinggal di sekitar hutan (jiwa): {{ $p2->jlm_warga_sekitar_hutan ?? '-' }}</td>
        </tr>
        <tr>
            <th>P227</th>
            <td>Ketergantungan warga terhadap hutan: {{ $ketergantungan_opt[$p2->ketergantungan_hutan] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P228</th>
            <td>Reboisasi hutan: {{ $tanam_opt[$p2->reboisasi_hutan] ?? '-' }}</td>
        </tr>
        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>
        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>

        {{-- DESKRIPSI PENGURUS RW P3 --}}
        <tr>
            <th><b>P3</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI PENGURUS RW</b></td>
        </tr>
        <tr>
            <th>P301</th>
            <td>Nama Ketua RW (dan foto): {{ $p3->nama_ket_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P302</th>
            <td>NIK Ketua RW: {{ $p3->nik_ket_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P303</th>
            <td>HP/telepon: {{ $p3->hp_ket_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P304</th>
            <td>Menjabat Ketua RW sejak tahun:
                {{ isset($p3->tahun_jabat_ket_rw) ? date('Y', strtotime($p3->tahun_jabat_ket_rw)) : '-' }}</td>
        </tr>
        <tr>
            <th>P305</th>
            <td>Nama Sekretaris RW: {{ $p3->nama_sek_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P306</th>
            <td>NIK Sekretaris RW: {{ $p3->nik_sek_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P307</th>
            <td>HP/telepon: {{ $p3->hp_sek_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P308</th>
            <td>Menjabat Sekretaris RW sejak tahun:
                {{ isset($p3->tahun_jabat_sek_rw) ? date('Y', strtotime($p3->tahun_jabat_sek_rw)) : '-' }}</td>
        </tr>
        <tr>
            <th>P309</th>
            <td>Nama Bendahara RW: {{ $p3->nama_bend_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P310</th>
            <td>NIK Bendahara RW: {{ $p3->nik_bend_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P311</th>
            <td>HP/telepon: {{ $p3->hp_bend_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P312</th>
            <td>Menjabat Bendahara RW sejak tahun:
                {{ isset($p3->tahun_jabat_bend_rw) ? date('Y', strtotime($p3->tahun_jabat_bend_rw)) : '-' }}</td>
        </tr>
        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>

        {{-- DESKRIPSI PENGURUS RT P4 --}}
        <tr>
            <th><b>P4</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI PENGURUS RT</b></td>
        </tr>
        <tr>
            <th>P401</th>
            <td>Nama Ketua RT (dan foto): {{ $p4->nama_ket_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P402</th>
            <td>NIK Ketua RT: {{ $p4->nik_ket_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P403</th>
            <td>HP/telepon: {{ $p4->hp_ket_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P404</th>
            <td>Menjabat Ketua RT sejak tahun:
                {{ isset($p4->tahun_jabat_ket_rt) ? date('Y', strtotime($p4->tahun_jabat_ket_rt)) : '-' }}</td>
        </tr>
        <tr>
            <th>P405</th>
            <td>Nama Sekretaris RT: {{ $p4->nama_sek_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P406</th>
            <td>NIK Sekretaris RT: {{ $p4->nik_sek_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P407</th>
            <td>HP/telepon: {{ $p4->hp_sek_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P408</th>
            <td>Menjabat Sekretaris RT sejak tahun:
                {{ isset($p4->tahun_jabat_sek_rt) ? date('Y', strtotime($p4->tahun_jabat_sek_rt)) : '-' }}</td>
        </tr>
        <tr>
            <th>P409</th>
            <td>Nama Bendahara RT: {{ $p4->nama_bend_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P410</th>
            <td>NIK Bendahara RT: {{ $p4->nik_bend_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P411</th>
            <td>HP/telepon: {{ $p4->hp_bend_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P412</th>
            <td>Menjabat Bendahara RT sejak tahun:
                {{ isset($p4->tahun_jabat_bend_rt) ? date('Y', strtotime($p4->tahun_jabat_bend_rt)) : '-' }}</td>
        </tr>

        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>

        {{-- LEMBAGA EKONOMI P5 --}}
        <tr>
            <th><b>P5</b></th>
            <td style="width: 90% !important;"><b>LEMBAGA EKONOMI</b></td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P501</th>
            <td>
                Agen pengerahan TKI ke luar negeri:<br>
                1. Jumlah (perusahaan): {{ $p5->jml_pt_tki ?? '-' }}<br>
                2. Jumlah (orang): {{ $p5->jml_orang_tki ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P502</th>
            <td>
                Industri menurut bahan baku utama
                <table style="margin: 5px 0;">
                    <tr>
                        <th style="width: 35%;">Jenis industri</th>
                        <th style="width: 15%;">Jumlah industri kecil dan rumah tangga (pekerja di bawah 20 orang)</th>
                        <th style="width: 15%;">Jumlah industri sedang dan besar</th>
                        <th style="width: 15%;">Jumlah manajemen (orang)</th>
                        <th style="width: 20%;">Jumlah pekerja (orang)</th>
                    </tr>
                    @php

                        $p502Data = [];

                        foreach ($p502 as $item) {
                            $p502Data[$item->id_master_jenis_industri] = $item;
                        }
                    @endphp

                    @foreach ($master_p502 as $index => $master)
                        @php
                            $data = $p502Data[$master->id] ?? null;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}. {{ $master->jenis_industri }}</td>
                            <td style="text-align: center;">{{ $data->jml_industri_kecil ?? '-' }}</td>
                            <td style="text-align: center;">{{ $data->jml_industri_sedang ?? '-' }}</td>
                            <td style="text-align: center;">{{ $data->jml_menejemen ?? '-' }}</td>
                            <td style="text-align: center;">{{ $data->jml_pekerja ?? '-' }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <th>P503</th>
            <td>
                Tata ruang industri:<br>
                1. Jumlah sentra industri: {{ $p5->jml_sentra_industri ?? '-' }}<br>
                2. Jumlah Lingkungan Industri Kecil (LIK): {{ $p5->jml_lik ?? '-' }}<br>
                3. Jumlah Perkampungan Industri Kecil (PIK): {{ $p5->jml_pik ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>P504</th>
            <td>
                Keberadaan pub/diskotik/tempat karaoke:

                @if ($p5->ada_tempat_hiburan == '2')
                    2. Tidak Ada, terdekat {{ $p5->jarak_tempat_hiburan ?? '-' }} km
                @elseif ($p5->ada_tempat_hiburan == '1')
                    1. Ada
                @else
                    -
                @endif

            </td>
        </tr>
        <tr>
            <th>P505</th>
            <td>
                Pangkalan minyak tanah dan LPG:<br>

                1. Keberadaan pangkalan/agen/penjual minyak tanah (termasuk penjual minyak tanah eceran):
                @if ($p5->ada_pangkalan_minyak == '1')
                    1. Ada
                @elseif ($p5->ada_pangkalan_minyak == '2')
                    2. Tidak ada
                @else
                    -
                @endif
                <br>

                2. Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas eceran):
                @if ($p5->ada_pangkalan_lpg == '1')
                    1. Ada
                @elseif ($p5->ada_pangkalan_lpg == '2')
                    2. Tidak ada
                @else
                    -
                @endif

            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P506</th>
            <td>
                Keberadaan koperasi:<br>
                1. Jumlah KUD: {{ $p5->jml_kud ?? '-' }}<br>
                2. Jumlah KUD yang membeli/menjual hasil/produksi pertanian: {{ $p5->jml_kud_tani ?? '-' }}<br>
                3. Jumlah KUD yang menyediakan Kredit Usaha: {{ $p5->jml_kud_kredit ?? '-' }}<br>
                4. Jumlah KUD yang melakukan kegiatan lainnya: {{ $p5->jml_kud_lain ?? '-' }}<br>
                5. Jumlah Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro:
                {{ $p5->jml_kopinkra ?? '-' }}<br>
                6. Jumlah Koperasi Simpan Pinjam (Kospin): {{ $p5->jml_kospin ?? '-' }}<br>
                7. Jumlah Koperasi Serba usaha: {{ $p5->jml_koperasi_serbausaha ?? '-' }}<br>
                8. Jumlah koperasi lainnya: {{ $p5->jml_koperasi_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P507</th>
            <td>
                Kios sarana produksi petani/nelayan:<br>
                1. Milik KUD (unit): {{ $p5->kios_kud ?? '-' }}<br>
                2. Milik Bumdes (unit): {{ $p5->kios_bumdes ?? '-' }}<br>
                3. Milik selain KUD dan Bumdes: {{ $p5->kios_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P508</th>
            <td>
                Sarana ekonomi yang tersedia
                <table style="margin: 2px 0; border-collapse: collapse;">
                    <tr style="line-height: 1.1">
                        <th style="width: 30%; padding: 2px 3px;">
                            Jenis
                        </th>
                        <th style="width: 10%; padding: 2px 3px;">
                            Jumlah
                        </th>
                        <th style="width: 15%; padding: 2px 3px;">
                            Kondisi:
                            <ol style="margin: 2px 0; padding-left: 15px; font-size: 9px; line-height: 1.1">
                                <li>Baik</li>
                                <li>Buruk</li>
                                <li>Tidak berfungsi</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>
                        <th style="width: 15%; padding: 2px 3px;">
                            Jika Tidak Ada, jarak ke sarana terdekat (km)
                        </th>
                        <th style="width: 20%; padding: 2px 3px;">
                            Kemudahan untuk mencapai:
                            <ol style="margin: 2px 0; padding-left: 15px; font-size: 9px; line-height: 1.1">
                                <li>Sangat mudah</li>
                                <li>Mudah</li>
                                <li>Sulit</li>
                                <li>Sangat sulit</li>
                            </ol>
                        </th>
                    </tr>
                    @php
                        $p508Data = [];
                        foreach ($p508 as $item) {
                            $p508Data[$item->id_master_sarana_ekonomi] = $item;
                        }

                        $kondisi_opt = [
                            '1' => '1. Baik',
                            '2' => '2. Buruk',
                            '3' => '3. Tidak berfungsi',
                            '4' => '4. Tidak ada',
                        ];

                        $kemudahan_opt = [
                            '1' => '1. Sangat mudah',
                            '2' => '2. Mudah',
                            '3' => '3. Sulit',
                            '4' => '4. Sangat sulit',
                        ];

                    @endphp

                    @foreach ($master_p508 as $index => $master)
                        @php
                            $data = $p508Data[$master->id] ?? null;
                            $kondisi = $data->kondisi ?? null;
                            $jarak = $data->jarak_sarana ?? '-';
                            $kemudahan = $data->kemudahan_mencapai ?? null;
                        @endphp
                        <tr style="line-height: 1.1">
                            <td style="padding: 2px 3px;">{{ $index + 1 }}. {{ $master->sarana_ekonomi }}</td>
                            <td style="padding: 2px 3px; text-align: center;">{{ $data->jumlah ?? '-' }}</td>
                            <td style="padding: 2px 3px; text-align: center;">{{ $kondisi_opt[$kondisi] ?? '-' }}</td>
                            <td style="padding: 2px 3px; text-align: center;">{{ $kondisi == '4' ? $jarak : '-' }}</td>
                            <td style="padding: 2px 3px; text-align: center;">{{ $kemudahan_opt[$kemudahan] ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>

        <tr>
            <th style="width: 15%; vertical-align: top;">P509</th>
            <td>
                Fasilitas kredit<br>

                1. Kredit Usaha Rakyat (KUR):
                @if ($p5->kur == '1')
                    1. Ada
                @elseif ($p5->kur == '2')
                    2. Tidak
                @else
                    -
                @endif
                <br>

                2. Kredit Ketahanan Pangan dan Energi (KKP-E):
                @if ($p5->kkpe == '1')
                    1. Ada
                @elseif ($p5->kkpe == '2')
                    2. Tidak
                @else
                    -
                @endif
                <br>

                3. Kredit Usaha Kecil (KUK):
                @if ($p5->kuk == '1')
                    1. Ada
                @elseif ($p5->kuk == '2')
                    2. Tidak
                @else
                    -
                @endif
                <br>

                4. Kelompok Usaha Bersama (KUBE):
                @if ($p5->kube == '1')
                    1. Ada
                @elseif ($p5->kube == '2')
                    2. Tidak
                @else
                    -
                @endif

            </td>
        </tr>
        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>

        {{-- INFRASTRUKTUR P6 --}}
        <tr>
            <th><b>P6</b></th>
            <td style="width: 90% !important;"><b>INFRASTRUKTUR</b></td>
        </tr>
        <tr>
            <th>P601</th>
            <td>
                Penerangan di jalan utama:
                @php
                    $penerangan_opt = [
                        '1' => '1. Listrik diusahakan pemerintah',
                        '2' => '2. Listrik diusahakan non pemerintah',
                        '3' => '3. Non listrik',
                        '4' => '4. Tidak ada',
                    ];

                @endphp
                {{ $penerangan_opt[$p6->penerangan_jalan] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P602</th>
            <td>
                Prasarana transportasi antar RT:
                @php
                    $transport_opt = [
                        '1' => '1. Darat',
                        '2' => '2. Air',
                        '3' => '3. Darat dan air',
                        '4' => '4. Udara',
                    ];

                @endphp
                {{ $transport_opt[$p6->prasarana_transport_antar_rt] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P603</th>
            <td>
                Panjang jalan (km)<br>
                1. Jalan aspal: {{ $p6->pj_jalan_aspal ?? '-' }}<br>
                2. Jalan diperkeras (kerikil, batu, dll): {{ $p6->pj_jalan_kerikil ?? '-' }}<br>
                3. Jalan tanah: {{ $p6->pj_jalan_tanah ?? '-' }}<br>
                4. Jalan papan di atas air: {{ $p6->pj_jalan_papan ?? '-' }}<br>
                5. Jalan setapak: {{ $p6->pj_jalan_setapak ?? '-' }}<br>
                6. Jalan lainnya: {{ $p6->pj_jalan_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P604</th>
            <td>
                Jalan darat dapat dilakukan kendotor roda 4 atau lebih:
                @php
                    $akses_opt = [
                        '1' => '1. Sepanjang tahun',
                        '2' => '2. Sepanjang tahun kecuali saat tertentu (ketika hujan, pasang, dll)',
                        '3' => '3. Selama musim kemarau',
                        '4' => '4. Tidak dapat dilalui sepanjang tahun',
                    ];
                @endphp
                {{ $akses_opt[$p6->akses_jalan_roda_4] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P605</th>
            <td>
                Keberadaan angkutan umum<br>
                @php
                    $trayek_opt = [
                        '1' => '1. Trayek tetap',
                        '2' => '2. Tanpa trayek tetap',
                        '3' => '3. Tidak ada angkutan umum',
                    ];

                    $operasional_opt = [
                        '1' => '1. Setiap hari',
                        '2' => '2. Tidak setiap hari',
                    ];

                    $jam_opt = [
                        '1' => '1. Siang dan malam hari',
                        '2' => '2. Hanya siang hari',
                    ];

                @endphp
                1. Trayek angkutan umum: {{ $trayek_opt[$p6->angkutan_trayek] ?? '-' }}<br>
                2. Operasional angkutan umum: {{ $operasional_opt[$p6->angkutan_operasional] ?? '-' }}<br>
                3. Jam operasi angkutan umum: {{ $jam_opt[$p6->angkutan_jam_operasional] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P606</th>
            <td>
                Dermaga laut/sungai:
                @php
                    $dermaga_opt = [
                        '1' => '1. Ada, kondisi baik',
                        '2' => '2. Ada, kondisi buruk',
                        '3' => '3. Ada, tidak dapat berfungsi',
                        '4' => '4. Tidak ada',
                    ];
                @endphp
                {{ $dermaga_opt[$p6->dermaga] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P607</th>
            <td>
                Sinyal HP<br>
                1. Jumlah menara Base Transceiver Station (BTS): {{ $p6->jml_bts ?? '-' }}<br>
                2. Operator layanan komunikasi telepon seluler/handphone yang menjangkau wilayah:
                <table style="margin: 5px 0;">
                    <tr>
                        <th style="width: 25%;">Operator</th>

                        <th style="width: 25%;">
                            Sinyal di sebagian besar wilayah:
                            <ol style="margin: 4px 0; padding-left: 18px;">
                                <li>Sinyal sangat kuat</li>
                                <li>Sinyal kuat</li>
                                <li>Sinyal lemah</li>
                                <li>Tidak ada sinyal</li>
                            </ol>
                        </th>

                        <th style="width: 25%;">
                            Sinyal internet:
                            <ol style="margin: 4px 0; padding-left: 18px;">
                                <li>4G/LTE</li>
                                <li>3G/H/H+/EVDO</li>
                                <li>2.5G/E/GPRS</li>
                                <li>Tidak ada sinyal internet</li>
                            </ol>
                        </th>

                    </tr>
                    @php
                        $p607Data = [];
                        foreach ($p607 as $item) {
                            $p607Data[$item->id_master_operator_sinyal] = $item;
                        }

                        $sinyal_opt = [
                            '1' => '1.Sinyal sangat kuat',
                            '2' => '2.Sinyal kuat',
                            '3' => '3.Sinyal lemah',
                            '4' => '4.Tidak ada sinyal',
                        ];

                        $internet_opt = [
                            '1' => '1.4G/LTE',
                            '2' => '2.3G/H/H+/EVDO',
                            '3' => '3.2.5G/E/GPRS',
                            '4' => '4.Tidak ada sinyal internet',
                        ];
                    @endphp

                    @foreach ($master_p607 as $index => $master)
                        @php
                            $data = $p607Data[$master->id] ?? null;
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}. {{ $master->nama_operator }}</td>
                            <td style="text-align: center;">{{ $sinyal_opt[$data->jenis_sinyal_1 ?? ''] ?? '-' }}</td>
                            <td style="text-align: center;">{{ $internet_opt[$data->jenis_sinyal_2 ?? ''] ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>

        <tr>
            <th style="width: 15%; vertical-align: top;">P608</th>
            <td>
                @php
                    $kantor_pos_opt = [
                        '1' => '1. Beroperasi',
                        '2' => '2. Jarang beroperasi',
                        '3' => '3. Tidak beroperasi',
                        '4' => '4. Tidak ada',
                    ];
                    $layanan_opt = [
                        '1' => '1. Ada',
                        '2' => '2. Tidak ada',
                    ];
                @endphp
                1. Kantor pos/pos pembantu/rumah pos: {{ $kantor_pos_opt[$p6->kantor_pos] ?? '-' }}<br>
                2. Layanan pos keliling: {{ $layanan_opt[$p6->pos_keliling] ?? '-' }}<br>
                3. Perusahaan/agen jasa ekspedisi (pengiriman barang/dokumen) swasta:
                {{ $kantor_pos_opt[$p6->ekspedisi_swasta] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P609</th>
            <td>
                Program/siaran TV/radio yang diterima
                <table style="margin: 5px 0;">
                    <tr>
                        <th style="width: 25%;">Program/siaran TV dan radio</th>
                        <th style="width: 20%;">Apakah dapat diterima?<br>1. Ya 2. Tidak</th>
                        <th style="width: 30%;">Jika program/siaran dapat diterima, apakah harus menggunakan parabola/TV
                            kabel?<br>1. Ya 2. Tidak</th>
                    </tr>
                    @php
                        $p609Data = [];
                        foreach ($p609 as $item) {
                            $p609Data[$item->id_master_tv_radio] = $item;
                        }

                        $ya_tidak_opt = [
                            '1' => '1. Ya',
                            '2' => '2. Tidak',
                        ];
                    @endphp

                    @foreach ($master_p609 as $index => $master)
                        @php
                            $data = $p609Data[$master->id] ?? null;
                            $diterima = $data->diterima ?? null;
                            $parabola = $data->parabola ?? null;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}. {{ $master->program_tv_radio }}</td>
                            <td style="text-align: center;">{{ $ya_tidak_opt[$diterima] ?? '-' }}</td>
                            <td style="text-align: center;">
                                @if ($diterima == '1')
                                    {{ $ya_tidak_opt[$parabola] ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P610</th>
            <td>
                1. Jumlah lokasi permukiman liar: {{ $p6->jml_permukiman_liar ?? '-' }}<br>
                2. Jumlah fasilitas umum/fasilitas sosial yang ditinggali penduduk:<br>
                &nbsp;&nbsp;1. Pasar: {{ $p6->fasum_pasar ?? '-' }}<br>
                &nbsp;&nbsp;2. Stasiun: {{ $p6->fasum_stasiun ?? '-' }}<br>
                &nbsp;&nbsp;3. Terminal: {{ $p6->fasum_terminal ?? '-' }}<br>
                &nbsp;&nbsp;4. Kolong jembatan: {{ $p6->fasum_jembatan ?? '-' }}<br>
                &nbsp;&nbsp;5. Pelabuhan: {{ $p6->fasum_pelabuhan ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P611</th>
            <td>
                Jumlah lokasi permukiman khusus<br>
                1. permukiman/perumahan mewah: {{ $p6->jml_rumah_mewah ?? '-' }}<br>
                2. apartemen: {{ $p6->jml_apartemen ?? '-' }}<br>
                3. rumah susun: {{ $p6->jml_rusun ?? '-' }}<br>
                4. sekolah berasrama (boarding school): {{ $p6->jml_boarding_school ?? '-' }}<br>
                5. kos-kosan: {{ $p6->jml_kos ?? '-' }}<br>
                6. asrama/barak militer: {{ $p6->jml_asrama_militer ?? '-' }}<br>
                7. LP/Rutan: {{ $p6->jml_lapas ?? '-' }}
            </td>
        </tr>
        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>

        {{-- LINGKUNGAN DAN BENCANA ALAM P7 --}}
        <tr>
            <th><b>P7</b></th>
            <td style="width: 90% !important;"><b>LINGKUNGAN DAN BENCANA ALAM</b></td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P701</th>
            <td>
                Luas lahan menurut jenis penggunaan lahan (Ha)<br>
                1. Lahan sawah irigasi: {{ $p7->lhn_sawah_irigasi ?? '-' }}<br>
                2. Lahan sawah non irigasi (tadah hujan, pasang surut, rawa, dll):
                {{ $p7->lhn_sawah_nonirigasi ?? '-' }}<br>
                3. Kebun: {{ $p7->lhn_kebun ?? '-' }}<br>
                4. Huma/ladang: {{ $p7->lhn_huma ?? '-' }}<br>
                5. Tambak: {{ $p7->lhn_tambak ?? '-' }}<br>
                6. Kolam/tebat/empang: {{ $p7->lhn_kolam ?? '-' }}<br>
                7. Lahan gembala ternak: {{ $p7->lhn_gembala ?? '-' }}<br>
                8. Lahan perusahaan perkebunan: {{ $p7->lhn_perkebunan ?? '-' }}<br>
                9. Areal hutan: {{ $p7->lhn_hutan ?? '-' }}<br>
                10. Lahan pertanian non sawah lainnya: {{ $p7->lhn_non_sawah ?? '-' }}<br>
                11. Lahan pertambangan: {{ $p7->lhn_tambang ?? '-' }}<br>
                12. Lahan perumahan: {{ $p7->lhn_perumahan ?? '-' }}<br>
                13. Lahan perkantoran: {{ $p7->lhn_perkantoran ?? '-' }}<br>
                14. Lahan pertokoan: {{ $p7->lhn_pertokoan ?? '-' }}<br>
                15. Lahan industri: {{ $p7->lhn_industri ?? '-' }}<br>
                16. Fasilitas umum (lapangan, prasarana umum, jalan, dermaga, dll): {{ $p7->lhn_fasum ?? '-' }}<br>
                17. Lahan lainnya: {{ $p7->lhn_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P702</th>
            <td>
                Nama sungai yang melintasi:<br>
                @php
                    $sungai = json_decode($p7->nama_sungai, true) ?? [];
                    $sungai = is_array($sungai) ? $sungai : [];
                @endphp
                @if (count($sungai) > 0)
                    @foreach ($sungai as $index => $nama)
                        {{ $index + 1 }}. {{ $nama }}<br>
                    @endforeach
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>P703</th>
            <td>
                Nama danau/waduk/situ:<br>
                @php
                    $danau = json_decode($p7->nama_danau, true) ?? [];
                    $danau = is_array($danau) ? $danau : [];
                @endphp
                @if (count($danau) > 0)
                    @foreach ($danau as $index => $nama)
                        {{ $index + 1 }}. {{ $nama }}<br>
                    @endforeach
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>P704</th>
            <td>
                Jumlah mata air: {{ $p7->jml_mata_air ?? '-' }}
            </td>
        </tr>

        <tr>
            <th style="width: 15%; vertical-align: top;">P706</th>
            <td>
                Penggunaan sungai, saluran irigasi, danau/waduk/bendungan, dan embung
                <table style="margin: 5px 0; font-size: 9px; border-collapse: collapse;" border="1">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2" style="width: 20%;">Jenis Penggunaan</th>

                        <th colspan="2">Sungai</th>
                        <th colspan="2">Saluran irigasi</th>
                        <th colspan="2">
                            Danau/waduk/situ/<br>bendungan
                        </th>

                        <th colspan="2">Embung</th>
                    </tr>
                    <tr>
                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Digunakan</li>
                                <li>Tidak digunakan</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>

                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Kondisi Baik</li>
                                <li>Tercemar</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>

                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Digunakan</li>
                                <li>Tidak digunakan</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>

                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Kondisi Baik</li>
                                <li>Rusak</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>

                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Digunakan</li>
                                <li>Tidak digunakan</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>

                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Kondisi Baik</li>
                                <li>Tercemar</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>

                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Digunakan</li>
                                <li>Tidak digunakan</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>

                        <th>
                            <ol style="margin:0; padding-left:12px; font-size:8px;">
                                <li>Kondisi Baik</li>
                                <li>Rusak</li>
                                <li>Tidak ada</li>
                            </ol>
                        </th>
                    </tr>


                    @php
                        $p706Data = [];
                        foreach ($p706 as $item) {
                            $p706Data[$item->id_master_guna_sumber] = $item;
                        }

                        $opt_penggunaan = [
                            '1' => 'Digunakan',
                            '2' => 'Tidak digunakan',
                            '3' => 'Tidak ada',
                        ];

                        $opt_kondisi_baik_rusak = [
                            '1' => 'Kondisi Baik',
                            '2' => 'Rusak',
                            '3' => 'Tidak ada',
                        ];

                        $opt_kondisi_baik_tercemar = [
                            '1' => 'Kondisi Baik',
                            '2' => 'Tercemar',
                            '3' => 'Tidak ada',
                        ];
                    @endphp

                    @foreach ($master_p706 as $index => $master)
                        @php
                            $d = $p706Data[$master->id] ?? null;

                            // Sumber Sungai
                            $s_penggunaan = $d ? $opt_penggunaan[$d->sungai] ?? '-' : '-';
                            $s_kondisi = $d ? $opt_kondisi_baik_tercemar[$d->kondisi_sungai] ?? '-' : '-';

                            // Irigasi
                            $i_penggunaan = $d ? $opt_penggunaan[$d->saluran_irigasi] ?? '-' : '-';
                            $i_kondisi = $d ? $opt_kondisi_baik_rusak[$d->kondisi_saluran_irigasi] ?? '-' : '-';

                            // Danau / Waduk
                            $d_penggunaan = $d ? $opt_penggunaan[$d->danau] ?? '-' : '-';
                            $d_kondisi = $d ? $opt_kondisi_baik_tercemar[$d->kondisi_danau] ?? '-' : '-';

                            // Embung
                            $e_penggunaan = $d ? $opt_penggunaan[$d->embung] ?? '-' : '-';
                            $e_kondisi = $d ? $opt_kondisi_baik_rusak[$d->kondisi_embung] ?? '-' : '-';
                        @endphp

                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $master->jenis_penggunaan }}</td>

                            <td style="text-align: center;">{{ $s_penggunaan }}</td>
                            <td style="text-align: center;">{{ $s_kondisi }}</td>

                            <td style="text-align: center;">{{ $i_penggunaan }}</td>
                            <td style="text-align: center;">{{ $i_kondisi }}</td>

                            <td style="text-align: center;">{{ $d_penggunaan }}</td>
                            <td style="text-align: center;">{{ $d_kondisi }}</td>

                            <td style="text-align: center;">{{ $e_penggunaan }}</td>
                            <td style="text-align: center;">{{ $e_kondisi }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>

        <tr>
            <th style="width: 15%; vertical-align: top;">P707</th>
            <td>
                @php
                    $ya_tidak_opt = [
                        '1' => '1. Ya',
                        '2' => '2. Tidak',
                    ];

                    $lokasi_opt = [
                        '1' => '1. Dalam RT',
                        '2' => '2. Dalam RW',
                        '3' => '3. Dalam desa',
                        '4' => '4. Luar desa',
                    ];
                @endphp
                Jika ada pencemaran sungai/waduk/situ/bendungan:<br>
                1. Sumber limbah dari:<br>
                &nbsp;&nbsp;a. pabrik/industri/usaha: {{ $ya_tidak_opt[$p7->limbah_industri] ?? '-' }}<br>
                &nbsp;&nbsp;b. rumah tangga: {{ $ya_tidak_opt[$p7->limbah_rumah_tangga] ?? '-' }}<br>
                &nbsp;&nbsp;c. lainnya: {{ $ya_tidak_opt[$p7->limbah_lain] ?? '-' }}<br>
                2. Sumber limbah berlokasi di: {{ $lokasi_opt[$p7->lokasi_limbah] ?? '-' }}
            </td>
        </tr>

        <tr>
            <th style="width: 15%; vertical-align: top;">P709</th>
            <td>
                Pencemaran/polusi setahun terakhir
                <table style="margin: 5px 0; width: 100%; font-size: 9px; border-collapse: collapse;">

                    <tr>
                        <th style="width: 5%; text-align:center;">No</th>

                        <th style="width: 12%; text-align:center;">
                            Lingkungan
                        </th>

                        <th style="width: 12%; text-align:center; vertical-align: top;">
                            Pencemaran:<br>
                            1. Ada &nbsp;&nbsp; 2. Tidak
                        </th>

                        <th style="width: 28%; text-align:center; vertical-align: top;">
                            Sumber pencemaran:<br>
                            1. Pabrik/industri/usaha<br>
                            2. Rumah tangga<br>
                            3. Lainnya
                        </th>

                        <th style="width: 22%; text-align:center; vertical-align: top;">
                            Lokasi limbah:<br>
                            1. dalam RT &nbsp;&nbsp; 2. Dalam RW<br>
                            3. dalam desa &nbsp;&nbsp; 4. Luar desa
                        </th>

                        <th style="width: 12%; text-align:center; vertical-align: top;">
                            Pengaduan warga:<br>
                            1. Ada &nbsp;&nbsp; 2. Tidak
                        </th>
                    </tr>

                    @php
                        $p709Data = [];
                        foreach ($p709 as $item) {
                            $p709Data[$item->id_master_lingkungan] = $item;
                        }

                        $opt = [
                            '1' => '1. Ada',
                            '2' => '2. Tidak',
                        ];

                        $lokasi_opt = [
                            '1' => '1. Dalam RT',
                            '2' => '2. Dalam RW',
                            '3' => '3. dalam desa',
                            '4' => '4. Luar desa',
                        ];
                    @endphp

                    @foreach ($master_p709 as $index => $master)
                        @php
                            $data = $p709Data[$master->id] ?? null;
                        @endphp
                        <tr>
                            <td style="text-align:center;">{{ $index + 1 }}</td>

                            <td>{{ $master->jenis_lingkungan }}</td>

                            <td style="text-align:center;">
                                {{ $data && $data->pencemaran ? $opt[$data->pencemaran] ?? '-' : '-' }}
                            </td>

                            <td style="text-align:center;">
                                @php
                                    $src = [];
                                    if ($data && $data->sumber_pencemaran_pabrik == '1') {
                                        $src[] = 'Pabrik';
                                    }
                                    if ($data && $data->sumber_pencemaran_rumah_tangga == '1') {
                                        $src[] = 'RT';
                                    }
                                    if ($data && $data->sumber_pencemaran_lain == '1') {
                                        $src[] = 'Lainnya';
                                    }
                                @endphp
                                {{ count($src) ? implode(', ', $src) : '-' }}
                            </td>

                            <td style="text-align:center;">
                                {{ $data && $data->lokasi_limbah ? $lokasi_opt[$data->lokasi_limbah] ?? '-' : '-' }}
                            </td>

                            <td style="text-align:center;">
                                {{ $data && $data->pengaduan_warga ? $opt[$data->pengaduan_warga] ?? '-' : '-' }}
                            </td>
                        </tr>
                    @endforeach

                </table>
            </td>
        </tr>

        <tr>
            <th>P710</th>
            <td>
                @php
                    $kegiatan_opt = [
                        '1' => '1. Ada, sebagian warga terlibat',
                        '2' => '2. Ada, warga tidak terlibat',
                        '3' => '3. Tidak ada kegiatan',
                    ];
                @endphp
                Pengolahan/daur ulang sampah/limbah: {{ $kegiatan_opt[$p7->daur_ulang_sampah] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P711</th>
            <td>
                @php
                    $ada_tidak_opt = [
                        '1' => '1. Ada',
                        '2' => '2. Tidak ada',
                    ];
                @endphp
                Kebiasaan masyarakat membakar ladang/kebun di desa/kelurahan untuk proses usaha pertanian:
                {{ $ada_tidak_opt[$p7->bakar_ladang] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P712</th>
            <td>
                Keberadaan lokasi penggalian Golongan C (misalnya: batu kali, pasir, kapur, kaolin, pasir kuarsa, tanah
                liat, dll.): {{ $ada_tidak_opt[$p7->lokasi_penggalian_c] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P713</th>
            <td>
                Bencana alam setahun terakhir
                <table style="margin: 5px 0; font-size: 9px;">
                    <tr>
                        <th rowspan="1" style="width: 8%;">No</th>
                        <th rowspan="1" style="width: 15%;">Bencana alam</th>
                        <th rowspan="1" style="width: 12%;">
                            Kejadian:<br>
                            <ol style="margin:0; padding-left: 12px;">
                                <li>Ada</li>
                                <li>Tidak</li>
                            </ol>
                        </th>

                        <th style="width: 15%;">
                            Banyak kejadian<br>(jumlah)
                        </th>

                        <th style="width: 12%;">
                            Korban jiwa<br>(jiwa)
                        </th>

                        <th style="width: 12%;">
                            Pengungsi<br>(jiwa)
                        </th>

                        <th style="width: 15%;">
                            Warga terdampak<br>(jiwa)
                        </th>
                    </tr>

                    @php
                        $p713Data = [];
                        foreach ($p713 as $item) {
                            $p713Data[$item->id_master_bencana_alam] = $item;
                        }

                        $kejadian_opt = [
                            '1' => '1. Ada',
                            '2' => '2. Tidak',
                        ];
                    @endphp

                    @foreach ($master_p713 as $index => $master)
                        @php
                            $data = $p713Data[$master->id] ?? null;
                            $kejadian = $data->kejadian ?? null;
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $master->jenis_bencana }}</td>
                            <td style="text-align: center;">{{ $kejadian_opt[$kejadian] ?? '-' }}</td>
                            <td style="text-align: center;">
                                {{ $kejadian == '1' ? $data->jml_kejadian ?? '0' : '-' }}</td>
                            <td style="text-align: center;">
                                {{ $kejadian == '1' ? $data->korban_jiwa ?? '0' : '-' }}</td>
                            <td style="text-align: center;">{{ $kejadian == '1' ? $data->pengungsi ?? '0' : '-' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $kejadian == '1' ? $data->warga_terdampak ?? '0' : '-' }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>

        <tr>
            <th style="width: 15%; vertical-align: top;">P714</th>
            <td>
                @php
                    $fasilitas_opt = [
                        '1' => '1. Ada',
                        '2' => '2. Tidak ada',
                    ];
                    $tsunami_opt = [
                        '1' => '1. Bukan wilayah potensi tsunami',
                        '2' => '2. Ada',
                        '3' => '3. Tidak ada',
                    ];
                @endphp
                Fasilitas/upaya antisipasi/mitigasi bencana alam:<br>
                1. Sistem peringatan dini bencana alam: {{ $fasilitas_opt[$p7->sistem_peringatan_dini] ?? '-' }}<br>
                2. Sistem peringatan dini khusus tsunami: {{ $tsunami_opt[$p7->sistem_tsunami] ?? '-' }}<br>
                3. Perlengkapan keselamatan (perahu karet, tenda, masker, dll.):
                {{ $fasilitas_opt[$p7->perlengkapan_keselamatan] ?? '-' }}<br>
                4. Rambu–rambu dan jalur evakuasi bencana: {{ $fasilitas_opt[$p7->rambu_jalur_evakuasi] ?? '-' }}<br>
                5. Pembuatan/perawatan/normalisasi: sungai, kanal, tanggul, parit, drainase, waduk, pantai, dll:
                {{ $fasilitas_opt[$p7->normalisasi_sumber_air] ?? '-' }}
            </td>
        </tr>
        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>



        {{-- PENDIDIKAN P8 --}}
        <tr>
            <th><b>P8</b></th>
            <td style="width: 90% !important;"><b>PENDIDIKAN</b></td>
        </tr>

        <tr>
            <th style="width: 15%; vertical-align: top;">P801</th>
            <td>
                Keberadaan sarana pendidikan
                <table style="margin: 5px 0; font-size: 8px;">
                    <tr>
                        <th style="width: 15%;">Jenjang</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 10%;">Pemilik:<br>1. Negeri 2. Swasta</th>
                        <th style="width: 12%;">Kondisi bangunan<br>1. Layak 2. Rusak</th>
                        <th style="width: 12%;">Guru (jiwa)</th>
                        <th style="width: 12%;">Murid (jiwa)</th>
                        <th style="width: 11%;">Pegawai lain (jiwa)</th>
                    </tr>

                    @php
                        // Group data by jenjang pendidikan
                        $p801Grouped = [];
                        foreach ($p801 as $item) {
                            $jenjang =
                                $item->jenjang_pendidikan ??
                                ($master_p801->where('id', $item->id_master_pendidikan)->first()->jenjang_pendidikan ??
                                    'Lainnya');

                            if (!isset($p801Grouped[$jenjang])) {
                                $p801Grouped[$jenjang] = [];
                            }
                            $p801Grouped[$jenjang][] = $item;
                        }

                        $pemilik_opt = ['1' => '1. Negeri', '2' => '2. Swasta'];
                        $kondisi_opt = ['1' => '1. Layak', '2' => '2. Rusak'];
                        $jenjangCounter = 1;
                    @endphp

                    @foreach ($master_p801 as $master)
                        @php
                            $jenjang = $master->jenjang_pendidikan;
                            $items = $p801Grouped[$jenjang] ?? [];
                            $rowspan = count($items) > 0 ? count($items) : 1;
                        @endphp

                        {{-- Jika ADA data --}}
                        @if (count($items) > 0)
                            @foreach ($items as $i => $data)
                                <tr>
                                    @if ($i === 0)
                                        <td rowspan="{{ $rowspan }}">
                                            {{ $jenjangCounter++ }}. {{ $jenjang }}
                                        </td>
                                    @endif

                                    <td>{{ $i + 1 }} . {{ $data->nama_pendidikan ?? '' }}</td>
                                    <td style="text-align: center;">
                                        {{ $pemilik_opt[$data->pemilik ?? ''] ?? '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $kondisi_opt[$data->kondisi_bangunan ?? ''] ?? '' }}
                                    </td>
                                    <td style="text-align: center;">{{ $data->jml_guru ?? '-' }}</td>
                                    <td style="text-align: center;">{{ $data->jml_murid ?? '-' }}</td>
                                    <td style="text-align: center;">{{ $data->jml_pegawai ?? '-' }}</td>
                                </tr>
                            @endforeach

                            {{-- Jika TIDAK ADA data --}}
                        @else
                            <tr>
                                <td rowspan="1">{{ $jenjangCounter++ }}. {{ $jenjang }}</td>

                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                            </tr>
                        @endif
                    @endforeach

                </table>
            </td>
        </tr>

        <tr>
            <th>P802</th>
            <td>
                @php
                    $ada_tidak_opt = [
                        '1' => '1. Ada',
                        '2' => '2. Tidak ada',
                    ];
                @endphp
                Perpustakaan/taman bacaan: {{ $ada_tidak_opt[$p8->perpustakaan_taman_bacaan] ?? '-' }}
            </td>
        </tr>


        <tr class="empty-row">
            <th></th>
            <td></td>
        </tr>

        {{-- KESEHATAN P9 --}}
        <tr>
            <th><b>P9</b></th>
            <td style="width: 90% !important;"><b>KESEHATAN</b></td>
        </tr>
        <tr>
            <th style="width: 15%; vertical-align: top;">P901</th>
            <td>
                Keberadaan sarana kesehatan
                <table style="margin: 5px 0; font-size: 8px;">
                    <tr>
                        <th style="width: 15%;">Jenjang</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 10%;">Pemilik:<br>1. Negeri 2. Swasta</th>
                        <th style="width: 10%;">Dokter (jiwa)</th>
                        <th style="width: 10%;">Bidan (jiwa)</th>
                        <th style="width: 12%;">Tenaga Kesehatan (jiwa)</th>
                        <th style="width: 10%;">Pegawai lain (jiwa)</th>
                    </tr>

                    @php
                        // Group data by jenjang kesehatan
                        $p901Grouped = [];
                        foreach ($p901 as $item) {
                            $jenjang =
                                $master_p901->where('id', $item->id_master_kesehatan)->first()->jenjang_kesehatan ??
                                'Lainnya';
                            if (!isset($p901Grouped[$jenjang])) {
                                $p901Grouped[$jenjang] = [];
                            }
                            $p901Grouped[$jenjang][] = $item;
                        }

                        $pemilik_opt = ['1' => '1. Negeri', '2' => '2. Swasta'];
                        $jenjangCounter = 1;
                    @endphp

                    @foreach ($master_p901 as $master)
                        @php
                            $jenjang = $master->jenjang_kesehatan;
                            $items = $p901Grouped[$jenjang] ?? [];
                            $rowspan = count($items) > 0 ? count($items) : 1;
                        @endphp


                        @if (count($items) > 0)
                            @foreach ($items as $i => $data)
                                <tr>
                                    @if ($i === 0)
                                        <td rowspan="{{ $rowspan }}">
                                            {{ $jenjangCounter++ }}. {{ $jenjang }}
                                        </td>
                                    @endif

                                    <td>{{ $i + 1 }} . {{ $data->nama_sarana ?? '' }}</td>
                                    <td style="text-align: center;">
                                        {{ $pemilik_opt[$data->pemilik ?? ''] ?? '' }}
                                    </td>
                                    <td style="text-align: center;">{{ $data->jml_dokter ?? '-' }}</td>
                                    <td style="text-align: center;">{{ $data->jml_bidan ?? '-' }}</td>
                                    <td style="text-align: center;">{{ $data->jml_tenaga_kesehatan ?? '-' }}</td>
                                    <td style="text-align: center;">{{ $data->jml_pegawai_lain ?? '-' }}</td>
                                </tr>
                            @endforeach

                            {{-- Jika TIDAK ADA data --}}
                        @else
                            <tr>
                                <td rowspan="1">{{ $jenjangCounter++ }}. {{ $jenjang }}</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>

            <tr>
        <th style="width: 15%; vertical-align: top;">P902</th>
        <td>
            Kejadian Luar Biasa (KLB) setahun terakhir
            <table style="margin: 5px 0; font-size: 9px;">
                <tr>
                    <th style="width: 25%;">Jenis</th>
                    <th style="width: 15%;">Kejadian:<br>1. Ada 2. Tidak ada</th>
                    <th style="width: 20%;">Jumlah penderita</th>
                    <th style="width: 20%;">Jumlah meninggal</th>
                </tr>

                @php
                    // Group data by jenis KLB
                    $p902Data = [];
                    foreach ($p902 as $item) {
                        $p902Data[$item->id_master_klb] = $item;
                    }

                    $kejadian_opt = ['1' => '1. Ada', '2' => '2. Tidak ada'];
                @endphp

                @foreach ($master_p902 as $index => $master)
                    @php
                        $data = $p902Data[$master->id] ?? null;
                        $kejadian = $data->kejadian ?? null;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}. {{ $master->jenis_klb }}</td>
                        <td style="text-align: center;">{{ $kejadian_opt[$kejadian] ?? '-' }}</td>
                        <td style="text-align: center;">
                            @if($kejadian == '1')
                                {{ $data->jml_penderita ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($kejadian == '1')
                                {{ $data->jml_meninggal ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>

        <tr class="empty-row">
        <th></th>
        <td></td>
    </tr>

    {{-- AGAMA SOSIAL BUDAYA P10 --}}
    <tr>
        <th><b>P10</b></th>
        <td style="width: 90% !important;"><b>AGAMA SOSIAL BUDAYA</b></td>
    </tr>
    <tr>
        <th>P1001</th>
        <td>
            Jumlah warga peserta jaminan sosial kesehatan (jiwa): {{ $p10->peserta_jamkes ?? '-' }}
        </td>
    </tr>
    <tr>
        <th>P1002</th>
        <td>
            Jumlah warga peserta jaminan sosial ketenagakerjaan (jiwa): {{ $p10->peserta_jamkerja ?? '-' }}
        </td>
    </tr>
    <tr>
        <th style="width: 15%; vertical-align: top;">P1003</th>
        <td>
            Tempat ibadah (jumlah)
            <table style="margin: 5px 0; border: none;">
                <tr>
                    <td style="border: none; padding: 2px; width: 50%;">
                        1. Masjid: {{ $p10->jml_masjid ?? '-' }}<br>
                        2. Musala/surau/langgar: {{ $p10->jml_musala ?? '-' }}<br>
                        3. Gereja Kristen: {{ $p10->jml_gereja_kristen ?? '-' }}<br>
                        4. Gereja Katolik: {{ $p10->jml_gereja_katolik ?? '-' }}<br>
                        5. Kapel: {{ $p10->jml_kapel ?? '-' }}
                    </td>
                    <td style="border: none; padding: 2px; width: 50%;">
                        6. Pura: {{ $p10->jml_pura ?? '-' }}<br>
                        7. Wihara: {{ $p10->jml_wihara ?? '-' }}<br>
                        8. Kelenteng: {{ $p10->jml_kelenteng ?? '-' }}<br>
                        9. Lainnya: {{ $p10->jml_lain_tempat_ibadah ?? '-' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

        <tr>
        <th style="width: 15%; vertical-align: top;">P1004</th>
        <td>
            Keberadaan lembaga keagamaan
            <table style="margin: 5px 0; font-size: 9px;">
                <tr>
                    <th style="width: 25%;">Nama</th>
                    <th style="width: 15%;">Jumlah pengurus (jiwa)</th>
                    <th style="width: 15%;">Jumlah anggota (jiwa)</th>
                    <th style="width: 45%;">Fasilitas:<br>1. Ada, baik 2. Ada, rusak sedang 3. Ada, rusak parah 4. Tidak ada</th>
                </tr>

                @php
                    $fasilitas_opt = [
                        '1' => '1. Ada, baik',
                        '2' => '2. Ada, rusak sedang',
                        '3' => '3. Ada, rusak parah',
                        '4' => 'Tidak ada'
                    ];
                @endphp

                @foreach ($p1004 as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}. {{ $data->nama_lembaga ?? '' }}</td>
                        <td style="text-align: center;">{{ $data->jml_pengurus ?? '-' }}</td>
                        <td style="text-align: center;">{{ $data->jml_anggota ?? '-' }}</td>
                        <td style="text-align: center;">{{ $fasilitas_opt[$data->fasilitas ?? ''] ?? '' }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>

        <tr>
        <th>P1005</th>
        <td>
            Situs cagar budaya (sebutkan)<br>
            @php
                $cagar_budaya = json_decode($p10->cagar_budaya, true) ?? [];
            @endphp
            @foreach($cagar_budaya as $index => $item)
                {{ $index + 1 }}. {{ $item }}<br>
            @endforeach
            @if(count($cagar_budaya) == 0)
                1. ...... 2. ...... 3. ......
            @endif
        </td>
    </tr>
    <tr>
        <th>P1006</th>
        <td>
            Keberadaan suku terasing<br>
            1. perkiraan jumlah keluarga: {{ $p10->jml_keluarga_suku_terasing ?? '-' }}<br>
            2. perkiraan jumlah jiwa: {{ $p10->jml_jiwa_suku_terasing ?? '-' }}
        </td>
    </tr>
    <tr>
        <th>P1007</th>
        <td>
            Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/ bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun-alun, taman, dll.):<br>
            @php
                $ruang_publik_opt = [
                    '1' => '1. Ada, dikelola',
                    '2' => '2. Ada, tidak dikelola',
                    '3' => '3. Tidak ada'
                ];
            @endphp
            {{ $ruang_publik_opt[$p10->ruang_publik_terbuka] ?? '-' }}
        </td>
    </tr>
    <tr>
        <th style="width: 15%; vertical-align: top;">P1008</th>
        <td>
            Nama kearifan lokal /adat (tuliskan):<br>
            <table style="margin: 5px 0; border: none;">
                <tr>
                    <td style="border: none; padding: 2px; width: 50%; vertical-align: top;">
                        @php
                            $kearifan_kehamilan = json_decode($p10->kearifan_kehamilan, true) ?? [];
                            $kearifan_kelahiran = json_decode($p10->kearifan_kelahiran, true) ?? [];
                            $kearifan_pekerjaan = json_decode($p10->kearifan_pekerjaan, true) ?? [];
                            $kearifan_alam = json_decode($p10->kearifan_alam, true) ?? [];
                        @endphp
                        1. Kehamilan: {{ implode(', ', $kearifan_kehamilan) ?: '......' }}<br>
                        2. Kelahiran: {{ implode(', ', $kearifan_kelahiran) ?: '......' }}<br>
                        3. Pekerjaan/pencaharian: {{ implode(', ', $kearifan_pekerjaan) ?: '......' }}<br>
                        4. Alam/lingkungan hidup: {{ implode(', ', $kearifan_alam) ?: '......' }}
                    </td>
                    <td style="border: none; padding: 2px; width: 50%; vertical-align: top;">
                        @php
                            $kearifan_perkawinan = json_decode($p10->kearifan_perkawinan, true) ?? [];
                            $kearifan_kehidupan = json_decode($p10->kearifan_kehidupan, true) ?? [];
                            $kearifan_kematian = json_decode($p10->kearifan_kematian, true) ?? [];
                        @endphp
                        5. Perkawinan: {{ implode(', ', $kearifan_perkawinan) ?: '......' }}<br>
                        6. Kehidupan warga: {{ implode(', ', $kearifan_kehidupan) ?: '......' }}<br>
                        7. Kematian: {{ implode(', ', $kearifan_kematian) ?: '......' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

        <tr>
        <th style="width: 15%; vertical-align: top;">P1009</th>
        <td>
            Jumlah jenis lembaga kemasyarakatan desa
            <table style="margin: 5px 0; font-size: 9px;">
                <tr>
                    <th style="width: 25%;">Nama</th>
                    <th style="width: 15%;">Jumlah kelompok/lembaga</th>
                    <th style="width: 15%;">Jumlah pengurus (jiwa)</th>
                    <th style="width: 15%;">Jumlah anggota (jiwa)</th>
                    <th style="width: 30%;">Fasilitas:<br>1. Ada, baik 2. Ada, rusak sedang 3. Ada, rusak parah 4. Tidak ada</th>
                </tr>

                @php
                    $p1009Data = [];
                    foreach ($p1009 as $item) {
                        $p1009Data[$item->id_master_lembaga_masyarakat] = $item;
                    }

                    $fasilitas_opt = [
                        '1' => '1. Ada, baik',
                        '2' => '2. Ada, rusak sedang',
                        '3' => '3. Ada, rusak parah',
                        '4' => '4. Tidak ada'
                    ];
                @endphp

                @foreach ($master_p1009 as $index => $master)
                    @php
                        $data = $p1009Data[$master->id] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}. {{ $master->nama_lembaga }}</td>
                        <td style="text-align: center;">{{ $data->jumlah_kelompok ?? '-' }}</td>
                        <td style="text-align: center;">{{ $data->jumlah_pengurus ?? '-' }}</td>
                        <td style="text-align: center;">{{ $data->jumlah_anggota ?? '-' }}</td>
                        <td style="text-align: center;">{{ $fasilitas_opt[$data->fasilitas ?? ''] ?? '' }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>

<tr>
    <th style="width: 15%; vertical-align: top;">P1101</th>
    <td>
        Kejadian perkelahian massal setahun terakhir
        <table style="margin: 5px 0; font-size: 9px; width: 100%; border-collapse: collapse;">
            <tr>
                <th style="width: 25%; border: 1px solid ; padding: 3px;">Jenis</th>
                <th style="width: 15%; border: 1px solid ; padding: 3px;">Penyebab utama</th>
                <th style="width: 10%; border: 1px solid ; padding: 3px;">Jumlah kejadian</th>
                <th style="width: 10%; border: 1px solid ; padding: 3px;">Korban luka-luka (jiwa)</th>
                <th style="width: 10%; border: 1px solid ; padding: 3px;">Korban tewas (jiwa)</th>
                <th style="width: 20%; border: 1px solid ; padding: 3px;">Penyelesaian</th>
            </tr>

            @php
                // Siapkan array untuk mapping data p1101 berdasarkan id_master_perkelahian
                $p1101Data = [];
                foreach ($p1101 as $item) {
                    $p1101Data[$item->id_master_perkelahian] = $item;
                }

                // Mapping untuk penyebab utama
                $penyebab_utama_opt = [
                    '1' => 'Harta',
                    '2' => 'Kekuasaan',
                    '3' => 'Asmara',
                    '4' => 'Ideologi',
                    '5' => 'Agama/kepercayaan',
                    '6' => 'Keramaian (olah raga, hiburan, dll)',
                    '7' => 'Ketidakpuasan atas kebijakan/pelayanan',
                    '8' => 'Lainnya'
                ];

                // Mapping untuk penyelesaian
                $penyelesaian_opt = [
                    '1' => 'Ya, semuanya',
                    '2' => 'Ya, sebagian',
                    '3' => 'Tidak'
                ];
            @endphp

            @foreach ($master_p1101 as $index => $master)
                @php
                    $data = $p1101Data[$master->id] ?? null;

                    // Get jenis perkelahian dengan nomor sesuai master
                    $jenis_display = ($index + 1) . '. ' . $master->jenis_perkelahian;

                    // Get penyebab utama text
                    $penyebab_text = '';
                    if ($data && isset($data->penyebab_utama)) {
                        $penyebab_text = $penyebab_utama_opt[$data->penyebab_utama] ?? $data->penyebab_utama;
                    }

                    // Get penyelesaian text
                    $penyelesaian_text = '';
                    if ($data && isset($data->penyelesaian)) {
                        $penyelesaian_text = $penyelesaian_opt[$data->penyelesaian] ?? $data->penyelesaian;
                    }
                @endphp
                <tr>
                    <td style="border: 1px solid ; padding: 3px;">{{ $jenis_display }}</td>
                    <td style="border: 1px solid ; padding: 3px; text-align: center;">{{ $penyebab_text }}</td>
                    <td style="border: 1px solid ; padding: 3px; text-align: center;">{{ $data->jumlah_kejadian ?? '-' }}</td>
                    <td style="border: 1px solid ; padding: 3px; text-align: center;">{{ $data->korban_luka ?? '-' }}</td>
                    <td style="border: 1px solid ; padding: 3px; text-align: center;">{{ $data->korban_tewas ?? '-' }}</td>
                    <td style="border: 1px solid ; padding: 3px; text-align: center;">{{ $penyelesaian_text }}</td>
                </tr>
            @endforeach
        </table>
    </td>

    <tr>
    <th style="width: 15%; vertical-align: top;">P1102</th>
    <td>
        Tindak kejahatan yang terjadi di desa selama setahun terakhir
        <table style="margin: 5px 0; font-size: 9px; width: 100%; border-collapse: collapse;">
            <tr>
                <th style="width: 25%; border: 1px solid  padding: 3px;">Jenis kejahatan</th>
                <th style="width: 15%; border: 1px solid  padding: 3px;">Jumlah kasus</th>
                <th style="width: 20%; border: 1px solid  padding: 3px;">Jumlah kasus tidak bisa ditangani</th>
                <th style="width: 15%; border: 1px solid  padding: 3px;">Korban luka-luka (jiwa)</th>
                <th style="width: 15%; border: 1px solid  padding: 3px;">Korban tewas (jiwa)</th>
            </tr>

            @php
                // Siapkan array untuk mapping data p1102 berdasarkan id_master_kejahatan
                $p1102Data = [];
                foreach ($p1102 as $item) {
                    $p1102Data[$item->id_master_kejahatan] = $item;
                }
            @endphp

            @foreach ($master_p1102 as $index => $master)
                @php
                    $data = $p1102Data[$master->id] ?? null;
                    $jenis_display = ($index + 1) . '. ' . $master->jenis_kejahatan;
                @endphp
                <tr>
                    <td style="border: 1px solid  padding: 3px;">{{ $jenis_display }}</td>
                    <td style="border: 1px solid  padding: 3px; text-align: center;">{{ $data->jumlah_kasus ?? '-' }}</td>
                    <td style="border: 1px solid  padding: 3px; text-align: center;">{{ $data->jumlah_tidak_ditangani ?? '-' }}</td>
                    <td style="border: 1px solid  padding: 3px; text-align: center;">{{ $data->korban_luka ?? '-' }}</td>
                    <td style="border: 1px solid  padding: 3px; text-align: center;">{{ $data->korban_tewas ?? '-' }}</td>
                </tr>
            @endforeach
        </table>

        <table border="1" width="100%" cellspacing="0" cellpadding="6">
    <tr>
        <td valign="top" width="50%">
            <b>KODE PENYEBAB UTAMA</b>
            <ol style="margin-top:6px; padding-left:20px;">
                <li>harta</li>
                <li>kekuasaan</li>
                <li>asmara</li>
                <li>ideologi</li>
                <li>agama/kepercayaan</li>
                <li>keramaian (olah raga, hiburan, dll)</li>
                <li>ketidakpuasan atas kebijakan/pelayanan</li>
                <li>lainnya</li>
            </ol>
        </td>

        <td valign="top" width="50%">
            <b>KODE PIHAK PENDAMAI UTAMA</b>
            <ol style="margin-top:6px; padding-left:20px;">
                <li>aparat keamanan</li>
                <li>aparat pemerintah desa</li>
                <li>aparat pemerintah daerah</li>
                <li>tokoh masyarakat</li>
                <li>tokoh agama</li>
                <li>lainnya</li>
                <li>tidak ada</li>
            </ol>
        </td>
    </tr>
</table>
    </td>
</tr>
</tr>

@php
    // Data dari p11
    $p11 = isset($p11) ? $p11 : null;

    // Mapping untuk opsi Ya/Tidak
    $ya_tidak_opt = [
        '1' => 'Ya',
        '2' => 'Tidak'
    ];

    // Mapping untuk kemudahan akses
    $kemudahan_opt = [
        '1' => 'Sangat mudah',
        '2' => 'Mudah',
        '3' => 'Sulit'
    ];
@endphp

<!-- P1103 -->
<tr>
    <th style="width: 15%; vertical-align: top;">P1103</th>
    <td>
        Kegiatan warga untuk menjaga keamanan lingkungan selama setahun terakhir:
        <br>
        1. Jumlah kegiatan pembangunan/pemeliharaan pos keamanan lingkungan: {{ $p11->jumlah_kegiatan_poskamling ?? '-' }}
        <br>
        2. Jumlah kegiatan pembentukan/pengaturan regu keamanan: {{ $p11->jumlah_kegiatan_regu_keamanan ?? '-' }}
        <br>
        3. Jumlah anggota hansip/linmas yang ditambahkan (jiwa): {{ $p11->jumlah_tambahan_hansip ?? '-' }}
        <br>
        4. Pelaporan tamu yang menginap lebih dari 24 jam ke aparat lingkungan:
        {{ isset($p11->pelaporan_tamu) ? $ya_tidak_opt[$p11->pelaporan_tamu] ?? $p11->pelaporan_tamu : '' }}
        <br>
        5. Pengaktifan sistem keamanan lingkungan berasal dari inisiatif warga:
        {{ isset($p11->inisiatif_siskamling) ? $ya_tidak_opt[$p11->inisiatif_siskamling] ?? $p11->inisiatif_siskamling : '' }}
    </td>
</tr>

<!-- P1104 -->
<tr>
    <th style="width: 15%; vertical-align: top;">P1104</th>
    <td>
        Jumlah anggota linmas/hansip (jiwa): {{ $p11->jumlah_anggota_linmas ?? '-' }}
    </td>
</tr>

<!-- P1105 -->
<tr>
    <th style="width: 15%; vertical-align: top;">P1105</th>
    <td>
        1. Jumlah pos polisi (termasuk kantor polisi):
        <br>
        &nbsp;&nbsp;a. yang digunakan (unit): {{ $p11->jumlah_pos_polisi_digunakan ?? '-' }}
        <br>
        &nbsp;&nbsp;b. yang tidak digunakan (unit): {{ $p11->jumlah_pos_polisi_tidak_digunakan ?? '-' }}
        <br>
        2. Jika tidak ada pos polisi, perkiraan jarak ke pos polisi (termasuk kantor polisi) terdekat (km):
        {{ $p11->jarak_ke_pos_polisi_terdekat ?? '-' }}
        <br>
        3. Kemudahan untuk mencapai pos polisi (termasuk kantor polisi) terdekat:
        {{ isset($p11->kemudahan_akses_pos_polisi) ? $kemudahan_opt[$p11->kemudahan_akses_pos_polisi] ?? $p11->kemudahan_akses_pos_polisi : '' }}
    </td>
</tr>

<!-- P1106 -->
<tr>
    <th style="width: 15%; vertical-align: top;">P1106</th>
    <td>
        Jumlah korban bunuh diri (termasuk percobaan bunuh diri) yang terjadi selama setahun terakhir (jiwa):
        {{ $p11->jumlah_korban_bunuh_diri ?? '-' }}
    </td>
</tr>

<!-- P1107 -->
<tr>
    <th style="width: 15%; vertical-align: top;">P1107</th>
    <td>
        1. Jumlah lokasi berkumpul/mangkal anak jalanan (selain rumah singgah):
        {{ $p11->jumlah_lokasi_anak_jalanan ?? '-' }}
        <br>
        2. Jumlah tempat mangkal gelandangan/pengemis:
        {{ $p11->jumlah_tempat_gelandangan_pengemis ?? '-' }}
    </td>
</tr>

<!-- P1108 -->
<tr>
    <th style="width: 15%; vertical-align: top;">P1108</th>
    <td>
        Jumlah lokalisasi/lokasi/tempat mangkal Pekerja Seks Komersial (PSK):
        {{ $p11->jumlah_lokasi_psk ?? '-' }}
    </td>
</tr>

    </table>

</body>

</html>

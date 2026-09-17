<!DOCTYPE html>
<html>

<head>
    <title>Export Data SDGs Desa</title>
    <style>
        body {
            font-family: Arial !important;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        /* table.data-table th {
            width: 80px !important;
        } */

        td {
            width: 90%
        }

        h2 {
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <table class="table table-bordered table-sm data-table">
        <tr class="tr-atas" style="border: none !important">
            <th colspan="2" style="padding: 5px !important; border: none !important; text-align:left;"><b>KEMENTRIAN
                    DESA, PDT DAN TRANSMIGRASI</b></th>
        </tr>
        <tr style="border: none !important">
            <th style="padding: 5px !important;border: none !important">
                <b>SDGs DESA</b>
            </th>
            <td style="padding: 5px !important;border: none !important"></td>
        </tr>
        <tr style="border: none !important; padding-top: 0px !important">
            <th style="padding: 5px !important;border: none !important">
                <b>KUESIONER DESA</b>
            </th>
            <td style="padding: 5px !important;border: none !important"></td>
        </tr>
        <tr>
            <th><b>P1</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI ENUMERATOR</b></td>
        </tr>
        {{-- ENUMERATOR --}}
        <tr>
            <th>P101</th>
            <td>Nama : {{ $user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>P102</th>
            <td>Alamat : {{ $user->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <th>P103</th>
            <td>HP/telepon : {{ $user->hp ?? '-' }}</td>
        </tr>
        {{-- ENUMERATOR END --}}
        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>
        {{-- DESA P2 --}}
        <tr>
            <th><b>P2</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI LOKASI</b></td>
        </tr>
        <tr>
            <th>P201</th>
            <td>Provinsi: {{ $p2->provinsi->nama ?? '-' }}</td>
        </tr>

        <tr>
            <th>P202</th>
            <td>Kabupaten: {{ $p2->kabupaten->nama ?? '-' }}</td>
        </tr>

        <tr>
            <th>P203</th>
            <td>Kecamatan: {{ $p2->kecamatan->nama ?? '-' }}</td>
        </tr>

        <tr>
            <th>P204</th>
            <td>Desa: {{ $p2->desa->nama ?? '-' }}</td>
        </tr>

        <tr>
            <th>P205</th>
            <td>Email Desa: {{ $p2->email ?? '-' }}</td>
        </tr>
        <tr>
            <th>P206</th>
            <td>Alamat Web Desa: {{ $p2->url_web ?? '-' }}</td>
        </tr>
        <tr>
            <th>P207</th>
            <td>Alamat Facebook Desa: {{ $p2->url_facebook ?? '-' }}</td>
        </tr>
        <tr>
            <th>P208</th>
            <td>Alamat Twitter Desa: {{ $p2->url_twitter ?? '-' }}</td>
        </tr>
        <tr>
            <th>P209</th>
            <td>Alamat Instagram Desa: {{ $p2->url_instagram ?? '-' }}</td>
        </tr>
        <tr>
            <th>P210</th>
            <td>Alamat YouTube Desa: {{ $p2->url_youtube ?? '-' }}</td>
        </tr>
        @php
            $statusMap = [
                1 => '1. Desa',
                2 => '2. Nagari',
                3 => '3. Gampong',
                4 => '4. Kampung',
                5 => '5. Kelurahan',
            ];
        @endphp
        <tr>
            <th>P211</th>
            <td>Status Pemerintahan:
                {{ $statusMap[$p2->status_pemerintahan] ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P212</th>
            <td>Jumlah RW (tulis angka): {{ $p2->jml_rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P213</th>
            <td>Jumlah RT (tulis angka): {{ $p2->jml_rt ?? '-' }}</td>
        </tr>
        <tr>
            <th>P214</th>
            <td>SK Pendirian Desa: {{ $p2->no_sk_pendirian_desa ?? '-' }}</td>
        </tr>
        <tr>
            <th>P215</th>
            <td>SK Bupati/Walikota atau Gubernur tentang Peta Desa:
                {{ $p2->no_sk_peta_desa ?? '-' }}</td>
        </tr>
        <tr>
            <th>P216</th>
            <td>Luas Wilayah (Ha): {{ $p2->luas_wilayah ?? '-' }}</td>
        </tr>
        <tr>
            <th>P217</th>
            <td>Lokasi Desa terletak di pulau (sebutkan nama pulau): {{ $p2->lokasi_desa ?? '-' }}
            </td>
        </tr>
        @php
            $topografi = [
                1 => '1. Lereng/Puncak',
                2 => '2. Lembah',
                3 => '3. Dataran',
            ];
        @endphp
        <tr>
            <th>P218</th>
            <td>Topografi terluas wilayah desa: {{ $topografi[$p2->topografi] ?? '-' }}</td>
        </tr>
        <tr>
            <th>P219</th>
            <td>Jumlah warga di lereng/puncak (jiwa): {{ $p2->jml_warga ?? '-' }}</td>
        </tr>
        @php
            $baldes = [
                1 => '1. Ada, Layak',
                2 => '2. Ada, tidak layak',
                3 => '3. Tidak Ada',
            ];
        @endphp
        <tr>
            <th>P220</th>
            <td>Kantor kepala desa/balai desa: {{ $baldes[$p2->balai_desa] ?? '-' }}</td>
        </tr>
        @php
            $kepemilikan = [
                1 => '1. Aset desa',
                2 => '2. Bukan aset desa',
            ];
        @endphp
        <tr>
            <th>P221</th>
            <td>Kepemilikan kantor kepala desa/balai desa: {{ $kepemilikan[$p2->kepemilikan] ?? '-' }}</td>
        </tr>
        @php
            $lokasi = [
                1 => '1. Di dalam desa',
                2 => '2. Di luar desa',
            ];
        @endphp
        <tr>
            <th>P222</th>
            <td>Lokasi kantor kepala desa/balai desa: {{ $lokasi[$p2->lokasi_balai_desa] ?? '-' }}</td>
        </tr>
        @php
            $tempat_pemdes = [
                1 => '1. kantor kepala desa/balai desa',
                2 => '2. Bukan kantor kepala desa/balai desa',
            ];
        @endphp
        <tr>
            <th>P223</th>
            <td>Penyelenggaraan pemerintahan desa utamanya dilaksanakan di:
                {{ $tempat_pemdes[$p2->tempat_pemerintah_desa] ?? '-' }}</td>
        </tr>
        @php
            $jam_kantor = [
                1 => '1. Tidak menentu/tidak ada jadwal tertentu',
                2 => '2. Ada jadwal kerja',
            ];
        @endphp
        <tr>
            <th>P224</th>
            <td>Jam kerja di kantor desa: {{ $jam_kantor[$p2->jam_kerja] ?? '-' }} <br>
                Jam Mulai: {{ $p2->mulai_pukul ?? '-' }} <br>
                Jam Akhir: {{ $p2->akhir_pukul ?? '-' }}
            </td>
        </tr>
        <tr>
            <th>P225</th>
            <td>Koordinat lokasi kegiatan pemerintahan desa <br>
                1.Koordinat Garis Lintang (latitude) {{ $p2->lintang ?? '-' }} <br>
                2.Lintang : <br>
                3.Garis bujur (longitude) Timur {{ $p2->bujur }}
            </td>
        </tr>
        <tr>
            <th>P226</th>
            <td>Ketinggian lokasi kegiatan pemerintahan desa dari permukaan air laut (DPAL) :
                {{ $p2->ketinggian_lok ?? '-' }} meter</td>
        </tr>
        <tr>
            <th>P227</th>
            <td>Panjang garis pantai (km) :
                {{ $p2->pjg_garis_pantai ?? '-' }} Km</td>
        </tr>
        {{-- END DESA P2 --}}
        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P3</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI PEMERINTAHAN DESA</b></td>
        </tr>
        @if ($p3)
            <tr>
                <th>P301</th>
                <td>Nama kepala desa (dan foto): {{ $p3->nama_kades ?? '-' }}</td>
            </tr>
            <tr>
                <th>P302</th>
                <td>NIK kepala desa: {{ $p3->nik_kades ?? '-' }}</td>
            </tr>
            <tr>
                <th>P303</th>
                <td>Nomor HP: {{ $p3->hp_kades ?? '-' }}</td>
            </tr>
            <tr>
                <th>P304</th>
                <td>Menjabat kepala desa sejak tahun: {{ $p3->awal_jabatan_kades ?? '-' }}</td>
            </tr>
            <tr>
                <th>P305</th>
                <td>Nama sekretaris desa: {{ $p3->nama_sekdes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P306</th>
                <td>NIK sekretaris desa: {{ $p3->nik_sekdes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P307</th>
                <td>Nomor HP: {{ $p3->hp_sekdes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P308</th>
                <td>Menjabat sekretaris desa sejak tahun: {{ $p3->awal_jabatan_sekdes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P309</th>
                <td>Nama bendahara desa: {{ $p3->nama_bendes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P310</th>
                <td>NIK bendahara desa: {{ $p3->nik_bendes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P311</th>
                <td>Nomor HP: {{ $p3->hp_bendes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P312</th>
                <td>Menjabat bendahara desa sejak tahun: {{ $p3->awal_jabatan_bendes ?? '-' }}</td>
            </tr>
            <tr>
                <th>P313</th>
                <td>Nama kepala urusan tata usaha: {{ $p3->nama_kpl_tu ?? '-' }}</td>
            </tr>
            <tr>
                <th>P314</th>
                <td>NIK kepala urusan tata usaha: {{ $p3->nik_kpl_tu ?? '-' }}</td>
            </tr>
            <tr>
                <th>P315</th>
                <td>Nomor HP: {{ $p3->hp_kpl_tu ?? '-' }}</td>
            </tr>
            <tr>
                <th>P316</th>
                <td>Menjabat kepala urusan tata usaha sejak tahun: {{ $p3->awal_jabatan_kpl_tu ?? '-' }}</td>
            </tr>
            <tr>
                <th>P317</th>
                <td>Nama kepala urusan keuangan: {{ $p3->nama_kpl_uang ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P318</th>
                <td>NIK kepala urusan keuangan: {{ $p3->nik_kpl_uang ?? '-' }}</td>
            </tr>
            <tr>
                <th>P319</th>
                <td>Nomor HP: {{ $p3->hp_kpl_uang ?? '-' }}</td>
            </tr>
            <tr>
                <th>P320</th>
                <td>Menjabat kepala urusan keuangan sejak tahun: {{ $p3->awal_jabatan_kpl_uang ?? '-' }}</td>
            </tr>
            <tr>
                <th>P321</th>
                <td>Nama kepala urusan perencanaan: {{ $p3->nama_kpl_rencana ?? '-' }}</td>
            </tr>
            <tr>
                <th>P322</th>
                <td>NIK kepala urusan perencanaan: {{ $p3->nik_kpl_rencana ?? '-' }}</td>
            </tr>
            <tr>
                <th>P323</th>
                <td>Nomor HP: {{ $p3->hp_kpl_rencana ?? '-' }}</td>
            </tr>
            <tr>
                <th>P324</th>
                <td>Menjabat kepala urusan perencanaan sejak tahun: {{ $p3->awal_jabatan_kpl_rencana ?? '-' }}</td>
            </tr>
            <tr>
                <th>P325</th>
                <td>Nama kepala seksi pemerintahan: {{ $p3->nama_kepsek_pemerintahan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P326</th>
                <td>NIK kepala seksi pemerintahan: {{ $p3->nik_kepsek_pemerintahan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P327</th>
                <td>Nomor HP: {{ $p3->hp_kepsek_pemerintahan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P328</th>
                <td>Menjabat kepala seksi pemerintahan sejak tahun: {{ $p3->awal_jabatan_kepsek_pemerintahan ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P329</th>
                <td>Nama kepala seksi kesejahteraan: {{ $p3->nama_kepsek_kesejahteraan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P330</th>
                <td>NIK kepala seksi kesejahteraan: {{ $p3->nik_kepsek_kesejahteraan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P331</th>
                <td>Nomor HP: {{ $p3->hp_kepsek_kesejahteraan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P332</th>
                <td>Menjabat kepala seksi kesejahteraan sejak tahun:
                    {{ $p3->awal_jabatan_kepsek_kesejahteraan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P333</th>
                <td>Nama kepala seksi pelayanan: {{ $p3->nama_kepsek_pelayanan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P334</th>
                <td>NIK kepala seksi pelayanan: {{ $p3->nik_kepsek_pelayanan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P335</th>
                <td>Nomor HP: {{ $p3->hp_kepsek_pelayanan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P336</th>
                <td>Menjabat kepala seksi pelayanan sejak tahun: {{ $p3->awal_jabatan_kepsek_pelayanan ?? '-' }}</td>
            </tr>
        @endif
        @php
            $maxPegawai = 5;

            // Mapping kode P337–P356 untuk 5 pegawai
            $kode = [
                1 => ['P337', 'P338', 'P339', 'P340'],
                2 => ['P341', 'P342', 'P343', 'P344'],
                3 => ['P345', 'P346', 'P347', 'P348'],
                4 => ['P349', 'P350', 'P351', 'P352'],
                5 => ['P353', 'P354', 'P355', 'P356'],
            ];
        @endphp

        @for ($i = 1; $i <= $maxPegawai; $i++)
            @php
                $p = $pegawai->firstWhere('pegawai_ke', $i);
            @endphp

            {{-- Nama --}}
            <tr>
                <th>{{ $kode[$i][0] }}</th>
                <td>Nama pegawai desa lainnya {{ $i }}: {{ $p->nama_pegawai_desa ?? '-' }}</td>
            </tr>

            {{-- NIK --}}
            <tr>
                <th>{{ $kode[$i][1] }}</th>
                <td>NIK pegawai desa lainnya {{ $i }}: {{ $p->nik_pegawai_desa ?? '-' }}</td>
            </tr>

            {{-- HP --}}
            <tr>
                <th>{{ $kode[$i][2] }}</th>
                <td>Nomor HP: {{ $p->hp_pegawai_desa ?? '-' }}</td>
            </tr>

            {{-- Menjabat --}}
            <tr>
                <th>{{ $kode[$i][3] }}</th>
                <td>Menjabat pegawai desa lainnya {{ $i }} sejak tahun:
                    {{ $p->awal_jabatan_pegawai_desa ?? '-' }}</td>
            </tr>
        @endfor

        @if ($p3)
            <tr>
                <th>P357</th>
                <td>Nama Kepala Badan Permusyawaratan Desa (BPD): {{ $p3->nama_kpl_bpd ?? '-' }}</td>
            </tr>
            <tr>
                <th>P358</th>
                <td>NIK Kepala Badan Permusyawaratan Desa (BPD): {{ $p3->nik_kepsek_pelayanan ?? '-' }}</td>
            </tr>
            <tr>
                <th>P359</th>
                <td>Nomor HP: {{ $p3->hp_kpl_bpd ?? '-' }}</td>
            </tr>
            <tr>
                <th>P360</th>
                <td>Menjabat Kepala Badan Permusyawaratan Desa (BPD) sejak tahun:
                    {{ $p3->awal_jabatan_kpl_bpd ?? '-' }}</td>
            </tr>
        @endif

        @php
            $maxAnggota = 9;

            // Mapping kode P337–P356 untuk 5 Anggota BPD
            $kode = [
                // 1 => ['P357', 'P358', 'P359', 'P360'],
                1 => ['P361', 'P362', 'P363', 'P364'],
                2 => ['P365', 'P366', 'P367', 'P368'],
                3 => ['P369', 'P370', 'P371', 'P372'],
                4 => ['P373', 'P374', 'P375', 'P376'],
                5 => ['P377', 'P378', 'P379', 'P380'],
                6 => ['P381', 'P382', 'P383', 'P384'],
                7 => ['P385', 'P386', 'P387', 'P388'],
                8 => ['P389', 'P390', 'P391', 'P392'],
                9 => ['P393', 'P394', 'P395', 'P396'],
            ];
        @endphp

        @for ($i = 1; $i <= $maxAnggota; $i++)
            @php
                $p = $bpd->firstWhere('anggota_ke', $i);
            @endphp

            {{-- Nama --}}
            <tr>
                <th>{{ $kode[$i][0] }}</th>
                <td>Nama anggota Badan Permusyawaratan Desa (BPD) {{ $i }}:
                    {{ $p->nama_anggota_bpd ?? '-' }}</td>
            </tr>

            {{-- NIK --}}
            <tr>
                <th>{{ $kode[$i][1] }}</th>
                <td>NIK anggota Badan Permusyawaratan Desa (BPD) {{ $i }}: {{ $p->nik_anggota_bpd ?? '-' }}
                </td>
            </tr>

            {{-- HP --}}
            <tr>
                <th>{{ $kode[$i][2] }}</th>
                <td>Nomor HP: {{ $p->hp_anggota_bpd ?? '-' }}</td>
            </tr>

            {{-- Menjabat --}}
            <tr>
                <th>{{ $kode[$i][3] }}</th>
                <td>Menjabat anggota Badan Permusyawaratan Desa (BPD) {{ $i }} sejak tahun:
                    {{ $p->awal_jabatan_anggota_bpd ?? '-' }}</td>
            </tr>
        @endfor

        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>
        <tr>
            <th><b>P4</b></th>
            <td style="width: 90% !important;"><b>MUSYAWARAH DESA</b></td>
        </tr>
        {{-- P4 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P401</th>
            <td>
                Musyawarah desa tahun sebelumnya <br>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Bulan Ke (tulis angka)</th>
                        <th>Agenda Musyawarah</th>
                        <th>Dokumen Musyawarah</th>
                    </tr>
                    @if ($p4->count())
                        @foreach ($p4 as $loopItem)
                            <tr>
                                <td style="width: 5% !important">{{ $loop->iteration ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->bulan_ke ?? '-' }}</td>
                                <td style="width: 30% !important">{!! base64_decode($loopItem->agenda_musyawarah ?? '-') !!}</td>
                                <td style="width: 50% !important">
                                    <a href="{{ asset('dokumen/musyawarah/' . $loopItem->id . '.pdf') }}"
                                        target="_blank">
                                        {{ $loopItem->id . '.pdf' }}
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 30% !important">-</td>
                            <td style="width: 50% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>

        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P5</b></th>
            <td style="width: 90% !important;"><b>REGULASI DESA</b></td>
        </tr>
        {{-- P501 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P501</th>
            <td>
                Peraturan Desa tahun sebelumnya <br>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nomor Dokumen</th>
                        <th>Bulan (tulis angka)</th>
                        {{-- <th>Dokumen Musyawarah</th> --}}
                        <th>Tentang</th>
                    </tr>
                    @if ($p501->count())
                        @foreach ($p501 as $loopItem)
                            <tr>
                                <td style="width: 5% !important">{{ $loop->iteration ?? '-' }}</td>
                                <td style="width: 20% !important">{{ $loopItem->no_dokumen ?? '-' }}</td>
                                <td style="width: 10% !important">{{ $loopItem->bulan ?? '-' }}</td>
                                {{-- <td style="width: 25% !important">Dokumen Musyawarah</td> --}}
                                <td style="width: 65% !important">{{ $loopItem->tentang ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Tetap tampilkan layout tabel walau tidak ada data --}}
                        <tr>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 20% !important">-</td>
                            <td style="width: 10% !important">-</td>
                            <td style="width: 65% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        {{-- P502 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P502</th>
            <td>
                Peraturan Kepala Desa tahun sebelumnya <br>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nomor Dokumen</th>
                        <th>Bulan (tulis angka)</th>
                        {{-- <th>Dokumen Musyawarah</th> --}}
                        <th>Tentang</th>
                    </tr>
                    @if ($p502->count())
                        @foreach ($p502 as $loopItem)
                            <tr>
                                <td style="width: 5% !important">{{ $loop->iteration ?? '-' }}</td>
                                <td style="width: 20% !important">{{ $loopItem->no_dokumen ?? '-' }}</td>
                                <td style="width: 10% !important">{{ $loopItem->bulan ?? '-' }}</td>
                                {{-- <td style="width: 25% !important">Dokumen Musyawarah</td> --}}
                                <td style="width: 65% !important">{{ $loopItem->tentang ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Tetap tampilkan layout tabel walau tidak ada data --}}
                        <tr>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 20% !important">-</td>
                            <td style="width: 10% !important">-</td>
                            <td style="width: 65% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        {{-- P503 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P503</th>
            <td>
                SK Kepala Desa tahun sebelumnya <br>

                <table>
                    <tr>
                        <th>No</th>
                        <th>Nomor Dokumen</th>
                        <th>Bulan (tulis angka)</th>
                        <th>Tentang</th>
                    </tr>

                    @if ($p503->count())
                        @foreach ($p503 as $loopItem)
                            <tr>
                                <td style="width: 5% !important">{{ $loop->iteration }}</td>
                                <td style="width: 20% !important">{{ $loopItem->no_dokumen ?? '-' }}</td>
                                <td style="width: 10% !important">{{ $loopItem->bulan ?? '-' }}</td>
                                <td style="width: 65% !important">{{ $loopItem->tentang ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Tetap tampilkan layout tabel walau tidak ada data --}}
                        <tr>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 20% !important">-</td>
                            <td style="width: 10% !important">-</td>
                            <td style="width: 65% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>

        @if ($p5)
            <tr>
                <th>P504</th>
                <td>RPJM Desa berlaku sampai tahun: {{ $p5->rpjm_berlaku ?? '-' }}</td>
            </tr>
            @php
                $rkp_desa = [
                    1 => '1. Ada',
                    2 => '2. Tidak ada',
                ];
            @endphp
            <tr>
                <th>P505</th>
                <td>RKP Desa: {{ $rkp_desa[$p5->rkp_desa] ?? '-' }}</td>
            </tr>
        @endif
        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P6</b></th>
            <td style="width: 90% !important;"><b>APBDesa DAN ASET DESA</b></td>
        </tr>
        @if ($p601)
            <tr>
                <th style="width: 15%; vertical-align: top;">P601</th>
                <td>Anggaran pendapatan desa tahun sebelumnya
                    <table>
                        <tr>
                            <th style="width: 70% !important">Anggaran Pendapatan</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p601->anggaran_pendapatan, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">1. Dana Desa bersumber dari APBN</th>
                            <td style="width: 30% !important">Rp.{{ number_format($p601->apbn, 0, ',', '.') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">2. Pendapatan Asli Desa (PADes)</th>
                            <td style="width: 30% !important">Rp.{{ number_format($p601->pades, 0, ',', '.') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">3. Bagian dari hasil pajak daerah dan retribusi daerah
                            </th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p601->pajak_daerah, 0, ',', '.') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">4. Alokasi Dana Desa (bagian dari dana perimbangan yang
                                diterima kabupaten/kota)</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p601->alokasi_dana_desa, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">5. Bantuan keuangan dari APBD Provinsi</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p601->apbd_prov, 0, ',', '.') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">6. Bantuan keuangan dari APBD Kabupaten/kota</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p601->apbd_kab, 0, ',', '.') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">7. Hibah dan sumbangan dari pihak ketiga</th>
                            <td style="width: 30% !important">Rp.{{ number_format($p601->hibah, 0, ',', '.') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">8. Lain–lain pendapatan desa yang sah</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p601->lain_lain, 0, ',', '.') ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
        @endif
        @if ($p602)
            <tr>
                <th style="width: 15%; vertical-align: top;">P602</th>
                <td>Anggaran pembelanjaan desa tahun sebelumnya
                    <table>
                        <tr>
                            <th style="width: 70% !important">Anggaran Pengeluaran</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->anggaran_pengeluaran, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">1. Bidang penyelenggaraan pemerintahan desa</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->penyelenggaraan_desa, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">2. Bidang pelaksanaan pembangunan desa</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->pembangunan_desa, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">3. Bidang pemberdayaan masyarakat</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->pemberdayaan_desa, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">4. Bidang pembinaan kemasyarakatan</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->bina_masyarakat, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">5. Belanja Modal (tanah, bangunan, jalan, jembatan,
                                komputer, dll.)</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->belanja_modal, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">6. Penyertaan modal ke BUMDes</th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->bumdes, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 70% !important">7. Lainnya (belanja tak terduga, konsumsi rapat, dll.)
                            </th>
                            <td style="width: 30% !important">
                                Rp.{{ number_format($p602->lainnya, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif
        {{-- P603 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P603</th>
            <td>
                Nilai aset desa <br>
                <table>
                    <tr>
                        <th>Aset</th>
                        <th>Volume</th>
                        <th>Satuan Volume</th>
                        <th>Nilai Rp</th>
                    </tr>
                    @if ($p603->isEmpty())
                        <tr>
                            <td style="width: 50% !important">-</td>
                            <td style="width: 10% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 25% !important">-</td>
                        </tr>
                    @else
                        @foreach ($p603 as $loopItem)
                            <tr>
                                <td style="width: 50% !important">{{ $loopItem->aset ?? '-' }}</td>
                                <td style="width: 10% !important">{{ $loopItem->volume ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->satuan_volume ?? '-' }}</td>
                                <td style="width: 25% !important">
                                    Rp.{{ $loopItem->nilai ? number_format($loopItem->nilai, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </table>
            </td>
        </tr>
        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P7</b></th>
            <td style="width: 90% !important;"><b>LAYANAN</b></td>
        </tr>
        @if ($p7)
            @php
                $teknologi = [
                    1 => '1. Digunakan',
                    2 => '2. Jarang digunakan',
                    3 => '3. Tidak digunakan',
                    4 => '4. Tidak ada',
                ];
                $fasilitas_internet = [
                    1 => '1. Berfungsi',
                    2 => '2. Jarang Berfungsi',
                    3 => '3. Tidak Berfungsi',
                    4 => '4. Tidak ada',
                ];
                $info_desa = [
                    1 => '1. Ada, diperbaharui',
                    2 => '2. Ada, tidak diperbaharui',
                    3 => '3. Tidak ada',
                ];
                $uang_desa = [
                    1 => '1. Ada, diperbaharui',
                    2 => '2. Ada, tidak diperbaharui',
                    3 => '3. Tidak ada',
                ];
            @endphp
            <tr>
                <th>P701</th>
                <td>
                    1. Komputer/PC/laptop yang masih berfungsi di kantor kepala desa/lurah:
                    {{ $teknologi[$p7->teknologi] ?? '-' }} <br>
                    2. Fasilitas internet di kantor kepala desa/lurah: {{ $fasilitas_internet[$p7->internet] ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P702</th>
                <td>
                    1. Sistem informasi desa: {{ $info_desa[$p7->info_desa] ?? '-' }} <br>
                    2. Sistem keuangan desa: {{ $uang_desa[$p7->keuangan_desa] ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P703</th>
                <td>
                    Jumlah surat terangan tidak mampu/miskin yang dikeluarkan setahun terakhir (jumlah):
                    {{ $p7->srt_tidak_mampu ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P704</th>
                <td>
                    1. Jumlah penduduk yang belum merekam eKTP (jiwa): {{ $p7->blm_ektp ?? '-' }} <br>
                    2. Jumlah penduduk yang belum tercatat di KK (jiwa): {{ $p7->blm_kk ?? '-' }}
                </td>
            </tr>
        @endif
        @if ($p705->count())
            <tr>
                <th style="width: 15%; vertical-align: top;">P705</th>
                <td>
                    Kerja sama desa <br>
                    <table>
                        <tr>
                            <th>Pihak yang diajak kerja sama</th>
                            <th>
                                Lingkup kerja sama <br>
                                1. Antardesa <br>
                                2. Dengan pemerintah daerah <br>
                                3. Dengan pemerintah pusat <br>
                                4. Dengan swasta <br>
                                5. Dengan lembaga internasional
                            </th>
                            <th>Tahun kerja sama berakhir</th>
                            <th>Jumlah pemanfaat (jiwa)</th>
                            <th>Nilai kerja sama (Rp)</th>
                        </tr>

                        @foreach ($p705 as $loopItem)
                            <tr>
                                <td style="width: 40% !important">{{ $loopItem->pihak_kerjasama ?? '-' }}</td>
                                <td style="width: 20% !important">{{ $loopItem->lingkup_kerjasama ?? '-' }}</td>
                                <td style="width: 10% !important">{{ $loopItem->akhir_kerjasama ?? '-' }}</td>
                                <td style="width: 10% !important">{{ $loopItem->jml_jiwa ?? '-' }}</td>
                                <td style="width: 20% !important">
                                    Rp.{{ number_format($loopItem->nilai_kerjasama, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endif
        @if ($p7)
            @php
                $jk_pdesa = [
                    1 => '1. Laki-Laki',
                    2 => '2. Perempuan',
                ];
            @endphp
            <tr>
                <th style="width: 15%; vertical-align: top;">P706</th>
                <td>
                    1. Nama pendamping desa: {{ $p7->nama_pdesa ?? '-' }} <br>
                    2. Jenis kelamin pendamping desa: {{ $jk_pdesa[$p7->jk_pdesa] ?? '-' }} <br>
                    3. No HP pendamping desa: {{ $p7->hp_pdesa ?? '-' }}
                </td>
            </tr>
        @endif
        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P8</b></th>
            <td style="width: 90% !important;"><b>LEMBAGA KEMASYARAKATAN DESA</b></td>
        </tr>
        {{-- p8 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P800</th>
            <td>
                Jumlah jenis lembaga kemasyarakatan desa <br>
                <table>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah pengurus (jiwa)</th>
                        <th>Jumlah anggota (jiwa)</th>
                    </tr>
                    @if ($p8->count())
                        @foreach ($p8 as $loopItem)
                            <tr>
                                <td style="width: 40% !important">{{ $loopItem->id_lembaga ?? '-' }}</td>
                                <td style="width: 30% !important">{{ $loopItem->jml_pengurus ?? '-' }}</td>
                                <td style="width: 30% !important">{{ $loopItem->jml_anggota ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="width: 40% !important">-</td>
                            <td style="width: 30% !important">-</td>
                            <td style="width: 30% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>

        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P9</b></th>
            <td style="width: 90% !important;"><b>BADAN USAHA MILIK DESA</b></td>
        </tr>
        @if ($p9)
            <tr>
                <th>P901</th>
                <td>
                    Nama Bumdes: {{ $p9->nama_bumdes ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P902</th>
                <td>
                    Email: {{ $p9->email ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P903</th>
                <td>
                    Alamat web: {{ $p9->web_bumdes ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P904</th>
                <td>
                    Alamat Facebook: {{ $p9->fb_bumdes ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P905</th>
                <td>
                    Alamat Twitter: {{ $p9->twitter_bumdes ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P906</th>
                <td>
                    Alamat desa: {{ $p9->alamat_desa ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P907</th>
                <td>
                    Alamat Youtube: {{ $p9->yt_bumdes ?? '-' }}
                </td>
            </tr>
            <tr>
                <th style="width: 15%; vertical-align: top;">P908</th>
                @php
                    $modal = explode(',', $p9->modal_awal);
                @endphp
                <td>
                    Modal awal <br>
                    1. dari pemerintah desa (Rp):
                    Rp.{{ number_format($modal[0], 0, ',', '.') ?? '-' }} <br>

                    2. dari warga desa (Rp):
                    Rp.{{ number_format($modal[1], 0, ',', '.') ?? '-' }} <br>

                    3. dari pihak lain (Rp):
                    Rp.{{ number_format($modal[2], 0, ',', '.') ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P909</th>
                <td>
                    Omset setahun terakhir (Rp): Rp.{{ number_format($p9->omset_setahun, 0, ',', '.') ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P910</th>
                <td>
                    Keuntungan bersih setahun terakhir (Rp):
                    Rp.{{ number_format($p9->keuntungan_bersih, 0, ',', '.') ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P911</th>
                <td>
                    Keuntungan kotor belum dikurangi pajak setahun terakhir (Rp):
                    Rp.{{ number_format($p9->keuntungan_kotor, 0, ',', '.') ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P912</th>
                <td>
                    Nilai aset Bumdes (Rp): Rp.{{ number_format($p9->aset_bumdes, 0, ',', '.') ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>P913</th>
                <td>
                    Sumbangan diberikan kepada PADesa (Rp):
                    Rp.{{ number_format($p9->sumbangan_padesa, 0, ',', '.') ?? '-' }}
                </td>
            </tr>
        @endif
        @php
            $maxPembina = 3;
            $kode = [
                1 => ['P914', 'P915', 'P916'],
                2 => ['P917', 'P918', 'P919'],
                3 => ['P920', 'P921', 'P922'],
            ];
        @endphp
        @for ($i = 1; $i <= $maxPembina; $i++)
            @php
                $p = $p914->firstWhere('komisaris_ke', $i);
            @endphp
            <tr>
                <th>{{ $kode[$i][0] }}</th>
                <td>Nama pembina/komisaris {{ $i }}: {{ $p->nama_komisaris ?? '-' }}</td>
            </tr>
            <tr>
                <th>{{ $kode[$i][1] }}</th>
                <td>NIK: {{ $p->nik_komisaris ?? '-' }}</td>
            </tr>
            <tr>
                <th>{{ $kode[$i][2] }}</th>
                <td>No HP: {{ $p->hp_komisaris ?? '-' }}</td>
            </tr>
        @endfor
        @php
            $maxPengawas = 3;
            $kode = [
                1 => ['P923', 'P924', 'P925'],
                2 => ['P926', 'P927', 'P928'],
                3 => ['P929', 'P930', 'P931'],
            ];
        @endphp
        @for ($i = 1; $i <= $maxPengawas; $i++)
            @php
                $p = $p923->firstWhere('pengawas_ke', $i);
            @endphp
            <tr>
                <th>{{ $kode[$i][0] }}</th>
                <td>Nama Pengawas {{ $i }}: {{ $p->nama_pengawas ?? '-' }}</td>
            </tr>
            <tr>
                <th>{{ $kode[$i][1] }}</th>
                <td>NIK: {{ $p->nik_pengawas ?? '-' }}</td>
            </tr>
            <tr>
                <th>{{ $kode[$i][2] }}</th>
                <td>No HP: {{ $p->hp_pengawas ?? '-' }}</td>
            </tr>
        @endfor
        @php
            $maxDireksi = 3;
            $kode = [
                1 => ['P932', 'P933', 'P934'],
                2 => ['P935', 'P936', 'P937'],
                3 => ['P938', 'P939', 'P940'],
            ];
        @endphp
        @for ($i = 1; $i <= $maxDireksi; $i++)
            @php
                $p = $p932->firstWhere('direksi_ke', $i);
            @endphp
            <tr>
                <th>{{ $kode[$i][0] }}</th>
                <td>Nama Direksi {{ $i }}: {{ $p->nama_direksi ?? '-' }}</td>
            </tr>
            <tr>
                <th>{{ $kode[$i][1] }}</th>
                <td>NIK: {{ $p->nik_direksi ?? '-' }}</td>
            </tr>
            <tr>
                <th>{{ $kode[$i][2] }}</th>
                <td>No HP: {{ $p->hp_direksi ?? '-' }}</td>
            </tr>
        @endfor
        {{-- P941 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P941</th>
            <td>
                Unit usaha Bumdes <br>
                <table>
                    <tr>
                        <th>Unit usaha</th>
                        <th>Jumlah unit usaha</th>
                        <th>Jumlah pekerja (jiwa)</th>
                        <th>Keuntungan bersih tahun lalu (Rp)</th>
                        <th>Omset tahun lalu (Rp)</th>
                        <th>Aset unit usaha tahun lalu (Rp)</th>
                    </tr>
                    @if ($p941->count())
                        @foreach ($p941 as $loopItem)
                            <tr>
                                <td style="width: 30% !important">{{ $loopItem->unit_usaha_bumdes ?? '-' }}</td>
                                <td style="width: 5% !important">{{ $loopItem->jml_unit_usaha ?? '-' }}</td>
                                <td style="width: 5% !important">{{ $loopItem->jml_pekerja ?? '-' }}</td>
                                <td style="width: 20% !important">
                                    Rp.{{ number_format($loopItem->keuntungan_bersih, 0, ',', '.') ?? '-' }}</td>
                                <td style="width: 20% !important">
                                    Rp.{{ number_format($loopItem->omset_thn_lalu, 0, ',', '.') ?? '-' }}</td>
                                <td style="width: 20% !important">
                                    Rp.{{ number_format($loopItem->aset_thn_lalu, 0, ',', '.') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Tetap tampilkan layout tabel walau tidak ada data --}}
                        <tr>
                            <td style="width: 30% !important">-</td>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 20% !important">-</td>
                            <td style="width: 20% !important">-</td>
                            <td style="width: 20% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>

        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P10</b></th>
            <td style="width: 90% !important;"><b>INFRASTRUKTUR DESA</b></td>
        </tr>
        {{-- P10 --}}
        <tr>
            <th style="width: 15%; vertical-align: top;">P1001</th>
            <td>
                Transportasi dari kantor kepala desa ke kantor camat dan kantor bupati <br>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th rowspan="2">Sarana transportasi yang biasa digunakan sebagian besar penduduk
                            </th>
                            <th rowspan="2">Sarana transportasi yang biasa digunakan (kode 1)</th>
                            <th colspan="2">Jika ada angkutan umum</th>
                            <th rowspan="2">Jarak Tempuh (km)</th>
                            <th rowspan="2">Waktu Tempuh (menit)</th>
                            <th rowspan="2">Biaya Transportasi (x Rp 1000)</th>
                        </tr>

                        <tr>
                            <th>Jenis Angkutan Umum (kode 2)</th>
                            <th>Angkutan Umum yang utama (kode 2)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($p10->count())
                            @php
                                $kode1 = [
                                    1 => '1. angkutan umum',
                                    2 => '2. kendaraan pribadi',
                                    3 => '3. sepeda, becak, bentor, delman',
                                    4 => '4. jalan kaki, dll',
                                ];
                                $kode2 = [
                                    1 => '1. Ojek sepeda motor',
                                    2 => '2. kendaraan bermotor roda 3 atau lebih',
                                    3 => '3. perahu (bermotor maupun tidak bermotor)',
                                    4 => '4. Pesawat terbang',
                                    4 => '4. Lainnya (becak, delman, pedati, dll)',
                                ];
                            @endphp
                            @foreach ($p10 as $loopItem)
                                <tr>
                                    <td>{{ $loopItem->sarana_yg_digunakan ?? '-' }}</td>
                                    <td>{{ $kode1[$loopItem->sarana_transportasi] ?? '-' }}</td>
                                    <td>{{ $kode2[$loopItem->angkutan_umum] ?? '-' }}</td>
                                    <td>{{ $kode2[$loopItem->angkutan_umum_utama] ?? '-' }}</td>
                                    <td>{{ $loopItem->jarak_tempuh ?? '-' }}</td>
                                    <td>{{ $loopItem->waktu_tempuh ?? '-' }}</td>
                                    <td>Rp.{{ number_format($loopItem->biaya, 0, ',', '.') ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <table style="margin-top: 10px;">
                    <tr>
                        <td>
                            <b>Kode 1</b> <br>
                            1. angkutan umum <br>
                            2. kendaraan pribadi <br>
                            3. sepeda, becak, bentor, delman <br>
                            4. jalan kaki, dll
                        </td>

                        <td>
                            <b>Kode 2</b> <br>
                            1. Ojek sepeda motor <br>
                            2. kendaraan bermotor roda 3 atau lebih <br>
                            3. perahu (bermotor maupun tidak bermotor) <br>
                            4. Pesawat terbang <br>
                            5. Lainnya (becak, delman, pedati, dll)
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

    </table>

</body>

</html>

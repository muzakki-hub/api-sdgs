<!DOCTYPE html>
<html>

<head>
    <title>Export Data SDGs Keluarga</title>
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
                <b>KUESIONER RUMAH TANGGA (KELUARGA)</b>
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
            <td>Kabupaten/kota: {{ $p2->kabupaten->nama ?? '-' }}</td>
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
            <td>RT/RW: {{ $p2->rt ?? '-' }}/{{ $p2->rw ?? '-' }}</td>
        </tr>
        <tr>
            <th>P206</th>
            <td>Nama: {{ $p2->nama_kpl_keluarga ?? '-' }}</td>
        </tr>
        <tr>
            <th>P207</th>
            <td>Alamat: {{ $p2->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <th>P208</th>
            <td>Nomor HP: {{ $p2->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <th>P209</th>
            <td>Nomor telepon kabel/rumah: {{ $p2->telp_rumah ?? '-' }}</td>
        </tr>
        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>

        <tr>
            <th><b>P3</b></th>
            <td style="width: 90% !important;"><b>DESKRIPSI KELUARGA</b></td>
        </tr>

        <tr>
            <th>P301</th>
            <td>Nomor KK: {{ $p2->no_kk ?? '-' }}</td>
        </tr>
        <tr>
            <th>P302</th>
            <td> NIK Kepala Keluarga: {{ $p2->nik_kk ?? '-' }}</td>
        </tr>

        <tr>
            <th style="padding: 10px !important"></th>
            <td style="padding: 10px !important"></td>
        </tr>
        <tr>
            <th><b>P4</b></th>
            <td style="width: 90% !important;"><b>PERMUKIMAN</b></td>
        </tr>
        @php
            $tmpt = [
                1 => '1. Milik sendiri',
                2 => '2. Sewa/kost',
                3 => '3. Bebas Sewa',
                4 => '4. Dipinjami',
                5 => '5. Dinas',
                6 => '6. Lainnya',
            ];

            $lahan = [
                1 => '1. Milik sendiri',
                2 => '2. Miliih orang lain',
                3 => '3. Tanah negara',
                4 => '4. Lainnya',
            ];

            $lantai = [
                1 => '1. Marmer/Granit',
                2 => '2. Keramik',
                3 => '3. Parket/Vinil/Permadani',
                4 => '4. Ubin/Tegel/Teraso',
                5 => '5. Kayu/Papan kualitas tinggi',
                6 => '6. Semen/Bata Merah',
                7 => '7. Bambu',
                8 => '8. Kayu/Papan kualitas rendah',
                9 => '9. Bambu',
                10 => '10. Lainnya',
            ];

            $dinding = [
                1 => '1. Semen/beton/kayu berkualitas tinggi',
                2 => '2. Kayu berkualitas rendah/bamboo',
            ];

            $jendela = [
                1 => '1. Ada, berfungsi',
                2 => '2. Ada, tidak berfungsi',
                3 => '3. Tidak ada',
            ];

            $atap = [
                1 => '1. Genteng',
                2 => '2. Kayu/Jerami',
                3 => '3. Lainnya',
            ];

            $penerangan = [
                1 => '1. Listrik PLN',
                2 => '2. Listrik non PLN',
                3 => '3. Lampu minyak/lilin',
                4 => '4. Sumber penerangan lainnya',
                5 => '5. Tidak ada',
            ];

            $energi = [
                1 => '1. Gas kota/LPG/biogas (ke P407)',
                2 => '2. Minyak tanah/batu bara (ke P407)',
                3 => '3. Kayu Bakar',
                4 => '4. Lainnya (ke P407)',
            ];

            $kayu = [
                1 => '1. Pembelian',
                2 => '2. Diambil dari hutan',
                3 => '3. Diambil di luar/bukan hutan',
                4 => '4. lainnya',
            ];

            $sampah = [
                1 => '1. Tidak ada',
                2 => '2. Di Kebun/Sungai/Drainse',
                3 => '3. Dibakar',
                4 => '4. Tempat Sampah',
                5 => '5. Tempat Sampah diangkut reguler',
            ];

            $mck = [
                1 => '1. Sendiri',
                2 => '2. Berkelompok/Tetangga',
                3 => '3. MCK umum',
                4 => '4. Tidak ada',
            ];

            $air = [
                1 => '1. Ledeng/perpipaan berbayar/air isi ulang/kemasan',
                2 => '2. Perpipaan',
                3 => '3. Mata air/sumu',
                4 => '4. Sungai/danau/embung',
                5 => '5. Tadah air hujan',
                6 => '6. Lainnya',
            ];

            $bab = [
                1 => '1. Jamban Sendiri',
                2 => '2. Jamban Bersama/Tetangga',
                3 => '3. Jamban Umum',
            ];

            $minum = [
                1 => '1. Ledeng/Perpipaan berbayar/air isi ulang/kemasan',
                2 => '2. Mata aiar/perpipaan/sumur',
                3 => '3. Sungai/danau/embung',
                4 => '4. Tada Air Hujan',
                5 => '5. Lainnya',
            ];

            $limbah = [
                1 => '1. Tangki/Instalasi Pengelolaan Limbah',
                2 => '2. Sawah/Kolam/Sungai/Drainase/Laut',
                3 => '3. Lubang di Tanah',
                4 => '4. Lainnya',
            ];

            $suttet = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $sungai = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $lereng = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $blt = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $pkh = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $bst = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $banpres = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $umkm = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $pekerja = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $anak = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

            $lainnya = [
                1 => '1. Ya',
                2 => '2. Tidak',
            ];

        @endphp


        <tr>
    <th>P401</th>
    <td>Tempat tinggal yang ditempati:
        {{ $tmpt[ optional($p4)->tempat_tinggal_yg_ditempati ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P402</th>
    <td>Status lahan tempat tinggal yang ditempati:
        {{ $lahan[ optional($p4)->status_lahan_tempat_tinggal_yg_ditempati ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P403</th>
    <td>
        1. Luas lantai tempat tinggal:
        {{ optional($p4)->luas_lantai_ttl_terluas ?? '-' }} <br>

        2. Luas lahan tempat tinggal:
        {{ optional($p4)->luas_lahan_ttl_terluas ?? '-' }}
    </td>
</tr>

<tr>
    <th>P404</th>
    <td>Jenis lantai tempat tinggal terluas:
        {{ $lantai[ optional($p4)->jns_lantai_ttl_terluas ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P405</th>
    <td>Dinding sebagian besar rumah:
        {{ $dinding[ optional($p4)->dinding_sebagian_besar_rumah ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P406</th>
    <td>Jendela:
        {{ $jendela[ optional($p4)->jendela ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P407</th>
    <td>Atap:
        {{ $atap[ optional($p4)->atap ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P408</th>
    <td>Penerangan rumah:
        {{ $penerangan[ optional($p4)->penerangan_rumah ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P409</th>
    <td>Energi untuk memasak:
        {{ $energi[ optional($p4)->energi_untuk_memasak ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P410</th>
    <td>Jika menggunakan kayu bakar untuk memasak, sumber kayu bakar:
        {{ $kayu[ optional($p4)->sumber_kayu_bakar ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P411</th>
    <td>Tempat pembuangan sampah:
        {{ $sampah[ optional($p4)->tempat_pembuangan_sampah ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P412</th>
    <td>Fasilitas MCK:
        {{ $mck[ optional($p4)->fasilitas_mck ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P413</th>
    <td>Sumber air mandi terbanyak dari:
        {{ $air[ optional($p4)->sumber_air_mandi ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P414</th>
    <td>Fasilitas buang air besar:
        {{ $bab[ optional($p4)->fasilitas_bab ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P415</th>
    <td>Sumber air minum terbanyak dari:
        {{ $minum[ optional($p4)->sumber_air_minum ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P416</th>
    <td>Tempat pembuangan limbah cair:
        {{ $limbah[ optional($p4)->tmpt_pembuangan_limbah_cair ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P417</th>
    <td>Rumah berada di bawah SUTET/SUTT/SUTTAS:
        {{ $suttet[ optional($p4)->rumah_berada_dibawah ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P418</th>
    <td>Rumah di bantaran sungai:
        {{ $sungai[ optional($p4)->rumah_di_bantaran_sungai ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P419</th>
    <td>Rumah di lereng bukit/gunung:
        {{ $lereng[ optional($p4)->rumah_dilereng_bukit_gunung ] ?? '-' }}
    </td>
</tr>

<tr>
    <th>P420</th>
    <td>Secara keseluruhan kondisi rumah:
        {{ optional($p4)->secara_keseluruhan_kondisi_rumah ?? '-' }}
    </td>
</tr>

        <tr>
            <th>P421</th>
            <td>Akses Pendidikan terdekat </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Fasilitas</th>
                        <th>Jarak (km)</th>
                        <th>Waktu Tempuh (jam)</th>
                        <th>Kemudahan: <br>1. Mudah <br>2. Sulit</th>
                    </tr>
                    @if ($p421->count())
                        @foreach ($p421 as $loopItem)
                            <tr>
                                <td style="width: 5% !important">{{ $loop->iteration ?? '-' }}</td>
                                <td style="width: 30% !important">
                                    {{ $loopItem->pendidikan->jenjang_pendidikan ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->jarak ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->waktu_tempuh ?? '-' }}</td>
                                <td style="width: 35% !important">{{ $loopItem->kemudahan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Tetap tampilkan layout tabel walau tidak ada data --}}
                        <tr>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 30% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 35% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <th>P422</th>
            <td>Akses Fasilitas Kesehatan terdekat</td>
        </tr>
        <tr>
            <th></th>
            <td>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Fasilitas</th>
                        <th>Jarak (km)</th>
                        <th>Waktu Tempuh (jam)</th>
                        <th>Kemudahan: <br>1. Mudah <br>2. Sulit</th>
                    </tr>
                    @if ($p422->count())
                        @foreach ($p422 as $loopItem)
                            <tr>
                                <td style="width: 5% !important">{{ $loop->iteration ?? '-' }}</td>
                                <td style="width: 30% !important">
                                    {{ $loopItem->masterFaskes->jenjang_kesehatan ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->jarak ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->waktu_tempuh ?? '-' }}</td>
                                <td style="width: 35% !important">{{ $loopItem->kemudahan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Tetap tampilkan layout tabel walau tidak ada data --}}
                        <tr>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 30% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 35% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <th>P423</th>
            <td> Akses tenaga kesehatan terdekat</td>
        </tr>
        <tr>
            <th></th>
            <td>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Fasilitas</th>
                        <th>Jarak (km)</th>
                        <th>Waktu Tempuh (jam)</th>
                        <th>Kemudahan: <br>1. Mudah <br>2. Sulit</th>
                    </tr>
                    @if ($p423->count())
                        @foreach ($p423 as $loopItem)
                            <tr>
                                <td style="width: 5% !important">{{ $loop->iteration ?? '-' }}</td>
                                <td style="width: 30% !important">
                                    {{ $loopItem->masterTenkes->tenaga_kesehatan ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->jarak ?? '-' }}</td>
                                <td style="width: 15% !important">{{ $loopItem->waktu_tempuh ?? '-' }}</td>
                                <td style="width: 35% !important">{{ $loopItem->kemudahan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Tetap tampilkan layout tabel walau tidak ada data --}}
                        <tr>
                            <td style="width: 5% !important">-</td>
                            <td style="width: 30% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 15% !important">-</td>
                            <td style="width: 35% !important">-</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <th>P424</th>
            <td>Akses Prasarana dan Sarana Transportasi</td>
        </tr>
        <tr>
            <th></th>
            <td>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Tujuan</th>
                        <th>Jenis Transportasi terlama: <br>1. Darat <br>2. Air <br>3. Udara</th>
                        <th>Penggunaan transportasi umum: <br>1. Ya <br>2. Tidak</th>
                        <th> Waktu Tempuh Sekali Jalan (jam)</th>
                        <th> Biaya Sekali Jalan (rp)</th>
                        <th>Kemudahan: <br>1. Mudah <br>2. Sulit</th>
                    </tr>
                    {{-- @dd($$p24[0]->jenis_transportasi) --}}
                    @php
                        $jen_tran424 = [
                            1 => '1. Darat',
                            2 => '2. Air',
                            3 => '3. Udara',
                        ];
                        $pt424 = [
                            1 => '1. Ya',
                            2 => '2. Tidak',
                        ];
                        $kp424 = [
                            1 => '1. Mudah',
                            2 => '2. Sulit',
                        ];
                    @endphp
                    {{-- @dd($p424->has(0)); --}}
                    @foreach ($masterApst as $i => $item)
                        {
                        <tr>
                            <td style="width: 5% !important">{{ $i + 1 }}</td>
                            <td style="width: 20% !important">{{ $item->nama_akses ?? '-' }}</td>


                            <td style="width: 20% !important">
                                {{ $p424->has($i) ? $jen_tran424[$p424[$i]->jenis_transportasi] ?? '-' : '-' }}
                            </td>

                            <td style="width: 20% !important">
                                {{ $p424->has($i) ? $pt424[$p424[$i]->penggunaan_transportasi] ?? '-' : '-' }}
                            </td>

                            <td style="width: 10% !important">
                                {{ $p424->has($i) ? $p424[$i]->waktu_tempuh ?? '-' : '-' }}
                            </td>

                            <td style="width: 10% !important">
                                {{ $p424->has($i) ? $p424[$i]->biaya_sekali ?? '-' : '-' }}
                            </td>

                            <td style="width: 15% !important">
                                {{ $p424->has($i) ? $kp424[$p424[$i]->kemudahan] ?? '-' : '-' }}
                            </td>


                        </tr>
                        }
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <th>P425</th>
            <td>Pemanfaat/penerima program pemerintah: </td>
        </tr>
        <tr>
            <th></th>
<td>
    1. BLT Dana Desa: {{ $blt[ optional($p4)->blt_dana_desa ] ?? '-' }}<br>
    2. Program Keluarga Harapan/PKH: {{ $pkh[ optional($p4)->pkh ] ?? '-' }}<br>
    3. Bantuan Sosial Tunai/BST: {{ $bst[ optional($p4)->bst ] ?? '-' }}<br>
    4. Bantuan Presiden/Banpres: {{ $banpres[ optional($p4)->banpres ] ?? '-' }}<br>
    5. Bantuan UMKM: {{ $umkm[ optional($p4)->bantuan_umkm ] ?? '-' }}<br>
    6. Bantuan untuk pekerja: {{ $pekerja[ optional($p4)->bantuan_pekerja ] ?? '-' }}<br>
    7. Bantuan pendidikan anak: {{ $anak[ optional($p4)->bantuan_anak ] ?? '-' }}<br>
    8. Lainnya: {{ $lainnya[ optional($p4)->lainnya ] ?? '-' }}<br>
</td>

        </tr>
    </table>

</body>

</html>

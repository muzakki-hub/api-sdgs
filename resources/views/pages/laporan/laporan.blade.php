<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Rekap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 6px;
            border: 1px solid #000000;
            text-align: left;
        }

        .table-pertama {
            border: none !important;
        }

        .th-atas {
            width: 20%;
            text-align: left;
            border: none !important;
        }

        .titik-dua {
            width: 5%;
            border: none !important;
        }

        .td-atas {
            width: 75%;
            border: none !important;
        }

        .sub-tb tr td {
            border: none !important;
        }

        @media print {
            thead {
                display: table-row-group;
            }
        }
    </style>
</head>

<body>

    <h2>Laporan Demografi Sustainable Development Goals</h2>

    <table class="table-pertama">
        <tr>
            <th class="th-atas">Nama Survey</th>
            <td class="titik-dua">:</td>
            <td class="td-atas">{{ $surveyAktif }}</td>
        </tr>
        <tr>
            <th class="th-atas">Periode Pengisian</th>
            <td class="titik-dua">:</td>
            <td class="td-atas">{{ $mulai }} s/d {{ $batas }}</td>
        </tr>

    </table>

    <br>

    <table>
        <tr>
            <th style="width: 60%">Item</th>
            <th style="width: 20%">Jumlah tersurvei</th>
            <th style="width: 20%">Jumlah seharusnya</th>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Jumlah Penduduk</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">{{ $totalIndividu }}</td>
                    </tr>
                </table>
            </td>
            <td>1300</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Jumlah Keluarga</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">{{ $totalKeluarga }}</td>
                    </tr>
                </table>
            </td>
            <td>1000</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Jumlah RW</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">{{ $totalRW }}</td>
                    </tr>
                </table>
            </td>
            <td>1000</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Jumlah RT</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">{{ $totalRT }}</td>
                    </tr>
                </table>
            </td>
            <td>1000</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Jumlah Tempat Tinggal</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">a. Milik sendiri</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">b. Lainnya</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">&nbsp;</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $tempatTinggal1 }}</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $tempatTinggalLainnya }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Status Lahan Tempat Tinggal</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">a. Milik sendiri</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">b. Lainnya</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">&nbsp;</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $statusLahan1 }}</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $statusLahanlainnya }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Jenis Kelamin</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">a. Laki Laki</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">b. Perempuan</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">&nbsp;</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $totalLk }}</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $totalPr }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important;padding: 5px">
                        <td style="border: none !important;padding: 5px">Agama</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">a. Islam</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">b. Lainnya</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width:100%;border: none !important">
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">&nbsp;</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $totalAgamaIslam }}</td>
                    </tr>
                    <tr style="border: none !important">
                        <td style="border: none !important;padding: 5px">{{ $totalAgamaLainnya }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
        <tr>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>Status Pernikahan</td>
                    </tr>
                    <tr>
                        <td>a. Kawin</td>
                    </tr>
                    <tr>
                        <td>b. Tidak Kawin</td>
                    </tr>
                    <tr>
                        <td>c. Duda/Janda</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>{{ $totalKawin }}</td>
                    </tr>
                    <tr>
                        <td>{{ $totalTidakKawin }}</td>
                    </tr>
                    <tr>
                        <td>{{ $totalDudaJanda }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
        <tr>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>Pekerjaan</td>
                    </tr>
                    <tr>
                        <td>a. Petani Pemilik Lahan</td>
                    </tr>
                    <tr>
                        <td>b. Petani penyewa</td>
                    </tr>
                    <tr>
                        <td>c. Buruh tani</td>
                    </tr>
                    <tr>
                        <td>d. Nelayan pemilik kapal/perahu</td>
                    </tr>
                    <tr>
                        <td>e. Nelayan penyewa Perahu/Kapal</td>
                    </tr>
                    <tr>
                        <td>f. Buruh nelayan</td>
                    </tr>
                    <tr>
                        <td>g. Guru</td>
                    </tr>
                    <tr>
                        <td>h. Guru Agama</td>
                    </tr>
                    <tr>
                        <td>i. Pedagang</td>
                    </tr>
                    <tr>
                        <td>j. Pengolahan/industri</td>
                    </tr>
                    <tr>
                        <td>k. PNS</td>
                    </tr>
                    <tr>
                        <td>l. TNI</td>
                    </tr>
                    <tr>
                        <td>m. Perangkat desa</td>
                    </tr>
                    <tr>
                        <td>n. Pegawai kantor desa</td>
                    </tr>
                    <tr>
                        <td>o. TKI</td>
                    </tr>
                    <tr>
                        <td>p. Lainnya</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan1 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan2 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan3 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan4 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan5 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan6 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan7 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan8 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan9 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan10 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan11 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan12 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan13 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan14 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan15 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pekerjaan16 }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
        <tr>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>Jumlah Penduduk Disabilitas</td>
                    </tr>
                    <tr>
                        <td>a. Tunanetra (buta)</td>
                    </tr>
                    <tr>
                        <td>b. Tunarungu (tuli)</td>
                    </tr>
                    <tr>
                        <td>c. Tunawicara (bisu)</td>
                    </tr>
                    <tr>
                        <td>d. Tunarungu–wicara (tuli–bisu)</td>
                    </tr>
                    <tr>
                        <td>e. Tunadaksa</td>
                    </tr>
                    <tr>
                        <td>f. Tunagrahita</td>
                    </tr>
                    <tr>
                        <td>g. Tunalaras</td>
                    </tr>
                    <tr>
                        <td>h. Cacat eks–sakit kusta</td>
                    </tr>
                    <tr>
                        <td>i. Cacat ganda</td>
                    </tr>
                    <tr>
                        <td>j. Dipasung</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>{{ $tunanetra }}</td>
                    </tr>
                    <tr>
                        <td>{{ $tunarungu }}</td>
                    </tr>
                    <tr>
                        <td>{{ $tunawicara }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>{{ $tunadaksa }}</td>
                    </tr>
                    <tr>
                        <td>{{ $tunagrahita }}</td>
                    </tr>
                    <tr>
                        <td>{{ $tunalaras }}</td>
                    </tr>
                    <tr>
                        <td>{{ $cacat_eks_sakitkusta }}</td>
                    </tr>
                    <tr>
                        <td>{{ $cacat_ganda }}</td>
                    </tr>
                    <tr>
                        <td>{{ $dipasung }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
        <tr>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>Pendidikan Terakhir</td>
                    </tr>
                    <tr>
                        <td>a. Tidak sekolah</td>
                    </tr>
                    <tr>
                        <td>b. SD dan sederajat</td>
                    </tr>
                    <tr>
                        <td>c. SMP dan sederajat</td>
                    </tr>
                    <tr>
                        <td>d. SMA dan sederajat</td>
                    </tr>
                    <tr>
                        <td>e. Diploma 1-3</td>
                    </tr>
                    <tr>
                        <td>f. S1 dan sederajat</td>
                    </tr>
                    <tr>
                        <td>g. S2 dan sederajat</td>
                    </tr>
                    <tr>
                        <td>h. S3 dan sederajat</td>
                    </tr>
                    <tr>
                        <td>i. Pesantren, seminari,wihara dan sejenisnya</td>
                    </tr>
                    <tr>
                        <td>j. Lainnya</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="sub-tb">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan1 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan2 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan3 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan4 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan5 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan6 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan7 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan8 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan9 }}</td>
                    </tr>
                    <tr>
                        <td>{{ $pendidikan10 }}</td>
                    </tr>
                </table>
            </td>
            <td>-</td>
        </tr>
    </table>

</body>

</html>

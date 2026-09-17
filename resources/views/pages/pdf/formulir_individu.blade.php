<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Form SDGs - Individu</title>
<style>

    @page { margin: 18mm; }

    body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        color: #000;
        margin: 0;
        padding: 0;
    }

    .title-block, .section-block {
        border: 2px solid #000;
        padding: 6px 8px;
        margin-bottom: 12px;
        page-break-inside: avoid;
    }

    .title-block .title,
    .section-block .title {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 6px;
        text-transform: uppercase;
    }

    .form-table, .p204-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
    }

    .form-table th, .form-table td,
    .p204-table th, .p204-table td {
        border: 1px solid #000;
        padding: 4px 5px;
        vertical-align: top;
    }

    .code { width: 6%; }
    .label { width: 22%; font-weight: bold; }
    .value { width: 72%; }

    .p204-table th {
        text-align: center;
        font-weight: bold;
    }

    .p204-table td {
        font-size: 9px;
    }

    .page-break {
        page-break-before: always;
    }

</style>
</head>
<body>

{{-- =================================== --}}
{{-- P1 --}}
{{-- =================================== --}}
<div class="title-block">
    <div class="title">P1 Deskripsi Individu</div>

    <table class="form-table">
        <tr><th class="code">P101</th><th class="label">Nomor KK</th><td class="value">: {{ $p1->no_kk ?? '-' }}</td></tr>
        <tr><th class="code">P102</th><th class="label">NIK</th><td class="value">: {{ $p1->nik ?? '-' }}</td></tr>
        <tr><th class="code">P103</th><th class="label">Nama</th><td class="value">: {{ $p1->nama ?? '-' }}</td></tr>

        <tr>
            <th class="code">P104</th>
            <th class="label">Jenis kelamin</th>
            <td class="value">
                : @if($p1->jenis_kelamin == 1) Laki-laki
                  @elseif($p1->jenis_kelamin == 2) Perempuan
                  @else - @endif
            </td>
        </tr>

        <tr><th class="code">P105</th><th class="label">Tempat lahir</th><td class="value">: {{ $p1->tempat_lahir ?? '-' }}</td></tr>
        <tr><th class="code">P106</th><th class="label">Tanggal lahir</th><td class="value">: {{ $p1->tgl_lahir ?? '-' }}</td></tr>

        <tr>
            <th class="code">P107</th>
            <th class="label">Status Pernikahan</th>
            <td class="value">
                @php $sp=[1=>'Kawin',2=>'Tidak kawin',3=>'Duda/Janda']; @endphp
                : {{ $sp[$p1->status_pernikahan] ?? '-' }}
            </td>
        </tr>

        <tr>
            <th class="code">P108</th>
            <th class="label">Agama</th>
            <td class="value">
                @php $agm=[1=>'Islam',2=>'Kristen',3=>'Katolik',4=>'Hindu',5=>'Budha',6=>'Konghucu']; @endphp
                : {{ $agm[$p1->agama] ?? '-' }}
            </td>
        </tr>

        <tr><th class="code">P109</th><th class="label">Suku bangsa</th><td class="value">: {{ $p1->suku_bangsa ?? '-' }}</td></tr>

        <tr>
            <th class="code">P110</th>
            <th class="label">Warganegara</th>
            <td class="value">
                : @if($p1->warganegara == 1) WNI
                  @elseif($p1->warganegara == 2) WNA
                  @else - @endif
            </td>
        </tr>

        <tr><th class="code">P111</th><th class="label">Nomor HP</th><td class="value">: {{ $p1->no_hp ?? '-' }}</td></tr>
        <tr><th class="code">P112</th><th class="label">Whatsapp</th><td class="value">: {{ $p1->no_wa ?? '-' }}</td></tr>
        <tr><th class="code">P113</th><th class="label">Email</th><td class="value">: {{ $p1->email ?? '-' }}</td></tr>
        <tr><th class="code">P114</th><th class="label">Facebook</th><td class="value">: {{ $p1->facebook ?? '-' }}</td></tr>
        <tr><th class="code">P115</th><th class="label">Twitter</th><td class="value">: {{ $p1->twitter ?? '-' }}</td></tr>
        <tr><th class="code">P116</th><th class="label">Instagram</th><td class="value">: {{ $p1->instagram ?? '-' }}</td></tr>
    </table>
</div>



{{-- =================================== --}}
{{-- P2 --}}
{{-- =================================== --}}
<div class="section-block">
    <div class="title">P2 Deskripsi Pekerjaan</div>

    <table class="form-table">

        {{-- P201 --}}
        <tr>
            <th class="code">P201</th>
            <th class="label">Kondisi pekerjaan</th>
            <td class="value">
                @php $kp=[1=>'Bersekolah',2=>'Ibu rumah tangga',3=>'Tidak bekerja',4=>'Sedang mencari pekerjaan',5=>'Bekerja']; @endphp
                : {{ $kp[$p2?->kondisi_pekerjaan] ?? '-' }}
            </td>
        </tr>

        {{-- P202 --}}
        <tr>
            <th class="code">P202</th>
            <th class="label">Pekerjaan utama</th>
            <td class="value">
                @php
                    $pu = [
                        1=>'Petani pemilik lahan',2=>'Petani penyewa',3=>'Buruh tani',4=>'Nelayan pemilik kapal/perahu',
                        5=>'Nelayan penyewa',6=>'Buruh nelayan',7=>'Guru',8=>'Guru agama',9=>'Pedagang',
                        10=>'Pengolahan/Industri',11=>'PNS',12=>'TNI',13=>'Perangkat desa',
                        14=>'Pegawai kantor desa',15=>'TKI',16=>'Lainnya'
                    ];
                @endphp

                : {{ $pu[$p2?->pekerjaan_utama] ?? ($p2?->pekerjaan_lainnya ?? '-') }}
            </td>
        </tr>

        {{-- P203 --}}
        <tr>
            <th class="code">P203</th>
            <th class="label">Jaminan Sosial Ketenagakerjaan</th>
            <td class="value">
                : @if($p2?->jsk == 1) Peserta
                  @elseif($p2?->jsk == 2) Bukan peserta
                  @else - @endif
            </td>
        </tr>
    </table>
</div>



{{-- =================================== --}}
{{-- P204 --}}
{{-- =================================== --}}
<div class="section-block">
    <div class="title">P204 Penghasilan setahun terakhir (Rp)</div>

    <table class="p204-table">
        <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Sumber Penghasilan</th>
            <th colspan="2">Volume</th>
            <th rowspan="2">Penghasilan<br>(Rp)</th>
            <th rowspan="2">Diekspor</th>
        </tr>

        <tr>
            <th>Jumlah</th>
            <th>Satuan</th>
        </tr>
        </thead>

        <tbody>
        @foreach($mpenghasilan as $i => $m)
            @php $row = $p204->get($m->id); @endphp
            <tr>
                <td style="text-align:center">{{ $i+1 }}</td>
                <td>{{ $m->nama_komoditas }}</td>

                <td style="text-align:center">{{ $row?->jumlah ?? '-' }}</td>
                <td style="text-align:center">{{ $row?->satuan ?? '-' }}</td>

                <td style="text-align:right">
                    {{ !empty($row?->penghasilan) ? number_format($row->penghasilan,0,',','.') : '-' }}
                </td>

                <td style="text-align:center">
                    @if($row?->diekspor == 1) Semua
                    @elseif($row?->diekspor == 2) Sebagian besar
                    @elseif($row?->diekspor == 3) Tidak
                    @else -
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



{{-- =================================== --}}
{{-- P4 --}}
{{-- =================================== --}}
<div class="section-block page-break">
    <div class="title">P4 Deskripsi Kesehatan</div>

    <table class="form-table">

        {{-- P401 --}}
        <tr>
            <th class="code">P401</th>
            <th class="label">Penyakit setahun terakhir</th>
            <td class="value">
                @foreach($mpenyakit as $i=>$mp)
                    @php $val = $p401->get($mp->id)?->status; @endphp
                    {{ $i+1 }}. {{ $mp->jenis_penyakit }} :
                    {{ $val == 1 ? 'Ya' : ($val == 2 ? 'Tidak' : '-') }} <br>
                @endforeach
            </td>
        </tr>

        {{-- P402 --}}
        <tr>
            <th class="code">P402</th>
            <th class="label">Fasilitas kesehatan dikunjungi</th>
            <td class="value">
                @foreach($msarkes as $i=>$ms)
                    @php $row = $p402->get($ms->id); @endphp
                    {{ $i+1 }}. {{ $ms->nama_sarkes }} : {{ $row?->jml_berkunjung ?? '0' }} <br>
                @endforeach
            </td>
        </tr>

        {{-- P4 JSK --}}
        <tr>
            <th class="code">P403</th>
            <th class="label">Jaminan sosial kesehatan</th>
            <td class="value">
                : @if($p4?->jsk == 1) Peserta
                  @elseif($p4?->jsk == 2) Bukan peserta
                  @else - @endif
            </td>
        </tr>

    </table>
</div>



{{-- =================================== --}}
{{-- P403 --}}
{{-- =================================== --}}
<div class="section-block">
    <div class="title">P403 Disabilitas</div>

    <table class="form-table">
        @php
        $dis = [
            'tunanetra'=>'Tunanetra (buta)',
            'tunarungu'=>'Tunarungu (tuli)',
            'tunawicara'=>'Tunawicara (bisu)',
            'tunarungu_wicara'=>'Tunarungu–wicara (tuli–bisu)',
            'tunadaksa'=>'Tunadaksa (cacat tubuh)',
            'tunagrahita'=>'Tunagrahita (cacat mental)',
            'tunalaras'=>'Tunalaras (eks sakit jiwa)',
            'cacat_eks_sakitkusta'=>'Cacat eks sakit kusta',
            'cacat_ganda'=>'Cacat ganda (fisik–mental)',
            'dipasung'=>'Dipasung'
        ];
        @endphp

        @foreach(array_values($dis) as $i=>$label)
            @php 
                $keys = array_keys($dis);
                $key = $keys[$i];
                $val = $p4?->$key;
            @endphp
            <tr>
                <th class="code">{{ $i+1 }}</th>
                <th class="label">{{ $label }}</th>
                <td class="value">
                    : @if($val == 1) Ya @elseif($val == 2) Tidak @else - @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>



{{-- =================================== --}}
{{-- P5 --}}
{{-- =================================== --}}
<div class="section-block">
    <div class="title">P5 Deskripsi Pendidikan & Partisipasi Sosial</div>

    <table class="form-table">

        {{-- P501 --}}
        @php
            $pd=[1=>'Tidak sekolah',2=>'SD',3=>'SMP',4=>'SMA',5=>'Diploma 1-3',
                6=>'S1',7=>'S2',8=>'S3',9=>'Pesantren/Seminary',10=>'Lainnya'];
        @endphp

        <tr>
            <th class="code">P501</th>
            <th class="label">Pendidikan tertinggi</th>
            <td class="value">: {{ $pd[$p5?->pendidikan_terakhir] ?? '-' }}</td>
        </tr>

        {{-- P502 --}}
        <tr><th class="code">P502</th><th class="label">Bahasa di rumah</th><td class="value">: {{ $p5?->bahasa_rumah ?? '-' }}</td></tr>

        {{-- P503 --}}
        <tr><th class="code">P503</th><th class="label">Bahasa formal</th><td class="value">: {{ $p5?->bahasa_formal ?? '-' }}</td></tr>

        {{-- P504 --}}
        <tr><th class="code">P504</th><th class="label">Kerja bakti setahun terakhir</th><td class="value">: {{ $p5?->kerja_bakti ?? '0' }}</td></tr>

        {{-- P505 --}}
        <tr><th class="code">P505</th><th class="label">Siskamling setahun terakhir</th><td class="value">: {{ $p5?->siskampling ?? '0' }}</td></tr>

        {{-- P506 --}}
        <tr><th class="code">P506</th><th class="label">Pesta rakyat / adat</th><td class="value">: {{ $p5?->pesta_rakyat ?? '0' }}</td></tr>

        {{-- P507 --}}
        <tr><th class="code">P507</th><th class="label">Menolong kematian</th><td class="value">: {{ $p5?->menolong_kematian ?? '0' }}</td></tr>

        {{-- P508 --}}
        <tr><th class="code">P508</th><th class="label">Menolong sakit</th><td class="value">: {{ $p5?->menolong_sakit ?? '0' }}</td></tr>

        {{-- P509 --}}
        <tr><th class="code">P509</th><th class="label">Menolong kecelakaan</th><td class="value">: {{ $p5?->menolong_kecelakaan ?? '0' }}</td></tr>

    </table>
</div>

</body>
</html>

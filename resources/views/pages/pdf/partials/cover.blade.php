<div class="cover-page-wrapper" style="width: 100%; box-sizing: border-box; page-break-inside: avoid; font-family: 'Times New Roman', Times, serif, Arial;">

    {{-- 1. Header SDGs Image --}}
    @if(!empty($cover['header_img']))
        <div style="text-align: center; margin-bottom: 22px;">
            <img src="{{ $cover['header_img'] }}" style="width: 72%; max-width: 500px; height: auto;" alt="SDGs Desa Header">
        </div>
    @endif

    {{-- 2. Title Section --}}
    <div style="text-align: center; margin-bottom: 30px;">
        @if(($cover['level'] ?? '') === 'individu')
            <h1 style="margin: 0; font-size: 22pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #000;">
                KUESIONER UNTUK INDIVIDU
            </h1>
            <p style="margin: 6px 0 0 0; font-size: 10.5pt; font-style: italic; font-weight: bold; color: #000;">
                FORMULIR DICETAK SEJUMLAH ANGGOTA KARTU KELUARGA/JUMLAH PENDUDUK/JIWA DALAM DESA
            </p>
        @elseif(($cover['level'] ?? '') === 'keluarga')
            <h1 style="margin: 0; font-size: 22pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #000; line-height: 1.15;">
                KUESIONER UNTUK KELUARGA<br>
                <span style="font-size: 18pt;">(RUMAH TANGGA)</span>
            </h1>
            <p style="margin: 8px 0 0 0; font-size: 10.5pt; font-style: italic; font-weight: bold; color: #000;">
                FORMULIR DICETAK SEJUMLAH KARTU KELUARGA DALAM DESA
            </p>
        @elseif(($cover['level'] ?? '') === 'rt')
            <h1 style="margin: 0; font-size: 21pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #000;">
                KUESIONER UNTUK RUKUN TETANGGA (RT)
            </h1>
            <p style="margin: 6px 0 0 0; font-size: 10.5pt; font-style: italic; font-weight: bold; color: #000;">
                FORMULIR DICETAK SEJUMLAH RUKUN TETANGGA DALAM DESA
            </p>
        @endif
    </div>

    {{-- 3. Identitas / Middle Fields --}}
    @if(($cover['level'] ?? '') === 'rt')
        {{-- Layout Khusus RT --}}
        <div style="margin: 0 auto 35px 40px; font-size: 14pt; font-weight: bold;">
            <table style="width: 90%; border-collapse: separate; border-spacing: 0 10px; border: none !important;">
                <tr>
                    <td style="width: 130px; font-weight: bold; border: none !important; padding: 4px 0; vertical-align: bottom;">RT</td>
                    <td style="width: 25px; text-align: center; border: none !important; padding: 4px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 4px; font-weight: bold; vertical-align: bottom; width: 140px;">
                        {{ $cover['rt'] ?? '-' }}
                    </td>
                    <td style="border: none !important;"></td>
                </tr>
                <tr>
                    <td style="width: 130px; font-weight: bold; border: none !important; padding: 4px 0; vertical-align: bottom;">RW</td>
                    <td style="width: 25px; text-align: center; border: none !important; padding: 4px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 4px; font-weight: bold; vertical-align: bottom; width: 140px;">
                        {{ $cover['rw'] ?? '-' }}
                    </td>
                    <td style="border: none !important;"></td>
                </tr>
                <tr>
                    <td style="width: 130px; font-weight: bold; border: none !important; padding: 4px 0; vertical-align: bottom;">DUSUN</td>
                    <td style="width: 25px; text-align: center; border: none !important; padding: 4px 0; vertical-align: bottom;">:</td>
                    <td colspan="2" style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 4px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['dusun'] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 130px; font-weight: bold; border: none !important; padding: 4px 0; vertical-align: bottom;">DESA</td>
                    <td style="width: 25px; text-align: center; border: none !important; padding: 4px 0; vertical-align: bottom;">:</td>
                    <td colspan="2" style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 4px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['desa'] ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>
    @else
        {{-- Layout Individu & Keluarga --}}
        <div style="margin: 0 auto 30px auto; font-size: 12pt;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 8px; border: none !important;">
                <tr>
                    <td style="width: 240px; font-weight: normal; border: none !important; padding: 3px 0; vertical-align: bottom; letter-spacing: 0.3px;">
                        NOMOR KARTU KELUARGA
                    </td>
                    <td style="width: 20px; text-align: center; border: none !important; padding: 3px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 6px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['no_kk'] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 240px; font-weight: normal; border: none !important; padding: 3px 0; vertical-align: bottom; letter-spacing: 0.3px;">
                        NAMA KEPALA KELUARGA
                    </td>
                    <td style="width: 20px; text-align: center; border: none !important; padding: 3px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 6px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['nama_kepala_keluarga'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 240px; font-weight: normal; border: none !important; padding: 3px 0; vertical-align: bottom; letter-spacing: 0.3px;">
                        ALAMAT DUSUN
                    </td>
                    <td style="width: 20px; text-align: center; border: none !important; padding: 3px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 6px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['alamat_dusun'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 240px; font-weight: normal; border: none !important; padding: 3px 0; vertical-align: bottom; letter-spacing: 0.3px;">
                        DESA
                    </td>
                    <td style="width: 20px; text-align: center; border: none !important; padding: 3px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 6px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['desa'] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 240px; font-weight: normal; border: none !important; padding: 3px 0; vertical-align: bottom; letter-spacing: 0.3px;">
                        KECAMATAN
                    </td>
                    <td style="width: 20px; text-align: center; border: none !important; padding: 3px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 6px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['kecamatan'] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 240px; font-weight: normal; border: none !important; padding: 3px 0; vertical-align: bottom; letter-spacing: 0.3px;">
                        KABUPATEN
                    </td>
                    <td style="width: 20px; text-align: center; border: none !important; padding: 3px 0; vertical-align: bottom;">:</td>
                    <td style="border: none !important; border-bottom: 1.5px solid #000 !important; padding: 2px 6px; font-weight: bold; vertical-align: bottom;">
                        {{ $cover['kabupaten'] ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>
    @endif

    {{-- 4. Kotak Enumerator / Petugas Pendata --}}
    <div style="margin-top: 25px;">
        <table style="width: 100%; border-collapse: collapse; border: 1.5px solid #000 !important; font-family: Arial, sans-serif;">
            <thead>
                <tr>
                    <th style="background-color: #d8d8d8; border: 1.5px solid #000 !important; padding: 7px 5px; font-size: 9.5pt; font-weight: bold; text-align: center; text-transform: uppercase;">
                        NAMA ENUMERATOR / PETUGAS PENDATA &amp; PENGINPUT KE APLIKASI ANDROID SDGs DESA :
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1.5px solid #000 !important; height: 35px; text-align: center; vertical-align: middle; font-size: 11pt; font-weight: bold; text-transform: uppercase; padding: 4px;">
                        {{ $cover['enumerator_nama'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #d8d8d8; border: 1.5px solid #000 !important; padding: 6px 5px; font-size: 9.5pt; font-weight: bold; text-align: center; text-transform: uppercase;">
                        JABATAN DALAM POKJA PENDATAAN DESA :
                    </th>
                </tr>
                <tr>
                    <td style="border: 1.5px solid #000 !important; height: 35px; text-align: center; vertical-align: middle; font-size: 11pt; font-weight: bold; text-transform: uppercase; padding: 4px;">
                        {{ $cover['enumerator_jabatan'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #d8d8d8; border: 1.5px solid #000 !important; padding: 6px 5px; font-size: 9.5pt; font-weight: bold; text-align: center; text-transform: uppercase;">
                        TANDA TANGAN :
                    </th>
                </tr>
                <tr>
                    <td style="border: 1.5px solid #000 !important; height: 75px; text-align: center; vertical-align: middle; padding: 4px;">
                        @if (!empty($cover['enumerator_ttd']))
                            <img src="{{ $cover['enumerator_ttd'] }}" alt="Tanda Tangan Enumerator" style="max-height: 65px; max-width: 220px; display: inline-block;">
                        @else
                            {{-- Dikosongkan untuk tanda tangan basah --}}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

{{-- Page break agar kuesioner form dimulai tepat di Halaman 2 --}}
<div style="page-break-after: always; clear: both;"></div>

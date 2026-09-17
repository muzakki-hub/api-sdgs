<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;

class WilayahController extends Controller
{
    public function provinces()
    {
        // provinsi: kode 2 digit
        $data = Wilayah::whereRaw('LENGTH(kode) = 2')->get();
        return response()->json($data);
    }

    public function regencies($provinceCode)
    {
        // kabupaten: kode format 11.xx (5 karakter termasuk titik)
        $data = Wilayah::where('kode', 'like', $provinceCode . '.%')
            ->whereRaw('LENGTH(kode) = 5')
            ->get();
        return response()->json($data);
    }

    public function districts($regencyCode)
    {
        // kecamatan: kode format 11.xx.xx (8 karakter)
        $data = Wilayah::where('kode', 'like', $regencyCode . '.%')
            ->whereRaw('LENGTH(kode) = 8')
            ->get();
        return response()->json($data);
    }

    public function villages($districtCode)
    {
        // desa: kode format 11.xx.xx.xxxx (13 karakter)
        $data = Wilayah::where('kode', 'like', $districtCode . '.%')
            ->whereRaw('LENGTH(kode) = 13')
            ->get();
        return response()->json($data);
    }
}

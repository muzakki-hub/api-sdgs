<?php

namespace App\Http\Controllers\Api\RT\P5;

use Carbon\Carbon;
use App\Models\RT\P5\RtP5M;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class P5RtController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_p4' => 'required|string|max:25',

            'jml_pt_tki' => 'nullable|integer',
            'jml_orang_tki' => 'nullable|integer',

            'jml_sentra_industri' => 'nullable|integer',
            'jml_lik' => 'nullable|integer',
            'jml_pik' => 'nullable|integer',

            'ada_tempat_hiburan' => 'required|in:1,2',
            'jarak_tempat_hiburan' => 'required_if:ada_tempat_hiburan,2|nullable|integer',

            'ada_pangkalan_minyak' => 'required|in:1,2',
            'ada_pangkalan_lpg' => 'required|in:1,2',

            'jml_kud' => 'nullable|integer',
            'jml_kud_tani' => 'nullable|integer',
            'jml_kud_kredit' => 'nullable|integer',
            'jml_kud_lain' => 'nullable|integer',

            'jml_kopinkra' => 'nullable|integer',
            'jml_kospin' => 'nullable|integer',
            'jml_koperasi_serbausaha' => 'nullable|integer',
            'jml_koperasi_lain' => 'nullable|integer',

            'kios_kud' => 'required|in:1,2',
            'kios_bumdes' => 'required|in:1,2',
            'kios_lain' => 'required|in:1,2',

            'kur' => 'required|in:1,2',
            'kkpe' => 'required|in:1,2',
            'kuk' => 'required|in:1,2',
            'kube' => 'required|in:1,2',
        ]);

        if ($validated["ada_tempat_hiburan"] == "1") {
            $validated['jarak_tempat_hiburan'] = null;
        }

        $id = 'RTP5-' . strtotime(now());

        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();


        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        try {
            RtP5M::create(array_merge($validated, [
                'id'         => $id,
                'id_buat'    => $userId,
                'id_update'  => $userId,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P5 berhasil disimpan!',
                'id' => $id,
                'data' => [
                    'id' => $id,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P5: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $idP4)
    {
        $data = RtP5M::where('id_p4', $idP4)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P5 tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P5 ditemukan.',
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = RtP5M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P5 tidak ditemukan.',
            ], 404);
        }


        $validated = $request->validate([
            'id_p4' => 'required|string|max:100',

            'jml_pt_tki' => 'nullable|integer',
            'jml_orang_tki' => 'nullable|integer',

            'jml_sentra_industri' => 'nullable|integer',
            'jml_lik' => 'nullable|integer',
            'jml_pik' => 'nullable|integer',

            'ada_tempat_hiburan' => 'required|in:1,2',
            'jarak_tempat_hiburan' => 'nullable|numeric',

            'ada_pangkalan_minyak' => 'required|in:1,2',
            'ada_pangkalan_lpg' => 'required|in:1,2',

            'jml_kud' => 'nullable|integer',
            'jml_kud_tani' => 'nullable|integer',
            'jml_kud_kredit' => 'nullable|integer',
            'jml_kud_lain' => 'nullable|integer',
            'jml_kopinkra' => 'nullable|integer',
            'jml_kospin' => 'nullable|integer',
            'jml_koperasi_serbausaha' => 'nullable|integer',
            'jml_koperasi_lain' => 'nullable|integer',

            'kios_kud' => 'nullable|integer',
            'kios_bumdes' => 'nullable|integer',
            'kios_lain' => 'nullable|integer',

            'kur' => 'required|in:1,2',
            'kkpe' => 'required|in:1,2',
            'kuk' => 'required|in:1,2',
            'kube' => 'required|in:1,2',
        ]);

        if ($validated["ada_tempat_hiburan"] == "1") {
            $validated['jarak_tempat_hiburan'] = null;
        }

        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();


        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        $data->update(array_merge($validated, [
            'id_update'  => $userId,
            'tgl_update' => now(),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data RT P5 berhasil diperbarui.',
            'data' => $data,
        ]);
    }

    public function destroy(string $idP4)
    {
        $data = RtP5M::where('id_p4', $idP4)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P5 tidak ditemukan.',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data RT P5 berhasil dihapus.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\RT\P7;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P7\TransaksiGunaSumberP7RTM;

class TransaksiGunaSumberP7RtController extends Controller
{
    public function store(Request $request)
    {
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

        $validated = $request->validate([
            'id_master_guna_sumber' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',


            'sungai' => 'required|in:1,2,3',
            'kondisi_sungai' => 'sometimes|in:1,2,3',

            'saluran_irigasi' => 'required|in:1,2,3',
            'kondisi_saluran_irigasi' => 'sometimes|in:1,2,3',

            'danau' => 'required|in:1,2,3',
            'kondisi_danau' => 'sometimes|in:1,2,3',

            'embung' => 'required|in:1,2,3',
            'kondisi_embung' => 'sometimes|in:1,2,3',
        ]);

        $rules = [
            'sungai' => 'kondisi_sungai',
            'saluran_irigasi' => 'kondisi_saluran_irigasi',
            'danau' => 'kondisi_danau',
            'embung' => 'kondisi_embung',
        ];

        foreach ($rules as $parent => $child) {
            if (($validated[$parent] ?? null) == 3) {
                $validated[$child] = 3;
            }
        }


        $id = 'P706-' . strtotime(now());

        try {
            TransaksiGunaSumberP7RTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT 706 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT 706: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($idP4, $idMasterGunaSumber)
    {
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

        $data = TransaksiGunaSumberP7RTM::where('id_p4', $idP4)
            ->where('id_master_guna_sumber', $idMasterGunaSumber)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P706 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P706 ditemukan',
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
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
        $data = TransaksiGunaSumberP7RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P706 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_master_guna_sumber' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'sungai' => 'required|in:1,2,3',
            'kondisi_sungai' => 'sometimes|in:1,2,3',

            'saluran_irigasi' => 'required|in:1,2,3',
            'kondisi_saluran_irigasi' => 'sometimes|in:1,2,3',

            'danau' => 'required|in:1,2,3',
            'kondisi_danau' => 'sometimes|in:1,2,3',

            'embung' => 'required|in:1,2,3',
            'kondisi_embung' => 'sometimes|in:1,2,3',
        ]);

        $rules = [
            'sungai' => 'kondisi_sungai',
            'saluran_irigasi' => 'kondisi_saluran_irigasi',
            'danau' => 'kondisi_danau',
            'embung' => 'kondisi_embung',
        ];

        foreach ($rules as $parent => $child) {
            if (($validated[$parent] ?? null) == 3) {
                $validated[$child] = 3;
            }
        }

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P706 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4, $idMasterGunaSumber)
    {
        $data = TransaksiGunaSumberP7RTM::where('id_p4', $idP4)->where('id_master_guna_sumber', $idMasterGunaSumber)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P706 tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data RT P706 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P706: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $deleted = TransaksiGunaSumberP7RTM::where('id_p4', $idP4)->delete();

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P706 berhasil dihapus',
        ], 200);
    }
}

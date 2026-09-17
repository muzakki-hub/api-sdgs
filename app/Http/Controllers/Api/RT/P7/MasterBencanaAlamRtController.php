<?php

namespace App\Http\Controllers\Api\RT\P7;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\Master\MasterBencanaAlamRTM;

class MasterBencanaAlamRtController extends Controller
{
      public function index(Request $request)
    {
        $idP4 = $request->query('id_p4') ?? $request->query('idP4');
        $survey = SurveyProgressService::getActiveSurvey();

        $data = MasterBencanaAlamRTM::with(['transaksi' => function ($q) use ($idP4, $survey) {
            if ($survey) {
                $q->where('id_survey', $survey->id);
            }
            if ($idP4) {
                $q->where('id_p4', $idP4);
            }
        }])->orderBy('tgl_buat', 'desc')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Belum ada data yang tersimpan',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }

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
            'jenis_bencana' => 'required|string|max:100',
        ]);

        $id = 'MBA-' . strtotime(now());

        try {

            MasterBencanaAlamRTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));


            return response()->json([
                'status' => true,
                'message' => 'Data master bencana alam berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data master bencana alam: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        $data = MasterBencanaAlamRTM::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data master bencana alam tidak ditemukan',
            ], 404);
        }

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data master bencana alam ditemukan.',
            'data' => $data
        ], 200);
    }

     public function update(Request $request, $id)
    {
        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        $data = MasterBencanaAlamRTM::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data master bencana alam tidak ditemukan',
            ], 404);
        }

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $validated = $request->validate([
            'jenis_bencana' => 'required|string|max:25',
        ]);

        $data->update(array_merge($validated, [
            'tgl_update' => now(),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data master bencana alam berhasil diperbarui',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
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


        $master = MasterBencanaAlamRTM::find($id);

        if ($master->transaksi()->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data masih digunakan tabel lain'
            ]);
        }

        $master->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data master bencana alam berhasil dihapus.',
        ]);
    }

}

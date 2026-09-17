<?php

namespace App\Http\Controllers\Api\Individu\P1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\Auth;

class P1IdvApi extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        $data = IdvP1M::with('survey')
            ->orderBy('tgl_buat', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'survey_aktif' => $survey,
            'data' => $data
        ]);
    }


    public function store(Request $request)
    {
        $today = Carbon::now()->toDateString();

        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada survey aktif untuk hari ini'
            ], 400);
        }

        $data = IdvP1M::create([
            'id' => "IDVP1-" . strtotime(now()),
            'id_survey' => $survey->id,
            'id_buat' => Auth::id(),
            'id_update' => Auth::id(),
            'tgl_buat' => now(),
            'tgl_update' => now(),

            'no_kk' => $request->no_kk,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'status_pernikahan' => $request->status_pernikahan,
            'agama' => $request->agama,
            'suku_bangsa' => $request->suku_bangsa,
            'warganegara' => $request->warganegara,
            'no_hp' => $request->no_hp,
            'no_wa' => $request->no_wa,
            'url_email_pribadi' => $request->url_email_pribadi,
            'url_facebook_pribadi' => $request->url_facebook_pribadi,
            'url_twitter_pribadi' => $request->url_twitter_pribadi,
            'url_instagram_pribadi' => $request->url_instagram_pribadi,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data individu berhasil disimpan',
            'data' => $data
        ]);
    }


    public function show($id)
    {
        $data = IdvP1M::with('survey')->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }


    public function byP1($id)
    {
        return $this->show($id);
    }


    public function update(Request $request, $id)
    {
        try {
            $data = IdvP1M::find($id);

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $updateData = $request->only([
                'no_kk',
                'nik',
                'nama',
                'jenis_kelamin',
                'tempat_lahir',
                'tgl_lahir',
                'status_pernikahan',
                'agama',
                'suku_bangsa',
                'warganegara',
                'no_hp',
                'no_wa',
                'url_email_pribadi',
                'url_facebook_pribadi',
                'url_twitter_pribadi',
                'url_instagram_pribadi',
            ]);

            $updateData['id_update'] = Auth::id();
            $updateData['tgl_update'] = now();

            $data->update($updateData);

            return response()->json([
                'status' => true,
                'message' => 'Data Individu berhasil diperbarui',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        $data = IdvP1M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data individu berhasil dihapus'
        ]);
    }
}

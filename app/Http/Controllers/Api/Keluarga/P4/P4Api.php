<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP4M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Keluarga\P2\KgP2M;

class P4Api extends Controller
{
    public function showByIdP2($id)
    {
        try {
            $survey = \App\Services\SurveyProgressService::getActiveSurvey();
            $query = KgP4M::where('id_kg_p2', $id);
            if ($survey) {
                $query->where('id_survey', $survey->id);
            }
            $data = $query->first();

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data P4 tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $this->enrichP4Data($data);

            return response()->json([
                'status' => true,
                'message' => 'Data P4 berdasarkan id_kg_p2',
                'data' => $data
            ], 200);
        } catch (Throwable $e) {
            Log::error("[P4 INDEX] " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $idKgP2 = $request->id_kg_p2;

            if (!$idKgP2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parameter id_kg_p2 diperlukan.'
                ], 400);
            }

            $data = KgP4M::where('id_kg_p2', $idKgP2)->get();
            foreach ($data as $item) {
                $this->enrichP4Data($item);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan.',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            Log::error("[P4 INDEX] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    // INSERT
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $request->validate([
                'id_kg_p2' => 'required',
                'tempat_tinggal_yg_ditempati' => 'required',
                'status_lahan_tempat_tinggal_yg_ditempati' => 'required',
    'daya_meteran_rumah' => 'nullable',
            ]);

            $datap2 = KgP2M::find($request->id_kg_p2);
            if (!$datap2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data P2 tidak ditemukan.'
                ], 404);
            }

            // Sync meteran fields to kg_p2 if provided
            if ($request->hasAny(['meteran_rumah', 'no_meteran', 'daya_meteran_rumah', 'atas_nama'])) {
                $p2Update = [];
                if ($request->filled('meteran_rumah')) {
                    $p2Update['meteran_rumah'] = $request->meteran_rumah;
                }
                if ($request->has('no_meteran')) {
                    $p2Update['no_meteran'] = $request->meteran_rumah == '1' ? $request->no_meteran : null;
                }
                if ($request->has('daya_meteran_rumah')) {
                    $p2Update['daya_meteran_rumah'] = $request->meteran_rumah == '1' ? $request->daya_meteran_rumah : null;
                }
                if ($request->has('atas_nama')) {
                    $p2Update['atas_nama'] = $request->meteran_rumah == '2' ? $request->atas_nama : null;
                }

                if (!empty($p2Update)) {
                    $p2Update['id_update'] = Auth::user()->id ?? 'SYSTEM';
                    $p2Update['tgl_update'] = Carbon::now();
                    KgP2M::where('id', $request->id_kg_p2)->update($p2Update);
                }
            }

            // Normalize 'rumah_berada_dibawah' ('1' => 'Ya', '2' => 'Tidak')
            $rumahBeradaDibawah = $request->rumah_berada_dibawah;
            if ($rumahBeradaDibawah === '1' || $rumahBeradaDibawah === 1) {
                $rumahBeradaDibawah = 'Ya';
            } elseif ($rumahBeradaDibawah === '2' || $rumahBeradaDibawah === 2) {
                $rumahBeradaDibawah = 'Tidak';
            }

            // Helper to normalize bantuan enum '1'/'2'
            $survey = \App\Services\SurveyProgressService::getActiveSurvey();
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

            $normalizeBantuan = function ($val) {
                if ($val === 1 || $val === '1' || $val === true || $val === 'true') {
                    return '1';
                }
                return '2';
            };

            $data = KgP4M::create([
                'id' => "KGP4-" . strtotime(date("Y-m-d H:i:s")),
                'id_buat' => $userId,
                'id_survey' => $survey->id,
                'tgl_buat' => now(),
                'tgl_update' => now(),

                // form input
                'id_kg_p2' => $request->id_kg_p2,
                'tempat_tinggal_yg_ditempati' => $request->filled('tempat_tinggal_yg_ditempati') ? $request->tempat_tinggal_yg_ditempati : '1',
                'status_lahan_tempat_tinggal_yg_ditempati' => $request->filled('status_lahan_tempat_tinggal_yg_ditempati') ? $request->status_lahan_tempat_tinggal_yg_ditempati : '1',
                'luas_lantai_ttl_terluas' => $request->filled('luas_lantai_ttl_terluas') ? (float)$request->luas_lantai_ttl_terluas : 0,
                'luas_lahan_ttl_terluas' => $request->filled('luas_lahan_ttl_terluas') ? (float)$request->luas_lahan_ttl_terluas : 0,
                'jns_lantai_ttl_terluas' => $request->filled('jns_lantai_ttl_terluas') ? $request->jns_lantai_ttl_terluas : '2',
                'dinding_sebagian_besar_rumah' => $request->filled('dinding_sebagian_besar_rumah') ? $request->dinding_sebagian_besar_rumah : '1',
                'jendela' => $request->filled('jendela') ? $request->jendela : '1',
                'atap' => $request->filled('atap') ? $request->atap : '1',
                'penerangan_rumah' => $request->filled('penerangan_rumah') ? $request->penerangan_rumah : '1',
                'energi_untuk_memasak' => $request->filled('energi_untuk_memasak') ? $request->energi_untuk_memasak : '1',
                'sumber_kayu_bakar' => $request->filled('sumber_kayu_bakar') ? $request->sumber_kayu_bakar : null,
                'tempat_pembuangan_sampah' => $request->filled('tempat_pembuangan_sampah') ? $request->tempat_pembuangan_sampah : '1',
                'fasilitas_mck' => $request->filled('fasilitas_mck') ? $request->fasilitas_mck : '1',
                'sumber_air_mandi' => $request->filled('sumber_air_mandi') ? $request->sumber_air_mandi : '1',
                'fasilitas_bab' => $request->filled('fasilitas_bab') ? $request->fasilitas_bab : '1',
                'sumber_air_minum' => $request->filled('sumber_air_minum') ? $request->sumber_air_minum : '1',
                'tmpt_pembuangan_limbah_cair' => $request->filled('tmpt_pembuangan_limbah_cair') ? $request->tmpt_pembuangan_limbah_cair : '1',
                'rumah_berada_dibawah' => $rumahBeradaDibawah ?: 'Tidak',
                'rumah_di_bantaran_sungai' => $request->filled('rumah_di_bantaran_sungai') ? $request->rumah_di_bantaran_sungai : '2',
                'rumah_dilereng_bukit_gunung' => $request->filled('rumah_dilereng_bukit_gunung') ? $request->rumah_dilereng_bukit_gunung : '2',
                'secara_keseluruhan_kondisi_rumah' => $request->secara_keseluruhan_kondisi_rumah ?: '',
                'blt_dana_desa' => $normalizeBantuan($request->blt_dana_desa),
                'pkh' => $normalizeBantuan($request->pkh),
                'bst' => $normalizeBantuan($request->bst),
                'banpres' => $normalizeBantuan($request->banpres),
                'bantuan_umkm' => $normalizeBantuan($request->bantuan_umkm),
                'bantuan_pekerja' => $normalizeBantuan($request->bantuan_pekerja),
                'bantuan_anak' => $normalizeBantuan($request->bantuan_anak),
                'lainnya' => $normalizeBantuan($request->lainnya),
            ]);

            DB::commit();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $request->id_kg_p2,
                'P4',
                'kg_p4',
                'id_kg_p2',
                [],
                $survey->id
            );

            $this->enrichP4Data($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $data
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P4 STORE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    // SHOW DETAIL
    public function show($id)
    {
        try {
            $survey = \App\Services\SurveyProgressService::getActiveSurvey();
            $query = KgP4M::where('id', $id);
            if ($survey) {
                $query->where('id_survey', $survey->id);
            }
            $data = $query->first();

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

            $this->enrichP4Data($data);

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan.',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            Log::error("[P4 SHOW] " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $survey = \App\Services\SurveyProgressService::getActiveSurvey();
            $query = KgP4M::where(function ($q) use ($id, $request) {
                $q->where('id', $id)
                  ->orWhere('id_kg_p2', $id)
                  ->orWhere('id_kg_p2', $request->id_kg_p2);
            });
            if ($survey) {
                $query->where('id_survey', $survey->id);
            }
            $data = $query->first();

            if (!$data) {
                DB::rollBack();
                return $this->store($request);
            }

            // Sync meteran fields to kg_p2 if provided and relation exists
            if ($request->hasAny(['meteran_rumah', 'no_meteran', 'daya_meteran_rumah', 'atas_nama']) && $data->id_kg_p2) {
                $p2Update = [];
                if ($request->filled('meteran_rumah')) {
                    $p2Update['meteran_rumah'] = $request->meteran_rumah;
                }
                if ($request->has('no_meteran')) {
                    $p2Update['no_meteran'] = $request->meteran_rumah == '1' ? $request->no_meteran : null;
                }
                if ($request->has('daya_meteran_rumah')) {
                    $p2Update['daya_meteran_rumah'] = $request->meteran_rumah == '1' ? $request->daya_meteran_rumah : null;
                }
                if ($request->has('atas_nama')) {
                    $p2Update['atas_nama'] = $request->meteran_rumah == '2' ? $request->atas_nama : null;
                }

                if (!empty($p2Update)) {
                    $userId = Auth::id() ?? $request->user()?->id ?? 'SYSTEM';
                    $p2Update['id_update'] = $userId;
                    $p2Update['tgl_update'] = Carbon::now();
                    KgP2M::where('id', $data->id_kg_p2)->update($p2Update);
                }
            }

            // Prepare payload for kg_p4
            $p4Payload = [];
            $allFields = [
                'tempat_tinggal_yg_ditempati', 'status_lahan_tempat_tinggal_yg_ditempati',
                'luas_lantai_ttl_terluas', 'luas_lahan_ttl_terluas', 'jns_lantai_ttl_terluas',
                'dinding_sebagian_besar_rumah', 'jendela', 'atap', 'penerangan_rumah',
                'energi_untuk_memasak', 'sumber_kayu_bakar', 'tempat_pembuangan_sampah',
                'fasilitas_mck', 'sumber_air_mandi', 'fasilitas_bab', 'sumber_air_minum',
                'tmpt_pembuangan_limbah_cair', 'rumah_di_bantaran_sungai',
                'rumah_dilereng_bukit_gunung', 'secara_keseluruhan_kondisi_rumah'
            ];

            foreach ($allFields as $field) {
                if ($request->has($field)) {
                    $p4Payload[$field] = $request->$field;
                }
            }

            if ($request->has('rumah_berada_dibawah')) {
                $val = $request->rumah_berada_dibawah;
                if ($val === '1' || $val === 1) $p4Payload['rumah_berada_dibawah'] = 'Ya';
                elseif ($val === '2' || $val === 2) $p4Payload['rumah_berada_dibawah'] = 'Tidak';
                else $p4Payload['rumah_berada_dibawah'] = $val;
            }

            $bantuanFields = ['blt_dana_desa', 'pkh', 'bst', 'banpres', 'bantuan_umkm', 'bantuan_pekerja', 'bantuan_anak', 'lainnya'];
            foreach ($bantuanFields as $field) {
                if ($request->has($field)) {
                    $val = $request->$field;
                    $p4Payload[$field] = ($val === 1 || $val === '1' || $val === true || $val === 'true') ? '1' : '2';
                }
            }

            $userId = Auth::id() ?? $request->user()?->id ?? 'SYSTEM';
            $p4Payload['id_update'] = $userId;
            $p4Payload['tgl_update'] = now();

            $data->update($p4Payload);

            DB::commit();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $data->id_kg_p2,
                'P4',
                'kg_p4',
                'id_kg_p2',
                [],
                $data->id_survey ?? $survey?->id
            );

            $this->enrichP4Data($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P4 UPDATE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    // DELETE
    public function destroy($id)
    {
        try {
            $survey = \App\Services\SurveyProgressService::getActiveSurvey();
            $query = KgP4M::where(function ($q) use ($id) {
                $q->where('id', $id)->orWhere('id_kg_p2', $id);
            });
            if ($survey) {
                $query->where('id_survey', $survey->id);
            }
            $data = $query->first();

            $idKgP2 = $data ? $data->id_kg_p2 : $id;
            $surveyId = $data->id_survey ?? $survey?->id;

            if ($data) {
                $data->delete();
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress($idKgP2, 'P4', 'kg_p4', 'id_kg_p2', [], $surveyId);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Throwable $e) {
            Log::error("[P4 DELETE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    /**
     * Format and enrich P4 model data before returning to frontend:
     * 1. Normalize rumah_berada_dibawah ('Ya' => '1', 'Tidak' => '2')
     * 2. Attach meteran fields and atas_nama from related kg_p2
     */
    private function enrichP4Data($data)
    {
        if (!$data) return;

        // 1. Normalize 'rumah_berada_dibawah' ('Ya' => '1', 'Tidak' => '2')
        if ($data->rumah_berada_dibawah === 'Ya') {
            $data->rumah_berada_dibawah = '1';
        } elseif ($data->rumah_berada_dibawah === 'Tidak') {
            $data->rumah_berada_dibawah = '2';
        }

        // 2. Attach meteran fields from kg_p2
        if ($data->id_kg_p2) {
            $p2 = KgP2M::find($data->id_kg_p2);
            if ($p2) {
                $data->meteran_rumah = $p2->meteran_rumah !== null ? (string)$p2->meteran_rumah : null;
                $data->no_meteran = $p2->no_meteran !== null ? (int)$p2->no_meteran : null;
                $data->daya_meteran_rumah = $p2->daya_meteran_rumah !== null ? (string)$p2->daya_meteran_rumah : null;
                $data->atas_nama = $p2->atas_nama ?? null;
            }
        }
    }
}


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
    // ✅ Ambil data P4 berdasarkan id_kg_p2
    public function showByIdP2($id)
    {
        try {
            $data = KgP4M::where('id_kg_p2', $id)->first();

            return response()->json([
                'status' => true,
                'message' => 'Data P4 berdasarkan id_kg_p2',
                'data' => $data
            ]);
        } catch (Throwable $e) {
            Log::error("[P4 INDEX] " . $e->getMessage());
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
            if ($request->hasAny(['meteran_rumah', 'no_meteran', 'daya_meteran_rumah'])) {
                $p2Update = [];
                if ($request->filled('meteran_rumah')) {
                    $p2Update['meteran_rumah'] = $request->meteran_rumah;
                }
                if ($request->has('no_meteran')) {
                    $p2Update['no_meteran'] = $request->no_meteran;
                }
                if ($request->has('daya_meteran_rumah')) {
                    $p2Update['daya_meteran_rumah'] = $request->daya_meteran_rumah;
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
            $normalizeBantuan = function ($val) {
                if ($val === 1 || $val === '1' || $val === true || $val === 'true') {
                    return '1';
                }
                return '2';
            };

            $data = KgP4M::create([
                'id' => "KGP4-" . strtotime(date("Y-m-d H:i:s")),
                'id_buat' => Auth::user()->id,
                'id_survey' => $datap2->id_survey,
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

    // GET DETAIL
    public function show($id)
    {
        try {
            $data = KgP4M::find($id);

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

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
            $data = KgP4M::find($id);

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

            // Sync meteran fields to kg_p2 if provided and relation exists
            if ($request->hasAny(['meteran_rumah', 'no_meteran', 'daya_meteran_rumah']) && $data->id_kg_p2) {
                $p2Update = [];
                if ($request->filled('meteran_rumah')) {
                    $p2Update['meteran_rumah'] = $request->meteran_rumah;
                }
                if ($request->has('no_meteran')) {
                    $p2Update['no_meteran'] = $request->no_meteran;
                }
                if ($request->has('daya_meteran_rumah')) {
                    $p2Update['daya_meteran_rumah'] = $request->daya_meteran_rumah;
                }

                if (!empty($p2Update)) {
                    $p2Update['id_update'] = Auth::user()->id ?? 'SYSTEM';
                    $p2Update['tgl_update'] = Carbon::now();
                    KgP2M::where('id', $data->id_kg_p2)->update($p2Update);
                }
            }

            // Prepare payload for kg_p4
            $payload = $request->except(['meteran_rumah', 'no_meteran', 'daya_meteran_rumah', 'atas_nama']);

            // Normalize 'rumah_berada_dibawah' ('1' => 'Ya', '2' => 'Tidak')
            if (isset($payload['rumah_berada_dibawah'])) {
                if ($payload['rumah_berada_dibawah'] === '1' || $payload['rumah_berada_dibawah'] === 1) {
                    $payload['rumah_berada_dibawah'] = 'Ya';
                } elseif ($payload['rumah_berada_dibawah'] === '2' || $payload['rumah_berada_dibawah'] === 2) {
                    $payload['rumah_berada_dibawah'] = 'Tidak';
                }
            }

            // Normalize bantuan boolean/integer to enum '1'/'2'
            $bantuanCols = ['blt_dana_desa', 'pkh', 'bst', 'banpres', 'bantuan_umkm', 'bantuan_pekerja', 'bantuan_anak', 'lainnya'];
            foreach ($bantuanCols as $bCol) {
                if (array_key_exists($bCol, $payload)) {
                    if ($payload[$bCol] === 0 || $payload[$bCol] === '0' || $payload[$bCol] === false || $payload[$bCol] === 'false' || is_null($payload[$bCol])) {
                        $payload[$bCol] = '2';
                    } elseif ($payload[$bCol] === 1 || $payload[$bCol] === '1' || $payload[$bCol] === true || $payload[$bCol] === 'true') {
                        $payload[$bCol] = '1';
                    }
                }
            }

            if (isset($payload['luas_lantai_ttl_terluas'])) {
                $payload['luas_lantai_ttl_terluas'] = ($payload['luas_lantai_ttl_terluas'] === '' || is_null($payload['luas_lantai_ttl_terluas'])) ? 0 : (float)$payload['luas_lantai_ttl_terluas'];
            }
            if (isset($payload['luas_lahan_ttl_terluas'])) {
                $payload['luas_lahan_ttl_terluas'] = ($payload['luas_lahan_ttl_terluas'] === '' || is_null($payload['luas_lahan_ttl_terluas'])) ? 0 : (float)$payload['luas_lahan_ttl_terluas'];
            }
            if (isset($payload['sumber_kayu_bakar']) && $payload['sumber_kayu_bakar'] === '') {
                $payload['sumber_kayu_bakar'] = null;
            }

            $payload['id_update'] = Auth::user()->id ?? 'SYSTEM';
            $payload['tgl_update'] = Carbon::now();

            $data->update($payload);

            DB::commit();

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
            $data = KgP4M::find($id);

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

            $data->delete();

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
}

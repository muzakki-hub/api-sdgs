<?php

namespace App\Http\Controllers\Api\Individu\P4;

use App\Http\Controllers\Controller;
use App\Models\Individu\P4\IdvP4M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P4IdvApi extends Controller
{
    /**
     * Tampilkan semua data P4
     */
    public function index()
    {
        $data = IdvP4M::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * Simpan data baru P4
     */
    public function store(Request $request)
    {
        $today = Carbon::now();

        $data = IdvP4M::create([
            'id' => "IDVP4-" . strtotime(now()),
            'id_individu_p1' => $request->id_individu_p1,

            // Kolom disabilitas
            'tunanetra' => $request->tunanetra,
            'tunarungu' => $request->tunarungu,
            'tunawicara' => $request->tunawicara,
            'tunarungu_wicara' => $request->{"tunarungu_wicara"},
            'tunadaksa' => $request->tunadaksa,
            'tunagrahita' => $request->tunagrahita,
            'tunalaras' => $request->tunalaras,
            'cacat_eks_sakitkusta' => $request->cacat_eks_sakitkusta,
            'cacat_ganda' => $request->cacat_ganda,
            'dipasung' => $request->dipasung,

            // Metadata
            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $request->id_individu_p1,
            'P4',
            'individu_p4',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berhasil disimpan',
            'data' => $data
        ]);
    }

    /**
     * Tampilkan data berdasarkan ID
     */
    public function show($id)
    {
        $data = IdvP4M::where('id', $id)->orWhere('id_individu_p1', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berhasil ditampilkan',
            'data' => $data
        ]);
    }

    /**
     * Update data P4
     */
    public function update(Request $request, $id)
    {
        $today = Carbon::now();
        $record = IdvP4M::where('id', $id)->orWhere('id_individu_p1', $id)->first();

        if ($record) {
            $record->update([
                'tunanetra' => $request->tunanetra,
                'tunarungu' => $request->tunarungu,
                'tunawicara' => $request->tunawicara,
                'tunarungu_wicara' => $request->{"tunarungu_wicara"},
                'tunadaksa' => $request->tunadaksa,
                'tunagrahita' => $request->tunagrahita,
                'tunalaras' => $request->tunalaras,
                'cacat_eks_sakitkusta' => $request->cacat_eks_sakitkusta,
                'cacat_ganda' => $request->cacat_ganda,
                'dipasung' => $request->dipasung,
                'id_update' => Auth::user()->id,
                'tgl_update' => $today
            ]);
            $idP1 = $record->id_individu_p1;
        } else {
            $idP1 = $request->id_individu_p1 ?? $id;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P4',
            'individu_p4',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berhasil diupdate',
            'data' => $record
        ]);
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $record = IdvP4M::where('id', $id)->orWhere('id_individu_p1', $id)->first();
        $idP1 = $record ? $record->id_individu_p1 : $id;

        if ($record) {
            $record->delete();
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P4',
            'individu_p4',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => "Data Individu P4 berhasil dihapus"
        ]);
    }

    /**
     * Tampilkan data berdasarkan ID P1
     */
    public function showByIdP1($id)
    {
        $data = IdvP4M::where('id_individu_p1', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berdasarkan ID P1',
            'data' => $data
        ]);
    }

    /**
     * Master data disabilitas dengan status transaksi per idP1 (seperti P508 RT)
     */
    public function master(Request $request)
    {
        $idP1 = $request->query('id_individu_p1') ?? $request->query('idP1');
        $p4 = $idP1 ? IdvP4M::where('id_individu_p1', $idP1)->first() : null;

        $definitions = [
            ['id' => 'tunanetra', 'nama_disabilitas' => 'Tunanetra (buta)'],
            ['id' => 'tunarungu', 'nama_disabilitas' => 'Tunarungu (tuli)'],
            ['id' => 'tunawicara', 'nama_disabilitas' => 'Tunawicara (bisu)'],
            ['id' => 'tunarungu_wicara', 'nama_disabilitas' => 'Tunarungu–wicara (tuli–bisu)'],
            ['id' => 'tunadaksa', 'nama_disabilitas' => 'Tunadaksa (cacat tubuh)'],
            ['id' => 'tunagrahita', 'nama_disabilitas' => 'Tunagrahita (cacat mental)'],
            ['id' => 'tunalaras', 'nama_disabilitas' => 'Tunalaras (eks–sakit jiwa)'],
            ['id' => 'cacat_eks_sakitkusta', 'nama_disabilitas' => 'Cacat eks–sakit kusta'],
            ['id' => 'cacat_ganda', 'nama_disabilitas' => 'Cacat ganda (fisik–mental)'],
            ['id' => 'dipasung', 'nama_disabilitas' => 'Dipasung'],
        ];

        $items = [];
        foreach ($definitions as $def) {
            $field = $def['id'];
            $val = $p4 ? $p4->{$field} : null;
            $transaksi = [];
            if ($val !== null && $val !== '') {
                $transaksi[] = [
                    'id' => $field,
                ];
            }
            $items[] = [
                'id' => $def['id'],
                'nama_disabilitas' => $def['nama_disabilitas'],
                'transaksi' => $transaksi,
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Data master disabilitas berhasil dimuat',
            'data' => $items,
        ]);
    }

    /**
     * Tampilkan detail satu field disabilitas untuk edit/create form
     */
    public function showField($idP1, $field)
    {
        $p4 = IdvP4M::where('id_individu_p1', $idP1)->first();
        $definitions = [
            'tunanetra' => 'Tunanetra (buta)',
            'tunarungu' => 'Tunarungu (tuli)',
            'tunawicara' => 'Tunawicara (bisu)',
            'tunarungu_wicara' => 'Tunarungu–wicara (tuli–bisu)',
            'tunadaksa' => 'Tunadaksa (cacat tubuh)',
            'tunagrahita' => 'Tunagrahita (cacat mental)',
            'tunalaras' => 'Tunalaras (eks–sakit jiwa)',
            'cacat_eks_sakitkusta' => 'Cacat eks–sakit kusta',
            'cacat_ganda' => 'Cacat ganda (fisik–mental)',
            'dipasung' => 'Dipasung',
        ];

        return response()->json([
            'status' => true,
            'data' => [
                'id_individu_p1' => $idP1,
                'id_disabilitas' => $field,
                'nama_disabilitas' => $definitions[$field] ?? $field,
                'status' => $p4 ? (string) ($p4->{$field} ?? '2') : '2',
            ]
        ]);
    }

    /**
     * Simpan/update satu field disabilitas
     */
    public function saveField(Request $request)
    {
        $idP1 = $request->id_individu_p1;
        $field = $request->id_disabilitas;
        $status = $request->input('status', '2');
        $today = Carbon::now();
        $userId = Auth::id() ?? '1750902135';

        $p4 = IdvP4M::where('id_individu_p1', $idP1)->first();
        if (!$p4) {
            $p4 = IdvP4M::create([
                'id' => "IDVP4-" . strtotime(now()),
                'id_individu_p1' => $idP1,
                $field => $status,
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);
        } else {
            $p4->update([
                $field => $status,
                'id_update' => $userId,
                'tgl_update' => $today,
            ]);
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P4',
            'individu_p4',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Disabilitas berhasil disimpan',
            'data' => $p4
        ]);
    }

    /**
     * Hapus (reset) satu field disabilitas
     */
    public function deleteField($field, $idP1)
    {
        $p4 = IdvP4M::where('id_individu_p1', $idP1)->first();
        if ($p4) {
            $p4->update([$field => null]);
            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P4',
                'individu_p4',
                'id_individu_p1'
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Data disabilitas berhasil dihapus'
        ]);
    }
}

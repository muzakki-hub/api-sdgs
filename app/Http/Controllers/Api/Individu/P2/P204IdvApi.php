<?php

namespace App\Http\Controllers\Api\Individu\P2;

use App\Http\Controllers\Controller;
use App\Models\Individu\P2\IdvP204M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Master\MasterPenghasilanM;

class P204IdvApi extends Controller
{
    /**
     * Satuan standar sesuai kuesioner resmi SDGs P204
     */
    protected const STANDARD_UNITS = [
        'MP001' => 'ton',
        'MP002' => 'ton',
        'MP003' => 'kg',
        'MP004' => 'ton',
        'MP005' => 'ton',
        'MP006' => 'kg',
        'MP007' => 'ton',
        'MP008' => 'ton',
        'MP009' => 'kg',
        'MP010' => 'kg',
        'MP011' => 'kg',
        'MP012' => 'ton',
        'MP013' => 'ekor',
        'MP014' => 'liter',
        'MP015' => 'ekor',
        'MP016' => 'ekor',
        'MP017' => 'ekor',
        'MP018' => 'kg',
        'MP019' => 'ekor',
        'MP020' => 'kg',
        'MP021' => 'kg',
        'MP022' => 'batang',
        'MP023' => 'batang',
        'MP024' => 'kg',
        'MP025' => 'ekor',
        'MP026' => 'ekor',
        'MP027' => 'hari',
        'MP028' => '-',
        'MP029' => '-',
        'MP030' => '-',
        'MP031' => '-',
        'MP032' => '-',
        'MP033' => '-',
        'MP034' => '-',
        'MP035' => '-',
        'MP036' => '-',
        'MP037' => '-',
        'MP038' => '-',
        'MP039' => '-',
        'MP040' => '-',
        'MP041' => '-',
        'MP042' => '-',
        'MP043' => '-',
        'MP044' => '-',
    ];

    public function index()
    {
        $data = IdvP204M::with([
            'individuP1',
            'masterPenghasilan'
        ])->get();

        return response()->json([
            'status' => true,
            'message' => 'Data P204 berhasil dimuat',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $today = Carbon::now();
        $idP1 = $request->id_individu_p1;
        $userId = Auth::id() ?? '1750902135';

        // 1. Backward compatibility: Jika request berupa data[]
        if ($request->has('data') && is_array($request->data)) {
            return $this->storeMany($request);
        }

        // 2. Backward compatibility: Jika request berupa single commodity
        if ($request->has('id_master_penghasilan')) {
            $data = IdvP204M::create([
                'id' => "IDVP204-" . strtotime(date("Y-m-d H:i:s")),
                'id_individu_p1' => $idP1,
                'id_master_penghasilan' => $request->id_master_penghasilan,
                'jumlah' => $request->input('jumlah', 0),
                'satuan' => $request->input('satuan', self::STANDARD_UNITS[$request->id_master_penghasilan] ?? '-'),
                'penghasilan' => $request->input('penghasilan', 0),
                'diekspor' => $request->input('diekspor', '3'),
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today
            ]);

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P204',
                'individu_p204',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data Individu P204 berhasil disimpan',
                'data' => $data
            ]);
        }

        // 3. Single-form questionnaire (seperti P403): simpan seluruh master komoditas
        $masters = MasterPenghasilanM::orderBy('id')->get();
        IdvP204M::where('id_individu_p1', $idP1)->delete();

        $result = [];
        $counter = 1;

        foreach ($masters as $m) {
            $jumlah = (int) $request->input('jumlah_' . $m->id, 0);
            $penghasilan = (float) $request->input('penghasilan_' . $m->id, 0);
            $diekspor = (string) $request->input('diekspor_' . $m->id, '3');
            if (!in_array($diekspor, ['1', '2', '3'])) {
                $diekspor = '3';
            }
            $satuan = self::STANDARD_UNITS[$m->id] ?? '-';

            $rand = random_int(10000, 99999);
            $id_final = "IDVP204-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP204M::create([
                'id' => $id_final,
                'id_individu_p1' => $idP1,
                'id_master_penghasilan' => $m->id,
                'jumlah' => $jumlah,
                'satuan' => $satuan,
                'penghasilan' => $penghasilan,
                'diekspor' => $diekspor,
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            $result[] = $save;
            $counter++;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P204',
            'individu_p204',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P204 berhasil disimpan',
            'data' => $result
        ]);
    }

    public function storeMany(Request $request)
    {
        if (!$request->has('data') || !is_array($request->data)) {
            return response()->json([
                'status' => false,
                'message' => 'Request harus berisi data[]'
            ], 400);
        }

        $today = Carbon::now();
        $result = [];
        $counter = 1;
        $idP1 = null;
        $userId = Auth::id() ?? '1750902135';

        foreach ($request->data as $row) {
            if (!isset($row['id_individu_p1']) || !isset($row['id_master_penghasilan'])) {
                continue;
            }

            $idP1 = $row['id_individu_p1'];
            $rand = random_int(10000, 99999);
            $id_final = "IDVP204-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);
            $satuan = $row['satuan'] ?? (self::STANDARD_UNITS[$row['id_master_penghasilan']] ?? '-');

            $save = IdvP204M::create([
                'id' => $id_final,
                'id_individu_p1' => $idP1,
                'id_master_penghasilan' => $row['id_master_penghasilan'],
                'jumlah' => $row['jumlah'] ?? 0,
                'satuan' => $satuan,
                'penghasilan' => $row['penghasilan'] ?? 0,
                'diekspor' => $row['diekspor'] ?? '3',
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today
            ]);

            $result[] = $save;
            $counter++;
        }

        if ($idP1) {
            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P204',
                'individu_p204',
                'id_individu_p1'
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Semua data P204 berhasil disimpan',
            'data' => $result
        ]);
    }

    public function show($id)
    {
        $data = IdvP204M::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P204 berhasil di Tampilkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $today = Carbon::now();
        $userId = Auth::id() ?? '1750902135';

        // 1. Backward compatibility: Jika update single record by record ID
        if ($request->has('id_master_penghasilan')) {
            $record = IdvP204M::find($id);
            if ($record) {
                $record->update([
                    'id_master_penghasilan' => $request->id_master_penghasilan,
                    'jumlah' => $request->input('jumlah', 0),
                    'satuan' => $request->input('satuan', $record->satuan),
                    'penghasilan' => $request->input('penghasilan', 0),
                    'diekspor' => $request->input('diekspor', '3'),
                    'id_update' => $userId,
                    'tgl_update' => $today
                ]);
                $idP1 = $record->id_individu_p1;
            } else {
                $idP1 = $request->id_individu_p1 ?? $id;
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P204',
                'individu_p204',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data Individu P204 berhasil di update',
                'data' => $record
            ]);
        }

        // 2. Single-form questionnaire (seperti P403): update seluruh master komoditas
        $idP1 = $request->id_individu_p1 ?? $id;
        $masters = MasterPenghasilanM::orderBy('id')->get();
        IdvP204M::where('id_individu_p1', $idP1)->delete();

        $result = [];
        $counter = 1;

        foreach ($masters as $m) {
            $jumlah = (int) $request->input('jumlah_' . $m->id, 0);
            $penghasilan = (float) $request->input('penghasilan_' . $m->id, 0);
            $diekspor = (string) $request->input('diekspor_' . $m->id, '3');
            if (!in_array($diekspor, ['1', '2', '3'])) {
                $diekspor = '3';
            }
            $satuan = self::STANDARD_UNITS[$m->id] ?? '-';

            $rand = random_int(10000, 99999);
            $id_final = "IDVP204-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP204M::create([
                'id' => $id_final,
                'id_individu_p1' => $idP1,
                'id_master_penghasilan' => $m->id,
                'jumlah' => $jumlah,
                'satuan' => $satuan,
                'penghasilan' => $penghasilan,
                'diekspor' => $diekspor,
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            $result[] = $save;
            $counter++;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P204',
            'individu_p204',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P204 berhasil diperbarui',
            'data' => $result
        ]);
    }

    public function destroy($id)
    {
        $record = IdvP204M::where('id', $id)->first();
        if ($record) {
            $idP1 = $record->id_individu_p1;
            $record->delete();
        } else {
            // Jika ID yang dilempar adalah id_individu_p1
            IdvP204M::where('id_individu_p1', $id)->delete();
            $idP1 = $id;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P204',
            'individu_p204',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => "Data Individu P204 Berhasil Dihapus"
        ]);
    }

    public function showByIdP1($id)
    {
        $records = IdvP204M::where('id_individu_p1', $id)->get();

        $formData = [
            'id_individu_p1' => $id,
            'id' => $id,
        ];
        foreach ($records as $r) {
            $formData['jumlah_' . $r->id_master_penghasilan] = $r->jumlah;
            $formData['penghasilan_' . $r->id_master_penghasilan] = $r->penghasilan;
            $formData['diekspor_' . $r->id_master_penghasilan] = (string) $r->diekspor;
        }

        return response()->json([
            'status' => true,
            'message' => 'Data P204 berdasarkan ID P1 berhasil dimuat',
            'data' => $formData,
            'raw_records' => $records,
        ]);
    }

    public function deleteAllByP1($id_individu_p1)
    {
        try {
            \App\Models\Individu\P2\IdvP204M::where('id_individu_p1', $id_individu_p1)->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $id_individu_p1,
                'P204',
                'individu_p204',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Semua data P204 berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}

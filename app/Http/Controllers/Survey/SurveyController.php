<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $survey = Survey::all();
        return view('pages.desa.survey', compact('survey'));
        // return response()->json($data);
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $request->validate([
            // 'id' => 'required|string|max:25|unique:survey',
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date',
            'deskripsi' => 'required|string',
        ]);

        $id = "sr-" . strtotime(date("Y-m-d H:i:s"));

        $survey = Survey::create([
            "id" => $id,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
            'deskripsi' => $request->deskripsi,
            'id_buat' => $userId,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Survey berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $survey = Survey::findOrFail($id);
        return response()->json($survey);
    }

    public function update(Request $request, string $id)
    {
        try {
            $survey = Survey::findOrFail($id);

            // $request->validate([
            //     'deskripsi' => 'sometimes|required|string',
            // ]);

            $survey->update(array_merge(
                $request->all(),
                [
                    'tgl_update' => now(),
                    'id_update' => Auth::user()->id
                ]
            ));

            return redirect()->route('survey.index')
                ->with('success', 'Survey berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e);
        }
    }

    public function destroy(string $id)
    {
        $relatedTables = [
            'desa_p2',
        ];

        foreach ($relatedTables as $table) {
            if (DB::table($table)->where('id_survey', $id)->exists()) {
                return back()->with('error', 'Survey tidak dapat dihapus karena sudah memiliki data isian.');
            }
        }

        // Jika aman, hapus survey
        Survey::destroy($id);

        return back()->with('success', 'Data Survey berhasil dihapus.');
    }

    public function getSurveyAktif()
    {
        $today = date('Y-m-d');

        $survey = \App\Models\Survey\Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        if ($survey) {
            return response()->json([
                'success' => true,
                'data' => $survey
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada survey aktif untuk tanggal hari ini'
            ]);
        }
    }
}

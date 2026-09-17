<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use App\Models\RT\P3\RtP3M;
use App\Models\RT\P4\RtP4M;
use App\Models\Wilayah;
use App\Support\PublicUploadPath;

class P2RtController extends Controller
{
     public function index(Request $request)
    {
        // $data = RtP2M::orderBy('tgl_buat', 'desc')->get();

        $now = Carbon::now();
     $today = Carbon::today();
        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->get();
        $data = RtP4M::with('survey')->get();
         


        // $data = RtP2M::orderBy('tgl_buat', 'desc')->where('id_p3_rw',"=",$request->id_p3_rw)->get();

        return view('pages.rt.rt', compact('data', 'survey'));
    }

    public function show_survey()
    {
        $today = Carbon::today();

        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->get();
        $keluarga = KgP2M::all();

        return view('pages.keluarga.forms.p2', compact('keluarga', 'survey'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            //custom
            'nama_rw' => 'required|integer|min:1',
            'foto_ket_rw' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // p201
            'kode_provinsi' => 'required|string|max:5',
            // p202
            'kode_kabupaten' => 'required|string|max:10',
            // p203
            'kode_kecamatan' => 'required|string|max:10',
            // p204
            'kode_desa' => 'required|string|max:15',
            'nama_desa' => 'required|string|max:100',
            'nama_dusun' => 'required|string|max:100',

            // p301
            'nama_ket_rw' => 'required|string|max:100',
            // p302
            'nik_ket_rw' => 'required|string|size:16',
            // p303
            'hp_ket_rw' => 'required|string|max:15',
            // p304
            'tahun_jabat_ket_rw' => 'required|date',

            // p305
            'nama_sek_rw' => 'nullable|string|max:100',
            // p306
            'nik_sek_rw' => 'nullable|string|size:16',
            // p307
            'hp_sek_rw' => 'nullable|string|max:15',
            // p308
            'tahun_jabat_sek_rw' => 'nullable|date',

            // p309
            'nama_bend_rw' => 'nullable|string|max:100',
            // p310
            'nik_bend_rw' => 'nullable|string|size:16',
            // p311
            'hp_bend_rw' => 'nullable|string|max:15',
            // p312
            'tahun_jabat_bend_rw' => 'nullable|date',

            // audit
            'id_buat' => 'required|string|max:25',
        ]);

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
        $existing = RtP3M::where('nama_rw', $validated['nama_rw'])
            ->where('nama_dusun', $validated['nama_dusun'])
            ->where('kode_provinsi', $validated["kode_provinsi"])
            ->where('kode_kabupaten', $validated["kode_kabupaten"])
            ->where('kode_kecamatan', $validated["kode_kecamatan"])
            ->where('kode_desa', $validated["kode_desa"])
            ->where('id_survey', $survey->id)
            ->first();

        // $existing = RtP3M::where('nama_rw', $validated['nama_rw'])
        //     ->where('nama_dusun', $validated['nama_dusun'])
        //     ->where('id_survey', $survey->id)
        //     ->first();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'Data RW ini sudah ada untuk periode survei berjalan',
            ], 409);
        }

        $id = 'RTP3-' . strtotime(now());

        $data = RtP3M::create(array_merge($validated, [
            'id' => $id,
            'id_update' => null,
            'tgl_buat' => now(),
            'tgl_update' => null,
            'id_survey' => $survey->id,
        ]));

        if ($request->hasFile('foto_ket_rw')) {
            $folderPath = PublicUploadPath::ensure('uploads/rt_p3');

            $foto = $request->file('foto_ket_rw');
            $fileName = 'foto_ket_rw_' . $id . '.' . $foto->getClientOriginalExtension();
            $foto->move($folderPath, $fileName);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => [
                'id' => $data->id,
                'id_survey' => $survey->id,
                'tgl_buat' => $data->tgl_buat,
            ],
        ], 201);
    }

    public function show(string $id)
    {
        $data = RtP3M::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $data->provinsiOptions = Wilayah::whereRaw('LENGTH(kode) = 2')->get();
        $data->kabupatenOptions = Wilayah::where('kode', 'like', $data->kode_provinsi . '.%')
            ->whereRaw('LENGTH(kode) = 5')
            ->get();
        $data->kecamatanOptions = Wilayah::where('kode', 'like', $data->kode_kabupaten . '.%')
            ->whereRaw('LENGTH(kode) = 8')
            ->get();
        $data->desaOptions = Wilayah::where('kode', 'like', $data->kode_kecamatan . '.%')
            ->whereRaw('LENGTH(kode) = 13')
            ->get();
        $folderPath = PublicUploadPath::ensure('uploads/rt_p3');
        $fotoUrl = null;
        if (File::exists($folderPath)) {

            $pattern = $folderPath . '/foto_ket_rw_' . $data->id . '.*';
            $files = File::glob($pattern);

            if (!empty($files)) {

                $fileName = basename($files[0]);
                $fotoUrl = secure_asset('uploads/rt_p3/' . $fileName);
            }
        }
        $data->foto_ket_rw = $fotoUrl;

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => [$data],
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = RtP3M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang akan di update tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([

            //custom
            'nama_rw' => 'required|integer|min:1',
            'foto_ket_rw' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_sebelum_update' => 'required|integer|min:1',
            // p201
            'kode_provinsi' => 'required|string|max:5',
            // p202
            'kode_kabupaten' => 'required|string|max:10',
            // p203
            'kode_kecamatan' => 'required|string|max:10',
            // p204
            'kode_desa' => 'required|string|max:15',
            'nama_desa' => 'required|string|max:100',
            'nama_dusun' => 'required|string|max:100',

            // p301
            'nama_ket_rw' => 'required|string|max:100',
            // p302
            'nik_ket_rw' => 'required|string|size:16',
            // p303
            'hp_ket_rw' => 'required|string|max:15',
            // p304
            'tahun_jabat_ket_rw' => 'required|date',

            // p305
            'nama_sek_rw' => 'nullable|string|max:100',
            // p306
            'nik_sek_rw' => 'nullable|string|size:16',
            // p307
            'hp_sek_rw' => 'nullable|string|max:15',
            // p308
            'tahun_jabat_sek_rw' => 'nullable|date',

            // p309
            'nama_bend_rw' => 'nullable|string|max:100',
            // p310
            'nik_bend_rw' => 'nullable|string|size:16',
            // p311
            'hp_bend_rw' => 'nullable|string|max:15',
            // p312
            'tahun_jabat_bend_rw' => 'nullable|date',

            // audit
            'id_update' => 'required|string|max:25',
        ]);

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

        $existing = RtP3M::where('nama_rw', $validated['nama_rw'])
            ->where('nama_dusun', $validated['nama_dusun'])
            ->where('kode_provinsi', $validated["kode_provinsi"])
            ->where('kode_kabupaten', $validated["kode_kabupaten"])
            ->where('kode_kecamatan', $validated["kode_kecamatan"])
            ->where('kode_desa', $validated["kode_desa"])
            ->where('id_survey', $survey->id)
            ->where('id', '!=', $data->id)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'Data RW ini sudah ada untuk periode survei berjalan',
            ], 409);
        }

        unset($validated["nama_sebelum_update"]);

        $data->update(array_merge($validated, [
            'tgl_update' => now(),
        ]));

        $folderPath = PublicUploadPath::ensure('uploads/rt_p3');
        $filePattern = $folderPath . '/foto_ket_rw_' . $data->id . '.*';

        if ($request->hasFile('foto_ket_rw')) {

            $oldFiles = File::glob($filePattern);
            foreach ($oldFiles as $oldFile) {
                File::delete($oldFile);
            }

            $foto = $request->file('foto_ket_rw');
            $fileName = 'foto_ket_rw_' . $data->id . '.' . $foto->getClientOriginalExtension();
            $foto->move($folderPath, $fileName);
        } else {
            // $validated['foto_ket_rw'] = $data->foto_ket_rw;

            $oldFiles = File::glob($filePattern);
            foreach ($oldFiles as $oldFile) {
                File::delete($oldFile);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        $data = RtP3M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang akan di hapus tidak ditemukan',
            ], 404);
        }

        $data->delete();

        $folderPath = PublicUploadPath::ensure('uploads/rt_p5');
        $filePattern = $folderPath . '/foto_ket_rw_' . $data->id . '.*';
        $oldFiles = File::glob($filePattern);
        foreach ($oldFiles as $oldFile) {
            File::delete($oldFile);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}

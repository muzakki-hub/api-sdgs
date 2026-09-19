<?php

namespace App\Http\Controllers\Api\RT\P4;

use Carbon\Carbon;
use App\Models\RT\P4\RtP4M;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class P4RtController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table("rt_p4")
            ->select('rt_p4.id', 'rt_p4.nama_ket_rt', 'rt_p4.nik_ket_rt', 'rt_p4.rt', 'rt_p4.id_p3_rw')
            ->where('rt_p4.id_p3_rw', "=", $request->id_p3_rw)
            ->orderBy('rt_p4.rt', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Belum ada data RT yang tersimpan',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rt' => 'required|integer',
            'id_p3_rw' => 'required',
            'nama_ket_rt' => 'required|string|max:100',
            'alamat_ket_rt' => 'required|string',
            'nik_ket_rt' => 'required|string|max:16',
            'hp_ket_rt' => 'required|string|max:15',
            'tahun_jabat_ket_rt' => 'required|date',

            'nama_sek_rt' => 'nullable|string|max:100',
            'nik_sek_rt' => 'nullable|string|max:16',
            'hp_sek_rt' => 'nullable|string|max:15',
            'tahun_jabat_sek_rt' => 'nullable|date',

            'nama_bend_rt' => 'nullable|string|max:100',
            'nik_bend_rt' => 'nullable|string|max:16',
            'hp_bend_rt' => 'nullable|string|max:15',
            'tahun_jabat_bend_rt' => 'nullable|date',

            'foto_ket_rt' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

        // $existing = DB::table('rt_p2')->join('rt_p3', 'rt_p2.id_p3_rw', "=", "rt_p3.id")
        //     ->select('rt_p3.nama_rw', 'rt_p3.id')
        //     ->where('rt_p3.id', $validated['id_p3_rw'])
        //     ->where('rt_p2.rt', $validated['rt'])
        //     ->first();

        $existing = DB::table('rt_p4')
            ->join('rt_p3', 'rt_p4.id_p3_rw', '=', 'rt_p3.id')
            ->select('rt_p3.nama_rw', 'rt_p3.id')
            ->where('rt_p3.id', $validated['id_p3_rw'])
            ->where('rt_p4.rt', $validated['rt'])
            ->first();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT ' . $validated['rt'] . ' RW ' . $existing->nama_rw . ' sudah ada untuk periode survei berjalan',
            ], 409);
        }

        $userId = Auth::id() ?? $request->user()?->id ?? auth('sanctum')->id();
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        $id = 'RTP4-' . strtotime(now());

        RtP4M::create(array_merge($validated, [
            'id'         => $id,
            'id_buat'    => $userId,
            'id_update'  => $userId,
            'tgl_buat'   => now(),
            'tgl_update' => null,
        ]));

        if ($request->hasFile('foto_ket_rt')) {
            $folderPath = public_path('uploads/rt_p4/');

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            $foto = $request->file('foto_ket_rt');
            $fileName = 'foto_ket_rt_' . $id . '.' . $foto->getClientOriginalExtension();
            $foto->move($folderPath, $fileName);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P4 berhasil disimpan!',
            'id' => $id,
            'data' => [
                'id' => $id,
            ],
        ], 201);
    }

    public function show(string $id)
    {
        $data = RtP4M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $folderPath = public_path('uploads/rt_p4/');
        $fotoUrl = null;

        if (File::exists($folderPath)) {

            $pattern = $folderPath . 'foto_ket_rt_' . $data->id . '.*';
            $files = File::glob($pattern);

            if (!empty($files)) {

                $fileName = basename($files[0]);
                $fotoUrl = secure_asset('uploads/rt_p4/' . $fileName);
            }
        }
        $data->foto_ket_rt = $fotoUrl;
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }


    public function update(Request $request, string $id)
    {
        $data = RtP4M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang akan diupdate tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'rt' => 'required|integer',
            'id_p3_rw' => 'required',
            'nama_ket_rt' => 'required|string|max:100',
            'alamat_ket_rt' => 'required|string',
            'nik_ket_rt' => 'required|string|max:16',
            'hp_ket_rt' => 'required|string|max:15',
            'tahun_jabat_ket_rt' => 'required|date',

            'nama_sek_rt' => 'nullable|string|max:100',
            'nik_sek_rt' => 'nullable|string|max:16',
            'hp_sek_rt' => 'nullable|string|max:15',
            'tahun_jabat_sek_rt' => 'nullable|date',

            'nama_bend_rt' => 'nullable|string|max:100',
            'nik_bend_rt' => 'nullable|string|max:16',
            'hp_bend_rt' => 'nullable|string|max:15',
            'tahun_jabat_bend_rt' => 'nullable|date',

            'foto_ket_rt' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

        $existing = DB::table('rt_p4')
            ->join('rt_p3', 'rt_p4.id_p3_rw', '=', 'rt_p3.id')
            ->select('rt_p3.nama_rw', 'rt_p3.id')
            ->where('rt_p3.id', $validated['id_p3_rw'])
            ->where('rt_p4.rt', $validated['rt'])
            ->where('rt_p4.id', '!=', $data->id)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT ' . $validated['rt'] . ' RW ' . $existing->nama_rw . ' sudah ada untuk periode survei berjalan',
            ], 409);
        }

        $userId = Auth::id() ?? $request->user()?->id ?? auth('sanctum')->id();

        $data->update(array_merge($validated, [
            'id_update'  => $userId,
            'tgl_update' => now(),
        ]));

        $folderPath = public_path('uploads/rt_p4/');
        $filePattern = $folderPath . 'foto_ket_rt_' . $data->id . '.*';

        if ($request->hasFile('foto_ket_rt')) {

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }


            $oldFiles = File::glob($filePattern);
            foreach ($oldFiles as $oldFile) {
                File::delete($oldFile);
            }

            $foto = $request->file('foto_ket_rt');
            $fileName = 'foto_ket_rt_' . $data->id . '.' . $foto->getClientOriginalExtension();
            $foto->move($folderPath, $fileName);
        } else {
            // $validated['foto_ket_rt'] = $data->foto_ket_rt;

            $oldFiles = File::glob($filePattern);
            foreach ($oldFiles as $oldFile) {
                File::delete($oldFile);
            }
        }



        return response()->json([
            'status' => true,
            'message' => 'Data RT P4 berhasil diperbarui!',
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        $data = RtP4M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang akan di hapus tidak ditemukan',
            ], 404);
        }

        $data->delete();
        $folderPath = public_path('uploads/rt_p4/');
        $filePattern = $folderPath . 'foto_ket_rt_' . $data->id . '.*';
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

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AdminTerritoryController extends Controller
{
    /**
     * Get list of surveyors (all users except admin 00).
     */
    public function getSurveyors(Request $request)
    {
        try {
            $users = User::with('jabatan')
                ->where('id_jabatan', '!=', '00')
                ->orderBy('id_jabatan', 'asc')
                ->orderBy('nama', 'asc')
                ->get();

            $surveyors = $users->map(function ($u) {
                return [
                    'id' => $u->id,
                    'nama' => $u->nama,
                    'username' => $u->username,
                    'hp' => $u->hp,
                    'id_jabatan' => $u->id_jabatan,
                    'nama_jabatan' => optional($u->jabatan)->nama_jabatan ?: 'Surveyor',
                    'rw_tugas' => $u->rw_tugas ? (string) $u->rw_tugas : null,
                    'rt_tugas' => $u->rt_tugas ? (string) $u->rt_tugas : null,
                    'is_restricted' => !empty($u->rw_tugas),
                    'status' => $u->status,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Daftar surveyor berhasil diambil',
                'data' => $surveyors,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data surveyor: ' . $th->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Update territory assignment for a specific surveyor.
     */
    public function updateWilayah(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'rw_tugas' => 'nullable|string|max:10',
                'rt_tugas' => 'nullable|string|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $rw = $request->filled('rw_tugas') ? trim((string)$request->rw_tugas) : null;
            $rt = $request->filled('rt_tugas') ? trim((string)$request->rt_tugas) : null;

            if (empty($rw)) {
                $rw = null;
                $rt = null;
            }

            $user->rw_tugas = $rw;
            $user->rt_tugas = $rt;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Wilayah tugas berhasil diperbarui',
                'data' => [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'rw_tugas' => $user->rw_tugas,
                    'rt_tugas' => $user->rt_tugas,
                    'is_restricted' => !empty($user->rw_tugas),
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui wilayah tugas: ' . $th->getMessage(),
            ], 500);
        }
    }
}

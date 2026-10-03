<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\DesaP2;

class CoverDataService
{
    /**
     * Cache base64 header image in memory per request.
     */
    protected static ?string $cachedHeaderBase64 = null;

    /**
     * Get base64 encoded header image for cover.
     */
    public static function getHeaderImageBase64(): string
    {
        if (static::$cachedHeaderBase64 !== null) {
            return static::$cachedHeaderBase64;
        }

        $path = public_path('images/cover/header_sdgs.png');
        if (file_exists($path)) {
            $data = file_get_contents($path);
            static::$cachedHeaderBase64 = 'data:image/png;base64,' . base64_encode($data);
            return static::$cachedHeaderBase64;
        }

        static::$cachedHeaderBase64 = '';
        return '';
    }

    /**
     * Get the enumerator User model/object based on auth session, bearer token,
     * query parameter, record audit trail, or database fallback.
     */
    public static function getEnumeratorUser($primaryRecord = null, $request = null)
    {
        $request = $request ?? request();

        // 1. Cek query param token jika sanctum belum terautentikasi (misal direct window.open)
        if (!Auth::check() && !auth('sanctum')->check() && $request && $request->has('token')) {
            $tokenStr = $request->query('token');
            $pat = \Laravel\Sanctum\PersonalAccessToken::findToken($tokenStr);
            if ($pat && $pat->tokenable) {
                return $pat->tokenable;
            }
        }

        // 2. Cek manual bearer token jika auth('sanctum') belum resolve
        if (!Auth::check() && !auth('sanctum')->check() && $request) {
            $bearer = $request->bearerToken();
            if ($bearer) {
                $pat = \Laravel\Sanctum\PersonalAccessToken::findToken($bearer);
                if ($pat && $pat->tokenable) {
                    return $pat->tokenable;
                }
            }
        }

        // 3. Auth user dari session atau sanctum
        $user = Auth::user()
            ?? auth('sanctum')->user()
            ?? ($request && method_exists($request, 'user') ? $request->user() : null);

        if ($user) {
            return $user;
        }

        // 3. Fallback ke audit trail (id_update / id_buat)
        if (is_object($primaryRecord)) {
            $userId = $primaryRecord->id_update ?: $primaryRecord->id_buat ?: null;
            if ($userId) {
                $user = DB::table('user')->where('id', $userId)->first();
                if ($user) {
                    return $user;
                }
            }
        }

        // 4. Fallback ke user pertama yang ada di database agar tidak pernah null
        return DB::table('user')->first();
    }

    /**
     * Resolve enumerator based on currently authenticated user (Opsi B).
     * Falls back to record audit trail if unauthenticated.
     */
    public static function resolveEnumerator($primaryRecord = null, $request = null): array
    {
        $user = static::getEnumeratorUser($primaryRecord, $request);

        $nama = '';
        $jabatan = '';
        $ttdBase64 = '';

        if ($user) {
            $nama = $user->nama ?? '';
            if (!empty($user->id_jabatan)) {
                $namaJabatan = DB::table('jabatan')
                    ->where('id', $user->id_jabatan)
                    ->value('nama_jabatan');
                if ($namaJabatan) {
                    $jabatan = $namaJabatan;
                }
            }

            if (!empty($user->tanda_tangan)) {
                $path = public_path($user->tanda_tangan);
                if (file_exists($path)) {
                    $mime = mime_content_type($path) ?: 'image/png';
                    $data = file_get_contents($path);
                    $ttdBase64 = 'data:' . $mime . ';base64,' . base64_encode($data);
                } elseif (str_starts_with($user->tanda_tangan, 'data:image/')) {
                    $ttdBase64 = $user->tanda_tangan;
                }
            }
        }

        return [
            'nama' => $nama,
            'jabatan' => $jabatan,
            'ttd' => $ttdBase64,
            'user' => $user,
        ];
    }

    /**
     * Resolve nama kepala keluarga for an individual record.
     * Returns string if resolved, or null if not yet present in database.
     */
    public static function resolveNamaKepalaKeluarga($p1, ?string $requestParam = null): ?string
    {
        // 1. If explicitly passed in request query (e.g. from user prompt)
        if (!empty($requestParam) && trim($requestParam) !== '') {
            return trim($requestParam);
        }

        if (!$p1) {
            return null;
        }

        // 2. Check if this individual is the Kepala Keluarga
        if (in_array((string)$p1->status_hubungan_keluarga, ['1', 'Kepala Keluarga'], true)) {
            return $p1->nama;
        }

        // 3. Search in individu_p1 with same no_kk having status_hubungan_keluarga == Kepala Keluarga
        if (!empty($p1->no_kk)) {
            $kk = DB::table('individu_p1')
                ->where('no_kk', $p1->no_kk)
                ->where(function ($query) {
                    $query->where('status_hubungan_keluarga', '1')
                        ->orWhere('status_hubungan_keluarga', 'Kepala Keluarga');
                })
                ->first();

            if ($kk && !empty($kk->nama)) {
                return $kk->nama;
            }
        }

        return null;
    }

    /**
     * Resolve wilayah (Desa, Kecamatan, Kabupaten) from desa_p2 and wilayah table.
     */
    public static function resolveWilayah(): array
    {
        $desaP2 = DesaP2::first();
        $desa = $desaP2?->nama_desa ?? '-';
        $kecamatan = '-';
        $kabupaten = '-';

        if ($desaP2 && !empty($desaP2->kode_kecamatan)) {
            $kecamatan = DB::table('wilayah')->where('kode', $desaP2->kode_kecamatan)->value('nama') ?? '-';
        }

        if ($desaP2 && !empty($desaP2->kode_kabupaten)) {
            $kabupaten = DB::table('wilayah')->where('kode', $desaP2->kode_kabupaten)->value('nama') ?? '-';
        }

        return [
            'desa' => $desa,
            'kecamatan' => $kecamatan,
            'kabupaten' => $kabupaten,
            'desa_p2' => $desaP2,
        ];
    }
}

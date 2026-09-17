<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa\DesaP2;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Keluarga\P2\KgP2M;

class SessionController extends Controller
{
    public function set($id, $form)
    {
        $p2 = DesaP2::findOrFail($id);

        // Simpan ke session
        session([
            'id_survey' => $p2->id_survey,
            'id_desa'   => $p2->id,
        ]);

        // Tentukan route tujuan berdasarkan form
        $redirectRoute = match ($form) {
            'p3'  => 'desa-p3.index',
            'p4'  => 'desa-p4.index',
            'p5'  => 'desa-p5.index',
            'p601' => 'desa-p601.index',
            'p602' => 'desa-p602.index',
            'p603' => 'desa-p603.index',
            'p7'  => 'desa-p7.index',
            'p8'  => 'desa-p8.index',
            'p9'  => 'desa-p9.index',
            'p10' => 'desa-p10.index',
            // jangan sertakan 'kgp...' di sini karena itu khusus keluarga
            default => 'dashboard',
        };

        return redirect()->route($redirectRoute);
    }

    public function setkg($id, $form)
    {
        $p2kg = KgP2M::findOrFail($id);

        // Simpan ke session
        session([
            'id_survey' => $p2kg->id_survey,
            'id_kg_p2'   => $p2kg->id,
        ]);

        $redirectRoute = match ($form) {
            'kgp3' => 'kg-p3.index',
            'kgp4' => 'kg-p4.index',
            'kgp421' => 'kg-p421.index',
            'kgp422' => 'kg-p422.index',
            'kgp423' => 'kg-p423.index',
            'kgp424' => 'kg-p424.index',
            default => 'dashboard',
        };

        return redirect()->route($redirectRoute);
    }

    public function setidv($id, $form)
    {
        $p1idv = IdvP1M::findOrFail($id);

        // Simpan ke session
        session([
            'id_survey' => $p1idv->id_survey,
            'id_individu_p1'   => $p1idv->id,
        ]);

        $redirectRoute = match ($form) {
            'idvp2' => 'idv-p2.index',
            'idvp204' => 'idv-p204.index',
            'idvp4' => 'idv-p4.index',
            'idvp401' => 'idv-p401.index',
            'idvp402' => 'idv-p402.index',
            'idvp5' => 'idv-p5.index',
            default => 'dashboard',
        };

        return redirect()->route($redirectRoute);
    }
}

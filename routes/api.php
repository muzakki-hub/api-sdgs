<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Formulir\FormulirIdvController;
use App\Http\Controllers\Api\Formulir\FormulirKgController;
use App\Http\Controllers\Api\Individu\P1\P1IdvApi;
use App\Http\Controllers\Api\Individu\P2\P204IdvApi;
use App\Http\Controllers\Api\Individu\P2\P2IdvApi;
use App\Http\Controllers\Api\Individu\P4\P401IdvApi;
use App\Http\Controllers\Api\Individu\P4\P402IdvApi;
use App\Http\Controllers\Api\Individu\P4\P4IdvApi;
use App\Http\Controllers\Api\Individu\P5\P5IdvApi;
use App\Http\Controllers\Api\Keluarga\P2\P2Api;
use App\Http\Controllers\Api\Keluarga\P3\P3Api;
use App\Http\Controllers\Api\Keluarga\P4\P421Api;
use App\Http\Controllers\Api\Keluarga\P4\P422Api;
use App\Http\Controllers\Api\Keluarga\P4\P423Api;
use App\Http\Controllers\Api\Keluarga\P4\P424Api;
use App\Http\Controllers\Api\Keluarga\KgprogressController;
use App\Http\Controllers\Api\Keluarga\P4\P4Api;
use App\Http\Controllers\Api\Master\MasterApstApiController;
use App\Http\Controllers\Api\Master\MasterFaskesApiController;
use App\Http\Controllers\Api\Master\MasterPendidikanApiController;
use App\Http\Controllers\Api\Master\MasterPenghasilanApiController;
use App\Http\Controllers\Api\Master\MasterPenyakitApiController;
use App\Http\Controllers\Api\Master\MasterSarkesApiController;
use App\Http\Controllers\Api\Master\MasterTenkesApiController;
use App\Http\Controllers\Api\RT\ExportRtController;
use App\Http\Controllers\Api\RT\P10\MasterLembagaMasyarakatRtController;
use App\Http\Controllers\Api\RT\P10\P1004RtController;
use App\Http\Controllers\Api\RT\P10\P10RtController;
use App\Http\Controllers\Api\RT\P10\TransaksiLembagaMasyarakatP10RtController;
use App\Http\Controllers\Api\RT\P11\MasterKejahatanRtController;
use App\Http\Controllers\Api\RT\P11\MasterPerkelahianRtController;
use App\Http\Controllers\Api\RT\P11\P11RtController;
use App\Http\Controllers\Api\RT\P11\TransaksiKejahatanP11RtController;
use App\Http\Controllers\Api\RT\P11\TransaksiPerkelahianP11RtController;
use App\Http\Controllers\Api\RT\P2\P2RtController;
use App\Http\Controllers\Api\RT\P3\P3RtController;
use App\Http\Controllers\Api\RT\P4\P4RtController;
use App\Http\Controllers\Api\RT\P5\MasterJenisIndustriRtController;
use App\Http\Controllers\Api\RT\P5\MasterSaranaEkonomiRtController;
use App\Http\Controllers\Api\RT\P5\P5RtController;
use App\Http\Controllers\Api\RT\P5\TransaksiIndustriP5RtController;
use App\Http\Controllers\Api\RT\P5\TransaksiSaranaEkonomiP5RtController;
use App\Http\Controllers\Api\RT\P6\MasterOperatorSinyalRtController;
use App\Http\Controllers\Api\RT\P6\MasterTvRadioRtController;
use App\Http\Controllers\Api\RT\P6\P6RtController;
use App\Http\Controllers\Api\RT\P6\TransaksiOperatorSinyalP6RtController;
use App\Http\Controllers\Api\RT\P6\TransaksiTvRadioP6RtController;
use App\Http\Controllers\Api\RT\P7\MasterBencanaAlamRtController;
use App\Http\Controllers\Api\RT\P7\MasterGunaSumberRtController;
use App\Http\Controllers\Api\RT\P7\MasterLingkunganRtController;
use App\Http\Controllers\Api\RT\P7\P7RtController;
use App\Http\Controllers\Api\RT\P7\TransaksiBencanaAlamP7RtController;
use App\Http\Controllers\Api\RT\P7\TransaksiGunaSumberP7RtController;
use App\Http\Controllers\Api\RT\P7\TransaksiPencemaranP7RtController;
use App\Http\Controllers\Api\RT\P8\MasterPendidikanRtController;
use App\Http\Controllers\Api\RT\P8\P8RtController;
use App\Http\Controllers\Api\RT\P8\TransaksiPendidikanP8RtController;
use App\Http\Controllers\Api\RT\P9\MasterKesehatanRtController;
use App\Http\Controllers\Api\RT\P9\MasterKlbRtController;
use App\Http\Controllers\Api\RT\P9\TransaksiKesehatanP9RtController;
use App\Http\Controllers\Api\RT\P9\TransaksiKlbP9RtController;
use App\Http\Controllers\Api\RT\RtprogressController;
use App\Http\Controllers\Api\Wilayah\WilayahApi;
use App\Http\Controllers\Api\Survey\SurveyApi;
use App\Http\Controllers\Laporan\LaporanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("login", [ApiController::class, "login"]);

Route::group([
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get("getuser", [ApiController::class, "getdatauser"]);
    Route::get("logout", [ApiController::class, "logout"]);
    Route::get("refresh-token", [ApiController::class, "refreshToken"]);

    // SURVEY
    Route::get('/survey/all', [SurveyApi::class, 'index']);
    Route::get('/survey/aktif', [SurveyApi::class, 'getSurveyAktif']);
    // LAPORANNN DEMOGRAFI
    Route::get('/laporan-rekap/download', [LaporanController::class, 'download'])->name('laporan.download');






    Route::prefix('keluarga')->group(function () {
        Route::resource('/p2', P2Api::class);
        Route::resource('/p3', P3Api::class);
        Route::get('/p3/by-p2/{id}', [P3Api::class, 'showByIdP2']);
        Route::resource('/p4', P4Api::class);
        Route::get('/p4/by-p2/{id}', [P4Api::class, 'showByIdP2']);
        Route::resource('/p421', P421Api::class);
        Route::get('/p421/by-p2/{id}', [P421Api::class, 'showByIdP2']);
        Route::resource('/p422', P422Api::class);
        Route::get('/p422/by-p2/{id}', [P422Api::class, 'showByIdP2']);
        Route::post('/p422/batch', [P422Api::class, 'storeBatch']);
        Route::resource('/p423', P423Api::class);
        Route::get('/p423/by-p2/{id}', [P423Api::class, 'showByIdP2']);
        Route::resource('/p424', P424Api::class);
        Route::get('/p424/by-p2/{id}', [P424Api::class, 'showByIdP2']);
        Route::get('/progress/{idP2}', [KgprogressController::class, 'getProgress']);
    });


    Route::prefix('individu')->group(function () {
        // INDIVIDU P1
        Route::resource('/p1', P1IdvApi::class);
        Route::get('/p1/by-p1/{id}', [P1IdvApi::class, 'byP1']);

        // INDIVIDU P2
        Route::resource('/p2', P2IdvApi::class);
        Route::get('/p2/by-p1/{id}', [P2IdvApi::class, 'showByIdP1']);

        // INDIVIDU P204
        Route::resource('/p204', P204IdvApi::class);
        Route::get('/p204/by-p1/{id}', [P204IdvApi::class, 'showByIdP1']);
        Route::delete(
            '/p204/delete-all/{id_individu_p1}',
            [P204IdvApi::class, 'deleteAllByP1']
        );
        // INDIVIDU P4
        Route::resource('/p4', P4IdvApi::class);
        Route::get('/p4/by-p1/{id}', [P4IdvApi::class, 'showByIdP1']);

        // INDIVIDU P401
        Route::resource('/p401', P401IdvApi::class);
        Route::get('/p401/by-p1/{id}', [P401IdvApi::class, 'showByIdP1']);
        Route::post('/p401/by-p1/{id_p1}', [P401IdvApi::class, 'updateMany']);
        Route::post('/p401/many', [P401IdvApi::class, 'storeMany']);
        Route::delete('/p401/delete-all/{id_individu_p1}', [P401IdvApi::class, 'deleteAllByP1']);

        // INDIVIDU P402
        Route::resource('/p402', P402IdvApi::class);
        Route::get('/p402/by-p1/{id}', [P402IdvApi::class, 'showByIdP1']);
        Route::post('/p402/by-p1/{id_p1}', [P402IdvApi::class, 'updateMany']);
        Route::post('/p402/many', [P402IdvApi::class, 'storeMany']);
        Route::delete('/p402/delete-all/{id_individu_p1}', [P402IdvApi::class, 'deleteAllByP1']);

        // INDIVIDU P5
        Route::resource('/p5', P5IdvApi::class);
        Route::get('/p5/by-p1/{id}', [P5IdvApi::class, 'showByIdP1']);
    });
    
    Route::prefix('master')->group(function () {
        Route::get('/penghasilan', [MasterPenghasilanApiController::class, 'index']);
        Route::get('/penyakit', [MasterPenyakitApiController::class, 'index']);
        Route::get('/sarkes', [MasterSarkesApiController::class, 'index']);
        Route::resource('/pendidikan', MasterPendidikanApiController::class);
        Route::resource('/faskes', MasterFaskesApiController::class);
        Route::resource('/tenkes', MasterTenkesApiController::class);
        Route::resource('/apst', MasterApstApiController::class);
    });
    Route::get('/formulir-keluarga/{id}', [FormulirKgController::class, 'view']);
    Route::get('/formulir-keluarga/{id}/download', [FormulirKgController::class, 'download']);
    Route::get('/formulir-individu/{id}', [FormulirIdvController::class, 'view']);
    Route::get('/formulir-individu/{id}/download', [FormulirIdvController::class, 'download']);

});
Route::prefix('rt')->middleware('auth:sanctum')->group(function () {

    Route::post('/p2', [P2RtController::class, 'store']);
    Route::get('/p2/{id_p3_rw}', [P2RtController::class, 'index']);
    Route::get('/p2/show/{idP4}', [P2RtController::class, 'show']);
    Route::put('/p2/{id}', [P2RtController::class, 'update']);
    Route::delete('/p2/{idP4}', [P2RtController::class, 'destroy']);

    Route::post('/p3', [P3RtController::class, 'store']);
    Route::get('/p3', [P3RtController::class, 'index']);
    Route::get('/p3/{id}', [P3RtController::class, 'show']);
    Route::get('/p3/update/{id}', [P3RtController::class, 'show']);
    Route::post('/p3/update/{id}', [P3RtController::class, 'update']);
    Route::delete('/p3/{id}', [P3RtController::class, 'destroy']);

    Route::get('/p4/{id_p3_rw}', [P4RtController::class, 'index']);
    Route::post('/p4', [P4RtController::class, 'store']);
    Route::get('/p4/show/{id}', [P4RtController::class, 'show']);
    Route::post('/p4/update/{id}', [P4RtController::class, 'update']);
    Route::delete('/p4/{id}', [P4RtController::class, 'destroy']);

    Route::post('/p5', [P5RtController::class, 'store']);
    Route::get('/p5/show/{idP4}', [P5RtController::class, 'show']);
    Route::put('/p5/{id}', [P5RtController::class, 'update']);
    Route::delete('/p5/{idP4}', [P5RtController::class, 'destroy']);

    Route::get('/master-jenis-industri', [MasterJenisIndustriRtController::class, 'index']);
    Route::post('/master-jenis-industri', [MasterJenisIndustriRtController::class, 'store']);
    Route::get('/master-jenis-industri/show/{id}', [MasterJenisIndustriRtController::class, 'show']);
    Route::put('/master-jenis-industri/{id}', [MasterJenisIndustriRtController::class, 'update']);

    Route::post('/p502', [TransaksiIndustriP5RtController::class, 'store']);
    Route::get('/p502/show/{idP4}/{idMasterIndustri}', [TransaksiIndustriP5RtController::class, 'show']);
    Route::put('/p502/{id}', [TransaksiIndustriP5RtController::class, 'update']);
    Route::delete('/p502/{idP4}/{idMasterIndustri}', [TransaksiIndustriP5RtController::class, 'destroy']);
    Route::delete('/p502/delete/all/{idP4}', [TransaksiIndustriP5RtController::class, 'destroyAll']);

    Route::get('/master-sarana-ekonomi', [MasterSaranaEkonomiRtController::class, 'index']);
    Route::post('/master-sarana-ekonomi', [MasterSaranaEkonomiRtController::class, 'store']);
    Route::get('/master-sarana-ekonomi/show/{id}', [MasterSaranaEkonomiRtController::class, 'show']);
    Route::put('/master-sarana-ekonomi/{id}', [MasterSaranaEkonomiRtController::class, 'update']);

    Route::post('/p508', [TransaksiSaranaEkonomiP5RtController::class, 'store']);
    Route::get('/p508/show/{idP4}/{idMasterSaranaEkonomi}', [TransaksiSaranaEkonomiP5RtController::class, 'show']);
    Route::put('/p508/{id}', [TransaksiSaranaEkonomiP5RtController::class, 'update']);
    Route::delete('/p508/{idP4}/{idMasterSaranaEkonomi}', [TransaksiSaranaEkonomiP5RtController::class, 'destroy']);
    Route::delete('/p508/delete/all/{idP4}', [TransaksiSaranaEkonomiP5RtController::class, 'destroyAll']);

    Route::get('/p6/show/{idP4}', [P6RtController::class, 'show']);
    Route::post('/p6', [P6RtController::class, 'store']);
    Route::put('/p6/{id}', [P6RtController::class, 'update']);
    Route::delete('/p6/{idP4}', [P6RtController::class, 'destroy']);

    Route::get('/p7/show/{idP4}', [P7RtController::class, 'show']);
    Route::post('/p7', [P7RtController::class, 'store']);
    Route::put('/p7/{id}', [P7RtController::class, 'update']);
    Route::delete('/p7/{idP4}', [P7RtController::class, 'destroy']);

    Route::get('/master-operator-sinyal', [MasterOperatorSinyalRtController::class, 'index']);
    Route::post('/master-operator-sinyal', [MasterOperatorSinyalRtController::class, 'store']);
    Route::get('/master-operator-sinyal/show/{id}', [MasterOperatorSinyalRtController::class, 'show']);
    Route::put('/master-operator-sinyal/{id}', [MasterOperatorSinyalRtController::class, 'update']);

    Route::post('/p607', [TransaksiOperatorSinyalP6RtController::class, 'store']);
    Route::get('/p607/show/{idP4}/{idMasterOperatorSinyal}', [TransaksiOperatorSinyalP6RtController::class, 'show']);
    Route::put('/p607/{id}', [TransaksiOperatorSinyalP6RtController::class, 'update']);
    Route::delete('/p607/{idP4}/{idMasterOperatorSinyal}', [TransaksiOperatorSinyalP6RtController::class, 'destroy']);
    Route::delete('/p607/delete/all/{idP4}', [TransaksiOperatorSinyalP6RtController::class, 'destroyAll']);

    Route::get('/master-tv-radio', [MasterTvRadioRtController::class, 'index']);
    Route::post('/master-tv-radio', [MasterTvRadioRtController::class, 'store']);
    Route::get('/master-tv-radio/show/{id}', [MasterTvRadioRtController::class, 'show']);
    Route::put('/master-tv-radio/{id}', [MasterTvRadioRtController::class, 'update']);

    Route::post('/p609', [TransaksiTvRadioP6RtController::class, 'store']);
    Route::get('/p609/show/{idP4}/{idMasterTvRadio}', [TransaksiTvRadioP6RtController::class, 'show']);
    Route::put('/p609/{id}', [TransaksiTvRadioP6RtController::class, 'update']);
    Route::delete('/p609/{idP4}/{idMasterTvRadio}', [TransaksiTvRadioP6RtController::class, 'destroy']);
    Route::delete('/p609/delete/all/{idP4}', [TransaksiTvRadioP6RtController::class, 'destroyAll']);

    Route::get('/master-guna-sumber', [MasterGunaSumberRtController::class, 'index']);
    Route::post('/master-guna-sumber', [MasterGunaSumberRtController::class, 'store']);
    Route::get('/master-guna-sumber/show/{id}', [MasterGunaSumberRtController::class, 'show']);
    Route::put('/master-guna-sumber/{id}', [MasterGunaSumberRtController::class, 'update']);

    Route::post('/p706', [TransaksiGunaSumberP7RtController::class, 'store']);
    Route::get('/p706/show/{idP4}/{idMasterGunaSumber}', [TransaksiGunaSumberP7RtController::class, 'show']);
    Route::put('/p706/{id}', [TransaksiGunaSumberP7RtController::class, 'update']);
    Route::delete('/p706/{idP4}/{idMasterGunaSumber}', [TransaksiGunaSumberP7RtController::class, 'destroy']);
    Route::delete('/p706/delete/all/{idP4}', [TransaksiGunaSumberP7RtController::class, 'destroyAll']);

    Route::get('/master-lingkungan', [MasterLingkunganRtController::class, 'index']);
    Route::post('/master-lingkungan', [MasterLingkunganRtController::class, 'store']);
    Route::get('/master-lingkungan/show/{id}', [MasterLingkunganRtController::class, 'show']);
    Route::put('/master-lingkungan/{id}', [MasterLingkunganRtController::class, 'update']);

    Route::post('/p709', [TransaksiPencemaranP7RtController::class, 'store']);
    Route::get('/p709/show/{idP4}/{idMasterLingkungan}', [TransaksiPencemaranP7RtController::class, 'show']);
    Route::put('/p709/{id}', [TransaksiPencemaranP7RtController::class, 'update']);
    Route::delete('/p709/{idP4}/{idMasterLingkungan}', [TransaksiPencemaranP7RtController::class, 'destroy']);
    Route::delete('/p709/delete/all/{idP4}', [TransaksiPencemaranP7RtController::class, 'destroyAll']);

    Route::get('/master-bencana', [MasterBencanaAlamRtController::class, 'index']);
    Route::post('/master-bencana', [MasterBencanaAlamRtController::class, 'store']);
    Route::get('/master-bencana/show/{id}', [MasterBencanaAlamRtController::class, 'show']);
    Route::put('/master-bencana/{id}', [MasterBencanaAlamRtController::class, 'update']);

    Route::post('/p713', [TransaksiBencanaAlamP7RtController::class, 'store']);
    Route::get('/p713/show/{idP4}/{idMasterLingkungan}', [TransaksiBencanaAlamP7RtController::class, 'show']);
    Route::put('/p713/{id}', [TransaksiBencanaAlamP7RtController::class, 'update']);
    Route::delete('/p713/{idP4}/{idMasterLingkungan}', [TransaksiBencanaAlamP7RtController::class, 'destroy']);
    Route::delete('/p713/delete/all/{idP4}', [TransaksiBencanaAlamP7RtController::class, 'destroyAll']);

    Route::get('/p8/show/{idP4}', [P8RtController::class, 'show']);
    Route::post('/p8', [P8RtController::class, 'store']);
    Route::put('/p8/{id}', [P8RtController::class, 'update']);
    Route::delete('/p8/{idP4}', [P8RtController::class, 'destroy']);


    Route::get('/master-pendidikan', [MasterPendidikanRtController::class, 'index']);
    Route::post('/master-pendidikan', [MasterPendidikanRtController::class, 'store']);
    Route::get('/master-pendidikan/show/{id}', [MasterPendidikanRtController::class, 'show']);
    Route::put('/master-pendidikan/{id}', [MasterPendidikanRtController::class, 'update']);

    Route::get('/p801/{idP4}', [TransaksiPendidikanP8RtController::class, 'index']);
    Route::post('/p801', [TransaksiPendidikanP8RtController::class, 'store']);
    Route::get('/p801/show/{id}', [TransaksiPendidikanP8RtController::class, 'show']);
    Route::put('/p801/{id}', [TransaksiPendidikanP8RtController::class, 'update']);
    Route::delete('/p801/{id}', [TransaksiPendidikanP8RtController::class, 'destroy']);
    Route::delete('/p801/delete/all/{id}', [TransaksiPendidikanP8RtController::class, 'destroyAll']);

    Route::get('/master-kesehatan', [MasterKesehatanRtController::class, 'index']);
    Route::post('/master-kesehatan', [MasterKesehatanRtController::class, 'store']);
    Route::get('/master-kesehatan/show/{id}', [MasterKesehatanRtController::class, 'show']);
    Route::put('/master-kesehatan/{id}', [MasterKesehatanRtController::class, 'update']);

    Route::get('/p901/{idP4}', [TransaksiKesehatanP9RtController::class, 'index']);
    Route::post('/p901', [TransaksiKesehatanP9RtController::class, 'store']);
    Route::get('/p901/show/{id}', [TransaksiKesehatanP9RtController::class, 'show']);
    Route::put('/p901/{id}', [TransaksiKesehatanP9RtController::class, 'update']);
    Route::delete('/p901/{id}', [TransaksiKesehatanP9RtController::class, 'destroy']);
    Route::delete('/p901/delete/all/{id}', [TransaksiKesehatanP9RtController::class, 'destroyAll']);

    Route::get('/master-klb', [MasterKlbRtController::class, 'index']);
    Route::post('/master-klb', [MasterKlbRtController::class, 'store']);
    Route::get('/master-klb/show/{id}', [MasterKlbRtController::class, 'show']);
    Route::put('/master-klb/{id}', [MasterKlbRtController::class, 'update']);

    Route::post('/p902', [TransaksiKlbP9RtController::class, 'store']);
    Route::get('/p902/show/{idP4}/{idMasterKlb}', [TransaksiKlbP9RtController::class, 'show']);
    Route::put('/p902/{id}', [TransaksiKlbP9RtController::class, 'update']);
    Route::delete('/p902/{idP4}/{idMasterKlb}', [TransaksiKlbP9RtController::class, 'destroy']);
    Route::delete('/p902/delete/all/{idP4}', [TransaksiKlbP9RtController::class, 'destroyAll']);

    Route::get('/p10/show/{idP4}', [P10RtController::class, 'show']);
    Route::post('/p10', [P10RtController::class, 'store']);
    Route::put('/p10/{id}', [P10RtController::class, 'update']);
    Route::delete('/p10/{idP4}', [P10RtController::class, 'destroy']);

    Route::get('/p1004/{idP4}', [P1004RtController::class, 'index']);
    Route::get('/p1004/show/{idP4}', [P1004RtController::class, 'show']);
    Route::post('/p1004', [P1004RtController::class, 'store']);
    Route::put('/p1004/{id}', [P1004RtController::class, 'update']);
    Route::delete('/p1004/{idP4}', [P1004RtController::class, 'destroy']);
    Route::delete('/p1004/delete/all/{idP4}', [P1004RtController::class, 'destroyAll']);

    Route::get('/master-lembaga', [MasterLembagaMasyarakatRtController::class, 'index']);
    Route::post('/master-lembaga', [MasterLembagaMasyarakatRtController::class, 'store']);
    Route::get('/master-lembaga/show/{id}', [MasterLembagaMasyarakatRtController::class, 'show']);
    Route::put('/master-lembaga/{id}', [MasterLembagaMasyarakatRtController::class, 'update']);

    Route::post('/p1009', [TransaksiLembagaMasyarakatP10RtController::class, 'store']);
    Route::get('/p1009/show/{idP4}/{idMasterLembaga}', [TransaksiLembagaMasyarakatP10RtController::class, 'show']);
    Route::put('/p1009/{id}', [TransaksiLembagaMasyarakatP10RtController::class, 'update']);
    Route::delete('/p1009/{idP4}/{idMasterLembaga}', [TransaksiLembagaMasyarakatP10RtController::class, 'destroy']);
    Route::delete('/p1009/{idP4}/{idMasterLembaga}', [TransaksiLembagaMasyarakatP10RtController::class, 'destroy']);
    Route::delete('/p1009/delete/all/{idP4}', [TransaksiLembagaMasyarakatP10RtController::class, 'destroyAll']);

    Route::get('/p11/show/{idP4}', [P11RtController::class, 'show']);
    Route::post('/p11', [P11RtController::class, 'store']);
    Route::put('/p11/{id}', [P11RtController::class, 'update']);
    Route::delete('/p11/{idP4}', [P11RtController::class, 'destroy']);

    Route::get('/master-perkelahian', [MasterPerkelahianRtController::class, 'index']);
    Route::post('/master-perkelahian', [MasterPerkelahianRtController::class, 'store']);
    Route::get('/master-perkelahian/show/{id}', [MasterPerkelahianRtController::class, 'show']);
    Route::put('/master-perkelahian/{id}', [MasterPerkelahianRtController::class, 'update']);

    Route::post('/p1101', [TransaksiPerkelahianP11RtController::class, 'store']);
    Route::get('/p1101/show/{idP4}/{idMasterPerkelahian}', [TransaksiPerkelahianP11RtController::class, 'show']);
    Route::put('/p1101/{id}', [TransaksiPerkelahianP11RtController::class, 'update']);
    Route::delete('/p1101/{idP4}/{idMasterPerkelahian}', [TransaksiPerkelahianP11RtController::class, 'destroy']);
    Route::delete('/p1101/delete/all/{idP4}', [TransaksiPerkelahianP11RtController::class, 'destroyAll']);


    Route::get('/master-kejahatan', [MasterKejahatanRtController::class, 'index']);
    Route::post('/master-kejahatan', [MasterKejahatanRtController::class, 'store']);
    Route::get('/master-kejahatan/show/{id}', [MasterKejahatanRtController::class, 'show']);
    Route::put('/master-kejahatan/{id}', [MasterKejahatanRtController::class, 'update']);

    Route::post('/p1102', [TransaksiKejahatanP11RtController::class, 'store']);
    Route::get('/p1102/show/{idP4}/{idMasterKejahatan}', [TransaksiKejahatanP11RtController::class, 'show']);
    Route::put('/p1102/{id}', [TransaksiKejahatanP11RtController::class, 'update']);
    Route::delete('/p1102/{idP4}/{idMasterKejahatan}', [TransaksiKejahatanP11RtController::class, 'destroy']);
    Route::delete('/p1102/delete/all/{idP4}', [TransaksiKejahatanP11RtController::class, 'destroyAll']);


    Route::get('/export/{idP4}/{idP3}', [ExportRtController::class, 'export']);
    Route::get('/progress/{idP4}', [RtprogressController::class, 'getProgress']);


    // Route::post('/progress/rt/{id_p4}', [RtprogressController::class, 'progressRT']);
    // Route::post('/progress/rw/{nama_rw}', [RtprogressController::class, 'progressRW']);
});

Route::prefix('wilayah')->group(function () {
        Route::get('/provinces', [WilayahApi::class, 'provinces']);
        Route::get('/kabupaten/{provinceCode}', [WilayahApi::class, 'regencies']);
        Route::get('/kecamatan/{regencyCode}', [WilayahApi::class, 'districts']);
        Route::get('/desa/{districtCode}', [WilayahApi::class, 'villages']);
    });
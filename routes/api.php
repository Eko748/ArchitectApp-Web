<?php

use App\Http\Controllers\API\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GeneratePDF;
use App\Http\Controllers\API\KonsultanController;
use App\Http\Controllers\API\KontraktorController;
use App\Http\Controllers\API\OwnerController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ProfileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'daftar']);
Route::post('/regiskonsultan', [AuthController::class, 'daftarKonsultan']);
Route::post('/regiskontraktor', [AuthController::class, 'daftarKontraktor']);
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('ownerapi')->group(function () {

        // owner
        Route::get('/owner/allproject', [OwnerController::class, 'getAllProjectKons']);
        Route::get('/owner/proposal', [OwnerController::class, 'getProposal']);
        Route::get('/owner/getdataowner', [OwnerController::class, 'getDataOwner']);
        
        // proposal
        Route::post('/owner/proposal/choose', [OwnerController::class, 'chooseProposal']);
        Route::post('/owner/project/rating', [OwnerController::class, 'rating']);
        Route::post('/owner/upload/payment', [OwnerController::class, 'uploadPayment']);
        Route::post('/owner/simpan/project', [OwnerController::class, 'favorit']);
        Route::delete('/owner/simpan/project', [OwnerController::class, 'hapusFavorit']);

        
        Route::post('/owner/choose/project', [OwnerController::class, 'chooseProject']);
        Route::get('/owner/project/{project}', [OwnerController::class, 'detailProjectKons']);
        Route::get('/owner/project', [OwnerController::class, 'getProjectByOwn']);
        Route::get('/owner/mylelang', [OwnerController::class, 'getLelangByOwn']);
        Route::get('/owner/allkonsultan', [OwnerController::class, 'getAllKons']);
        Route::post('/owner/mylelang/proposal', [OwnerController::class, 'getProposalByOwn']);
        Route::post('/owner/postlelang', [OwnerController::class, 'postLelangOwner']);
        Route::put('/owner/putlelang/{lelang}', [OwnerController::class, 'putLelangOwner']);
        Route::delete('/owner/deletelelang/{lelang}', [OwnerController::class, 'deleteLelangOwn']);
    });
    Route::middleware('konsapi')->group(function () {

        //konsultan
        Route::get('/konsultan/alllelang', [KonsultanController::class, 'getAllLelang']);
        Route::get('/konsultan/myproject', [KonsultanController::class, 'getProjectByKons']);
        Route::get('/konsultan/getdatakonsultan', [KonsultanController::class, 'getDataKonsultan']);
        Route::post('/konsultan/allmyproject', [KonsultanController::class, 'getAllProjectByKons']);
        Route::post('/konsultan/allproposal', [KonsultanController::class, 'getAllProposal']);
        Route::post('/konsultan/addproposal', [KonsultanController::class, 'postProposal']);
        Route::post('/konsultan/addlelang', [KonsultanController::class, 'postLelangKons']);
        Route::post('/konsultan/uploadHasil', [KonsultanController::class, 'uploadHasil']);
        Route::put('/konsultan/putlelang/{lelang}', [KonsultanController::class, 'putLelangKons']);
        Route::delete('/konsultan/deletelelang/{lelang}', [KonsultanController::class, 'deleteLelangKons']);
        Route::post('/konsultan/addproject', [KonsultanController::class, 'postProject']);
        Route::post('/konsultan/putproject/{project}', [KonsultanController::class, 'putProject']);
        Route::delete('/konsultan/deleteproject/{project}', [KonsultanController::class, 'deleteProject']);
        Route::post('/konsultan/upload/hasil', [KonsultanController::class, 'uploadHasil']);
        Route::post('/konsultan/upload/hasil-project', [KonsultanController::class, 'createProject']);

    });

    Route::middleware('kontraapi')->group(function () {

        // kontraktor
        Route::get('/kontraktor/alllelang', [KontraktorController::class, 'getAllLelangKons']);
        Route::post('/kontraktor/addproposal', [KontraktorController::class, 'postProposal']);
    });


    Route::middleware('adminapi')->group(function () {

        // admin
        Route::get('/admin/allpro', [AdminController::class, 'getAllPro']);
        Route::get('/admin/allkonsultan', [AdminController::class, 'getAllKonsultan']);
        Route::get('/admin/allkontraktor', [AdminController::class, 'getAllKontraktor']);
        Route::put('/admin/verificationpro/{user}', [AdminController::class, 'verifikasiPro']);
        
        //proposal 
        Route::get('/admin/allproposal', [AdminController::class, 'getAllProposal']);
        Route::post('/admin/verifikasi/proposal', [AdminController::class, 'verifikasiLelang']);
        
        Route::get('/admin/paymentKonsultan', [AdminController::class, 'getPaymentKonsultan']);
        Route::post('/admin/verifikasi/payment', [AdminController::class, 'verifPayment']);

        
    
    });




    Route::put('/update-profile/{user}', [ProfileController::class, 'updateProfile']);
    Route::put('/update-profilecons/{user}', [ProfileController::class, 'updateProfileConsultant']);
    Route::post('/gantiava/{user}', [ProfileController::class, 'gantiava']);
    Route::put('/gantipass/{user}', [ProfileController::class, 'updatePass']);
    Route::get('/allproject', [ProjectController::class, 'getAllProject']);
    Route::get('/showproject/{project}', [ProjectController::class, 'showProject']);
    Route::post('/postproject', [ProjectController::class, 'postProject']);
    Route::post('/putproject/{project}', [ProjectController::class, 'putProject']);
    Route::delete('/destroyproject/{project}', [ProjectController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/setfirebase', [AuthController::class, 'setFirebase']);
});

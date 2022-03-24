<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\PDFController;

use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\Admin\DesainController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfessionalController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProposalController as AdminProposalController;
use App\Http\Controllers\Konsultan\ProjectController;
use App\Http\Controllers\Konsultan\ProfileController as KonsultanProfile;
use App\Http\Controllers\Kontraktor\ProfileController as KontraktorProfile;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Konsultan\JobController;
use App\Http\Controllers\Konsultan\KonsultanController;
use App\Http\Controllers\Konsultan\LelangController;
use App\Http\Controllers\Konsultan\ProposalController;
use App\Http\Controllers\Kontraktor\KontraktorController;
use App\Http\Controllers\Owner\GeneratePDFController;
use App\Http\Controllers\Owner\LelangController as OwnerLelangController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\ProjectController as OwnerProjectController;
use App\Http\Controllers\Owner\ProposalController as OwnerProposalController;
use App\Models\LelangOwner;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//public 
Route::get('/', [OwnerController::class, 'index'])->name('public.landing');
Route::get('/project', [OwnerController::class, 'project'])->name('public.project');
Route::get('/all-konsultan', [OwnerController::class, 'professional'])->name('public.konsultan');
// Route::get('/detil/konsultan/{konsultan}', [OwnerController::class, 'detilProfessional'])->name('public.konsultan.detail');
Route::get('/detil/konsultan/{kons:slug}', [OwnerController::class, 'konsDetil'])->name('public.konsultan.detail');
Route::get('/detil/project/{project:slug}', [OwnerController::class, 'projectDetil'])->name('public.project.detail');




Route::middleware('auth')->group(function () {
    Route::post('/gettimelogin', [Admincontroller::class, 'getTimeLogging']);
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [Admincontroller::class, 'index'])->name('dashboard');

        // user routes
        Route::get('/owner', [Admincontroller::class, 'userPage'])->name('owner.page');
        Route::get('/owner-all', [UserController::class, 'getAllUser'])->name('users.all');
        Route::post('/user/{user}', [UserController::class, 'show'])->name('users.get');

        // user pro routes
        Route::get('/konsultan', [AdminController::class, 'proPage'])->name('konsultan.page');
        Route::get('/konsultan-all', [ProfessionalController::class, 'getAllKonsultan'])->name('konsultan.all');

        // kontraktor routes
        Route::get('/kontraktor', [Admincontroller::class, 'adminPage'])->name('kontraktor.page');
        Route::get('/kontraktor-all', [ProfessionalController::class, 'getAllKontraktor'])->name('kontraktor.all');

        // verifyPro

        Route::post('/verify/pro', [ProfessionalController::class, 'verifyPro'])->name('verify.pro');

        // proposal routes
        Route::get('/verify/proposal', [Admincontroller::class, 'verifyProp'])->name('admin.tender');
        Route::get('/tender/all', [AdminProposalController::class, 'showAllTenderWin'])->name('tender.all');
        Route::put('/tender/verify', [AdminProposalController::class, 'putVerifyProp'])->name('tender.verify');
        Route::get('/tender/{proposal}', [AdminProposalController::class, 'showTenderWin'])->name('tender.win');
        // profile routes
        Route::get('/my/{user}/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::post('/my/{user}/profile', [ProfileController::class, 'show']);
        Route::put('/my/{user}/profile', [ProfileController::class, 'update']);
        Route::put('/gantiava/{user}', [ProfileController::class, 'gantiAva'])->name('gantiava');
        Route::post('/confirmpass/{user}', [ProfileController::class, 'confirmPass']);
        Route::put('/confirmpass/{user}', [ProfileController::class, 'updatePass']);
        Route::delete('/delete/{user}', [ProfileController::class, 'destroy']);

        // payment
        Route::get('/payment/verify', [Admincontroller::class, 'verifyPayment'])->name('admin.verify');
        Route::get('/payment', [PaymentController::class, 'getAllPayment'])->name('payment.all');
        Route::post('/payment', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
    });

    Route::middleware(['konsultan'])->group(function () {

        Route::get('/konsultan/dashboard', [KonsultanController::class, 'dashboard'])->name('konsultan.dashboard');

        // project
        Route::get('/konsultan/project', [KonsultanController::class, 'project'])->name('konsultan.project');
        Route::get('/konsultan/project-all', [ProjectController::class, 'getAllProject'])->name('konsultan.allproject');
        Route::post('/konsultan/project', [ProjectController::class, 'tambahProject']);
        Route::delete('/konsultan/project-del/{project}', [ProjectController::class, 'destroy'])->name('konsultan.hapus.project');

        // lelang
        Route::get('/konsultan/lelang', [KonsultanController::class, 'lelangKons'])->name('konsultan.find');
        Route::get('/konsultan/all-lelang', [LelangController::class, 'getAllLelangOwner'])->name('konsultan.lelang');
        Route::get('/konsultan/lelang/{lelang}', [KonsultanController::class, 'detilLelang'])->name('konsultan.lelang.detil');
        Route::get('/konsultan/getlelang/{lelang}', [LelangController::class, 'showLelang'])->name('konsultan.lelang.show');

        // job
        Route::get('/konsultan/myjob/archived-job', [KonsultanController::class, 'archivedJob'])->name('konsultan.job.archived');
        Route::post('/konsultan/myjob/detil/data', [JobController::class, 'getDetilJob'])->name('konsultan.job.data');
        Route::get('/konsultan/myjob/detil/{project}', [KonsultanController::class, 'detilJob'])->name('konsultan.job.detil');
        Route::get('/konsultan/myjob/active-job', [KonsultanController::class, 'activeJob'])->name('konsultan.job.active');
        Route::get('/konsultan/myjob/active', [JobController::class, 'getAllJob'])->name('konsultan.job');
        Route::get('/konsultan/archived-job', [JobController::class, 'getArchivedJob'])->name('konsultan.archived.job');
        Route::post('/konsultan/upload/job', [JobController::class, 'uploadHasil'])->name('konsultan.upload.job');

        // proposal

        Route::get('/konsultan/myproposal/active', [KonsultanController::class, 'activeProposal'])->name('konsultan.proposal.active');
        Route::get('/konsultan/myproposal/submit', [KonsultanController::class, 'submitProposal'])->name('konsultan.proposal.submit');
        Route::get('/konsultan/myproposal/archived', [KonsultanController::class, 'archivedProposal'])->name('konsultan.proposal.archived');
        Route::get('/konsultan/myproposal/getactive', [ProposalController::class, 'getAllProposalAktif'])->name('konsultan.proposal.data.active');
        Route::get('/konsultan/myproposal/getsubmit', [ProposalController::class, 'getAllProposalSubmit'])->name('konsultan.proposal.data.submit');
        Route::get('/konsultan/myproposal/getarchived', [ProposalController::class, 'getAllProposalArchived'])->name('konsultan.proposal.data.archived');
        Route::post('/konsultan/addprop', [ProposalController::class, 'postProposal'])->name('konsultan.proposal.add');

        // profile
        Route::get('/konsultan/profile/{user}', [KonsultanProfile::class, 'edit'])->name('konsultan.profile');
        Route::post('/konsultan/profile/{user}', [KonsultanProfile::class, 'show'])->name('konsultan.profile.show');
        Route::put('/konsultan/profile/{user}', [KonsultanProfile::class, 'update'])->name('konsultan.profile.edit');
        Route::put('/konsultan/gantiava/{user}', [KonsultanProfile::class, 'gantiAva'])->name('konsultan.profile.ava');
        Route::post('/konsultan/confirmpass/{user}', [KonsultanProfile::class, 'confirmPass'])->name('konsultan.profile.confirm');
        Route::put('/konsultan/confirmpass/{user}', [KonsultanProfile::class, 'updatePass'])->name('konsultan.profile.pass');
        Route::delete('/konsultan/delete/{user}', [KonsultanProfile::class, 'destroy'])->name('konsultan.profile.del');
    });
    Route::middleware(['kontraktor'])->group(function () {
        Route::get('/kontraktor/dashboard', [KontraktorController::class, 'dashboard'])->name('kontraktor.dashboard');

        // project
        Route::get('/kontraktor/project', [KontraktorController::class, 'project'])->name('kontraktor.project');
        Route::get('/kontraktor/project-all', [ProjectController::class, 'getAllProject'])->name('kontraktor.allproject');
        Route::post('/kontraktor/project', [ProjectController::class, 'tambahProject']);
        Route::delete('/kontraktor/project-del/{project}', [ProjectController::class, 'destroy'])->name('kontraktor.hapus.project');

        // lelang
        Route::get('/kontraktor/lelang', [KontraktorController::class, 'lelangKons'])->name('kontraktor.job');
        Route::get('/kontraktor/all-lelang', [LelangController::class, 'getAllLelangOwner'])->name('kontraktor.lelang');
        Route::get('/kontraktor/lelang/{lelang}', [KontraktorController::class, 'detilLelang'])->name('kontraktor.lelang.detil');
        Route::get('/kontraktor/getlelang/{lelang}', [LelangController::class, 'showLelang'])->name('kontraktor.lelang.show');

        // job
        Route::get('/kontraktor/myjob/active-job', [KontraktorController::class, 'activeJob'])->name('kontraktor.job.active');
        Route::get('/kontraktor/myjob/archived-job', [KontraktorController::class, 'archivedJob'])->name('kontraktor.job.archived');

        // proposal

        Route::get('/kontraktor/myproposal/active', [KontraktorController::class, 'activeProposal'])->name('kontraktor.proposal.active');
        Route::get('/kontraktor/myproposal/submit', [KontraktorController::class, 'submitProposal'])->name('kontraktor.proposal.submit');
        Route::get('/kontraktor/myproposal/archived', [KontraktorController::class, 'archivedProposal'])->name('kontraktor.proposal.archived');
        Route::get('/kontraktor/myproposal/getactive', [ProposalController::class, 'getAllProposalAktif'])->name('kontraktor.proposal.data.active');
        Route::get('/kontraktor/myproposal/getsubmit', [ProposalController::class, 'getAllProposalSubmit'])->name('kontraktor.proposal.data.submit');
        Route::get('/kontraktor/myproposal/getarchived', [ProposalController::class, 'getAllProposalArchived'])->name('kontraktor.proposal.data.archived');
        Route::post('/kontraktor/addprop', [ProposalController::class, 'postProposal'])->name('kontraktor.proposal.add');

        // profile
        Route::get('/kontraktor/profile/{user}', [KontraktorProfile::class, 'edit'])->name('kontraktor.profile');
        Route::post('/kontraktor/profile/{user}', [KontraktorProfile::class, 'show'])->name('kontraktor.profile.show');
        Route::put('/kontraktor/profile/{user}', [KontraktorProfile::class, 'update'])->name('kontraktor.profile.edit');
        Route::put('/kontraktor/gantiava/{user}', [KontraktorProfile::class, 'gantiAva'])->name('kontraktor.profile.ava');
        Route::post('/kontraktor/confirmpass/{user}', [KontraktorProfile::class, 'confirmPass'])->name('kontraktor.profile.confirm');
        Route::put('/kontraktor/confirmpass/{user}', [KontraktorProfile::class, 'updatePass'])->name('kontraktor.profile.pass');
        Route::delete('/kontraktor/delete/{user}', [KontraktorProfile::class, 'destroy'])->name('kontraktor.profile.del');
    });

    Route::middleware('owner')->group(function () {

        Route::post('/owner/profile/{user}', [OwnerController::class, 'profileOwner'])->name('owner.profile.show');
        Route::post('/owner/lelang', [OwnerLelangController::class, 'postLelang'])->name('owner.lelang.post');
        Route::get('/owner/lelang/all', [OwnerLelangController::class, 'AllMyLelang'])->name('owner.lelang.all');
        Route::get('/owner/showlelang/{lelang}', [OwnerLelangController::class, 'showMyLelang'])->name('owner.lelang.show');
        Route::get('/owner/lelang', [OwnerController::class, 'lelangOwner'])->name('owner.lelang');
        Route::get('/owner/mylelang', [OwnerController::class, 'myLelang'])->name('owner.my.lelang');
        Route::get('/owner/mylelang/{lelang}', [OwnerController::class, 'showLelang'])->name('owner.my.lelang.show');
        Route::get('/owner/myproject', [OwnerController::class, 'myProject'])->name('owner.my.project');
        Route::get('/owner/myproject/{project}', [OwnerController::class, 'getDetilProject'])->name('owner.detil.myproject');
        Route::get('/owner/allproject', [OwnerProjectController::class, 'showAllMyProject'])->name('owner.all.project');
        Route::get('/owner/mylelang/proposal/{proposal}', [OwnerController::class, 'proposal'])->name('owner.proposal');
        Route::get('/owner/lelang/proposal/{proposal}', [OwnerProposalController::class, 'checkProposal'])->name('owner.get.proposal');

        Route::post('/owner/mylelang/proposal/{proposal}', [OwnerController::class, 'proposal']);
        Route::put('/owner/proposal/choose/{proposal}', [OwnerProposalController::class, 'chooseProposal']);
        Route::post('/owner/pay/project', [OwnerProjectController::class, 'payProject'])->name('owner.pay');
        Route::get('/owner/download/kontrak/{kontrak}', [OwnerController::class, 'downloadKontrak'])->name('owner.download');
        Route::put('/owner/bio/update', [OwnerController::class, 'updateBio'])->name('owner.update');
        Route::post('/owner/project/choose', [OwnerProjectController::class, 'chooseProject'])->name('owner.choose.project');
    });
});



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('generate-pdf', [PDFController::class, 'generatePDF']);

// Route::get('/', function () {
//     return view('welcome');
// });

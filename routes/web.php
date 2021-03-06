<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\PDFController;

use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\Admin\DesainController;
use App\Http\Controllers\Admin\PaymentController;
// use App\Http\Controllers\Payment\PaymentController;
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
use App\Http\Controllers\Kontraktor\CabangController;
use App\Http\Controllers\Owner\GeneratePDFController;
use App\Http\Controllers\Owner\KonstruksiController;
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

Route::get("/tahapan-konstruksi", [KonstruksiController::class, "tahapanKonstruksi"])->name('public.tahapan-konstruksi');

Route::get('kirim-email', 'App\Http\Controllers\MailController@index');

Route::get('/', [OwnerController::class, 'index'])->name('public.landing');
Route::get('/project', [OwnerController::class, 'project'])->name('public.project');
Route::get('/all-konsultan', [OwnerController::class, 'professional'])->name('public.konsultan');
Route::get('/all-kontraktor', [OwnerController::class, 'kontraktor'])->name('public.kontraktor');
// Route::get('/detil/konsultan/{konsultan}', [OwnerController::class, 'detilProfessional'])->name('public.konsultan.detail');
Route::get('/detil/konsultan/{kons:slug}', [OwnerController::class, 'konsDetil'])->name('public.konsultan.detail');
Route::get('/detil/project/{project:slug}', [OwnerController::class, 'projectDetil'])->name('public.project.detail');
Route::get('/detil/kontraktor/{kontraktor:slug}', [OwnerController::class, 'kontraktorDetil'])->name('public.kontraktor.detail');
Route::get('/detil/cabang-kontraktor/{cabang:slug}', [OwnerController::class, 'cabangDetil'])->name('public.cabang.detail');



Route::middleware('auth')->group(function () {
    Route::post('/gettimelogin', [Admincontroller::class, 'getTimeLogging']);
    Route::middleware(['admin'])->group(function () {
        // Route::get('/dashboard', [Admincontroller::class, 'index'])->name('index');
        Route::get('/dashboard', [UserController::class, 'lastLogin'])->name('dashboard');
        Route::get('online-user', [UserController::class, 'lastLogin']);

        // Route::post('/admin/profile/{user}', [ProfileController::class, 'show'])->name('admin.profile.show');
        // Route::post('/admin/confirmpass/{user}', [ProfileController::class, 'confirmPass'])->name('admin.profile.confirm');


        Route::delete('/konsultan/{id}', [AdminController::class, 'deletekonsul'])->name('user.konsultan.delete');
        Route::delete('/owner/{id}', [AdminController::class, 'deleteowner'])->name('user.owner.delete');
        Route::delete('/kontraktor/{id}', [AdminController::class, 'deletekontraktor'])->name('user.kontraktor.delete');

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
        Route::post('/my/{user}/profile', [ProfileController::class, 'show'])->name('admin.profile.show');
        Route::put('/my/{user}/profile', [ProfileController::class, 'update']);
        Route::put('/gantiava/{user}', [ProfileController::class, 'gantiAva'])->name('gantiava');
        Route::post('/confirmpass/{user}', [ProfileController::class, 'confirmPass'])->name('admin.profile.confirm');
        Route::put('/confirmpass/{user}', [ProfileController::class, 'updatePass'])->name('admin.profile.pass');
        Route::delete('/delete/{user}', [ProfileController::class, 'destroy']);

        // payment
        // Route::get('/payment/verify', [Admincontroller::class, 'verifyPayment'])->name('admin.verify');
        Route::get('/payment-konsultan/verify', [Admincontroller::class, 'verifyOrder'])->name('admin.verify');
        Route::get('/payment-konsultan/archieved', [Admincontroller::class, 'getArchievedOrder'])->name('admin.archieved-order');
        Route::get('/payment-konsultan', [PaymentController::class, 'getAllOrder'])->name('order.all');
        Route::get('/payment-konsultan-archieved', [PaymentController::class, 'getAllArchievedOrder'])->name('archieved-order.all');
        Route::post('/payment-konsultan', [PaymentController::class, 'verifyOrder'])->name('order.verify');
        Route::post('/payment-konsultan-unverify', [PaymentController::class, 'unverifyOrder'])->name('order.unverify');

        Route::get('/payment-kontraktor/verify', [Admincontroller::class, 'getVerifyTransaksi'])->name('admin.transaksi');
        Route::get('/payment-kontraktor/archieved', [Admincontroller::class, 'getArchievedTransaksi'])->name('admin.archieved-transaksi');
        Route::get('/payment-kontraktor', [PaymentController::class, 'getAllTransaksi'])->name('transaksi.all');
        Route::get('/payment-kontraktor-archieved', [PaymentController::class, 'getAllArchievedTransaksi'])->name('archieved-transaksi.all');
        Route::post('/payment-kontraktor', [PaymentController::class, 'verifyTransaksi'])->name('transaksi.verify');
        Route::post('/payment-kontraktor-unverify', [PaymentController::class, 'unverifyTransaksi'])->name('transaksi.unverify');
        // Route::get('/payment', [PaymentController::class, 'getAllPayment'])->name('payment.all');
        // Route::post('/payment', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
    });

    Route::middleware(['konsultan'])->group(function () {
        // Route::get('/konsultan/dashboard', [Konsultancontroller::class, 'index'])->name('konsultan.dashboard');
        Route::get('/konsultan/dashboard', [KonsultanController::class, 'dashboard'])->name('konsultan.dashboard');

        // project
        Route::get('/konsultan/project', [KonsultanController::class, 'project'])->name('konsultan.project');
        Route::get('/konsultan/project-all', [ProjectController::class, 'getAllProject'])->name('konsultan.allproject');
        Route::put('/konsultan/project/{id}', [ProjectController::class, 'editProject'])->name('konsultan.update.project');
        Route::get('/konsultan/projectedit/{id}', [ProjectController::class, 'edit'])->name('konsultan.editProject');
        Route::get('/konsultan/project/view/{id}', [ProjectController::class, 'view'])->name('konsultan.project.view');
        Route::post('/konsultan/project', [ProjectController::class, 'tambahProject']);
        Route::delete('/konsultan/project-del/{project}', [ProjectController::class, 'destroy'])->name('konsultan.hapus.project');

        // Lelang Konsultan
        Route::get('/konsultan/lelang-konsultan', [KonsultanController::class, 'lelangKonsultan'])->name('konsultan.lelang-konsultan');
        Route::get('/konsultan/all-lelang-konsultan', [LelangController::class, 'getAllKonsLelang'])->name('konsultan.all.Lelang.Konsultan');
        Route::post('/konsultan/lelang-konsultan', [LelangController::class, 'tambahLelang']);
        Route::delete('/konsultan/lelang-del/{id}', [LelangController::class, 'destroy'])->name('konsultan.hapus.lelang');

        // lelang
        Route::get('/konsultan/getdatakonsultan', [KonsultanController::class, 'getDataKonsultan']);
        Route::get('/konsultan/lelang/all', [LelangController::class, 'AllMyLelang'])->name('konsultan.lelang.all');
        Route::get('/konsultan/lelang', [KonsultanController::class, 'lelangKons'])->name('konsultan.find');
        Route::get('/konsultan/alllelang', [KonsultanController::class, 'getAllLelang']);
        // Route::get('/konsultan/mylelang/viewlelang/{id}', [OwnerController::class, 'view'])->name('owner.my.lelang.view');
        Route::get('/konsultan/all-lelang', [LelangController::class, 'getAllLelangOwner'])->name('konsultan.lelang');
        Route::get('/konsultan/lelang/{lelang}', [KonsultanController::class, 'detilLelang'])->name('konsultan.lelang.detil');
        Route::get('/konsultan/getlelang/{lelang}', [LelangController::class, 'showLelang'])->name('konsultan.lelang.show');

        // job
        Route::get('/konsultan/myproject', [KonsultanController::class, 'getProjectByKons']);
        Route::get('/konsultan/myjob/archived-job', [KonsultanController::class, 'archivedJob'])->name('konsultan.job.archived');
        Route::post('/konsultan/myjob/detil/data', [JobController::class, 'getDetilJob'])->name('konsultan.job.data');
        Route::get('/konsultan/myjob/detil/{project}', [KonsultanController::class, 'detilJob'])->name('konsultan.job.detil');
        Route::get('/konsultan/myjob/active-job', [KonsultanController::class, 'activeJob'])->name('konsultan.job.active');
        Route::get('/konsultan/myjob/active', [JobController::class, 'getAllJob'])->name('konsultan.job');
        Route::get('/konsultan/myjob/active-verify', [JobController::class, 'getAllJobVerify'])->name('konsultan.job-verify');
        Route::get('/konsultan/archived-job', [JobController::class, 'getArchivedJob'])->name('konsultan.archived.job');
        Route::post('/konsultan/upload/job', [JobController::class, 'uploadHasil'])->name('konsultan.upload.job');
        Route::post('/konsultan/upload/hasil-project', [JobController::class, 'createProject'])->name('konsultan.upload.hasil');

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

        // Download Kontrak
        Route::get('/konsultan/download/kontrak/{kontrak}', [JobController::class, 'downloadKontrak'])->name('konsultan.download');
    });

    Route::middleware(['kontraktor'])->group(function () {
        Route::get('/kontraktor/dashboard', [KontraktorController::class, 'dashboard'])->name('kontraktor.dashboard');
        // project
        Route::get('/kontraktor/cabang', [KontraktorController::class, 'cabang'])->name('kontraktor.cabang');
        Route::get('/kontraktor/cabang-all', [CabangController::class, 'getAllCabang'])->name('kontraktor.allcabang');
        Route::post('/kontraktor/cabang', [CabangController::class, 'tambahCabang']);
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
        // Route::get('/kontraktor/myjob/active', [JobController::class, 'getAllJob'])->name('konsultan.job');
        Route::get('/kontraktor/myjob/active', [CabangController::class, 'getAllJob'])->name('kontraktor.job.verify');
        Route::get('/kontraktor/myjob/active-job', [KontraktorController::class, 'activeJob'])->name('kontraktor.job.active');
        Route::get('/kontraktor/myjob/active-verify', [CabangController::class, 'getAllJobVerify'])->name('kontraktor.job.verify.active');
        Route::get('/kontraktor/myjob/active-archived', [CabangController::class, 'getAllJobArchived'])->name('kontraktor.job.verify.archived');
        Route::get('/kontraktor/myjob/archived-job', [KontraktorController::class, 'archivedJob'])->name('kontraktor.job.archived');

        // ACC Job
        Route::post('/kontraktor/myjob/active-verify', [CabangController::class, 'verifyProject'])->name('project.verify');
        Route::post('/kontraktor/myjob/active-unverify', [CabangController::class, 'unVerifyProject'])->name('project.un-verify');
        Route::post('/kontraktor/myjob/active-verify-acc', [CabangController::class, 'verifyProjectActive'])->name('project.verify.active');

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
        Route::get('/owner/mylelang/viewlelang/{id}', [OwnerController::class, 'view'])->name('owner.my.lelang.view');
        Route::get('/owner/mylelang/editlelang/{id}', [OwnerController::class, 'edit'])->name('owner.my.lelang.edit');
        Route::put('/owner/mylelang/updatelelang/{id}', [OwnerController::class, 'updatemylelang'])->name('owner.my.update.update');
        Route::delete('/owner/mylelang/{id}', [OwnerController::class, 'delete'])->name('owner.my.lelang.delete');
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

        // Choose Kontraktor
        Route::post('/owner/konstruksi/choose', [KonstruksiController::class, 'chooseKonstruksi'])->name('owner.choose.konstruksi');
        // Route::get('/owner/download/kontrakKontraktor/{kontrak}', [OwnerController::class, 'downloadKontrakKontraktor'])->name('owner.download');

        // My Konstruksi
        Route::get('/owner/mykonstruksi', [OwnerController::class, 'myKonstruksi'])->name('owner.my.konstruksi');
        Route::get('/owner/mykonstruksi/{konstruksi}', [OwnerController::class, 'getDetilKonstruksi'])->name('owner.detil.mykonstruksi');

        //Profile routes
        Route::get('/owner/profile/', [OwnerController::class, 'profileEdit'])->name('owner.profile');
        Route::post('/owner/{user}/profile', [OwnerController::class, 'show'])->name('profileOwner');
        // Route::get('/owner/my/{user}/profile', [OwnerController::class, 'editProfile'])
        Route::put('/owner/{user}/profile', [OwnerController::class, 'update']);
        Route::post('/owner/gantiava/{user}', [OwnerController::class, 'gantiAva'])->name('gantiavaOwner');
        Route::post('/owner/confirmpass/{user}', [OwnerController::class, 'confirmPass']);
        Route::put('/owner/confirmpass/{user}', [OwnerController::class, 'updatePass']);
        Route::delete('/owner/delete/{user}', [OwnerController::class, 'destroy'])->name('owner.profile.del');

        // Payment
        Route::get('/owner/project/myproject/payment/', [OwnerProjectController::class, 'payment'])->name('owner.payment');
        Route::post('/owner/project/myproject/payment', [OwnerProjectController::class, 'paymentPost'])->name('owner.payment.post');
        Route::get('/owner/project/viewpayment', [OwnerProjectController::class, 'viewPayment'])->name('view.payment');

        Route::get('/owner/konstruksi/mykonstruksi/payment/', [KonstruksiController::class, 'transaksi'])->name('owner.transaksi');
        Route::post('/owner/konstruksi/mykonstruksi/payment', [KonstruksiController::class, 'transaksiPost'])->name('owner.transaksi.post');
        Route::get('/owner/konstruksi/viewtransaksi', [KonstruksiController::class, 'viewTransaksi'])->name('view.transaksi');
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

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

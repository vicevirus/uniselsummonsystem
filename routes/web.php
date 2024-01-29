<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\SecurityGuard;
use App\Models\IssueSummon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AdminController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/teest', function () {


    SecurityGuard::create([
        'securityName' => 'Firdaus',
        'guard_username' => 'vicevirus',
        'guard_password' => Hash::make('#B1sm1llah#'),

    ]);
});

Route::get('/testCreateSummon', function () {
    IssueSummon::create([
        'violation' => 'Example Violation',
        'fineAmount' => 100.00, // Example fine amount
        'dueDate' => now()->addDays(30), // Example due date 30 days from now
        'issuedBy' => 'Example Issuer',
        'QRCodeId' => '2290862e-def8-47ca-8420-7243a68e445a', // Example QR code ID, should exist in your students table
        'securityId' => 1, // Example security ID, should exist in your security_guards table
    ]);

    return 'Summon created successfully!';
});



Route::post('admin/approve/{matricNumber}', [AdminController::class, 'approveStudent'])->name('admin.approveStudent');


Route::get('/dashboard', function () {
    
    $summonsRecords = IssueSummon::with('student')->whereHas('student', fn($query) => $query->where('matricNumber', Auth::id()))->get();

    
    return view('user.userDashboard', ['summonsRecords' => $summonsRecords]);
})->middleware(['auth'])->name('dashboard');

Route::get('/generate_qr/{qrCodeId}', function ($qrCodeId) {
    return QrCode::format('png')->size(500)->generate($qrCodeId);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

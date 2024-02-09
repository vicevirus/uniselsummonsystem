<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\SecurityGuard;
use App\Models\IssueSummon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\SummonController;
use Intervention\Image\ImageManager;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

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
        'guard_password' => Hash::make('sensonic'),

    ]);
});





Route::post('admin/approve/{matricNumber}', [AdminController::class, 'approveStudent'])->name('admin.approveStudent');


Route::get('/dashboard', function () {

    $summonsRecords = IssueSummon::with('student')
        ->whereHas('student', function ($query) {
            $query->where('matricNumber', Auth::id());
        })
        ->get();

    $filteredRecords = $summonsRecords->where('status', '!=', 'paid');








    return view('user.userDashboard', ['summonsRecords' => $filteredRecords]);
})->middleware(['auth'])->name('dashboard');

Route::get('/paySummon', function (Request $request) {

    $summonId = $request->input('summonId');

    $summon = IssueSummon::find($summonId);

    return view('user.userPaySummon', ['summon' => $summon]);
})->middleware(['auth'])->name('paySummon');

Route::post('/paidSummon', [SummonController::class, 'paySummon'])->name('paidSummon');

Route::get('/generate_qr/{qrCodeId}', function ($qrCodeId) {
    // Assuming QrCode::generate() can save to a file directly
    $qrFilePath = tempnam(sys_get_temp_dir(), 'qr') . '.png'; // Temporary file
    QrCode::format('png')->size(290)->generate($qrCodeId, $qrFilePath);

    $image = imagecreatefromjpeg(public_path('template.jpeg'));
    $qrCode = imagecreatefrompng($qrFilePath);



    $x = imagesx($image) - 990; // Adjust the position
    $y = 90;

    imagecopy($image, $qrCode, $x, $y, 0, 0, 290, 290);

    header('Content-Type: image/jpeg');
    imagejpeg($image);
    imagedestroy($image);
    imagedestroy($qrCode);
    unlink($qrFilePath); // Remove the temporary file
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

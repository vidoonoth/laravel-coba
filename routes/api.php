<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsulanController;
use App\Http\Controllers\pengusulanController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

route::get('/test', function (){
    return response([
        'message' => 'is working'
    ], 200);
});


Route::middleware('api')->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store']); // tanpa middleware
    // Route::post('/pengusulan', [pengusulanController::class, 'store']); // tanpa middleware
    // Route::post('/pengusulan', [pengusulanController::class, 'store'])->middleware('auth:sanctum'); // tanpa middleware
    // Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');
    Route::get('/profile', [UserController::class, 'index'])->name('profile.index')->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->match(['put', 'patch'], '/profile/{profile}', [UserController::class, 'update']);
    // Route::middleware('auth:sanctum')->post('/profile/{profile}', [UserController::class, 'update']);
    // Route::middleware('auth:sanctum')->match(['put', 'patch'], '/profile/{profile}', [UserController::class, 'update']);
    // Route::middleware('auth:sanctum')->put('/profile', [UserController::class, 'update']);
    
    Route::middleware('auth:sanctum')->get('/riwayat-usulan', [UsulanController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/pengusulan', [UsulanController::class, 'store']);
    Route::middleware('auth:sanctum')->match(['put', 'patch'], '/pengusulan/{pengusulan}', [UsulanController::class, 'update']);
    Route::middleware('auth:sanctum')->delete('/pengusulan/{pengusulan}', [UsulanController::class, 'destroy']);
    Route::middleware('auth:sanctum')->delete('/pengusulan/delete-all/{user}', [UsulanController::class, 'deleteAll']);
    Route::get('/koleksi', [BookController::class, 'koleksiBuku']);
    
    Route::middleware('auth:sanctum')->delete('/notifications/delete-all', [NotificationController::class, 'deleteAllUserNotifications']);
    Route::middleware('auth:sanctum')->get('/notifications', [NotificationController::class, 'getUserNotifications']);    
});




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');




// Route::middleware('auth:sanctum')->get('/koleksi', [BookController::class, 'koleksiBuku']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\WeeklyReviewController;
use App\Http\Controllers\DailyLogController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/goals', [GoalController::class, 'saveGoals']);
    Route::get('/weekly-review', [WeeklyReviewController::class, 'getWeeklyReview']);
    Route::post('/daily-logs/update-calories', [DailyLogController::class, 'updateCalories']);
    Route::post('/daily-logs/update-steps', [DailyLogController::class, 'updateSteps']);
    Route::post('/verify/email', [AuthController::class, 'verify']);
    Route::post('/resend/code', [AuthController::class, 'resendCode']);

});

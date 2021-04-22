<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'App\Http\Controllers\API\UserController']);
Route::apiResources(['profile' => 'App\Http\Controllers\API\ProfileController']);
Route::apiResources(['department' => 'App\Http\Controllers\API\DepartmentController']);
Route::apiResources(['position' => 'App\Http\Controllers\API\PositionController']);
Route::apiResources(['employment' => 'App\Http\Controllers\API\EmploymentController']);
Route::apiResources(['payroll' => 'App\Http\Controllers\API\PayrollController']);

Route::get('profileshow', [App\Http\Controllers\API\ProfileController::class, 'profileshow']);
Route::get('usershow', [App\Http\Controllers\API\ProfileController::class, 'usershow']);
Route::get('myEmployment', [App\Http\Controllers\API\EmploymentController::class, 'myEmployment']);
Route::get('myPayrolls', [App\Http\Controllers\API\PayrollController::class, 'myPayrolls']);
Route::get('getPayroll', [App\Http\Controllers\API\PayrollController::class, 'getPayroll']);
//Route::put('updateProfileInfo', [App\Http\Controllers\API\ProfileController::class, 'update']);
Route::put('updatePhoto', [App\Http\Controllers\API\ProfileController::class, 'updatePhoto']);

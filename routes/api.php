<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::pattern('user_id', '0x[0-9a-zA-Z]{40}');





Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('companies/{id}/programs_status', [StatController::class, 'getProgramsStatus']);//status_prog_count
Route::get('companies/{id}/programs_stats', [StatController::class, 'getProgramsStats']);//prog stats
Route::get('companies/{id}/bounty_stats', [StatController::class, 'CompanyBounty']); //bounty evolution
Route::get('companies/{id}/reports_stats', [StatController::class, 'getCompanyReportsStats']);//reports status_count and severity_count
Route::get('companies/{id}/programs', [ProgramController::class, 'getCompanyPrograms']);
Route::post('companies/{id}/programs/search', [ProgramController::class, 'searchProgram']);

Route::get('me', [ManagerController::class, 'show']);
Route::get('companies/{id}', [CompanyController::class, 'show']);
Route::post('companies/{id}', [CompanyController::class, 'update']);
Route::post('companies/{id}/code', [CompanyController::class, 'generate']);
Route::get('companies/{id}/managers', [CompanyController::class, 'getManagers']);
Route::get('companies/{id}/reports', [ReportController::class, 'getCompanyReports']);
Route::get('programs/{id}/reports', [ReportController::class, 'getProgramReports']);
Route::post('companies/{id}/managers', [CompanyController::class, 'addManager']);
Route::post('managers/{user_id}', [ManagerController::class, 'changeRole']);
Route::get('programs/{id}', [ProgramController::class, 'show']);
Route::get('programs/{id}/users', [ProgramController::class, 'getUsers']);
Route::get('programs/{id}/reports', [ReportController::class, 'getProgramReports']);
Route::post('programs', [ProgramController::class, 'store']);
Route::post('programs/{id}', [ProgramController::class, 'update']);
Route::post('reports/{id}', [ReportController::class, 'update']);

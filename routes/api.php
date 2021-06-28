<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportMessageController;
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

Route::pattern('user_id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

//API For Users
Route::post('login', [ManagerController::class, 'login']);
Route::post('edit', [ManagerController::class, 'edit']);
Route::post('register', [ManagerController::class, 'register']);
Route::group(['middleware' => ['is.auth']], function() {
    Route::get('me', [ManagerController::class, 'me']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('programs_status', [StatController::class, 'getProgramsStatus']);//status_prog_count
Route::get('programs_stats', [StatController::class, 'getProgramsStats']);//prog stats
Route::get('bounty_stats', [StatController::class, 'CompanyBounty']); //bounty evolution
Route::get('reports_stats', [StatController::class, 'getCompanyReportsStats']);//reports status_count and severity_count
Route::get('programs', [ProgramController::class, 'getCompanyPrograms']);
Route::post('programs/search', [ProgramController::class, 'searchProgram']);

Route::get('company', [CompanyController::class, 'show']);
Route::post('company', [CompanyController::class, 'update']);
Route::post('code', [CompanyController::class, 'generate']);
Route::get('managers', [CompanyController::class, 'getManagers']);
Route::post('reports', [ReportController::class, 'getCompanyReports']);
Route::post('programs/{id}/reports', [ReportController::class, 'getProgramReports']);
Route::post('invite_manager', [ManagerController::class, 'inviteManager']);
Route::post('managers', [CompanyController::class, 'addManager']);
Route::post('managers/{user_id}', [ManagerController::class, 'changeRole']);
Route::get('programs/{id}', [ProgramController::class, 'show']);
Route::get('programs/{id}/users', [ProgramController::class, 'getUsers']);
Route::post('programs', [ProgramController::class, 'store']);
Route::post('programs/{id}', [ProgramController::class, 'update']);
Route::post('reports/{id}', [ReportController::class, 'update']);
Route::get('me/messages', [ReportMessageController::class, 'getMessages']);
Route::post('reports/{id}/messages', [ReportMessageController::class, 'store']);
Route::get('reports/{id}/messages', [ReportMessageController::class, 'getReportMessages']);
Route::post('reports/{id}/assign', [ReportController::class, 'assigne']);
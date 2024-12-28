<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppSliderController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentControlle;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\GiftShopProductController;
use App\Http\Controllers\Admin\BasicSettingsController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\DropzoneController;
use App\Http\Controllers\Admin\TicketCategoryController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\UserProjectController;
use App\Http\Controllers\UserManagement\UserController;
use Illuminate\Support\Facades\Route;

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

// --------------->authentication routes<-----------------
Route::middleware('guest')->group(function (){

    Route::get('/',function(){
        return redirect()->route("admin.login");
    })->name('home');

    Route::get('admin/login',[LoginController::class,"login"])->name('admin.login');
    Route::post('admin/login',[LoginController::class,"loginProccess"])->name('admin.loginProccess');
});
// -------------------------------------------------------


Route::middleware(['auth:admin'])->prefix("admin")->name("admin.")->group(function () {
    Route::get("/file/{fileDir}/{fileName}",[FileController::class,"getFile"])->name("getFile"); //for download file
    Route::get("/logout",[LoginController::class,'logout'])->name("logout");
    Route::get('/',[DashboardController::class,"index"])->name('dashboard');
    Route::get('/dashboard',[DashboardController::class,"index"])->name('dashboard');

    Route::post('/media/store', [MediaController::class, 'storeMedia'])->name('media.store');

    Route::get('/filter/users/{table_field_value}',[UserController::class,'externalFilter'])->name("users_external_filter")->withoutMiddleware("CheckPermission");

    Route::get('/filter/projects/{table_field_value}',[UserProjectController::class,'externalFilter'])->name("userproject_external_filter")->withoutMiddleware("CheckPermission");

    Route::prefix("admin_management")->name("admins_management.")->group(function(){
        // admins routes
        Route::resource("admins",AdminController::class);
        Route::post("admins/bulk_delete",[AdminController::class,"bulkDelete"])->name("admins.bulk_delete");

        // -----------------------
        // roles routes
        Route::resource("roles",RoleController::class);
        Route::post("roles/bulk_delete",[AdminController::class,"bulkDelete"])->name("roles.bulk_delete");
        Route::get("roles/{role_id}/permissions",[RoleController::class,"permissions"])->name("role.permissions");
        Route::post("roles/{role_id}/permissions",[RoleController::class,"updatePermissions"])->name("role.permissions.update");
        // -----------------------
        // premissions routes
        Route::resource("permissions",PermissionController::class);
        Route::post("permissions/bulk_delete",[AdminController::class,"bulkDelete"])->name("permissions.bulk_delete");
    });
    Route::prefix("tickets_management")->name("tickets_management.")->group(function(){
        // ticket category routes
        Route::resource("tickets_categories",TicketCategoryController::class);
        Route::post("tickets_categories/bulk_delete",[TicketCategoryController::class,"bulkDelete"])->name("tickets_categories.bulk_delete");
        // tickets routes
        Route::resource("tickets",TicketController::class);
        Route::post("tickets/bulk_delete",[TicketController::class,"bulkDelete"])->name("tickets.bulk_delete");
        Route::post("tickets/{ticket_id}/reply",[TicketController::class,"reply"])->name("tickets.reply");
        Route::get("tickets/attachment/{attachment}/download",[TicketController::class,"attachmentDownload"])->name("tickets.attachment.download");
        Route::post("tickets/{ticket_id}/change_status",[TicketController::class,"changeStatus"])->name("tickets.change_status");

    });

    Route::prefix("basic_data_management")->name("basic_data_management.")->group(function(){
        // departments routes
        Route::resource("department",DepartmentControlle::class);
        Route::post("department/bulk_delete",[DepartmentControlle::class,"bulkDelete"])->name("department.bulk_delete");
        // -----------------------
    });

    Route::prefix("settings")->name("settings.")->group(function(){
        Route::get("main_settings",[BasicSettingsController::class,"mainSettings"])->name("main_settings.index");
        Route::post("main_settings",[BasicSettingsController::class,"updateMainSettings"])->name("main_settings.update");
        Route::resource("basic_settings",BasicSettingsController::class);
        // -----------------------
    });

    Route::prefix("app-settings")->name("app-settings.")->group(function(){
        Route::resource("sliders", AppSliderController::class);
        // -----------------------
    });

    Route::get('/file/download/{token}', [DownloadController::class, 'download'])->name('file.download');



    Route::post("/filter/getcities",[LocationController::class,"getCities"])->name("get_cities");

    Route::post("dropzone/upload/files",[DropzoneController::class,'storeImages'])->name("dropzone.upload.files");
});

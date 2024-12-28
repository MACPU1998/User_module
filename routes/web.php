<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Api\V1\AppVersionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Libraries\SMSIR;
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
//require __DIR__.'/admin.php';

require __DIR__.'/user.php';

require __DIR__.'/../app/Services/DataTableBuilder/Routes/data_table_routes.php';

Route::get('/', function () {
     return redirect("/workspace");
});

 Route::get('/workspace', function () {
     return view('workspace');
 })->middleware(['auth'])->name('workspace');

require __DIR__.'/auth.php';



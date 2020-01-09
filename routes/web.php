<?php

use App\Http\Controllers\AdminMustahiqController;
use App\Http\Controllers\CollectorDonationReportPrintController;
use App\Http\Controllers\CollectorMustahiqDataPrintController;
use App\Http\Controllers\CollectorMustahiqDonationController;
use App\Http\Controllers\CollectorMuzakkiDataPrintController;
use App\Http\Controllers\CollectorMuzakkiReceivementController;
use App\Http\Controllers\CollectorReceivementReportPrintController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MustahiqDataPrintController;
use App\Http\Controllers\MuzakkiDataPrintController;
use App\Http\Controllers\UnverifiedCollectorController;
use App\Http\Controllers\UnverifiedCollectorVerificationController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [HomeController::class, 'show'])->name('home.show');
Route::get('/map', [MapController::class, 'show'])->name('map.show');

Route::group(['prefix' => '/collector', 'as' => 'collector.'], function() {
    Route::middleware('can:act-as-administrator')->group(function() {
        Route::get('/index', 'CollectorController@index')->name('index');
        Route::get('/show/{collector}', 'CollectorController@show')->name('show');
        Route::get('/create', 'CollectorController@create')->name('create');
        Route::post('/store', 'CollectorController@store')->name('store');
        Route::get('/edit/{collector}', 'CollectorController@edit')->name('edit');
        Route::post('/update/{collector}', 'CollectorController@update')->name('update');
        Route::post('/delete/{collector}', 'CollectorController@delete')->name('delete');
    });

    Route::middleware('can:act-as-collector')->group(function() {
        Route::get('/{collector}/report/index', 'CollectorReportController@index')->name('report.index');
        Route::get('/{collector}/report/create', 'CollectorReportController@create')->name('report.create');
        Route::post('/{collector}/report/store', 'CollectorReportController@store')->name('report.store');
        Route::get('/report/edit/{report}', 'CollectorReportController@edit')->name('report.edit');
        Route::post('/report/update/{report}', 'CollectorReportController@update')->name('report.update');
        Route::post('/report/{report}/delete', 'CollectorReportController@delete')->name('report.delete');
    });
});

Route::group(['prefix' => '/receivement', 'as' => 'receivement.'], function() {
    Route::get('/index', 'ReceivementController@index')->name('index');
    Route::get('/index/print', 'ReceivementController@printIndex')->name('printIndex');
    Route::get('/detail/{collector}', 'ReceivementController@detail')->name('detail');
});

Route::group(['prefix' => '/unverified-collector', 'as' => 'unverified-collector.'], function() {
    Route::get('/index', [UnverifiedCollectorController::class, 'index'])->name('index');
});

Route::group(['prefix' => '/unverified-collector-verification', 'as' => 'unverified-collector-verification.'], function() {
    Route::post('/update/{any_collector}', [UnverifiedCollectorVerificationController::class, 'update'])->name('update');
});


Route::group(['prefix' => '/donation', 'as' => 'donation.'], function() {
    Route::get('/index', 'DonationController@index')->name('index');
    Route::get('/index/print', 'DonationController@printIndex')->name('printIndex');
    Route::get('/detail/{collector}', 'DonationController@detail')->name('detail');
});

Route::group(['prefix' => '/report', 'as' => 'report.'], function() {
    Route::get('/index', 'ReportController@index')->middleware('can:act-as-administrator')->name('index');
});

Route::group(['prefix' => '/donation', 'as' => 'donation.'], function() {
    Route::get('/api/count/{collector}', 'DonationController@count')->name('api.count');
});

Route::get('/collector/thumbnail/{collector}', 'CollectorController@thumbnail')->name('collector.thumbnail');

Route::group(['prefix' => '/error', 'as' => 'error.'], function() {
    Route::view('/403', 'error.403')->name('403');
});

Route::group(['middleware' => ['collector-verified']], function () {
    Route::group(['prefix' => '/mustahiq', 'as' => 'collector.mustahiq.'], function() {
        Route::get('/index/{collector}', 'MustahiqController@index')->name('index');
        Route::get('/create/{collector}', 'MustahiqController@create')->name('create');
        Route::post('/store/{collector}', 'MustahiqController@store')->name('store');
        Route::get('/edit/{collector}/{mustahiq}', 'MustahiqController@edit')->name('edit');
        Route::post('/update/{mustahiq}', 'MustahiqController@update')->name('update');
        Route::post('/delete/{mustahiq}', 'MustahiqController@delete')->name('delete');
    });

    Route::group(['prefix' => '/muzakki', 'as' => 'collector.muzakki.'], function() {
        Route::get('/index/{collector}', 'MuzakkiController@index')->name('index');
        Route::get('/create/{collector}', 'MuzakkiController@create')->name('create');
        Route::post('/store/{collector}', 'MuzakkiController@store')->name('store');
        Route::get('/edit/{collector}/{muzakki}', 'MuzakkiController@edit')->name('edit');
        Route::post('/update/{muzakki}', 'MuzakkiController@update')->name('update');
        Route::post('/delete/{muzakki}', 'MuzakkiController@delete')->name('delete');
    });

    Route::group(['prefix' => '/report', 'as' => 'report.'], function() {
        Route::get('/index', 'ReportController@index')->name('index');
        Route::get('/create', 'ReportController@create')->name('create');
        Route::post('/store', 'ReportController@store')->name('store');
        Route::get('/edit/{report}', 'ReportController@edit')->name('edit');
        Route::post('/update/{report}', 'ReportController@update')->name('update');
        Route::post('/delete/{report}', 'ReportController@delete')->name('delete');
    });

    Route::group(['prefix' => '/collector-receivement', 'as' => 'collector.receivement.'], function() {
        Route::get('/index/{collector}', 'CollectorReceivementController@index')->name('index');
        Route::get('/create/{collector}', 'CollectorReceivementController@create')->name('create');
        Route::post('/store/{collector}', 'CollectorReceivementController@store')->name('store');
        Route::get('/edit/{receivement}', 'CollectorReceivementController@edit')->name('edit');
        Route::post('/update/{receivement}', 'CollectorReceivementController@update')->name('update');
        Route::post('/delete/{receivement}', 'CollectorReceivementController@delete')->name('delete');
    });

    Route::group(['prefix' => '/collector-donation', 'as' => 'collector.donation.'], function() {
        Route::get('/index/{collector}', 'CollectorDonationController@index')->name('index');
        Route::get('/create/{collector}', 'CollectorDonationController@create')->name('create');
        Route::post('/store/{collector}', 'CollectorDonationController@store')->name('store');
        Route::get('/edit/{donation}', 'CollectorDonationController@edit')->name('edit');
        Route::post('/update/{donation}', 'CollectorDonationController@update')->name('update');
        Route::post('/delete/{donation}', 'CollectorDonationController@delete')->name('delete');
    });
});

Route::group(['prefix' => '/admin-report', 'as' => 'admin-report.'], function() {
    Route::get('/index', 'AdminReportController@index')->name('index');
    Route::get('/print-index', 'AdminReportController@printIndex')->name('print-index');
    Route::get('/detail/{collector}', 'AdminReportController@detail')->name('detail');
});

Route::group(['prefix' => '/information', 'as' => 'information.'], function() {
    Route::get('/show/{information}', [InformationController::class, 'show'])->name('show');
    Route::get('/edit/{information}', [InformationController::class, 'edit'])->name('edit');
    Route::post('/update/{information}', [InformationController::class, 'update'])->name('update');
});


Route::group(['prefix' => '/collector-muzakki-receivement', 'as' => 'collector-muzakki-receivement.'], function() {
    Route::get('/index/{muzakki}', [CollectorMuzakkiReceivementController::class, 'index'])->name('index');
});

Route::group(['prefix' => '/collector-mustahiq-donation', 'as' => 'collector-mustahiq-donation.'], function() {
    Route::get('/index/{mustahiq}', [CollectorMustahiqDonationController::class, 'index'])->name('index');
});

Route::group(['prefix' => '/collector-receivement-report-print', 'as' => 'collector-receivement-report-print.'], function() {
    Route::get('/show/{collector}', [CollectorReceivementReportPrintController::class, 'show'])->name('show');
});

Route::group(['prefix' => '/collector-donation-report-print', 'as' => 'collector-donation-report-print.'], function() {
    Route::get('/show/{collector}', [CollectorDonationReportPrintController::class, 'show'])->name('show');
});

Route::group(['prefix' => '/mustahiq-data-print', 'as' => 'mustahiq-data-print.'], function() {
    Route::get('/show', [MustahiqDataPrintController::class, 'show'])->name('show');
});

Route::group(['prefix' => '/muzakki-data-print', 'as' => 'muzakki-data-print.'], function() {
    Route::get('/show', [MuzakkiDataPrintController::class, 'show'])->name('show');
});

Route::group(['prefix' => '/collector/{collector}/muzakki/data-print', 'as' => 'collector-muzakki-data-print.'], function() {
    Route::get('/show', [CollectorMuzakkiDataPrintController::class, 'show'])->name('show');
});

Route::group(['prefix' => '/collector/{collector}/mustahiq/data-print', 'as' => 'collector-mustahiq-data-print.'], function() {
    Route::get('/show', [CollectorMustahiqDataPrintController::class, 'show'])->name('show');
});

Route::group(['prefix' => '/admin/mustahiq', 'as' => 'admin.mustahiq.'], function() {
    Route::get('/index/{collector}', [AdminMustahiqController::class, 'index'])->name('index');
    Route::get('/create/{collector}', [AdminMustahiqController::class, 'create'])->name('create');
    Route::post('/store/{collector}', [AdminMustahiqController::class, 'store'])->name('store');
    Route::get('/edit/{mustahiq}', [AdminMustahiqController::class, 'edit'])->name('edit');
    Route::post('/update/{mustahiq}', [AdminMustahiqController::class, 'update'])->name('update');
    Route::post('/delete/{mustahiq}', [AdminMustahiqController::class, 'delete'])->name('delete');
});

<?php
use App\Http\Controllers\InformationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;

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

Route::middleware('auth')->group(function() {
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

    Route::group(['prefix' => '/donation', 'as' => 'donation.'], function() {
        Route::get('/index', 'DonationController@index')->name('index');
        Route::get('/index/print', 'DonationController@printIndex')->name('printIndex');
        Route::get('/detail/{collector}', 'DonationController@detail')->name('detail');
    });

    Route::group(['prefix' => '/collector-receivement', 'as' => 'collector.receivement.'], function() {
        Route::get('/index', 'CollectorReceivementController@index')->name('index');
        Route::get('/create', 'CollectorReceivementController@create')->name('create');
        Route::post('/store', 'CollectorReceivementController@store')->name('store');
        Route::get('/edit/{receivement}', 'CollectorReceivementController@edit')->name('edit');
        Route::post('/update/{receivement}', 'CollectorReceivementController@update')->name('update');
        Route::post('/delete/{receivement}', 'CollectorReceivementController@delete')->name('delete');
    });

    Route::group(['prefix' => '/collector-donation', 'as' => 'collector.donation.'], function() {
        Route::get('/index', 'CollectorDonationController@index')->name('index');
        Route::get('/create', 'CollectorDonationController@create')->name('create');
        Route::post('/store', 'CollectorDonationController@store')->name('store');
        Route::get('/edit/{donation}', 'CollectorDonationController@edit')->name('edit');
        Route::post('/update/{donation}', 'CollectorDonationController@update')->name('update');
        Route::post('/delete/{donation}', 'CollectorDonationController@delete')->name('delete');
    });

    Route::group(['prefix' => '/report', 'as' => 'report.'], function() {
        Route::get('/index', 'ReportController@index')->middleware('can:act-as-administrator')->name('index');
    });
});

Route::group(['prefix' => '/donation', 'as' => 'donation.'], function() {
    Route::get('/api/count/{collector}', 'DonationController@count')->name('api.count');
});

Route::get('/collector/thumbnail/{collector}', 'CollectorController@thumbnail')->name('collector.thumbnail');

Route::group(['prefix' => '/error', 'as' => 'error.'], function() {
    Route::view('/403', 'error.403')->name('403');
});

Route::group(['prefix' => '/mustahiq', 'as' => 'collector.mustahiq.'], function() {
    Route::get('/index', 'MustahiqController@index')->name('index');
    Route::get('/create', 'MustahiqController@create')->name('create');
    Route::post('/store', 'MustahiqController@store')->name('store');
    Route::get('/edit/{mustahiq}', 'MustahiqController@edit')->name('edit');
    Route::post('/update/{mustahiq}', 'MustahiqController@update')->name('update');
    Route::post('/delete/{mustahiq}', 'MustahiqController@delete')->name('delete');
});

Route::group(['prefix' => '/muzakki', 'as' => 'collector.muzakki.'], function() {
    Route::get('/index', 'MuzakkiController@index')->name('index');
    Route::get('/create', 'MuzakkiController@create')->name('create');
    Route::post('/store', 'MuzakkiController@store')->name('store');
    Route::get('/edit/{muzakki}', 'MuzakkiController@edit')->name('edit');
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

Route::group(['prefix' => '/item', 'as' => 'item.'], function() {
    Route::get('/index', [ItemController::class, 'index'])->name('index');
    Route::get('/create', [ItemController::class, 'create'])->name('create');
    Route::post('/store', [ItemController::class, 'store'])->name('store');
    Route::get('/edit/{item}', [ItemController::class, 'edit'])->name('edit');
    Route::post('/update/{item}', [ItemController::class, 'update'])->name('update');
    Route::post('/delete/{item}', [ItemController::class, 'delete'])->name('delete');
});

<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::view('/admin/dashboard', 'dashboard');

Route::get('/guest/map', 'GuestController@map')->name('guest.map');
Route::redirect('/', '/guest/map');

Route::middleware('auth')->group(function() {
    Route::group(['prefix' => '/collector', 'as' => 'collector.'], function() {
        Route::middleware('can:act-as-administrator')->group(function() {
            Route::get('/index', 'CollectorController@index')->name('index');
            Route::get('/create', 'CollectorController@create')->name('create');
            Route::post('/store', 'CollectorController@store')->name('store');
            Route::get('/edit/{collector}', 'CollectorController@edit')->name('edit');
            Route::post('/update/{collector}', 'CollectorController@update')->name('update');
            Route::post('/delete/{collector_id}', 'CollectorController@delete')->name('delete');

            Route::get('/image/thumbnail/{collector}', 'CollectorController@thumbnail')->name('thumbnail');

        });

        Route::middleware('can:act-as-collector')->group(function() {
            Route::get('/{collector}/report/index', 'CollectorReportController@index')->name('report.index');
            Route::get('/{collector}/report/create', 'CollectorReportController@create')->name('report.create');
            Route::post('/{collector}/report/store', 'CollectorReportController@store')->name('report.store');
            Route::post('/report/{report}/delete', 'CollectorReportController@delete')->name('report.delete');
        });
    });

    Route::group(['prefix' => '/report', 'as' => 'report.'], function() {
        Route::get('/index', 'ReportController@index')->middleware('can:act-as-administrator')->name('index');
    });
});

Route::group(['prefix' => '/error', 'as' => 'error.'], function() {
    Route::view('/403', 'error.403')->name('403');
});
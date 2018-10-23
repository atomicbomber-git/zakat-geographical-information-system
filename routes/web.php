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

Route::redirect('/', '/collector/index');

Route::view('/admin/dashboard', 'dashboard');

Route::group(['prefix' => '/collector', 'as' => 'collector.', 'middleware' => ['auth']], function() {
    Route::middleware('can:act-as-administrator')->group(function() {
        Route::get('/index', 'CollectorController@index')->name('index');
        Route::post('/store', 'CollectorController@store')->name('store');
        Route::post('/delete/{collector_id}', 'CollectorController@delete')->name('delete');
    });

    Route::middleware('can:act-as-collector')->group(function() {
        Route::get('/{collector}/report/index', 'CollectorReportController@index')->name('report.index');
        Route::get('/{collector}/report/create', 'CollectorReportController@index')->name('report.create');
    });
});

Route::group(['prefix' => '/report', 'as' => 'report.'], function() {
    Route::get('/index', 'ReportController@index')->name('index');
});

Route::group(['prefix' => '/error', 'as' => 'error.'], function() {
    Route::view('/403', 'error.403')->name('403');
});
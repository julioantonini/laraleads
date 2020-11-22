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


Auth::routes([
  'register' => false,
  'reset' => false,
  'verify' => false,
  'confirm' => false,
]);


Route::post('/lead-insert', 'RouletteController@store')->name('lead.insert');

Route::get('/check/{user_id}/{lead_id}', 'LeadController@show')->name('lead.check');

Route::get('/cron', 'CronController@index');

Route::group(['middleware' => 'auth'], function()
{
  Route::get('logout', 'Auth\LoginController@logout')->name('logout');
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
  Route::get('/', 'FunnelController@index')->name('home');

  Route::get('/team', 'TeamController@index')->name('team');
  Route::get('/team/add', 'TeamController@create')->name('team.create');
  Route::post('/team', 'TeamController@store')->name('team.store');
  Route::get('/team/{id}', 'TeamController@edit')->name('team.edit');
  Route::post('/team/{id}', 'TeamController@update')->name('team.update');
  Route::get('/team/destroy/{id}', 'TeamController@destroy')->name('team.destroy');

  Route::get('/user', 'UserController@index')->name('user');
  Route::get('/user/add', 'UserController@create')->name('user.create');
  Route::post('/user', 'UserController@store')->name('user.store');
  Route::get('/user/{id}', 'UserController@edit')->name('user.edit');
  Route::post('/user/{id}', 'UserController@update')->name('user.update');
  Route::get('/user/destroy/{id}', 'UserController@destroy')->name('user.destroy');
  Route::post('/user/destroy/move', 'UserController@moveAndDestroy')->name('user.movedestroy');

  Route::get('/lead', 'LeadController@index')->name('lead');
  Route::get('/lead/add', 'LeadController@create')->name('lead.create');
  Route::post('/lead', 'LeadController@store')->name('lead.store');
  Route::get('/lead/{id}', 'LeadController@edit')->name('lead.edit');
  Route::post('/lead/{id}', 'LeadController@update')->name('lead.update');
  Route::get('/lead/destroy/{id}', 'LeadController@destroy')->name('lead.destroy');

  Route::get('/export', 'ExportController@index')->name('export');
  Route::post('/export', 'ExportController@store')->name('export.store');

  Route::get('/funnel', 'FunnelController@index')->name('funnel');
  Route::post('/funnel/update', 'FunnelController@update')->name('funnel.update');

  Route::get('/lead-info/{id}', 'LeadInfoController@show')->name('lead.info');
  Route::post('/lead-info', 'LeadInfoController@store')->name('lead.info.create');
});






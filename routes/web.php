<?php

use Illuminate\Support\Facades\Route;



Route::get('/', 'Site\HomeController@index')->name('site.home');

Route::prefix('/admin')->group(function(){
    Route::get('/', 'Admin\HomeController@index')->name('admin.home');
    Route::get('login', 'Admin\Auth\LoginController@index')->name('login');
    Route::post('login', 'Admin\Auth\LoginController@authenticate');
    Route::post('sair', 'Admin\Auth\LoginController@logout')->name('admin.sair');

    Route::get('registrar', 'Admin\Auth\RegisterController@index')->name('admin.registrar');
    Route::post('registrar', 'Admin\Auth\RegisterController@register');

    Route::resource('users', 'Admin\UserController');
    Route::get('excluir/{id}', 'Admin\UserController@delete')->name('excluir');

    Route::get('profile', 'Admin\ProfileController@index')->name('admin.profile');
    Route::put('profileupdate', 'Admin\ProfileController@update')->name('profile.update');

    Route::get('settings', 'Admin\SettingController@index')->name('admin.settings');
    Route::put('settings', 'Admin\SettingController@save')->name('admin.savesettings');

    Route::get('pages', 'Admin\PageController@index')->name('admin.pages');
    Route::get('page/criar', 'Admin\PageController@create')->name('admin.page.criar');
    Route::post('page/criar/save', 'Admin\PageController@save')->name('admin.page.save');
    Route::get('page/editar/{id}', 'Admin\PageController@edit')->name('admin.page.editar');
    Route::put('page/editar/atualizar/{id}', 'Admin\PageController@update')->name('admin.page.atualizar');
    Route::get('page/excluir/{id}', 'Admin\PageController@delete')->name('admin.page.excluir');


});

Route::fallback('Site\PageController@index');

// Auth::routes();


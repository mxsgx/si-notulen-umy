<?php

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

Route::get('/', 'HomeController')->name('beranda');

Auth::routes([
    'verify' => false,
    'reset' => false,
    'confirm' => false,
    'register' => false,
]);

Route::middleware('auth')->group(function () {
    Route::prefix('notulen')->group(function () {
        Route::get('/', 'MinuteController@index')->name('minute.index');
        Route::get('/tambah', 'MinuteController@create')->name('minute.create');
        Route::post('/', 'MinuteController@store')->name('minute.store');
        Route::get('/{minute}', 'MinuteController@edit')->name('minute.edit');
        Route::patch('/{minute}', 'MinuteController@update')->name('minute.update');
        Route::delete('/{minute}', 'MinuteController@delete')->name('minute.delete');
        Route::get('/{minute}/pdf', 'MinuteController@pdf')->name('minute.pdf');
        Route::get('/{minute}/lampiran/{document:file_name}', 'MinuteController@document')->name('minute.attachment');
    });

    Route::prefix('pengguna')->group(function () {
        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('/buat', 'UserController@create')->name('user.create');
        Route::post('/', 'UserController@store')->name('user.store');
        Route::get('/{user}', 'UserController@edit')->name('user.edit');
        Route::patch('/{user}', 'UserController@update')->name('user.update');
        Route::delete('/{user}', 'UserController@delete')->name('user.delete');
    });

    Route::prefix('fakultas')->group(function () {
        Route::get('/', 'FacultyController@index')->name('faculty.index');
        Route::get('/tambah', 'FacultyController@create')->name('faculty.create');
        Route::post('/', 'FacultyController@store')->name('faculty.store');
        Route::get('/{faculty}', 'FacultyController@edit')->name('faculty.edit');
        Route::patch('/{faculty}', 'FacultyController@update')->name('faculty.update');
        Route::delete('/{faculty}', 'FacultyController@delete')->name('faculty.delete');
    });

    Route::prefix('prodi')->group(function () {
        Route::get('/', 'StudyController@index')->name('study.index');
        Route::get('/tambah', 'StudyController@create')->name('study.create');
        Route::post('/', 'StudyController@store')->name('study.store');
        Route::get('/{study}', 'StudyController@edit')->name('study.edit');
        Route::patch('/{study}', 'StudyController@update')->name('study.update');
        Route::delete('/{study}', 'StudyController@delete')->name('study.delete');
    });

    Route::prefix('dosen')->group(function () {
        Route::get('/', 'LecturerController@index')->name('lecturer.index');
        Route::get('/tambah', 'LecturerController@create')->name('lecturer.create');
        Route::post('/', 'LecturerController@store')->name('lecturer.store');
        Route::get('/{lecturer}', 'LecturerController@edit')->name('lecturer.edit');
        Route::patch('/{lecturer}', 'LecturerController@update')->name('lecturer.update');
        Route::delete('/{lecturer}', 'LecturerController@delete')->name('lecturer.delete');
    });

    Route::prefix('jenis-rapat')->group(function () {
        Route::get('/', 'MeetingController@index')->name('meeting.index');
        Route::get('/tambah', 'MeetingController@create')->name('meeting.create');
        Route::post('/', 'MeetingController@store')->name('meeting.store');
        Route::get('/{meeting}', 'MeetingController@edit')->name('meeting.edit');
        Route::patch('/{meeting}', 'MeetingController@update')->name('meeting.update');
        Route::delete('/{meeting}', 'MeetingController@delete')->name('meeting.delete');
    });

    Route::prefix('ruangan')->group(function () {
        Route::get('/', 'RoomController@index')->name('room.index');
        Route::get('/tambah', 'RoomController@create')->name('room.create');
        Route::post('/', 'RoomController@store')->name('room.store');
        Route::get('/{room}', 'RoomController@edit')->name('room.edit');
        Route::patch('/{room}', 'RoomController@update')->name('room.update');
        Route::delete('/{room}', 'RoomController@delete')->name('room.delete');
    });
});

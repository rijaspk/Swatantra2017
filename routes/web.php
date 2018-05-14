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


Route::resource('/', 'RegistrationController');

Route::get('/payment_status', function () {
    return redirect('/');
});

Route::match(['get', 'post'],'/payment_status', 'RegistrationController@payment_status');

Route::match(['get', 'post'],'/registrations', 'RegistrationController@view_registrations');

Route::match(['get', 'post'],'/update_tickets','RegistrationController@update_tickets');

Route::put('/update_tickets','RegistrationController@update_category');

Route::match(['get', 'post'],'/students','RegistrationController@students_for_later');

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
    return view('website.pages.index_page');
})->name('website.home');

Route::get('/about', function () {
    return view('website.pages.about_page');
})->name('admin.about');

Route::get('/doctor', function () {
    return view('website.pages.doctor_page');
})->name('admin');

Route::get('/department', function () {
    return view('website.pages.department_page');
})->name('admin.department');

Route::get('/pricing', function () {
    return view('website.pages.pricing_page');
})->name('admin.pricing');

Route::get('/blog', function () {
    return view('website.pages.blog_page');
})->name('admin.blog');

Route::get('/contact', function () {
    return view('website.pages.contact');
})->name('admin.contact');

Route::get('/login', function () {
    return view('website.pages.login');
})->name("login.admin");

Route::get('/register', function () {
    return view('website.pages.register');


})->name('admin.register');

Route::get('/user/verify/{token}', 'AdminController@verifyUser')->name('user.verify.token');

Route::post('store','AdminController@store')->name('store');

Route::post('restore','AdminController@restore')->name('restore');

Route::post('forgot_pass','AdminController@forgot_pass')->name('fog.pass');

Route::get('/password_reset/{id}','AdminController@password_reset')->name('password.reset');

Route::patch('update/{user}','AdminController@update')->name('admin.update');



Route::get('/my_profile/{user}', 'AdminController@profile')->name('admin.profile');

Route::get('/edit_profile/{user}', 'AdminController@profileedt')->name('admin.profile.edit');

Route::post('admin_login','AdminController@admin_login')->name('admin.login');

Route::get('/forgot_password', function(){
    return view('admin.pages.forgot_password')->name('forgot.password');
});



Route::group(['middleware' => 'checkloggedin'], function(){

	
Route::get('/index/{user}', 'AdminController@index')->name('admin.index');

Route::get('/admin_logout','AdminController@admin_logout')->name('admin.logout');

});



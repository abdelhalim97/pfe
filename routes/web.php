<?php
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/result', 'HomeController@index');

//reading the barcode 4 any guest
Route::get('/scanning','Scanner@show')->name('scanner.get');
Route::post('/scanning','Scanner@scannerReader')->name('scanner.reader');
Route::get('/scanning/elements','Scanner@scannerResult')->name('scanner.result');


//display all the elements
Route::get('/display/elements','barcode@showElements')->name('show.elements');
//adding the elements
Route::get('/add/button','barcode@showAddButton')->name('show.button');
Route::post('/add/button','barcode@addButton')->name('add.button');

Route::get('/add/boitier','barcode@showAddBoitier')->name('show.boitier');
Route::post('/add/boitier','barcode@addBoitier')->name('add.boitier');

Route::get('/add/pole','barcode@showAddPole')->name('show.pole');
Route::post('/add/pole','barcode@addPole')->name('add.pole');

Route::get('/add/ampere','barcode@showAddAmpere')->name('show.ampere');
Route::post('/add/ampere','barcode@addAmpere')->name('add.ampere');

//add product
Route::get('/add/product','barcode@showAddProduct')->name('show.product');
Route::post('/add/product','barcode@addProduct')->name('add.product');
//display edit and delete product
Route::get('/display/products','barcode@showProducts')->name('show.products');
Route::get('/update/product/{id}','barcode@show')->name('show.product');
Route::get('/update/product/{id}/edit','barcode@updateProduct')->name('edit-form.product');
Route::post('/update/product/{id}/edit','barcode@update')->name('edit.product');
Route::get('/delete/product/{id}','barcode@deleteProduct')->name('delete.product');
//user management
Route::get('/status/{id}','UserManage@status')->name('status');//worker*


Route::prefix('admin')->group(function(){
    Route::get('/login', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');//ma etnahich
    //password reset
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
  //adding new worker
  Route::get('/add/worker','WorkerManage@addWorker');
  Route::post('/add/worker','WorkerManage@addNewWorker');
  //manipulate worker
  Route::get('/update/worker','WorkerManage@display')->name('admin.worker.display');
  Route::get('/update/worker/{id}','WorkerManage@showw')->name('admin.worker.showw');
  Route::get('/update/worker/{id}/edit','WorkerManage@updateForm')->name('admin.worker.edit-form');
  Route::post('/update/worker/{id}/edit','WorkerManage@update')->name('admin.worker.edit');
//delete worker
Route::get('/update/worker/{id}/delete','WorkerManage@deleteWorker')->name('admin.worker.delete');
});
Route::prefix('moderator')->group(function(){
    Route::get('/login', 'ModeratorLoginController@showLoginForm')->name('moderator.login');
    Route::post('/login', 'ModeratorLoginController@login')->name('moderator.login.submit');
    Route::get('/', 'ModeratorController@index')->name('moderator.dashboard');//ma etnahich
    //password reset
    Route::post('/password/email', 'Auth\ModeratorForgotPasswordController@sendResetLinkEmail')->name('moderator.password.email');
    Route::get('/password/reset', 'Auth\ModeratorForgotPasswordController@showLinkRequestForm')->name('moderator.password.request');
    Route::post('/password/reset', 'Auth\ModeratorResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\ModeratorResetPasswordController@showResetForm')->name('moderator.password.reset');
    //adding new admin
    // Route::get('/manage/admin','ModeratorController@create');
    // Route::post('/manage/admin','ModeratorController@store');
    //manipulate admin
    // Route::get('/manage/admins','ModeratorController@index')->name('moderator.admin.display');
    // Route::get('/manage/admin/{id}','ModeratorController@show')->name('moderator.admin.showw');
    // Route::get('/manage/admin/{id}/edit','ModeratorController@edit')->name('moderator.admin.edit-form');
    // Route::post('/manage/admin/{id}/edit','ModeratorController@update')->name('moderator.admin.edit');
    // //delete admin
    // Route::get('/manage/admin/{id}/delete','ModeratorController@destroy')->name('moderator.admin.delete');

});



Route::get('{path}','AdminController@index')->where('path','.*');

//Route::resource('/update/admin','ModeratorController@deleteAdmin');
//2 chapms string /code article/desc/photo/nom de photo
//when display elements just show articles names(option)
//host |button scanner with cursor|img size|recherche|interface|Bel
//si S we shiw double buttons
//W  S  D|01|x
//W normal  |S double buttons | D 1 button
//01couleur
//description
//if D 1 button black
//  s 2 couleurs gr red

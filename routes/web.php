<?php
// LOGIN ROUTES
Auth::routes();

Route::get('/', function () {
    return view('principal');
});

// LOGICA DE USUSARIOS
Route::get('register_usuario','UsuarioController@register_usuario');
Route::post('save_user','UsuarioController@save_user');
Route::get('editar_usuario/{id}','UsuarioController@editar_usuario');
Route::post('update_user','UsuarioController@update_user');
Route::get('delete_user/{id}','UsuarioController@delete_user');
Route::get('restore_user/{id}','UsuarioController@restore_user');

// LOGICA DE FUNCIONARIOS
Route::get('register_funcionario','FuncionarioController@register_funcionario');
Route::get('get_areas_select2/{id_sucursal}','FuncionarioController@get_areas_select2');

// LOGICA DE SUCURSALES
Route::get('registrar_sucursal','SucursalController@registrar_sucursal');
Route::post('save_sucursal','SucursalController@save_sucursal');
Route::get('editar_sucursal/{id_sucursal}','SucursalController@editar_sucursal');
Route::post('update_sucursal','SucursalController@update_sucursal');
Route::get('delete_sucursal/{id_sucursal}','SucursalController@delete_sucursal');
Route::get('restore_sucursal/{id_sucursal}','SucursalController@restore_sucursal');
Route::get('sucursal/{id_sucursal}','SucursalController@sucursal');
//LOGICA  DE CREACION DE AREAS
Route::post('create_area','SucursalController@create_area');
Route::get('get_areas/{id_sucursal}','SucursalController@get_areas');
Route::get('edit_area/{id_area}','SucursalController@edit_area');
Route::post('update_area','SucursalController@update_area');
Route::get('delete_area/{id_area}','SucursalController@delete_area');
Route::get('restore_area/{id_area}','SucursalController@restore_area');
// LOGICA DE CREACION DE ALMACENES
Route::post('create_almacen','SucursalController@create_almacen');
Route::get('get_almacenes/{id_sucursal}','SucursalController@get_almacenes');
Route::get('edit_almacen/{id_almacen}','SucursalController@edit_almacen');
Route::post('update_almacen','SucursalController@update_almacen');

Route::get('/home', 'HomeController@index')->name('home');

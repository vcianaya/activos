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
Route::post('save_funcionario','FuncionarioController@save_funcionario');
Route::get('list_funcionarios','FuncionarioController@list_funcionarios');
Route::get('editar_funcionario/{id_funcionario}','FuncionarioController@editar_funcionario');
Route::post('update_funcionario','FuncionarioController@update_funcionario');
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
// CREACION DE CATEGORIAS
Route::get('registrar_categoria','EquipoController@registrar_categoria');
Route::post('save_categoria','EquipoController@save_categoria');
Route::get('get_categorias','EquipoController@get_categorias');
Route::get('editar_categoria/{id_categoria}','EquipoController@editar_categoria');
Route::post('update_categoria','EquipoController@update_categoria');
// CREACION DE EQUIPOS
Route::get('registrar_equipo','EquipoController@create_equipo');
Route::get('get_almacenes_select2/{id_sucursal}','EquipoController@get_almacenes_select2');
Route::get('get_codigo_categoria/{id_categoria}','EquipoController@get_codigo_categoria');
Route::post('save_equipo','EquipoController@save_equipo');
Route::get('get_equipos','EquipoController@get_equipos');
Route::get('editar_equipo/{id_equipo}','EquipoController@editar_equipo');
Route::get('get_almacenes_sucursal/{id_sucursal}/{id_almacen}','EquipoController@get_almacenes_sucursal');
Route::post('update_equipo','EquipoController@update_equipo');
Route::post('registro_masivo_equipos','EquipoController@registro_masivo_equipos');
Route::get('descargar_formato','EquipoController@descargar_formato');
Route::get('detalle_equipo/{id_equipo}','EquipoController@detalle_equipo');
// FALLA TECNICA
Route::get('falla_tecnica','EquipoController@falla_tecnica');
//ACTIVOS FIJOS
Route::get('asignar_equipo','ActivoController@asignar_equipo');
Route::get('get_funcionarios/{id_sucursal}','ActivoController@get_funcionarios');
Route::get('get_almacen/{id_sucursal}','ActivoController@get_almacen');
Route::get('get_equipos_table/{id_almacen}','ActivoController@get_equipos_table');
Route::post('save_activos','ActivoController@save_activos');
Route::get('detalle_funcionario_activos/{id_equipo}','FuncionarioController@get_activos_pdf');

Route::get('devolver_activo','ActivoController@devolver_activo');
Route::get('get_activos_asignados/{id_funcionario}','ActivoController@get_activos_asignados');
Route::get('get_activo_asignado/{id_asignacion}','ActivoController@get_activo_asignado');
Route::post('save_devolver_activos','ActivoController@save_devolver_activos');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('test','EquipoController@test');
// DATA TABLES

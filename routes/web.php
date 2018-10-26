<?php

Route::get('/', function () {
    return view('principal');
});

//LOGICA DE USUSARIOS
Route::get('register_usuario','UsuarioController@register_usuario');
Route::post('save_user','UsuarioController@save_user');
Route::get('editar_usuario/{id}','UsuarioController@editar_usuario');
Route::post('update_user','UsuarioController@update_user');
Route::get('delete_user/{id}','UsuarioController@delete_user');
Route::get('restore_user/{id}','UsuarioController@restore_user');

//LOGICA DE FUNCIONARIOS
Route::get('register_funcionario','FuncionarioController@register_funcionario');
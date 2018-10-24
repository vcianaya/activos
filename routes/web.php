<?php

Route::get('/', function () {
    return view('principal');
});

Route::get('register_usuario','UsuarioController@register_usuario');
Route::post('save_user','UsuarioController@save_user');
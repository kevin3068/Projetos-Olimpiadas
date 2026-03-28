<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TarefaController;

// CRUD Usuários
Route::apiResource('usuarios', UsuarioController::class);

// CRUD Tarefas
Route::apiResource('tarefas', TarefaController::class);

// Endpoint bônus
Route::get('usuarios/{id}/tarefas', [UsuarioController::class, 'tarefas']);

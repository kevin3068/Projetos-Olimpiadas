<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;

Route::get('/teste', function() {
    return 'ok';
});

Route::resource("/tarefas", TarefaController::class);

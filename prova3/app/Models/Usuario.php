<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ✅ Importa o Model Tarefa
use App\Models\Tarefa;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email'];

    // Um usuário tem muitas tarefas
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'user_id');
    }
}

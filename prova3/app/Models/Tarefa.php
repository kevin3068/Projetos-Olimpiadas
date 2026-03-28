<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario; // importar para relacionamento

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'status', 'user_id'];

    // Relação: uma tarefa pertence a um usuário
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}

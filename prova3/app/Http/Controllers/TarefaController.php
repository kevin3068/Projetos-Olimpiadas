<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index()
    {
        return response()->json(Tarefa::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'descricao' => 'sometimes|string',
            'status' => 'sometimes|in:pendente,em_andamento,concluido',
            'user_id' => 'required|exists:usuarios,id',
        ]);

        $tarefa = Tarefa::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $request->status ?? 'pendente',
            'user_id' => $request->user_id,
        ]);

        return response()->json($tarefa, 201);
    }

    public function show($id)
    {
        $tarefa = Tarefa::find($id);
        if (!$tarefa) return response()->json(['erro' => 'Tarefa não encontrada'], 404);

        return response()->json($tarefa, 200);
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::find($id);
        if (!$tarefa) return response()->json(['erro' => 'Tarefa não encontrada'], 404);

        $request->validate([
            'titulo' => 'sometimes|string',
            'descricao' => 'sometimes|string',
            'status' => 'sometimes|in:pendente,em_andamento,concluido',
            'user_id' => 'sometimes|exists:usuarios,id',
        ]);

        $tarefa->update($request->only('titulo', 'descricao', 'status', 'user_id'));

        return response()->json($tarefa, 200);
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::find($id);
        if (!$tarefa) return response()->json(['erro' => 'Tarefa não encontrada'], 404);

        $tarefa->delete();
        return response()->json(['mensagem' => 'Tarefa deletada com sucesso'], 200);
    }
}

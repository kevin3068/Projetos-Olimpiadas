<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retorna todas as tarefas em JSON
        return response()->json(Tarefa::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Para APIs, geralmente não usamos formulários HTML
        // Podemos deixar vazio ou retornar uma mensagem
        return response()->json(['mensagem' => 'Endpoint não utilizado em API'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação básica
        if (!$request->titulo) {
            return response()->json(['erro' => 'Título obrigatório'], 400);
        }

        // Validação do status
        $statusPermitido = ['pendente', 'em_andamento', 'concluida'];
        $status = $request->status ?? 'pendente';
        if (!in_array($status, $statusPermitido)) {
            return response()->json(['erro' => 'Status inválido. Valores permitidos: pendente, em_andamento, concluida'], 400);
        }

        // Criar a tarefa
        $tarefa = Tarefa::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $status,
        ]);

        return response()->json($tarefa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        // Retorna a tarefa em JSON
        return response()->json($tarefa, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        // Para APIs, geralmente não usamos formulários HTML
        return response()->json(['mensagem' => 'Endpoint não utilizado em API'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        // Validação do status se enviado
        if ($request->has('status')) {
            $statusPermitido = ['pendente', 'em_andamento', 'concluida'];
            if (!in_array($request->status, $statusPermitido)) {
                return response()->json(['erro' => 'Status inválido. Valores permitidos: pendente, em_andamento, concluida'], 400);
            }
        }

        // Atualiza apenas os campos enviados
        $tarefa->update($request->all());

        return response()->json($tarefa, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();
        return response()->json(['mensagem' => 'Tarefa deletada com sucesso'], 200);
    }
}

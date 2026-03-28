<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(Usuario::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:usuarios,email',
        ]);

        $usuario = Usuario::create($request->only('nome', 'email'));

        return response()->json($usuario, 201);
    }

    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) return response()->json(['erro' => 'Usuário não encontrado'], 404);

        return response()->json($usuario, 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) return response()->json(['erro' => 'Usuário não encontrado'], 404);

        $request->validate([
            'nome' => 'sometimes|string',
            'email' => 'sometimes|email|unique:usuarios,email,' . $id,
        ]);

        $usuario->update($request->only('nome', 'email'));

        return response()->json($usuario, 200);
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) return response()->json(['erro' => 'Usuário não encontrado'], 404);

        $usuario->delete();
        return response()->json(['mensagem' => 'Usuário deletado com sucesso'], 200);
    }

    public function tarefas($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) return response()->json(['erro' => 'Usuário não encontrado'], 404);

        return response()->json($usuario->tarefas, 200);
    }
}

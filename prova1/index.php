<?php 

$tarefas = [
    [
        'id' => 1,
        'titulo' => 'Estudar PHP',
        'dificuldade' => 10,
        'status' => 'pendente',
    ],
    [
        'id' => 2,
        'titulo' => 'Construir foguete de garrafa PET',
        'dificuldade' => 7,
        'status' => 'pendente',
    ],
    [
        'id' => 3,
        'titulo' => 'Fazer sistema completo de linha de produção industrial',
        'dificuldade' => 4,
        'status' => 'concluído',
    ],
];


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];


if ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/tarefas') {
    http_response_code(200);
    echo json_encode($tarefas); // Transforma o array em json
    die();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/tarefas') {
    $dados = json_decode(file_get_contents("php://input"), true); // true == array associativo, false (default) == objeto
    // file_get_contents() é uma função nativa do PHP que lê todo o conteúdo de um arquivo ou de um “stream” e retorna como string.
    // php://input é um “stream” especial do PHP que contém todo o corpo da requisição HTTP bruta.

    if (!isset($dados['titulo'])) { // Se o valor for null ou não existir
        http_response_code(400);
        echo json_encode(['erro' => 'Nome da tarefa é obrigatório']);
        die();
    }

    $novaTarefa = [
        'id' => count($tarefas) + 1,
        'titulo' => $dados['titulo'],
        'dificuldade' => $dados['dificuldade'] ?? 5, // Valor default == 5
        'status' => $dados['status'] ?? 'pendente', // Valor default == 'pendente'
    ];

    $tarefas[] = $novaTarefa; // Adiciona ao final do array

    http_response_code(201); // Created
    echo json_encode($novaTarefa);
    die();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $uri === '/tarefas') {
    parse_str($_SERVER['QUERY_STRING'], $query); // Guarda a query em um array $query

    if (!isset($query['id'])) { // Garante que o cliente envie a ID da tarefa para saber qual é para atualizar
        http_response_code(400);
        echo json_encode(['erro' => 'ID é obrigatório']);
        die();
    }

    $dados = json_decode(file_get_contents("php://input"), true);
    $id = $query['id'];
    $tarefaEncontrada = false; // Inicializa variável que determina se a tarefa foi encontrada 

    foreach ($tarefas as &$tarefa) { // & permite atualizar o array
        if($tarefa['id'] == $id) { // Se o ID da tarefa for igual ao ID da query (se for a tarefa que foi selecionada). É == por que o tipo é diferente (query vem como string e ID da tarefa é inteiro)
            // Atualizar somente os valores alterados:
            $tarefa['titulo'] = $dados['titulo'] ?? $tarefa['titulo'];
            $tarefa['dificuldade'] = $dados['dificuldade'] ?? $tarefa['dificuldade'];
            $tarefa['status'] = $dados['status'] ?? $tarefa['status'];
            $tarefaEncontrada = true;

            http_response_code(200);
            echo json_encode($tarefa);
            unset($tarefa); // Quebra de referência
            die();
        }
    }

    unset($tarefa); // Garante quebra de referência mesmo se a tarefa não for encontrada

    if (!$tarefaEncontrada) {
        http_response_code(400);
        echo json_encode(['erro' => 'Tarefa não encontrada']);
        die();
    }

}


<?php
session_start();

function salvarEvento($data, $evento) {
    $eventos = $_SESSION['eventos'] ?? [];
    $eventos[$data][] = $evento;
    $_SESSION['eventos'] = $eventos;
}
function exibirEventos($data) {
    $eventos = $_SESSION['eventos'][$data] ?? [];
    if (!empty($eventos)) {
       
        echo '<ul>';
        foreach ($eventos as $index => $evento) {
            echo '<li>';
            echo '<h3>' . $data . '</h3>';
            echo '<span>' . htmlspecialchars($evento) . '</span>';
            echo '<a href="?data=' . $data . '&index=' . $index . '&action=excluir">Excluir</a>';
            echo '</li>';
        }
        echo '</ul>';
        echo '<hr/>';
    }
}
function excluirEvento($data, $index) {
    $eventos = $_SESSION['eventos'][$data];
    unset($eventos[$index]);
    $_SESSION['eventos'][$data] = $eventos;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $evento = $_POST['evento'];

    if (!empty($data) && !empty($evento)) {
        salvarEvento($data, $evento);
    }
}
if (isset($_GET['data']) && isset($_GET['index']) && isset($_GET['action'])) {
    $data = $_GET['data'];
    $index = $_GET['index'];
    $action = $_GET['action'];

    if ($action === 'editar') {
        $eventos = $_SESSION['eventos'][$data];
        $eventoEdit = $eventos[$index];
    } elseif ($action === 'excluir') {
        excluirEvento($data, $index);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        form,.container {
            max-width: 400px;
            margin: 10px auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="date"],
        input[type="text"] {
            width: 100%;
            padding: 10px 0;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            border: none;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        span {
            display: inline-block;
            margin-right: 10px;
        }
        a {
            color: #fff;
            background-color: #4caf50;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Calendário de Eventos</h1>

    <form method="POST" action="">
        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required>
        <label for="evento">Evento:</label>
        <input type="text" name="evento" id="evento" required>
        <input type="submit" value="Adicionar Evento">
    </form>
    <div class="container" >
        <?php
        echo '<h2>Eventos</h2>';
        if (isset($_SESSION['eventos'])) {
            foreach ($_SESSION['eventos'] as $data => $eventos) {
                exibirEventos($data);
            }
        }
        ?>
    </div>

</body>
</html>

<?php

require __DIR__ . '/connect.php';

session_start();

// Primeiro, buscar os detalhes da tarefa
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->bindParam(':id', $_GET['key']);
$stmt->execute();
$data = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400'500;700&display=swap" rel="stylesheet">
        <title>Gerenciador de Tarefas</title>
</head>
<body>


<div class="details-container">
    <div class="header">
        <h1><?php echo $data[0]['task_name']; ?></h1>
</div>
<div class="content">
        <div class="task-info">
</div>
            <dl>
                <dt>Descrição da Tarefa:</dt>
                <dd><?php echo $data[0]['task_description']; ?></dd>
                <dt>Data da Tarefa:</dt>
                <dd><?php echo $data[0]['task_date']; ?></dd>
            </dl>
        </div>
        <div class="image">
            <img src="uploads/<?php echo $data[0]['task_image'] ?>" alt="Imagem tarefa">

</div>
        <div class="footer">
            <p>Desenvolvido por Natasha Krisley Floriano</p>
        </div>
</div>

</head>
<body>
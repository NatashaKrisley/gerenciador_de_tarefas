<?php

try {
    $conn = new pdo('mysql:host=localhost;dbname=gerenciador_tarefas', 'root', '');
    // dbname=gerenciador_tarefas =echo "Conectou"; 
} catch (PDOException $e) {
    echo "Erro ao se conectar: Erro " . $e->getMessage();
}


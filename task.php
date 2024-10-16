<?php

require __DIR__ . '/connect.php';
session_start();

// Verifica se o nome da tarefa foi enviado e não está vazio
if ( isset( $_POST['task_name'] ) ) {
    if ( $_POST['task_name'] !="") 

        // Verifica se um arquivo foi enviado via o campo de upload
        if ( isset ($_FILES['task_image'])) {
            // Define a extensão e o nome do arquivo (com um hash para evitar duplicidade)
            $ext =strtolower( substr( $_FILES['task_image']['name'], -4 ) );
            $file_name = md5( date('Y.m.d.H.i.s')) . $ext;
            //$file_name = md5( date('Y.m.d.H.i.s') ) .$ext;
            $dir = 'uploads/';

            // Move o arquivo enviado para o diretório 'uploads/'
            move_uploaded_file( $_FILES['task_image']['tmp_name'], $dir.$file_name );
        }
        
        $data = [
            'task_name'=> $_POST['task_name'],
            'task_descrition'=> $_POST['task_description'],
            'task_date'=> $_POST['task_date'],
            'task_image'=> $file_name,
        ];

        // task eu consigo ver que os dados nao foram cadastrados 
        $stmt = $conn->prepare('INSERT INTO tasks (task_name, task_description, task_image, task_date)
                            VALUES (:name, :description, :image, :date)');

        $stmt->bindParam('name', $_POST['task_name']);
        $stmt->bindParam('description', $_POST['task_description']);
        $stmt->bindParam('image', $file_name);
        $stmt->bindParam('date', $_POST['task_date']);

        if ( $stmt->execute() ) {
            $_SESSION['success'] = "Dados cadastrados.";
            header('Location:index.php');
        }
        else {
            $_SESSION['error'] = "Dados não cadastrados.";
            header('Location:index.php');
        }

       } else {
        // Caso o nome da tarefa esteja vazio
       $_SESSION['message'] = "O campo nome da tarefa não pode ser vazio!";
       header('Location:index.php');
    }

    // Verifica se uma chave 'key' foi enviada para remoção de tarefa

if( isset($_GET['key']) ) {
    // Remove a tarefa da sessão
    // if(isset($_SESSION['tasks'][$_GET['key']])) {
    $stmt = $conn->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->bindParam(':id', $_GET['key']);

    if ( $stmt->execute() ) {
        $_SESSION['success'] = "Dados Removidos.";
        header('Location:index.php');
    }
    else {
        $_SESSION['error'] = "Dados não removidos.";
        header('Location:index.php');
    }

}
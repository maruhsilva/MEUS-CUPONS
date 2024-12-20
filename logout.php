<?php
// Inicia a sessão
session_start();

// Destroi a sessão e limpa os dados de autenticação
session_unset();
session_destroy();

// Redireciona para a página de login após o logout
header('Location: login.php');
exit;
?>

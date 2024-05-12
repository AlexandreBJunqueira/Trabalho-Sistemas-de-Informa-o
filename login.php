<?php
session_start(); // Inicia a sessão (se ainda não estiver iniciada)
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nusp = $_POST['nusp'];
    $senha = $_POST['senha'];

    // Consulta SQL para verificar se o número USP e a senha correspondem aos registros no banco de dados
    $sql = "SELECT * FROM candidatos WHERE nusp = '$nusp' AND senha = '$senha'";
    $result = $conn->query($sql);

    // Verifica se há algum resultado retornado pela consulta
    if ($result->num_rows > 0) {
        // Se os dados do usuário foram encontrados no banco de dados, redireciona para a página de acesso autorizado
        $_SESSION['loggedin'] = true;
        $_SESSION['nusp'] = $nusp;
        header("Location: acesso_autorizado.php");
    } else {
        // Se os dados do usuário não foram encontrados no banco de dados, exibe uma mensagem de erro
        $error_message = "Usuário ou Senha errados";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="login.css">
<title>Login</title>
</head>
<body>

<div class="logo">
    <img src="logo_pj.png" alt="Logo da Empresa">
</div>

<div class="login-box">
    <h2>Área do Candidato 
    </h2>
    <form action="#" method="post">
      <input type="text" name="nusp" placeholder="Número USP" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <input type="submit" value="Entrar">
    </form>

<?php
if (isset($error_message)) {
    echo "<div class='error-message'>$error_message</div>";
}
?>

<div class="container" style="text-align: center;">
  <a href="inicial_10.html" style="font-size: 12px;">Voltar para a página inicial</a>
</div>

</body>
</html>

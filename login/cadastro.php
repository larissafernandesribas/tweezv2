<?php
include("conexao.php");

$erroUsuario = "";
$erroEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verifica se o usuário já existe
    $checkUsuario = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultUsuario = $conn->query($checkUsuario);
    if ($resultUsuario->num_rows > 0) {
        $erroUsuario = "Ai, esse usuário já tá sendo usado!";
    }

    // Verifica se o email já existe
    $checkEmail = "SELECT * FROM usuarios WHERE email='$email'";
    $resultEmail = $conn->query($checkEmail);
    if ($resultEmail->num_rows > 0) {
        $erroEmail = "Ai, esse email já tá sendo usado!";
    }

    // Se não houver erros, cadastra
    if ($erroUsuario == "" && $erroEmail == "") {
        $sql = "INSERT INTO usuarios (usuario, email, senha) VALUES ('$usuario', '$email', '$senha')";
        if ($conn->query($sql) === TRUE) {
            header("Location: ../login.html?cadastro=sucesso");
            exit;
        } else {
            echo "Erro: " . $conn->error;
        }
    }
}
?>

<form method="post">
    Usuário: <input type="text" name="usuario" value="<?php echo isset($usuario) ? $usuario : ''; ?>" required><br>
    <span style="color:red;"><?php echo $erroUsuario; ?></span><br>

    Email: <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required><br>
    <span style="color:red;"><?php echo $erroEmail; ?></span><br>

    Senha: <input type="password" name="senha" required><br>
    <button type="submit">Cadastrar</button>
</form>

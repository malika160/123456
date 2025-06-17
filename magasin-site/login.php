<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'magasin');
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Nom d'utilisateur non trouvé.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <h1>Connexion</h1>
    <?php if ($message): ?>
        <p style="color:red;"><?=htmlspecialchars($message)?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" id="username" name="username" required /><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required /><br><br>

        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore de compte? <a href="register.php">Inscrivez-vous ici</a></p>
</body>
</html>

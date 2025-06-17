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
    $password_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($password) || empty($password_confirm)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif ($password !== $password_confirm) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "Ce nom d'utilisateur est déjà pris.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insert->bind_param('ss', $username, $hashed_password);
            if ($insert->execute()) {
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit;
            } else {
                $message = "Erreur lors de l'inscription.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Créer un compte</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <h1>Créer un compte</h1>
    <?php if ($message): ?>
        <p style="color:red;"><?=htmlspecialchars($message)?></p>
    <?php endif; ?>
    <form method="post" action="register.php">
        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" id="username" name="username" required /><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required /><br><br>

        <label for="password_confirm">Confirmer le mot de passe :</label><br>
        <input type="password" id="password_confirm" name="password_confirm" required /><br><br>

        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà un compte? <a href="login.php">Connectez-vous ici</a></p>
</body>
</html>

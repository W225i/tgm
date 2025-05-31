<!DOCTYPE html>
<html lang="fr">
<?php 
include 'templates/header.php';

$message = "";


if ($_SESSION['TGM_auth']) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $user = trim($_POST["username"]);
        $pass = $_POST["password"];

        $stmt = $tgm->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$user]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $hash = strtoupper(sha1(strtoupper($user) . ":" . strtoupper($pass)));

        $isPass = false;
        if ($hash == $result["password_hash"]) $isPass = true;

        if ($result && $isPass) {
            
            $_SESSION['TGM_auth'] = true; // Indique que l'utilisateur est authentifié
            $_SESSION['TGM_id'] = $result["id"]; // Stocke l'ID utilisateur dans la session
            $_SESSION['TGM_user'] = $result; // Stocke les informations de l'utilisateur dans la session
            header("Location: index.php"); // Redirige vers la page d'accueil
            exit;
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
?>
<body>
    <h2>Connexion</h2>
    <form method="POST" action="login.php">
        <label>Nom d'utilisateur :</label><br>
        <input type="text" name="username" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Se connecter">
    </form>

    <p style="color: lightcoral;"><?php echo htmlspecialchars($message); ?></p>
</body>
<?php include 'templates/footer.php'; ?>
</html>

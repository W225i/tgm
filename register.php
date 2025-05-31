

<!DOCTYPE html>
<html lang="fr">
<?php 

include 'templates/header.php'; 

$message = "";

if ($_SESSION['TGM_auth']) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {

        $user = trim($_POST["username"]);
        $pass = $_POST["password"];
        $hash = strtoupper(sha1(strtoupper($user) . ":" . strtoupper($pass)));

        $stmt = $tgm->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$user, $hash]);

        header("Location: login.php");
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "Nom d'utilisateur déjà pris.";
        } else {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
?>
<body>
    <h2>Créer un compte</h2>
    <form method="POST" action="register.php">
        <label>Nom d'utilisateur :</label><br>
        <input type="text" name="username" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>

    <p style="color: lightcoral;"><?php echo htmlspecialchars($message); ?></p>
</body>
<?php include 'templates/footer.php'; ?>
</html>

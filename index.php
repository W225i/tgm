<!DOCTYPE html>
<html lang="fr">
<?php 
include 'templates/header.php'; 
?>
<body>
<div class="text-center mt-5">
    <h1>Bienvenue <?= htmlspecialchars($_SESSION['TGM_auth'] ? ucfirst($_SESSION['TGM_user']['username']) : '') ?> sur TGM</h1>
    <p class="lead">Une messagerie privée simple et sécurisée.</p>
    <p class="text-muted">TGM utilise le chiffrement de bout en bout pour garantir la confidentialité de vos messages.</p>
    <p class="text-muted">Ceci est un projet indépendant et n'est pas affilié à Telegram.</p>
    <p class="text-muted">En cours de développement, n'hésitez pas à nous faire part de vos retours.</p>
    <p class="text-muted">Pour toute question ou suggestion, n'hésitez pas à nous contacter via la messagerie.</p></br>
    <p class="text-muted">TGM est un projet de messagerie privée développé par <a href="https://linktr.ee/owa31i" target="_blank">Owa31i</a> et <a href="https://linktr.ee/wess225" target="_blank">Wess225</a>.</p>
    <p class="text-muted">Ce projet est open-source et disponible sur <a href="https://github.com/W225i/tgm" target="_blank">GitHub</a>.</p>
    

<?php
if (!$_SESSION['TGM_auth']) {
?>

    <a href="/login.php" class="btn btn-primary m-2">Connexion</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/register.php" class="btn 
    btn-outline-secondary m-2">Créer un compte</a>


<?php
} else {
?>
    <a href="/messagerie.php" class="btn btn-primary m-2">Accéder à la messagerie</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/logout.php" class="btn btn-outline-danger m-2">Déconnexion</a>

<?php
} 
?>

</div>

</body>

<?php include 'templates/footer.php'; ?>
</html>
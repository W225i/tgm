  {chats}
<div class="list-group ">
    <a href="{link}" class="list-group-item list-group-item-action"> 
        <!--  border border-start border-warning  -->
        <div class="d-flex w-100 justify-content-between">
      <h5 class="text-capitalize mb-1">{name}</h5>
      <!-- <small>3 days ago</small>
        <span class="badge bg-primary rounded-pill">{unread}</span> -->
    </div>
    <p class="mb-1">{last_message}</p>
    <small>{created_at}</small>
    </a>
</div>
  {/chats}




  
<!DOCTYPE html>
<html lang="fr">
<?php 
include 'templates/header.php'; 

if (!isset($_SESSION['TGM_auth'])) {
    header("Location: /auth/login.php");
    exit;
}

$_SESSION['TGM_secretKey'] =  htmlspecialchars($_SESSION['defaultKey']); // Initialise la clé secrète dans la session si elle n'existe pas

$contacts = getContacts($_SESSION['TGM_id']); // Récupère les contacts de l'utilisateur
if (!$contacts || count($contacts) <= 0) {
    //$contacts = getAllUsers(); // Si pas de contacts, récupère tous les utilisateurs
}

$messages = getAllMessages(); // Récupère tous les messages de la base de données
?>
<body>
    <h2>TGM - Messagerie privée cryptée</h2></br>
    <a href="index.php">Accueil</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="index.php">Contacts</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="index.php">Paramètres</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="logout.php">Se déconnecter</a>

    </br>
    <h2>Bienvenue <?= htmlspecialchars(ucfirst($_SESSION['TGM_user']['username'])) ?> !</h2>
    <p>Les messages sont chiffrés de bout en bout.</p>
        

    <form id="messageForm" method="POST" action="api/send_message.php" onsubmit="encryptMessage()">

        <label for="receiver_id">Destinataire :</label><br>
        <select id="receiver_id" name="receiver_id" required>
            <option value="<?= $_SESSION['TGM_id'] ?>">Nota Bene</option>
            <option value="" disabled selected>----- Choisir un contact -----</option>
            <?php if (count($contacts) <= 0) { ?>
                    <option value="" disabled>Aucun contact disponible</option>
                <?php } foreach ($contacts as $c) { ?>
                <option value="<?= htmlspecialchars($c['id']) ?>"><?= htmlspecialchars($c['username']) ?></option>
            <?php } ?>
                <option value="">Canal Public</option>
        </select><br>

        <textarea type="text" id="messageInput" name="message" placeholder="Écris ton message ici..." required ></textarea><br>
        Bientôt... <input type="file" name="attachment" accept="image/*,video/*">
        
        <button id="sendMsg" type="submit" class="btn btn-primary">Envoyer</button>

        <input type="hidden" id="secretKey" placeholder="Ex: <?= $_SESSION['TGM_defaultKey'] ?>" value="<?= $_SESSION['TGM_secretKey'] ?>"><br>
    </form>

                
    </br></br>
    <h3>Derniers messages :</h3>
    <div id="notification" style="color: lightcoral; font-weight: bold;"></div>
    <div id="messagesList">
        <?php
        if ($messages) {
            foreach ($messages as $msg) {
                // On récupère l'utilisateur qui a envoyé le message
                $user = getUserById($msg["user_id"]);
                // On affiche le message chiffré, déchiffré côté client

                if (!$user) {
                    $user = ["username" => "Utilisateur inconnu"];
                }

                // Formate la date du message
                $date = formatDate(htmlspecialchars($msg["created_at"]));

                // Affiche le message
                echo '<div class="message">';
                echo '<div class="meta"><strong>' . htmlspecialchars($user["username"]) . '</strong> - ' . $date . '</div>';
                echo '<div class="encrypted-message" data-encrypted="' . htmlspecialchars($msg["message"]) . '">[Message chiffré]</div>';
                echo '</div>';
            }
        } else {
            echo "<p>Aucun message pour l'instant.</p>";
        }
        ?>
    </div>

</body>
<?php include 'templates/footer.php'; ?>
</html>

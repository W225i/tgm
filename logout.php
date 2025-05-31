<?php
unset($_SESSION['TGM_auth']);
unset($_SESSION['TGM_user']);
unset($_SESSION['TGM_id']);
unset($_SESSION['TGM_secretKey']);
session_start();
session_regenerate_id(true); // Regénère l'ID de session pour éviter les attaques de fixation de session
session_unset();
session_destroy();	
header("Location: index.php"); // Redirige vers la page d'accueil après la déconnexion
exit;
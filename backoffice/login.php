<?php
session_start();
require_once '../bdd/service_bdd.php';

if (isset($_POST['login'])) {
    $db = connexionbdd();
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = :user AND password = :pass";
    $stmt = $db->prepare($sql);
    $stmt->execute(['user' => $user, 'pass' => $pass]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin_logged'] = true;
        header('Location: ajouter_etudiant.php');
        exit;
    } else {
        $erreur = "Identifiants incorrects !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../frontoffice/style.css">
</head>
<body>
    <div class="wrap">
        <div class="hero">
            <div class="glow"></div>
            <div class="hero-inner" style="display:block; text-align:center;">
                <h1>Espace Admin</h1>
                <p class="subtitle">Veuillez vous connecter pour gérer les étudiants</p>
                
                <?php if(isset($erreur)): ?>
                    <p style="color:#ff4d4d; margin-bottom:15px;"><?php echo $erreur; ?></p>
                <?php endif; ?>

                <form method="POST">
                    <label>Utilisateur</label>
                    <input type="text" name="username" required><br>
                    <label>Mot de passe</label>
                    <input type="password" name="password" required>
                    <input type="submit" name="login" value="Se connecter">
                </form><br>
                <form action="../frontoffice/aceuille.php">
                    <button type="submit">Retour à l'accueil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
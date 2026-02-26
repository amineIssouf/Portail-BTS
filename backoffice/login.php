<?php
session_start();
if (isset($_SESSION['admin_logged'])) {
    header('Location: ajouter_etudiant.php');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['utilisateur'] === 'admin' && $_POST['password'] === '1234') {
        $_SESSION['admin_logged'] = true;
        header('Location: ajouter_etudiant.php');
        exit;
    } else {
        $error = "Accès refusé.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Login</title>
    <link rel="stylesheet" href="../frontoffice/style.css">
</head>
<body>
    <div class="wrap" style="max-width:450px; margin-top:100px;">
        <div class="card">
            <h1 class="gradient-text" style="text-align:center;">Espace Admin</h1>
            <?php if($error) echo "<p style='color:#ff4b2b; text-align:center;'>$error</p>"; ?>
            
            <form method="POST" class="form-group">
                <label>Identifiant</label>
                <input type="text" name="utilisateur" required>
                <label>Mot de passe</label>
                <input type="password" name="password" required>
                <button type="submit" class="btn-main" style="margin-top:1rem;">Se connecter</button>
            </form>
            <div style="text-align:center; margin-top:1rem;">
                <a href="../frontoffice/accueil.php" style="color:var(--text-dim); text-decoration:none;">← Retour au site</a>
            </div>
        </div>
    </div>
</body>
</html>
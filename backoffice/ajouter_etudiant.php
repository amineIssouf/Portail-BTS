<?php
session_start();
// Sécurité : redirection si non connecté
if (!isset($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}
require_once '../bdd/service_bdd.php';
$pdo = connexionbdd();

// Logique de suppression directe
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $stmt = $pdo->prepare("DELETE FROM etudiant WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ajouter_etudiant.php?msg=supprime");
    exit;
}

$etudiants = recuperer_les_etudiant(); //
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../frontoffice/style.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; color: white; }
        .admin-table th, .admin-table td { padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left; }
        .btn-edit { color: #38bdf8; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .btn-delete { color: #ef4444; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="hero">
            <h1 class="gradient-text">Tableau de Bord Admin</h1>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <a href="formulaire_ajout.php" class="btn-main"> + Ajouter un Étudiant</a>
                <a href="logout.php" class="btn-nav" style="background:#ff4b2b; color:white;">Déconnexion</a>
            </div>
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <p style="color: #22c55e; text-align: center;">Action effectuée avec succès !</p>
        <?php endif; ?>

        <div class="card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom & Prénom</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $etu): ?>
                    <tr>
                        <td><img src="../frontoffice/images/<?php echo $etu['photo']; ?>" width="40" style="border-radius:50%;"></td>
                        <td><?php echo htmlspecialchars($etu['prenom'] . " " . $etu['nom']); ?></td>
                        <td><?php echo htmlspecialchars($etu['classe']); ?></td>
                        <td>
                            <a href="modifier_etudiant.php?id=<?php echo $etu['id']; ?>" class="btn-edit">Modifier</a>
                            <a href="ajouter_etudiant.php?supprimer=<?php echo $etu['id']; ?>" class="btn-delete" onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="text-align:center;"><a href="../frontoffice/accueil.php" class="btn-nav">Retour au Portail Public</a></div>
    </div>
</body>
</html>
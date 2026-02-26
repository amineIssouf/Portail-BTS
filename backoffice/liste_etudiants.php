<?php
session_start();
if (!isset($_SESSION['admin_logged'])) { header('Location: login.php'); exit; }
require_once '../bdd/service_bdd.php';
$etudiants = recuperer_les_etudiant(); //
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les étudiants</title>
    <link rel="stylesheet" href="../frontoffice/style.css">
</head>
<body>
    <div class="wrap">
        <h1 class="gradient-text">Gestion des étudiants</h1>
        <div class="card">
            <div class="student-grid">
                <?php foreach ($etudiants as $etu): ?>
                    <div class="student-item">
                        <div>
                            <strong><?php echo htmlspecialchars($etu['prenom'] . " " . $etu['nom']); ?></strong>
                            <div class="subtitle"><?php echo htmlspecialchars($etu['classe']); ?></div>
                        </div>
                        <a href="modifier_etudiant.php?id=<?php echo $etu['id']; ?>" class="btn-small">Modifier</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <a href="ajouter_etudiant.php" class="btn-nav">Ajouter un nouveau</a>
    </div>
</body>
</html>
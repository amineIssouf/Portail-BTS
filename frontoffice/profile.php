<?php
require_once '../bdd/service_bdd.php';
connexionbdd();

$id_selectionne = isset($_POST['etudiant']) ? $_POST['etudiant'] : null;
$etudiant = null;

if ($id_selectionne) {
    $etudiant = recuperer_un_etudiant_par_id($id_selectionne);
}


if (!$etudiant) {
    header("Location: accueil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil de <?php echo htmlspecialchars($etudiant['prenom']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div class="hero-inner">
            <div class="avatar">
                <img src="images/<?php echo !empty($etudiant['photo']) ? htmlspecialchars($etudiant['photo']) : 'default.jpg'; ?>" alt="Photo">
            </div>
            <div class="info">
                <h1><?php echo htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']); ?></h1>
                <p style="color:var(--primary); font-weight:500;"><?php echo htmlspecialchars($etudiant['classe']); ?> — Lycée Bamana — SLAM</p>
                <div class="tags">
                    <span class="tag">Classe</span>
                    <span class="tag">Informatique</span>
                    <span class="tag">BTS</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid">
        <section class="card">
            <h2>🙋 Description</h2>
            <p><?php echo nl2br(htmlspecialchars($etudiant['description'])); ?></p>
        </section>

        <section class="card">
            <h2>🔥 Passions</h2>
            <p><?php echo nl2br(htmlspecialchars($etudiant['passions'])); ?></p>
        </section>

        <section class="card">
            <h2>🚀 Projets / ambitions</h2>
            <p><?php echo nl2br(htmlspecialchars($etudiant['projet'])); ?></p>
        </section>
    </div>

    <div style="display:flex; gap:1rem; justify-content:center;">
        <a href="accueil.php" class="btn-nav">Retour à l'accueil</a>
        <a href="../backoffice/login.php" class="btn-nav" style="background:var(--accent); color:white;">Admin</a>
    </div>

    <footer>© <?php echo date('Y'); ?> Amine Issouf Abdou Mouhoudhoir</footer>
</div>
</body>
</html>
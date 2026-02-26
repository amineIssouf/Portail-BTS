<?php
require_once '../bdd/service_bdd.php';
connexionbdd();

$les_etudiants = recuperer_les_etudiant();
$resultats_recherche = [];
$recherche_effectuee = false;

if (isset($_GET['rechercher']) && !empty(trim($_GET['rechercher']))) {
    $recherche_effectuee = true;
    $resultats_recherche = rechercher_etudiants($_GET['rechercher']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Portail Étudiants BTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrap">
        <div class="hero">
            <h1 class="gradient-text">Bienvenue sur le Portail BTS</h1>
            <p style="color: var(--text-dim)">Explorez les talents et les projets des étudiants.</p>
            
            <div style="margin-top: 2rem;">
                <form action="accueil.php" method="GET" style="display:flex; gap:10px; justify-content:center;">
                    <input type="text" name="rechercher" placeholder="Nom ou prénom..." 
                           value="<?php echo isset($_GET['rechercher']) ? htmlspecialchars($_GET['rechercher']) : ''; ?>" style="width:300px;">
                    <button type="submit" class="btn-main">Rechercher</button>
                </form>
            </div>
        </div>

        <?php if ($recherche_effectuee): ?>
            <div class="card">
                <h3>Résultats pour "<?php echo htmlspecialchars($_GET['rechercher']); ?>"</h3>
                <?php if (count($resultats_recherche) > 0): ?>
                    <div class="student-grid">
                        <?php foreach ($resultats_recherche as $etu): ?>
                            <div class="student-item">
                                <div>
                                    <div style="font-weight:600;"><?php echo htmlspecialchars($etu['prenom'] . " " . $etu['nom']); ?></div>
                                    <div style="color:var(--text-dim); font-size:0.85rem;"><?php echo htmlspecialchars($etu['classe']); ?></div>
                                </div>
                                <form action="profile.php" method="POST">
                                    <input type="hidden" name="etudiant" value="<?php echo $etu['id']; ?>">
                                    <button type="submit" class="btn-small">Voir</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Aucun étudiant trouvé.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form action="profile.php" method="POST" style="display:flex; flex-direction:column; gap:15px;">
                <label>Veuillez sélectionner l'étudiant :</label>
                <select name="etudiant">
                    <?php foreach ($les_etudiants as $etu): ?>
                        <option value="<?php echo $etu['id']; ?>">
                            <?php echo htmlspecialchars($etu['prenom'] . ' ' . $etu['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn-main">Voir le profil</button>
            </form>
        </div>
        
        <footer>© <?php echo date('Y'); ?> Amine Issouf Abdou Mouhoudhoir</footer>
    </div>
</body>
</html>
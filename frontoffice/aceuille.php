<?php
require_once '../bdd/service_bdd.php';
connexionbdd();

$les_etudiants = recuperer_les_etudiant();
$resultats_recherche = [];
$recherche_effectuee = false;

// Vérifier si une recherche a été soumise
if (isset($_GET['rechercher']) && !empty(trim($_GET['rechercher']))) {
    $recherche_effectuee = true;
    $resultats_recherche = rechercher_etudiants($_GET['rechercher']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - Portail Étudiants</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="welcome.css">
</head>
<body>
    <div class="wrap">
        <div class="hero welcome-screen">
            <div class="glow"></div>
            <div class="hero-inner welcome-content">
                <h1>Bienvenue sur le Portail BTS</h1>
                <p class="subtitle">Explorez les talents et les projets des etudiants.</p>
                
                <h3>Vous recherchez un etudiant ?</h3><br>
                <form action="aceuille.php" method="GET">
                    <p class="subtitle">Effectuez votre recherche.</p>
                    <input type="text" name="rechercher" value="<?php echo isset($_GET['rechercher']) ? htmlspecialchars($_GET['rechercher']) : ''; ?>">
                    <input type="submit" value="Rechercher">
                </form>
            </div>
        </div>

        <?php if ($recherche_effectuee): ?>
            <div class="hero welcome-screen" style="margin-top: 20px;">
                <h3>Résultats pour "<?php echo htmlspecialchars($_GET['rechercher']); ?>"</h3>
                <?php if (count($resultats_recherche) > 0): ?>
                    <ul>
                        <?php foreach ($resultats_recherche as $etu): ?>
                            <li style="color: white; list-style: none; margin-bottom: 10px;">
                                <strong><?php echo $etu['prenom'] . " " . $etu['nom']; ?></strong> (Classe: <?php echo $etu['classe']; ?>)
                                <form action="profile.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="etudiant" value="<?php echo $etu['id']; ?>">
                                    <input type="submit" value="Voir profil" style="padding: 2px 10px; margin-left: 10px;">
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucun étudiant trouvé.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <br>
        <div class="hero welcome-screen">
            <form action="profile.php" method="POST">
                <label for="etudiant">Veuillez selectionner l'etudiant :</label>
                <select name="etudiant">
                    <?php
                    foreach ($les_etudiants as $etu) {
                        // Correction : attention à la casse, dans SQL c'est 'id' minuscule
                        echo '<option value="' . $etu['id'] . '">' . $etu['prenom'] . ' ' . $etu['nom'] . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" value="Voir le profil">
            </form>
        </div>
        
        <footer>
            © 2026 Amine Issouf Abdou Mouhoudhoir
        </footer>
    </div>
</body>
</html>
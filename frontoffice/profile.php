<?php
require_once '../bdd/service_bdd.php';
connexionbdd();

// Récupération de l'identifiant envoyé par le formulaire
$id_selectionne = isset($_POST['etudiant']) ? $_POST['etudiant'] : null;
$etudiant = null;

if ($id_selectionne) {
    // Utilisation de votre fonction pour récupérer les infos d'un seul étudiant
    $etudiant = recuperer_un_etudiant_par_id($id_selectionne);
}

// Sécurité : si l'étudiant n'est pas trouvé
if (!$etudiant) {
    echo "Étudiant non trouvé. <a href='aceuille.php'>Retour</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Profil de <?php echo htmlspecialchars($etudiant['prenom']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
  <div class="hero">
    <div class="glow"></div>
    <div class="hero-inner">
      <div class="avatar">
        <?php 
        // Gestion de la photo : utilise la photo en BDD ou une image par défaut
        $photo_nom = !empty($etudiant['photo']) ? $etudiant['photo'] : 'default.jpg'; 
        ?>
        <img src="images/<?php echo htmlspecialchars($photo_nom); ?>" alt="Photo de <?php echo htmlspecialchars($etudiant['nom']); ?>">
      </div>
      <div>
        <h1><?php echo htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']); ?></h1>
        <p class="subtitle">Classe : <?php echo htmlspecialchars($etudiant['classe']); ?> — Lycée Bamana</p>
        <div class="tags">
          <span class="tag">Étudiant</span>
          <span class="tag">BTS SIO</span>
        </div>
      </div>
    </div>
  </div>

  <div class="grid">
    <section id="desc">
      <h2>🙋 Description — Qui suis-je ?</h2>
      <p><?php echo nl2br(htmlspecialchars($etudiant['description'])); ?></p>
    </section>

    <section id="passions">
      <h2>🔥 Mes passions</h2>
      <p><?php echo htmlspecialchars($etudiant['passions']); ?></p>
    </section>

    <section id="projets">
      <h2>🚀 Projets / ambitions</h2>
      <p><?php echo nl2br(htmlspecialchars($etudiant['projet'])); ?></p>
    </section>

    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <form action="aceuille.php">
          <button type="submit">Retour à l'accueil</button>
        </form>
        <form action="../backoffice/ajouter_etudiant.php">
          <button type="submit">Ajouter un étudiant</button>
        </form>
    </div>
  </div>

  <footer>&copy; <span id="y"></span> Amine Issouf Abdou Mouhoudhoir</footer>
</div>
<script>document.getElementById('y').textContent=new Date().getFullYear()</script>
</body>
</html>
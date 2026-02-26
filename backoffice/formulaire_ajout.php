

<?php
session_start();
// Vérification de la session pour la sécurité
if (!isset($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

require_once '../bdd/service_bdd.php';

$success = null;
$error = null;

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $classe = $_POST['classe'] ?? '';
    $description = $_POST['description'] ?? '';
    $passions = $_POST['passions'] ?? '';
    $projet = $_POST['projet'] ?? '';
    $photo_nom = 'default.jpg'; // Photo par défaut

    // Gestion de l'upload de l'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $upload_dir = '../frontoffice/images/';
        
        // Créer le dossier s'il n'existe pas
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_nom = uniqid() . '.' . $extension; // Nom unique pour éviter les doublons
        
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo_nom);
    }

    // Connexion et Insertion SQL
    try {
        $pdo = connexionbdd();
        $sql = "INSERT INTO etudiant (nom, prenom, photo, classe, description, passions, projet) 
                VALUES (:nom, :prenom, :photo, :classe, :description, :passions, :projet)";
        
        $stmt = $pdo->prepare($sql);
        $resultat = $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'photo' => $photo_nom,
            'classe' => $classe,
            'description' => $description,
            'passions' => $passions,
            'projet' => $projet
        ]);

        if ($resultat) {
            $success = "L'étudiant " . htmlspecialchars($prenom) . " a été ajouté avec succès !";
        } else {
            $error = "Une erreur est survenue lors de l'enregistrement.";
        }
    } catch (PDOException $e) {
        $error = "Erreur base de données : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
    <link rel="stylesheet" href="../frontoffice/style.css">
</head>
<body>
    <div class="wrap">
        <div class="admin-header" style="display:flex; justify-content:flex-end; padding:10px;">
            <a href="logout.php" class="btn-small" style="background:#ff4b2b; color:white;">Déconnexion</a>
        </div>
        
        <div class="hero">
            <h1 class="gradient-text">Nouveau Profil</h1>
            <p>Remplissez les informations pour créer un nouveau profil étudiant.</p>
        </div>

        <div class="card">
            <?php if($success): ?>
                <div style="background: #22c55e; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if($error): ?>
                <div style="background: #ef4444; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="grid">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" required>
                        <label>Prénom</label>
                        <input type="text" name="prenom" required>
                    </div>

                    <div class="form-group">
                        <label>Photo de profil</label>
                        <input type="file" name="photo" accept="image/*">
                        <label>Classe</label>
                        <input type="text" name="classe" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description (Bio)</label>
                    <textarea name="description" rows="4" required style="width:100%; background:rgba(0,0,0,0.2); color:white; border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:10px;"></textarea>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label>Passions</label>
                        <input type="text" name="passions" placeholder="Ex: Sport, Musique...">
                    </div>
                    <div class="form-group">
                        <label>Projet / Ambitions</label>
                        <input type="text" name="projet" placeholder="Ex: Devenir développeur Fullstack">
                    </div>
                </div>
                
                <button type="submit" class="btn-main" style="width:100%; margin-top:20px;">ENREGISTRER LE PROFIL</button>
            </form>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="../frontoffice/accueil.php" class="btn-nav">← Retour au Portail</a>
            </div>
        </div>
    </div>
</body>
</html>
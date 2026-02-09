<?php
session_start();

// Protection de la page : si pas connecté, retour au login
if (!isset($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

require_once '../bdd/service_bdd.php';

if (isset($_POST['nom']) && isset($_POST['prenom'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $classe = $_POST['classe'];
    $description = $_POST['description'];
    $passions = $_POST['passions'];
    $projet = $_POST['projet'];
    
    // Gestion de l'upload photo
    $nom_photo = "default.jpg";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $dossier = '../frontoffice/images/';
        if (!is_dir($dossier)) mkdir($dossier, 0777, true);
        
        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $nom_photo = uniqid() . "." . $extension;
        move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $nom_photo);
    }

    try {
        $db = connexionbdd();
        $sql = "INSERT INTO etudiant (nom, prenom, photo, classe, description, passions, projet) 
                VALUES (:n, :p, :img, :c, :d, :pass, :proj)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'n' => $nom, 'p' => $prenom, 'img' => $nom_photo, 
            'c' => $classe, 'd' => $description, 'pass' => $passions, 'proj' => $projet
        ]);
        $success = "L'étudiant $prenom a été ajouté !";
    } catch (Exception $e) { $error = $e->getMessage(); }
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
        <div style="text-align:right; margin-bottom:10px;">
            <a href="logout.php" style="color:var(--g1); text-decoration:none;">Déconnexion</a>
        </div>
        <div class="hero">
            <div class="glow"></div>
            <div class="hero-inner" style="display:block;">
                <h1>Nouveau Profil</h1>
                <?php if(isset($success)) echo "<p style='color:var(--g1)'>$success</p>"; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div>
                        <label>Nom</label>
                        <input type="text" name="nom" required>
                        <label>Prénom</label>
                        <input type="text" name="prenom" required>
                    </div><br>

                    <div>
                        <label>Photo de profil</label>
                        <input type="file" name="photo" accept="image/*">

                        <label>Classe</label>
                        <input type="text" name="classe" required>

                        <label>Description</label>
                        <input type="text" name="description"><br>
                    </div><br>

                    <div>
                        <label>Passions</label>
                        <input type="text" name="passions">

                        <label>Projet</label>
                        <input type="text" name="projet">
                        <input type="submit" value="ENREGISTRER LE PROFIL">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
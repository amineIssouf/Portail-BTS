<?php
require_once '../bdd/service_bdd.php';
connexionbdd();

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['classe']))
{
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $classe = $_POST['classe'];
    $description = $_POST['description'];
    $passions = $_POST['passions'];
    $projet = $_POST['projet'];
    
    // --- GESTION DE LA PHOTO ---
    $nom_photo = "default.jpg"; // Nom par défaut

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $dossier_destination = '../frontoffice/images/';
        
        // Créer le dossier s'il n'existe pas
        if (!is_dir($dossier_destination)) {
            mkdir($dossier_destination, 0777, true);
        }

        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $nom_photo = uniqid() . "." . $extension; // Génère un nom unique (ex: 65b12...jpg)
        
        move_uploaded_file($_FILES['photo']['tmp_name'], $dossier_destination . $nom_photo);
    }
    // ---------------------------

    try {
        $db = connexionbdd();
        $sql = "INSERT INTO etudiant (nom, prenom, photo, classe, description, passions, projet)
                VALUES (:nom, :prenom, :photo, :classe, :description, :passions, :projet)";
        $requete = $db->prepare($sql);
        $requete->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':photo' => $nom_photo, // On insère le nom du fichier
            ':classe' => $classe,
            ':description' => $description,
            ':passions' => $passions,
            ':projet' => $projet,
        ]);
        echo "<p style='color:green;'>L'etudiant $prenom $nom a été ajouté avec succès !</p>";
    } catch (PDOException $e){
        echo "<p style='color:red;'>Erreur SQL : " . $e->getMessage() . "</p>";
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
        <div class="hero">
            <section>
                <H2>Ajouter un nouveau etudiant</H2>
                <h6>Veuillez entrer ses informations ci-dessous</h6>
            </section>
            <div class="grid">
                <section>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label>Nom</label>
                        <input type="text" name="nom" required>
                        <label>Prenom</label>
                        <input type="text" name="prenom" required><br><br>
                        
                        <label>Photo de profil</label>
                        <input type="file" name="photo" accept="image/*"><br><br>
                        
                        <label>Classe</label>
                        <input type="text" name="classe" required>
                        <label>Description</label>
                        <input type="text" name="description"><br><br>
                        <label>Passions</label>
                        <input type="text" name="passions">
                        <label>Projet</label>
                        <input type="text" name="projet">
                        <input type="submit" value="ENVOYER">
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['admin_logged'])) { header('Location: login.php'); exit; }
require_once '../bdd/service_bdd.php';

$id = $_GET['id'];
$etudiant = recuperer_un_etudiant_par_id($id); //

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connexionbdd();
    $sql = "UPDATE etudiant SET nom = :nom, prenom = :prenom, classe = :classe, description = :desc WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'classe' => $_POST['classe'],
        'desc' => $_POST['description'],
        'id' => $id
    ]);
    header("Location: ajouter_etudiant.php?msg=modifie");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Étudiant</title>
    <link rel="stylesheet" href="../frontoffice/style.css">
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h2 class="gradient-text">Modifier : <?php echo htmlspecialchars($etudiant['prenom']); ?></h2>
            <form method="POST" class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo htmlspecialchars($etudiant['nom']); ?>" required>
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?php echo htmlspecialchars($etudiant['prenom']); ?>" required>
                <label>Classe</label>
                <input type="text" name="classe" value="<?php echo htmlspecialchars($etudiant['classe']); ?>" required>
                <label>Description</label>
                <textarea name="description" rows="5"><?php echo htmlspecialchars($etudiant['description']); ?></textarea>
                <button type="submit" class="btn-main" style="margin-top:20px;">Mettre à jour le profil</button>
            </form>
            <a href="ajouter_etudiant.php" class="btn-nav" style="display:block; margin-top:15px; text-align:center;">Annuler</a>
        </div>
    </div>
</body>
</html>
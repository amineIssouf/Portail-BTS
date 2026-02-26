<?php
function connexionbdd()
{
    $dsn = 'mysql:host=localhost;dbname=bts;charset=utf8';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO($dsn, $user, $password);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Echec de la connexion : ' . $e->getMessage();
        exit;
    }
    
}


function recuperer_les_etudiant()
{
    $pdo= connexionbdd();
    $sql_rqt= 'SELECT * FROM etudiant';
    $sql= $pdo->prepare($sql_rqt);
    $sql->execute();
    $sql_resultat = $sql->fetchALL();
    return $sql_resultat;

}

function recuperer_un_etudiant_par_id($id) {
    $db = connexionbdd(); // Assurez-vous que cette fonction retourne l'objet PDO
    $sql = "SELECT * FROM etudiant WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




function rechercher_etudiants($recherche) {
    $pdo = connexionbdd();
    // On utilise LIKE pour trouver les noms ou prénoms qui contiennent le mot-clé
    $sql_rqt = 'SELECT * FROM etudiant WHERE nom LIKE :search OR prenom LIKE :search';
    $sql = $pdo->prepare($sql_rqt);
    $sql->execute(['search' => '%' . $recherche . '%']);
    return $sql->fetchAll();
}
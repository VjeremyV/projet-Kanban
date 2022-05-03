<?php
if (isset($_GET['suppr']) && !empty($_GET['suppr'])) {
    $idProjet = $_GET['suppr'];
    $stmt = $dbh->prepare('SELECT * FROM taches WHERE `id_projet_projet` = :idProjet');
    if ($stmt->execute(['idProjet' => $idProjet])) {
        $resultats = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED);
        foreach ($resultats as $resultat) {
            $idCats = $resultat['id_categorie_categories'];
            $stmt = $dbh->prepare('DELETE commentaires FROM commentaires join taches on commentaires.id_taches_taches = taches.id_taches_taches WHERE taches.id_categorie_categories = :idCat');
            if ($stmt->execute(['idCat' => $idCats])) {
                $stmt = $dbh->prepare('DELETE fichiers FROM fichiers join taches on fichiers.id_taches_taches = taches.id_taches_taches WHERE taches.id_categorie_categories = :idCat');
                if ($stmt->execute(['idCat' => $idCats])) {
                    $stmt = $dbh->prepare('DELETE FROM taches WHERE `id_categorie_categories` = :idCat');
                    if (!$stmt->execute(['idCat' => $idCats])) {
                        echo "<span>Une erreur lors de la mise à jour de la base de données a été detectée</span>";
                    }
                } else {
                    echo "<span>Une erreur lors de la mise à jour de la base de données a été detectée</span>";
                }
            } else {
                echo "<span>Une erreur lors de la mise à jour de la base de données a été detectée</span>";
            }
        }
        $stmt = $dbh->prepare('DELETE FROM categories WHERE `id_projet_projet` = :idProjet');
        if ($stmt->execute(['idProjet' => $idProjet])) {
            $stmt = $dbh->prepare('DELETE FROM projet WHERE `id_projet_projet` = :idProjet');
            if (!$stmt->execute(['idProjet' => $idProjet])) {
                echo "<span>Une erreur lors de la mise à jour de la base de données a été detectée</span>";
            }
        }
    }
}

<?php
session_start();
include_once(__DIR__ . '/../template/head.php');
include_once(__DIR__ . '/../template/header.php');
include_once(__DIR__.'/../src/fonctions/formulaire.php');

if (isConnect()) {
    $idProjet = $_GET['id'];
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
        include_once(__DIR__.'./../src/fonctions/draggable.php');

        $stmt = $dbh->prepare('SELECT `date_creation_projet`, `description_projet` FROM `projet` WHERE projet.id_projet_projet = :idProjet');
        if ($stmt->execute(['idProjet' => $idProjet])) {
            $resultat = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED);
?>
            <p>Date de Création : <?= $resultat[0]['date_creation_projet'] ?></p>
            <p>Description : <?= $resultat[0]['description_projet'] ?></p>
        <?php
        } else {
            echo "<p>Une erreur est survenue lors de la connexion à la base de données</p>";
        }
        ?>
        <div class="d-flex justify-content-between">
            <?php
            $stmt = $dbh->prepare('SELECT `nom_categories`,`id_categorie_categories` FROM categories join projet on categories.id_projet_projet = projet.id_projet_projet WHERE projet.id_projet_projet = :idProjet');
            if ($stmt->execute(['idProjet' => $idProjet])) {
                $resultats = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED);
                $i = 0;
                $categories = [];

                $stmt = $dbh->prepare('SELECT `id_taches_taches`,`nom_taches`,`date_taches`,`description_taches`,`duree_taches`, categories.id_categorie_categories FROM `taches` join categories ON categories.id_categorie_categories = taches.id_categorie_categories WHERE categories.id_projet_projet = :idProjet');
                if ($stmt->execute(['idProjet' => $idProjet])) {
                    $res = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED);
                    // var_dump($res);
                    foreach ($resultats as $resultat) {
                        $categories[] = [$resultat['nom_categories'] => $resultat['id_categorie_categories']];
            ?>
                        <div class="categorieContainer px-1 pb-5" >
                            <h2><?= $resultat['nom_categories'] ?></h2>
                            <ul data-draggable="target" id = <?= $resultat['id_categorie_categories'] ?>>
                                <?php for ($j = 0; $j < count($res); $j++) {
                                    if (in_array($resultat['id_categorie_categories'], $res[$j])) {
                                        echo "<li class= 'p-2 m-1' draggable = 'true' data-draggable = 'item' id = '" . $res[$j]['id_taches_taches'] . "'>" . $res[$j]['nom_taches'] . "</li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
        <?php

                    }
                }
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
        ?>
        </div>


        <form action="" method="post" id="setUpdateTache">
            <input type="text" value="" id="saveTacheInput" name="saveTacheInput" >
            <input type="text" value="" id="idCatInput" name="idCatInput" >
        </form>
    <?php

    include_once(__DIR__ . '/../template/footer.php');
} else {
    header('location: ./../');
}
    ?>
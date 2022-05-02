<?php
session_start();
include_once(__DIR__ . '/../template/head.php');
include_once(__DIR__ . '/../template/header.php');
include_once(__DIR__ . '/../src/fonctions/formulaire.php');

if (isConnect()) {
    $idProjet = $_GET['id'];
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
        include_once(__DIR__ . './../src/fonctions/draggable.php');
        include_once(__DIR__ . '/../src/fonctions/modal.php');

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
                        <div class="categorieContainer px-1 pb-5">
                            <h2><?= $resultat['nom_categories'] ?></h2>
                            <ul data-draggable="target" id=<?= $resultat['id_categorie_categories'] ?>>
                                <?php for ($j = 0; $j < count($res); $j++) {
                                    if (in_array($resultat['id_categorie_categories'], $res[$j])) {
                                ?>
                                        <li class='p-2 m-1' draggable='true' data-draggable='item' id='<?= $res[$j]['id_taches_taches'] ?> '> <?= $res[$j]['nom_taches'] ?><button data-target='#modal-<?= $res[$j]['id_taches_taches'] ?>' data-toggle='modal' class="<?= $res[$j]['nom_taches'] ?>">Agrandir</button></li>

                                        <div class="modal" id="modal-<?= $res[$j]['id_taches_taches'] ?>" role="dialog">
                                            <div class="mw-100 bg-light mx-auto my-auto rounded">
                                                <form action="" method="post">
                                                    <div class="p-3 border-bottom border-dark">
                                                        <input type="text" id='nomTache' name='nomTache' class="h3" value="<?= ucfirst($res[$j]['nom_taches']) ?>"></input>
                                                    </div>
                                                    <div class="p-3 d-flex flex-column justiy-content-center align-items-start">
                                                        <div class="p-2">
                                                            <label for="description">Description de la tache</label>
                                                            <input type="text" name="description" id="description" value="<?= $res[$j]['description_taches']; ?>">

                                                            <label for="date">Date de création</label>
                                                            <input type="date" name="date" id="date" value="<?= $res[$j]['date_taches'] ?>">
                                                        </div>

                                                        <div class="p-2 d-flex">
                                                            <label for="date">Ajouter un commentaire</label>
                                                            <textarea name="com" id="com" value=""></textarea>
                                                        </div>
                                                        <input type="hidden" name="idTache" value="<?= $res[$j]['id_taches_taches'] ?>">
                                                    </div>

                                                    <div class="d-flex flex-column align-items-start px-4 mt-2">
                                                        <h3>Commentaires:</h3>
                                                        <?php
                                                        $sth = $dbh->prepare('SELECT * FROM commentaires WHERE id_taches_taches = :id');
                                                        $sth->execute(array(':id' => $res[$j]['id_taches_taches']));
                                                        $commentaires = $sth->fetchAll(PDO::FETCH_ASSOC);
                                                        if (count($commentaires) > 0) {
                                                            foreach ($commentaires as $commentaire) {
                                                                echo "<br><span>" . $commentaire['date_commentaires'] . '</span><p>' . $commentaire['texte_commentaires'] . '</p>';
                                                            }
                                                        } else {
                                                            echo "<br><span>Il n'y a aucun commentaire sur cette tâche</span>";
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="border-top border-dark pt-3 fs-5 d-flex justify-content-end ">
                                                        <input type="submit" class="btn btn-success m-2" value="Envoyer">
                                                        <button role="button" class="btn btn-secondary m-2" data-dismiss="dialog">X</button>
                                                    </div>
                                                </form>

                                                <button class="btn btn-danger mb-3" data-target='#suppr-<?= $res[$j]['id_taches_taches'] ?>' data-toggle='modal'>supprimer</button>
                                                <form action="" method="post" class="modal px-5 w-25 h-25 mx-auto my-auto rounded text-light d-flex flex-column justify-content-center" id="suppr-<?= $res[$j]['id_taches_taches'] ?>">
                                                    <label class="m-3" for="suppression">Confirmez-vous la suppresion de la tâche ?</label>
                                                    <div class="d-flex justify-content-center suppr-buttons">
                                                        <input class="m-3" type="submit" value="Oui" name="suppression">
                                                        <input type="hidden" name="supprId" value="<?= $res[$j]['id_taches_taches'] ?>">
                                                        <button class="m-3" role="button" data-dismiss="dialog">Non</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                            <button class="btn btn-primary addTache align-self-end" data-target='#modal-new-<?= $resultat['id_categorie_categories'] ?>' data-toggle=modal>+</button>

                            <div class="modal" id="modal-new-<?= $resultat['id_categorie_categories'] ?>" role="dialog">
                                <div class="mw-100 bg-light mx-auto my-auto rounded">
                                    <form action="" method="post">
                                        <div class="p-3 border-bottom border-dark d-flex flex-column justiy-content-center align-items-start">
                                            <label for="newTache">Intitulé de la tâche</label>
                                            <input type="text" id='newTache' name='newTache' class="h3"></input>
                                        </div>
                                        <div class="p-3 d-flex flex-column justiy-content-center align-items-start">
                                            <label for="newDescription">Description de la tache</label>
                                            <textarea name="newDescription" id="newDescription"></textarea>
                                        </div>
                                        <input type="hidden" name="idCat" value="<?= $resultat['id_categorie_categories'] ?>">
                                        <div class="border-top border-dark px-5 py-3 fs-5 d-flex ">
                                            <button role="button" class="btn btn-danger m-2" data-dismiss="dialog">Fermer</button>
                                            <input type="submit" class="btn btn-success m-2" value="Envoyer">
                                        </div>
                                    </form>
                                </div>
                            </div>
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
            <input type="hidden" value="" id="saveTacheInput" name="saveTacheInput">
            <input type="hidden" value="" id="idCatInput" name="idCatInput">
        </form>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary p-2" data-target='#modal-new-categorie' data-toggle=modal>Ajouter une catégorie</button>
        </div>
        <div class="modal" id="modal-new-categorie" role="dialog">
            <div class="mw-100 bg-light mx-auto my-auto rounded">
                <form action="" method="post">
                    <div class="p-3 border-bottom border-dark d-flex flex-column justiy-content-center align-items-start">
                        <label for="newTache">Intitulé de la Catégorie</label>
                        <input type="text" id='newTache' name='newTache' class="h3"></input>
                    </div>
                    <input type="hidden" name="idProjet" value="<?= $_GET['id']?>">
                    <div class="border-top border-dark px-5 py-3 fs-5 d-flex ">
                        <button role="button" class="btn btn-danger m-2" data-dismiss="dialog">Fermer</button>
                        <input type="submit" class="btn btn-success m-2" value="Envoyer">
                    </div>
                </form>
            </div>
        </div>
    <?php

    include_once(__DIR__ . '/../template/footer.php');
} else {
    header('location: ./../');
}
    ?>
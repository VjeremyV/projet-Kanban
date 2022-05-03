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
        @include_once(__DIR__ . '/../src/fonctions/modal.php');
        include_once(__DIR__ . '/../src/fonctions/categoriesPosition.php');


        $stmt = $dbh->prepare('SELECT `date_creation_projet`, `description_projet` FROM `projet` WHERE projet.id_projet_projet = :idProjet');
        if ($stmt->execute(['idProjet' => $idProjet])) {
            $resultat = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED); ?>
            <p>Date de Création : <?= $resultat[0]['date_creation_projet'] ?></p>
            <p>Description : <?= $resultat[0]['description_projet'] ?></p>
        <?php
        } else {
            echo "<p>Une erreur est survenue lors de la connexion à la base de données</p>";
        } ?>
        <div class="d-flex justify-content-evenly flex-wrap">
            <?php
            $stmt = $dbh->prepare('SELECT `nom_categories`,`id_categorie_categories`,`ordre` FROM categories join projet on categories.id_projet_projet = projet.id_projet_projet WHERE projet.id_projet_projet = :idProjet ORDER BY ordre');
        if ($stmt->execute(['idProjet' => $idProjet])) {
            $resultats = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED);
            $i = 0;
            $categories = [];

            $stmt = $dbh->prepare('SELECT `id_taches_taches`,`nom_taches`,`date_taches`,`description_taches`,`duree_taches`, categories.id_categorie_categories FROM `taches` join categories ON categories.id_categorie_categories = taches.id_categorie_categories WHERE categories.id_projet_projet = :idProjet');
            if ($stmt->execute(['idProjet' => $idProjet])) {
                $res = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED);
                // var_dump($resultats);
                // echo count($resultats);
                foreach ($resultats as $resultat) {
                    $categories[] = [$resultat['nom_categories'] => $resultat['id_categorie_categories']]; ?>

                        <div class="categorieContainer px-1 pb-5" data-id="<?= $resultat['id_categorie_categories'] ?>" style="order :<?= $resultat['ordre'] ?> ;">

                            <h2><?php if ($resultat['ordre'] > 1) : ?><button class="fs-5 px-0 mx-0 btn boutonMoins bi bi-chevron-double-left"></button><?php endif; ?><?= $resultat['nom_categories'] ?><?php if ($resultat['ordre'] < count($resultats)) : ?> <button class="fs-5 px-0 mx-0 btn boutonPlus bi bi-chevron-double-right"></button><?php endif; ?></h2>

                            <ul data-draggable="target" id=<?= $resultat['id_categorie_categories'] ?>>
                                <?php for ($j = 0; $j < count($res); $j++) {
                        if (in_array($resultat['id_categorie_categories'], $res[$j])) {
                            ?>
                                        <li class='p-2 m-1 d-flex justify-content-between' draggable='true' data-draggable='item' id='<?= $res[$j]['id_taches_taches'] ?> '> <?= $res[$j]['nom_taches'] ?><button class="btn btn-secondary" data-target='#modal-<?= $res[$j]['id_taches_taches'] ?>' data-toggle='modal' class="<?= $res[$j]['nom_taches'] ?>">Voir</button></li>

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
                                    echo "<table class='table-responsive 
                                                                m-2 align-top table-striped'>";
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $commentaire['date_commentaires'] . "</th>";
                                    echo '<td class="text-start">' . $commentaire['texte_commentaires'] . "</td>";
                                    echo "</tr>";
                                    echo "</table>";
                                }
                            } else {
                                echo "<br><span>Il n'y a aucun commentaire sur cette tâche</span>";
                            } ?>
                                                    </div>

                                                    <div class="border-top border-dark pt-3 fs-5 d-flex justify-content-end ">
                                                        <input type="submit" class="btn btn-success m-2" value="Envoyer">
                                                        <button role="button" class="btn btn-secondary m-2" data-dismiss="dialog"><i class="bi bi-x-square"></i></button>
                                                    </div>
                                                </form>

                                                <button class="btn btn-danger mb-3" data-target='#suppr-<?= $res[$j]['id_taches_taches'] ?>' data-toggle='modal'>Supprimer</button>
                                                <form action="" method="post" class="modal px-5 w-25 h-25 mx-auto my-auto rounded text-light d-flex flex-column justify-content-center" id="suppr-<?= $res[$j]['id_taches_taches'] ?>">
                                                    <label class="fs-4 m-3 bi bi-exclamation-octagon-fill text-danger avertissement" for="suppression"> Confirmez-vous la suppresion de la tâche ?</label>
                                                    <div class="d-flex justify-content-center suppr-buttons">
                                                        <input class="m-3 btn btn-danger" type="submit" value="Oui" name="suppression">
                                                        <input type="hidden" name="supprId" value="<?= $res[$j]['id_taches_taches'] ?>">
                                                        <button class="m-3 btn btn-success" role="button" data-dismiss="dialog">Non</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                <?php
                        }
                    } ?>
                            </ul>
                            <div class="d-flex justify-content-between barreTache px-2 w-100">
                                <button class="btn btn-danger bi bi-trash3-fill" data-target='#modal-suppr-<?= $resultat['id_categorie_categories'] ?>' data-toggle=modal></button>
                                <button class="btn btn-primary fw-bold addbutton bi bi-plus-square" data-target='#modal-new-<?= $resultat['id_categorie_categories'] ?>' data-toggle=modal></button>
                            </div>
                            <div class="modal" id="modal-new-categorie" role="dialog">
                                <div class="mw-100 bg-light mx-auto my-auto rounded">
                                    <form action="" method="post">
                                        <div class="p-3 border-bottom border-dark d-flex flex-column justiy-content-center align-items-start">
                                            <label for="newCategorie">Intitulé de la Catégorie</label>
                                            <input type="text" id='newCategorie' name='newCategorie' class="h3"></input>
                                        </div>
                                        <input type="hidden" name="idProjet" value="<?= $_GET['id'] ?>">
                                        <div class="border-top border-dark px-5 py-3 fs-5 d-flex ">
                                            <button role="button" class="btn btn-danger m-2" data-dismiss="dialog">Fermer</button>
                                            <input type="submit" class="btn btn-success m-2" value="Envoyer">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="modal" id="modal-suppr-<?= $resultat['id_categorie_categories'] ?>" role="dialog">
                                <div class="mw-100 text-light mx-auto my-auto rounded">
                                    <form action="" method="post">
                                        <div class="p-3 border-bottom border-dark d-flex flex-column justiy-content-center align-items-start">
                                            <input type="hidden" name="idCat" value="<?= $resultat['id_categorie_categories'] ?>">
                                            <label class="fs-4 bi-exclamation-octagon-fill text-danger avertissement" for="supprCat"> Confirmez-vous la suppresion de la catégorie ? <br><strong>Toutes les tâches et commentaires affiliés seront supprimés</strong></label>
                                            <div class="d-flex justify-content-center w-100 suppr-buttons">
                                                <input class="m-3 btn btn-danger" type="submit" name="supprCat" id="supprCat" value="Oui">
                                                <button class="m-3 btn btn-success" role="button" data-dismiss="dialog">Non</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

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
    } ?>

        </div>
        <form action="" method="post" id="setUpdateTache">
            <input type="hidden" value="" id="saveTacheInput" name="saveTacheInput">
            <input type="hidden" value="" id="idCatInput" name="idCatInput">
        </form>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-primary p-2 bi bi-plus-square" data-target='#modal-new-categorie' data-toggle=modal> Ajouter une catégorie</button>
            <!-- Je crée un button pour cloturer le projet -->
                <button class="btn btn-warning p-2 bi bi-x-square" data-target='#modal-close-projet' data-toggle=modal> Clôturer le projet</button>
                <?php
                //* J'affiche le bouton de cloture du projet si le projet n'est pas cloturé
                
                ?>
                <div class="modal" id="modal-close-projet" role="dialog">
                    <div class="mw-100 text-light mx-auto my-auto rounded">
                        <form action="" method="post">
                            <div class="p-3 border-bottom border-dark d-flex flex-column justiy-content-center align-items-start">
                                <input type="hidden" name="idProjet" value="<?= $_GET['id'] ?>">
                                <label class="fs-4 bi bi-exclamation-triangle text-warning avertissement" for="closeProjet"> Confirmez-vous la cloture du projet ?</label>
                                <div class="d-flex justify-content-center w-100 suppr-buttons">
                                    <input class="m-3 btn btn-warning" type="submit" name="closeProjet" id="closeProjet" value="Oui">
                                    <button class="m-3 btn btn-success" role="button" data-dismiss="dialog">Non</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                
            
            

        </div>

    <?php

    include_once(__DIR__ . '/../template/footer.php');
} else {
    header('location: ./../');
}
    ?>
<?php
$idProjet = $_GET['id'];
try {
    $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
    $stmt = $dbh->prepare('SELECT `date_creation_projet`, `description_projet` FROM `projet` WHERE projet.id_projet_projet = :idProjet');
    if ($stmt->execute(['idProjet' => $idProjet])) {
        $resultat = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED); ?>
        <p>Date de Création : <?= $resultat[0]['date_creation_projet'] ?></p>
        <p>Description : <?= $resultat[0]['description_projet'] ?></p>
    <?php
    } else {
        echo "<p>Une erreur est survenue lors de la connexion à la base de données</p>";
    } ?>
    <div>
        <?php
        // $stmt = $dbh->prepare(' SELECT * FROM `taches` WHERE `id_projet_projet` =:idProjet ORDER BY `date_taches`');
        $stmt = $dbh->prepare('select DISTINCT `date_taches` from taches WHERE `id_projet_projet`=:idProjet');
        if ($stmt->execute(['idProjet' => $idProjet])) {
            $dates = $stmt->fetchAll($fetchMode = PDO::FETCH_NAMED);
            $j = 1;
            foreach ($dates as $date) {
                echo $date['date_taches'];
                echo "<div class='d-flex flex-wrap justify-content-start'>";
                $stmt = $dbh->prepare('select * from taches WHERE `date_taches`=:date AND `id_projet_projet`=:idProjet');
                if ($stmt->execute(['date' => $date['date_taches'], 'idProjet' => $idProjet])) {
                    $resultats = $stmt->fetchAll($fetchMode = PDO::FETCH_NAMED);
                    foreach ($resultats as $resultat) {
        ?>
                        <ul class="border p-2 m-1">
                            <li class="p-2 m-1">Intitulé de la tâche : <?= $resultat['nom_taches'] ?></li>
                            <li class="p-2 m-1">Date : <?= $resultat['date_taches'] ?></li>
                            <li class="p-2 m-1">Description : <?= $resultat['description_taches'] ?></li>
                            <button class="btn btn-primary" data-target='#modal-agrandir<?= $j ?>' data-toggle=modal>Agrandir</button>
                        </ul>

                        <div class="modal w-100 h-100" id="modal-agrandir<?= $j ?>">
                            <div class="border-dark bg-light px-5 w-50 h-75 mx-auto my-auto rounded d-flex flex-column justify-content-center" role="dialog">
                                <ul>
                                    <li class="p-2 m-1">Intitulé de la tâche : <?= $resultat['nom_taches'] ?></li>
                                    <li class="p-2 m-1">Date : <?= $resultat['date_taches'] ?></li>
                                    <li class="p-2 m-1">Description : <?= $resultat['description_taches'] ?></li>
                                </ul>

                                <div class="d-flex flex-column align-items-start px-4 mt-2">
                                    <h3>Fichiers:</h3>
                                    <?php
                                    $sth = $dbh->prepare('SELECT * FROM fichiers WHERE id_taches_taches = :id');
                                    if ($sth->execute(array(':id' => $resultat['id_taches_taches']))) {
                                        $fichiers = $sth->fetchAll(PDO::FETCH_ASSOC);
                                        if (count($fichiers) > 0) {
                                            foreach ($fichiers as $fichier) {
                                    ?>
                                                <table class='table-responsive m-2 align-top table-striped'>
                                                    <thead>
                                                        <tr>
                                                            <th scope='row'> <?= $fichier['date_fichiers'] ?></th>
                                                            <td class="listFichier d-flex justify-content-around align-items-center"><a href="./../upload/fichiers/<?= $fichier['nom_fichiers'] ?>"><?= $fichier['user_nom_fichier'] ?></a></td>
                                                        </tr>
                                                </table>
                                    <?php
                                            }
                                        } else {
                                            echo "<span>Il n'y a aucun fichier sur cette tâche</span>";
                                        }
                                    } else {
                                        echo "<br><span>Errreur lors de l'affichage des fichiers</span>";
                                    } ?>
                                </div>
                                <div class="d-flex flex-column align-items-start px-4 mt-2">
                                    <h3>Commentaires:</h3>
                                    <?php
                                    $sth = $dbh->prepare('SELECT * FROM commentaires WHERE id_taches_taches = :id');
                                    if ($sth->execute(array(':id' => $resultat['id_taches_taches']))) {
                                        $commentaires = $sth->fetchAll(PDO::FETCH_ASSOC);
                                        if (count($commentaires) > 0) {
                                            foreach ($commentaires as $commentaire) {
                                                echo "<table class='table-responsive m-2 align-top table-striped'>";
                                                echo "<thead>";
                                                echo "<tr>";
                                                echo "<th scope='row'>" . $commentaire['date_commentaires'] . "</th>";
                                                echo '<td class="text-start">' . $commentaire['texte_commentaires'] . "</td>";
                                                echo "</tr>";
                                                echo "</table>";
                                            }
                                        } else {
                                            echo "<span>Il n'y a aucun commentaire sur cette tâche</span>";
                                        }
                                    } else {
                                        echo "<span> Erreur lors de l'affichage des commentaires</span>";
                                    } ?>
                                </div>
                                <button class="m-3 btn btn-success" role="button" data-dismiss="dialog">Réduire</button>
                            </div>
                        </div>
        <?php
                        $j++;
                    }
                }
                echo "</div>";
            }
        }

        ?>
    </div>
<?php
    //SELECT * FROM `taches` WHERE `id_projet_projet` = 13 ORDER BY `date_taches`;
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

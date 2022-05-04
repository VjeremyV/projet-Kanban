<?php
//page de menu projets
session_start();
include_once(__DIR__ . '/../template/head.php');
include_once(__DIR__ . '/../template/header.php');
include_once(__DIR__ . '/../src/fonctions/security.php');// fichier qui gère la sécurité de la connexion 


?>
<div>
    <?php
    if (isConnect()) {//vérifie si la connexion est établie sinon renvoie à l'accueil
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
            include_once(__DIR__ . '/../src/fonctions/supprCat.php');// fichier  qui gere la suppression des projets avec la bdd (mal nommé)
            if ($_GET['page'] === 'terminer_projet') {//on affiche la liste des projets en fonction s'ils sont terminés ou non et de la querystring 'page'
                $projet = $dbh->prepare('select * from projet join utilisateur on projet.id_utilisateur_utilisateur=utilisateur.id_utilisateur_utilisateur WHERE utilisateur.id_utilisateur_utilisateur = :id AND `terminer_projet` = 1');
            } else {
                $projet = $dbh->prepare('select * from projet join utilisateur on projet.id_utilisateur_utilisateur=utilisateur.id_utilisateur_utilisateur WHERE utilisateur.id_utilisateur_utilisateur = :id AND `terminer_projet` = 0');
            }
            if (!$projet->execute(['id' => $_SESSION['id']])) {
                echo "<p>Il y a eu une erreur lors de la connexion avec la base de donnée.</p>";
            } else {
    ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nom du Projet</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $projets = $projet->fetchAll($fetchMode = PDO::FETCH_NAMED);
                        foreach ($projets as $projet) {//on affiche les projets
                        ?>

                            <tr>
                                <td scope="row"><span><a href="./projet.php?page=<?= $projet['nom_projet'] ?>&id=<?= $projet['id_projet_projet'] ?>&kanban=<?= $projets[0]['terminer_projet'] === '0' ? 'true' : 'false' ?>"><?= $projet['nom_projet'] ?></a></span></td>
                                <td><span><?= $projet['date_creation_projet'] ?></span></td>
                                <td><span><?= $projet['description_projet'] ?></span></td>
                                <?php if ($_GET['page'] === "encours") :?>
                                <td><button class="border-0 bg-transparent" title='supprimer projet' data-target='#modal-supprimer-<?= $projet['id_projet_projet'] ?>' data-toggle=modal><i title='supprimer projet' class="bi bi-x-circle"></i></button></td>
                            </tr>
                            <!-- modale de suppression d'un projet -->
                            <div class="modal w-100 h-100" id="modal-supprimer-<?= $projet['id_projet_projet'] ?>">
                                <div class="border-dark px-5 w-50 h-75 mx-auto my-auto rounded d-flex flex-column justify-content-center align-items-center" role="dialog">
                                    <p class="fs-4 bi-exclamation-octagon-fill text-danger avertissement"> Êtes Vous sur de vouloir supprimer ce projet ?</p>
                                    <button class="m-3 btn btn-danger w-md-25 w-50" title="valider suppression"><a class='decoration-none text-white' href="?page=encours&suppr=<?= $projet['id_projet_projet'] ?>">Oui</i></a></button>
                                    <button class="m-3 btn btn-success w-md-25 w-50" title="revenir en arriere" role="button" data-dismiss="dialog">Non</button>
                                </div>
                            </div>
                <?php
                endif;
                        }
                    }
                } catch (Exception $e) {
                    echo 'Erreur : ' . $e->getMessage();
                } ?>
                    </tbody>
                </table>
</div>
<?php
        include_once(__DIR__ . '/../template/footer.php');
    } else {
        header('location: ./../index.php');
    }
?>
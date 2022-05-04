<?php
//page de creation de projet
session_start();
include_once(__DIR__ . '/../template/head.php');
include_once(__DIR__ . '/../template/header.php');
include_once(__DIR__ . '/../src/fonctions/formulaire.php');//fichier de fonctions gestion de formulaire
include_once(__DIR__ . '/../src/fonctions/security.php');// fichier qui gère la sécurité de la connexion 

if (isConnect()) { //vérifie si la connexion est établie sinon renvoie à l'accueil

    if (isset($_POST['submit'])) {
        if (validForm($_POST['nomProjet']) && validForm($_POST['description']) && validForm($_POST['nbCategorie'], 'int')) { //voir validForm dans fichier fonctions/formulaire.php
            try {
                $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
                $stmt = $dbh->prepare('SELECT `nom_projet` FROM projet WHERE id_utilisateur_utilisateur =:id');
                if ($stmt->execute(['id' => $_SESSION['id']])) {
                    $vNomProjet = $stmt->fetchAll($fetchMode = PDO::FETCH_NAMED);
                    if (isUnique($vNomProjet, $_POST['nomProjet'], 'nom_projet')) {//voir fonction isUnique dans fichier fonctions/formulaire.php
                        $nomProjet = htmlentities($_POST['nomProjet']);
                        $description = htmlentities($_POST['description']);
                        $stmt = $dbh->prepare('insert into projet (`nom_projet`,`description_projet`,`date_creation_projet`,`id_utilisateur_utilisateur`, `terminer_projet`) values (:nom,:description, :date, :id, 0);');
                        $stmt->execute(['nom' => $nomProjet, 'description' => $description, 'date' => date('Y-m-d'), 'id' => $_SESSION['id']]);
                        $i = 0;
                        $stmt = $dbh->prepare('SELECT `id_projet_projet` FROM `projet`WHERE `id_utilisateur_utilisateur` = :idUtilisateur AND `nom_projet` = :nomProjet');
                        $stmt->execute(['idUtilisateur' => $_SESSION['id'], 'nomProjet' => $nomProjet]);
                        $resultat = $stmt->fetchall($fetchMode = PDO::FETCH_NAMED);
                        $idProjet = $resultat[0]['id_projet_projet'];

                        $stmt = $dbh->prepare('insert INTO categories (`nom_categories`,`id_projet_projet`,`id_utilisateur_utilisateur`,`ordre`) values (:nom, :idProjet, :idUtilisateur, :ordre)');
                        while (isset($_POST['categorie' . $i])) { //on fait une boucle pour créer en base de donnée le nbre de catégories correspondantes au nombre de champs affichés
                            if (validForm($_POST['categorie' . $i])) {//voir validForm dans fichier fonctions/formulaire.php
                                $nomCat = htmlentities($_POST['categorie' . $i]);
                                $stmt->execute(['nom' => $nomCat, 'idProjet' => $idProjet, 'idUtilisateur' => $_SESSION['id'], 'ordre' => $i+1]);
                            }
                            $i++;
                        }
                        echo '<span class=" m-3 alert alert-success" role="alert">Votre projet a bien été créé</span> <br><span>Vous pourrez définir les champs manquants dans l\'onglet de votre projet </span>';
                        // header('Refresh: 1; url=../pages/projets.php?page=encours');
                    } else {
                        echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert">Le nom du projet existe déjà</span>';
                    }
                }
            } catch (Exception $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
        }
    }
?>

<form action="" method="post">

        <div class="form-floating my-3">
            <input class="form-control" type="text" id="nomProjet" name="nomProjet" placeholder="nom du projet">
            <label class="form-label" for="nomProjet">Nom du projet</label>
        </div>

        <div class="form-floating my-3">
            <textarea class="form-control" id="description" name="description" placeholder="description"></textarea>
            <label class="form-label" for="description">Description</label>
        </div>

        <div class="form-floating my-3">
            <input class="form-control" type="text" id="nbCategorie" name="nbCategorie" value="0" placeholder="Nb catégories">
            <label class="form-label" for="nbCategorie">nombre de Categories</label>
        </div>

        <div class="container d-flex flex-wrap my-3" id="containerCategorie">
        </div>

        <input class="btn btn-primary d-flex justify-content-end" type="submit" name="submit" value="créer">

    </form>

<?php
    include_once(__DIR__ . '/../template/footer.php');
} else {
    header('location: ./../index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modale</title>

    <link rel="stylesheet" href="css/styles.css">

    <script src="js/scripts.js" defer></script>
</head>
<body>
<?php
//* Gestion des constante a mettre dans un fichier connectDB.php
  const user = "tretrello";
  const password = "tretrello";
  const host = "localhost:8889";
  const dbname = "tretrello";

  //* Récuperation id_tâches_tâches de la Tache
  $id_tache = $_GET['id'];
  
  //* Connection a la base de donnée
  $dbh = new PDO('mysql:host='.host.';dbname='.dbname, user, password);

  //* Requete de selection de la tache
  $stmt = $dbh->prepare('SELECT * FROM tâches WHERE id_tâches_tâches = :id');

  //* Execution de la requete
  $stmt -> execute(array(':id' => $id_tache));

  //* Récupération de la tache
  $tache = $stmt->fetch();
?>
    <!-- "Bouton" d'ouverture de la modale de visualisation -->
    <a href="#" role="button" data-target="#modal" data-toggle="modal">Voir</a>

    <!-- Modale de visualiasation de la tache a partir de la base de donnée -->
    <div class="modal" id="modal" role="dialog">
        <div class="modal-content">
            <div class="modal-close" data-dismiss="dialog">X</div>
            <div class="modal-header">
                <p><?php echo $tache['nom_tâches']; ?></p>
            </div>
            <form action="index.php?page=projetcourant" method="post">
                <div class="modal-body">
                    
                    <!*--Affichage de la tache -->
                    <label for="description">Description de la tache</label>
                    <input type="text" name="description" id="description" value="<?php echo $tache['description_tâches']; ?>">

                    <label for="date">Date de la tache</label>
                    <input type="date" name="date" id="date" value="<?php echo $tache['date_tâches']; ?>">

                    <label for="statut">Commentaire de la tache</label>
                </div>
                <div class="modal-footer">
                <?php
                //* Recupération des commentaires
                        //* Connection a la base de donnée
                        $dbh = new PDO('mysql:host='.host.';dbname='.dbname, user, password);

                        //* Requete de selection des commentaires
                        $sth = $dbh->prepare('SELECT * FROM commentaires WHERE id_tâches_tâches = :id');

                        //* Execution de la requete
                        $sth->execute(array(':id' => $_GET['id']));

                        //* Récupération des commentaires
                        $commentaires = $sth->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <!-- Affichage des commentaires -->
                    <label for="commentaire">Commentaire de la tache</label>
                    <?php
                        //* Boucle de récupération des commentaires
                        foreach ($commentaires as $commentaire) {
                            echo $commentaire['date_commentaires'].' - '.$commentaire['texte_commentaires'].'<br>';
                        }
                    ?>
                </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-close" role="button" data-dismiss="dialog">Fermer</a>
                <a href="#" class="btn" role="button">Valider</a>
            </div>
        </div>
    </div>


</body>
</html>
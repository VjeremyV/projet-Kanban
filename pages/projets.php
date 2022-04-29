<?php
session_start();
include_once(__DIR__.'/../template/head.php');
include_once(__DIR__.'/../template/header.php');
include_once(__DIR__.'/../src/fonctions/security.php');
?>


    <?php
    if(isConnect()){

        try {
            
            $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
            if($_GET['page']=== 'terminer_projet'){
                $projet= $dbh->prepare('select * from projet join utilisateur on projet.id_utilisateur_utilisateur=utilisateur.id_utilisateur_utilisateur WHERE utilisateur.id_utilisateur_utilisateur = :id AND `terminer_projet` = 1');
            } else {
                $projet= $dbh->prepare('select * from projet join utilisateur on projet.id_utilisateur_utilisateur=utilisateur.id_utilisateur_utilisateur WHERE utilisateur.id_utilisateur_utilisateur = :id AND `terminer_projet` = 0');
            }
            if (!$projet->execute(['id' => $_SESSION['id']])){
                echo "<p>Il y a eu une erreur lors de la connexion avec la base de donnée.</p>";
            } else {
                $projets = $projet->fetchAll($fetchMode = PDO::FETCH_NAMED);
                foreach ($projets as $projet) {
                    ?>
                <div>
                    <span><a href="./projet.php?page=<?= $projet['nom_projet'] ?>&id=<?=$projet['id_projet_projet']?>&kanban=true"><?= $projet['nom_projet'] ?></a></span>
                    <span><?= $projet['date_creation_projet'] ?></span>
                    <span><?= $projet['description_projet'] ?></span>
                </div>
                
                <?php
            }
            
        }
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
    
    
    include_once(__DIR__.'/../template/footer.php');
} else {
    header('location: ./../');
}
    ?>
